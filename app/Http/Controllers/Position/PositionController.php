<?php

namespace App\Http\Controllers\Position;

use App\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PositionController extends Controller
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
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Dicipta Pada','searchable' => false,'orderable' => true,],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Tindakan','searchable' => false,'orderable' => false,],
        ])
        ->ajax(['url' => route('position.index'),'type' => 'GET','data' => 'function(d) { d.key = "value"; }'])
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
            $position = Position::query();
            return DataTables::of($position)
                ->addIndexColumn()
                ->addColumn('actions', function(Position $position){  
                    $data = ['entity' => 'position','id' => $position->id]; 
                    return view('shared._actions',$data);
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        return view('position.index',compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('position.create');
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

        if($position = Position::create($request->all())) {
            Session::flash('success', 'Jawatan telah berjaya dicipta.');
        }else{
            Session::flash('error', 'Jawatan tidak berjaya dicipta.');
        }

        return redirect()->route('position.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position = Position::findOrFail($id);
        return view('position.show',compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::findOrFail($id);
        return view('position.edit',compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attributes = [
            'name' => 'nama',
            'description' => 'perincian',
        ];

        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'description' => 'nullable'
        ], [], $attributes);

        $position = Position::findOrFail($id);
        $position->fill($request->all());

        if ($position->save()){
            Session::flash('success', 'Jawatan telah berjaya dikemas kini.');
        }else{
            Session::flash('error', 'Jawatan tidak dapat dikemas kini.');
        }

        return redirect()->route('position.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Position::findOrFail($id)->delete()) {
            Session::flash('success', 'Jawatan telah berjaya dipadam.');
        }else{
            Session::flash('error', 'Jawatan tidak dapat dipadam.');
        }

        return redirect()->back();
    }
}
