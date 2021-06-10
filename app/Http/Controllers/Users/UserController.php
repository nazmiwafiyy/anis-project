<?php

namespace App\Http\Controllers\Users;

use Avatar;
use App\User;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No','searchable' => false,'orderable' => false,],
            ['data' => 'name', 'name' => 'name', 'title' => 'Nama','searchable' => true,'orderable' => true,],
            ['data' => 'email', 'name' => 'email', 'title' => 'E-mel','searchable' => true,'orderable' => true,],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Dicipta pada','searchable' => false,'orderable' => true,],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Tindakan','searchable' => false,'orderable' => false,],
        ])
        ->ajax(['url' => route('users.index'),'type' => 'GET','data' => 'function(d) { d.key = "value"; }'])
        ->parameters([
            'autoWidth' => false,
            'columnDefs' => [
                ['targets' => 0,'width' => '5%',],
                ['targets' => 1,'width' => '35%','className' => ''],
                ['targets' => 2,'width' => '30%','className' => ''],
                ['targets' => 3,'width' => '15%','className' => ''],
                ['targets' => 4,'width' => '15%','className' => 'text-center'],
            ],
            'language' => ['url' => url('//cdn.datatables.net/plug-ins/1.10.24/i18n/Malay.json')],
            'order' => [3,'desc']

        ]);

        if($request->ajax()){
            $user = User::query();
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('actions', function(User $user){  
                    $data = ['entity' => 'users','id' => $user->id]; 
                    return view('shared._actions',$data);
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        return view('users.index',compact('html'));
    }

    public function show($id)
    {
       $user = User::findOrFail($id);
       return view('users.show',compact('user'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'id');
        
        return view('users.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $attributes = [
            'name' => 'nama',
            'email' => 'e-mel',
            'password' => 'kata laluan',
            'roles' => 'peranan',
        ];

        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required|min:1'
        ], [], $attributes);

        $request->merge(['password' => Hash::make($request->get('password'))]);

        if($user = User::create($request->except('roles'))) {

            $user->syncRoles($request->get('roles'));

            $avatar = Avatar::create($user->name)->getImageObject()->encode('png',100);
            Storage::disk('public')->put('avatars/'.$user->id.'/avatar.png', (string) $avatar);

            // Alert::toast('Pengguna baru berjaya dicipta.', 'success');
            Session::flash('success', 'Pengguna baru berjaya dicipta.');

        }else{
            // Alert::toast('Pengguna baru tidak dapat dicipta.', 'error');
            Session::flash('error', 'Pengguna baru tidak dapat dicipta.');
        }

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = User::findorFail($id);
        $roles = Role::pluck('name', 'id');
        
        return view('users.edit',compact('user','roles'));
    }

    public function update(Request $request, $id)
    {
        $attributes = [
            'name' => 'nama',
            'email' => 'e-mel',
            'password' => 'kata laluan',
            'roles' => 'peranan',
        ];

        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'string|nullable',
            'roles' => 'required|array'
        ],[], $attributes);

        $user = User::findOrFail($id);

        //update avatar
        if ($user->name != $request->get('name')){
            $avatar = Avatar::create($request->get('name'))->getImageObject()->encode('png',100);
            Storage::disk('public')->put('avatars/'.$user->id.'/avatar.png', (string) $avatar);
        }
        
        $user->fill($request->except('roles', 'permissions', 'password'));

        if($request->get('password')) {
            $user->password =  Hash::make($request->password);
        }

        if ($user->save()){
            $user->syncRoles($request->get('roles'));
            Session::flash('success', 'Pengguna berjaya dikemas kini.');
        }else{
            Session::flash('error', 'Pengguna tidak dapat dikemas kini.');
        }

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        if (Auth::user()->id == $id ){
            Session::flash('warning', 'Pemadaman pengguna yang sedang dilog masuk tidak dibenarkan.');
            return redirect()->back();
        }

        if($id == 1 ){
            Session::flash('warning', 'Pemadaman pengguna lalai tidak dibenarkan.');
            return redirect()->back();
        }

        if(User::findOrFail($id)->delete()) {
            Session::flash('success', 'Pengguna telah berjaya dipadam.');
        }else{
            Session::flash('error', 'Pengguna tidak dapat dipadam.');
        }

        return redirect()->back();
    }
}
