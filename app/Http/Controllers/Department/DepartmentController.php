<?php

namespace App\Http\Controllers\Department;

use App\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $builder)
    {
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No','searchable' => false,'orderable' => false,],
            ['data' => 'name', 'name' => 'name', 'title' => 'Nama','searchable' => true,'orderable' => true,],
            ['data' => 'description', 'name' => 'description', 'title' => 'Perincian','searchable' => true,'orderable' => true,],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Dicipta pada','searchable' => false,'orderable' => true,],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Tindakan','searchable' => false,'orderable' => false,],
        ])
        ->ajax(['url' => route('department.index'),'type' => 'GET','data' => 'function(d) { d.key = "value"; }'])
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
            $department = Department::query();
            return DataTables::of($department)
                ->addIndexColumn()
                ->addColumn('actions', function(Department $department){  
                    $data = ['entity' => 'department','id' => $department->id]; 
                    return view('shared._actions',$data);
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        return view('department.index',compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = [
            'name' => 'nama',
            'description' => 'perincian',
        ];

        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'description' => 'nullable'
        ], [], $attributes);

        if($department = Department::create($request->all())) {
            Session::flash('success', 'Bahagian/Unit baru berjaya dicipta');
        }else{
            Session::flash('error', 'Bahagian/Unit tidak dapat dicipta');
        }

        return redirect()->route('department.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::findOrFail($id);
        return view('department.show',compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('department.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $attributes = [
            'name' => 'nama',
            'description' => 'perincian',
        ];

        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'description' => 'nullable'
        ], [], $attributes);

        $department = Department::findOrFail($id);
        $department->fill($request->all());

        if ($department->save()){
            Session::flash('success', 'Bahagian/Unit berjaya dikemas kini.');
        }else{
            Session::flash('error', 'Bahagian/Unit tidak dapat dikemas kini.');
        }

        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Department::findOrFail($id)->delete()) {
            Session::flash('success', 'Bahagian/Unit telah berjaya dipadam.');
        }else{
            Session::flash('error', 'Bahagian/Unit tidak dapat dipadam.');
        }

        return redirect()->back();
    }
}
