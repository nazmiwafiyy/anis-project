<?php

namespace App\Http\Controllers\Roles;

use App\Role;
use App\Module;
use App\Permission;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No','searchable' => false,'orderable' => false,],
            ['data' => 'display_name', 'name' => 'display_name', 'title' => 'Peranan','searchable' => true,'orderable' => true,],
            // ['data' => 'name', 'name' => 'name', 'title' => 'Slug','searchable' => true,'orderable' => true,],
            ['data' => 'permission', 'name' => 'permission', 'title' => 'Keizinan','searchable' => false,'orderable' => false,],     
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Dicipta pada','searchable' => false,'orderable' => true,],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Tindakan','searchable' => false,'orderable' => false,],
        ])
        ->ajax(['url' => route('roles.index'),'type' => 'GET','data' => 'function(d) { d.key = "value"; }'])
        ->parameters([
            'autoWidth' => false,
            'columnDefs' => [
                ['targets' => 0,'width' => '5%',],
                ['targets' => 1,'width' => '35%','className' => ''],
                // ['targets' => 2,'width' => '20%','className' => ''],
                ['targets' => 2,'width' => '30%','className' => ''],
                ['targets' => 3,'width' => '15%','className' => ''],
                ['targets' => 4,'width' => '15%','className' => 'text-center'],
            ],
            'language' => ['url' => url('//cdn.datatables.net/plug-ins/1.10.24/i18n/Malay.json')],
            'order' => [3,'desc']

        ]);

        if($request->ajax()){
            $role = Role::query();
            return DataTables::of($role)
                ->addIndexColumn()
                ->addColumn('actions', function(Role $role){  
                    $data = ['entity' => 'roles','id' => $role->id]; 
                    return view('shared._actions',$data);
                })
                ->addColumn('permission', function(Role $role){
                    $rolePermission = $role->permissions->count();
                    $allPermission = Permission::count();
                    $permission =   'Paras<small class="text-muted float-right">' . $rolePermission  .' of ' . $allPermission . '</small>
                                    <div class="progress progress-xxs progress-bar-danger">
                                        <div class="progress-bar progress-bar-danger" style="width: '. $rolePermission/$allPermission*100  .'%"></div>
                                    </div>';
                    return $permission;
                })
                ->rawColumns(['actions'])
                ->rawColumns(['permission'])
                ->toJson();
        }

        return view('roles.index',compact('html'));
    }

    public function create()
    {
        $modules = Module::with('permissions')->orderBy('name')->get();
        return view('roles.create',compact('modules'));
    }

    public function store (Request $request)
    {
        $attributes = [
            'display_name' => 'nama peranan',
            'name' => 'slug',
            'permissions' => 'keizinan'
        ]; 

        $this->validate($request, [
            'name' => 'bail|required|string|unique:roles',
            'display_name' => 'required|string|unique:roles',
            'permissions' => 'required|array'
        ], [], $attributes);

        $request->merge(['guard_name' => 'web']);

        if($role = Role::create($request->except('permissions'))) {
            $role->syncPermissions($request->get('permissions'));
            Session::flash('success', 'Peranan baru berjaya dicipta.');

        }else{
            Session::flash('error', 'Peranan baru tidak dapat dicipta.');
        }

        return redirect()->route('roles.index');
    }

    public function show($id)
    {
       $role = Role::findOrFail($id);
       return view('roles.show',compact('role'));
    }

    public function edit($id)
    {
        $role = Role::findorFail($id);
        $modules = Module::with('permissions')->orderBy('name')->get();

        return view('roles.edit',compact('role','modules'));
    }

    public function update (Request $request, $id)
    {
        $attributes = [
            'display_name' => 'nama peranan',
            'name' => 'slug',
            'permissions' => 'keizinan'
        ]; 

        $this->validate($request, [
            'name' => 'required|string|unique:roles,name,'.$id,
            'display_name' => 'required|string|unique:roles,display_name,'.$id,
            'permissions' => 'required|array'
        ]);

        $role = Role::findOrFail($id);
        
        $role->fill($request->except('permissions'));
        
        if ($role->save()){
            $role->syncPermissions($request->get('permissions'));
            Session::flash('success', 'Peranan berjaya dikemas kini.');
        }else{
            Session::flash('error', 'Peranan tidak dapat dikemas kini.');
        }

        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        if($id == 1 ){
            Session::flash('warning', 'Pemadaman peranan lalai tidak dibenarkan.');
            return redirect()->back();
        }

        if(Role::findOrFail($id)->delete()) {
            Session::flash('success', 'Peranan telah berjaya dipadam.');
        }else{
            Session::flash('error', 'Peranan tidak dapat dipadam.');
        }

        return redirect()->back();
    }
}
