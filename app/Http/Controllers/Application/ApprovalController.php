<?php

namespace App\Http\Controllers\Application;

use App\File;
use App\Type;
use App\Approval;
use App\Position;
use App\Department;
use App\Application;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ApprovalController extends Controller
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
            ['data' => 'fullname', 'name' => 'user.profile.fullname', 'title' => 'Nama','searchable' => true,'orderable' => true,],
            ['data' => 'type', 'name' => 'type.name', 'title' => 'Perkara','searchable' => true,'orderable' => true,],
            ['data' => 'approval', 'name' => 'approval', 'title' => 'Kelulusan','searchable' => false,'orderable' => false,],
            ['data' => 'approval_date', 'name' => 'approvals.created_at', 'title' => 'Diluluskan pada','searchable' => false,'orderable' => false,],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Dicipta pada','searchable' => false,'orderable' => true,],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Tindakan','searchable' => false,'orderable' => false,],
        ])
        ->ajax(['url' => route('approval.index'),'type' => 'GET','data' => 'function(d) { d.key = "value"; }'])
        ->parameters([
            'autoWidth' => false,
            'columnDefs' => [
                ['targets' => 0,'width' => '5%',],
                ['targets' => 1,'width' => '20%','className' => ''],
                ['targets' => 2,'width' => '15%','className' => ''],
                ['targets' => 3,'width' => '15%','className' => ''],
                ['targets' => 4,'width' => '15%','className' => 'text-center'],
                ['targets' => 5,'width' => '15%','className' => ''],
                ['targets' => 6,'width' => '15%','className' => 'text-center'],
            ],
            'language' => ['url' => url('//cdn.datatables.net/plug-ins/1.10.24/i18n/Malay.json')],
            'order' => [5,'desc'],
        ]);

        if($request->ajax()){
            $application = Application::with('user.profile','type','approvals')->select('applications.*');
            // $application = Application::query();
            return DataTables::of($application)
                ->addIndexColumn()
                ->addColumn('fullname', function(Application $application){ 
                    return $application->user->profile->fullname;
                })
                ->addColumn('type', function(Application $application){  
                    return $application->type->name;
                })
                ->addColumn('approval', function(Application $application){
                    $approvalCount = $application->approvals->where('status', 1)->count();
                    $isRejected = $application->approvals->where('status', 0)->count() > 0 ? true : false;
                    if($isRejected){
                        $bgColor = 'bg-danger';
                        $status = 'Gagal';
                        $txtColor = 'text-danger';
                    }elseif($approvalCount == 4){
                        $bgColor = 'bg-success';
                        $status = 'Berjaya';
                        $txtColor = 'text-success';
                    }else{
                        $bgColor = 'bg-primary';
                        $status = 'Dalam Proses';
                        $txtColor = 'text-primary';
                    }
                    $approval = '<span class = "' . $txtColor . '">' . $status . '</span><small class="text-muted float-right">' .$approvalCount. ' drp. 4</small>
                        <div class="progress progress-xxs">
                            <div class="progress-bar '.$bgColor.'" style="width: '. ($approvalCount/4)*100 .'%"></div>
                        </div>';
                    return $approval;
                })
                ->addColumn('approval_date', function(Application $application){
                    $approval_date = '-';
                    if($application->is_approve == 'Y'){
                        $approval = $application->approvals->where('status', 1)->sortByDesc('created_at')->first();
                        $approval_date = $approval->created_at; 
                    }  
                    return $approval_date;
                })
                ->addColumn('actions', function(Application $application){ 
                    $canEdit = ($application->approvals->count() > 0 ? false : true); 
                    $data = ['entity' => 'approval','id' => $application->id,'canEdit' => $canEdit]; 
                    return view('shared._actions',$data);
                })
                ->rawColumns(['approval','actions'])
                ->toJson();
        }

        return view('application.index',compact('html'));
    }

    public function needAction(Request $request, Builder $builder){
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No','searchable' => false,'orderable' => false,],
            ['data' => 'fullname', 'name' => 'user.profile.fullname', 'title' => 'Nama','searchable' => true,'orderable' => true,],
            ['data' => 'type', 'name' => 'type.name', 'title' => 'Perkara','searchable' => true,'orderable' => true,],
            ['data' => 'approval', 'name' => 'approval', 'title' => 'Kelulusan','searchable' => false,'orderable' => false,],
            ['data' => 'approval_date', 'name' => 'approvals.created_at', 'title' => 'Diluluskan pada','searchable' => false,'orderable' => false,],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Dicipta pada','searchable' => false,'orderable' => true,],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Tindakan','searchable' => false,'orderable' => false,],
        ])
        ->ajax(['url' => route('approval.action'),'type' => 'GET','data' => 'function(d) { d.key = "value"; }'])
        ->parameters([
            'autoWidth' => false,
            'columnDefs' => [
                ['targets' => 0,'width' => '5%',],
                ['targets' => 1,'width' => '20%','className' => ''],
                ['targets' => 2,'width' => '15%','className' => ''],
                ['targets' => 3,'width' => '15%','className' => ''],
                ['targets' => 4,'width' => '15%','className' => 'text-center'],
                ['targets' => 5,'width' => '15%','className' => ''],
                ['targets' => 6,'width' => '15%','className' => 'text-center'],
            ],
            'language' => ['url' => url('//cdn.datatables.net/plug-ins/1.10.24/i18n/Malay.json')],
            'order' => [5,'desc'],
        ]);

        if($request->ajax()){
            $application = Application::whereNull('is_approve')->get();
            $userLevel = Auth::user()->approvalLevel();
            $allNeedAction = [];
            foreach($application as $app){
                $currentLevel = $app->currentApproveLevel();
                if($userLevel == $currentLevel+1){
                    $allNeedAction[] = $app->id;
                }
            }

            $application = Application::with('user.profile','type','approvals')->select('applications.*')->whereIn('id', $allNeedAction);
            // $application = Application::query();
            return DataTables::of($application)
                ->addIndexColumn()
                ->addColumn('fullname', function(Application $application){ 
                    return $application->user->profile->fullname;
                })
                ->addColumn('type', function(Application $application){  
                    return $application->type->name;
                })
                ->addColumn('approval', function(Application $application){
                    $approvalCount = $application->approvals->where('status', 1)->count();
                    $isRejected = $application->approvals->where('status', 0)->count() > 0 ? true : false;
                    if($isRejected){
                        $bgColor = 'bg-danger';
                        $status = 'Gagal';
                        $txtColor = 'text-danger';
                    }elseif($approvalCount == 4){
                        $bgColor = 'bg-success';
                        $status = 'Berjaya';
                        $txtColor = 'text-success';
                    }else{
                        $bgColor = 'bg-primary';
                        $status = 'Dalam Proses';
                        $txtColor = 'text-primary';
                    }
                    $approval = '<span class = "' . $txtColor . '">' . $status . '</span><small class="text-muted float-right">' .$approvalCount. ' drp. 4</small>
                        <div class="progress progress-xxs">
                            <div class="progress-bar '.$bgColor.'" style="width: '. ($approvalCount/4)*100 .'%"></div>
                        </div>';
                    return $approval;
                })
                ->addColumn('approval_date', function(Application $application){
                    $approval_date = '-';
                    if($application->is_approve == 'Y'){
                        $approval = $application->approvals->where('status', 1)->sortByDesc('created_at')->first();
                        $approval_date = $approval->created_at; 
                    }  
                    return $approval_date;
                })
                ->addColumn('actions', function(Application $application){ 
                    $canEdit = ($application->approvals->count() > 0 ? false : true); 
                    $data = ['entity' => 'approval','id' => $application->id,'canEdit' => $canEdit]; 
                    return view('shared._actions',$data);
                })
                ->rawColumns(['approval','actions'])
                ->toJson();
        }

        return view('application.index',compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application = Application::findOrFail($id);
        // dd($application->approvals->pluck('user_id'));
        return view('application.show',compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Application::findOrFail($id)->delete()) {
            Session::flash('success', 'Permohonan telah berjaya dipadam.');
        }else{
            Session::flash('error', 'Permohonan tidak dapat dipadam.');
        }

        return redirect()->back();
    }
}
