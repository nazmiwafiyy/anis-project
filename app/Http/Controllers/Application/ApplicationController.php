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
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
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
        ->ajax(['url' => route('application.index'),'type' => 'GET','data' => 'function(d) { d.key = "value"; }'])
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
            $application = Application::where('user_id', Auth::user()->id)->with('user.profile','type','approvals')->select('applications.*');
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
                    $data = ['entity' => 'application','id' => $application->id,'canEdit' => $canEdit]; 
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
    public function create(Request $request)
    { 
        $profile = $request->user()->profile;
        $application = new Application;
        $application->position_id = $profile->position_id;
        $application->department_id = $profile->department_id;
        $application->type_id = $profile->type_id;
        $application->fullname = $profile->fullname;
        $application->identity_no = $profile->identity_no;
        $application->phone_no = $profile->phone_no;

        $position = Position::orderBy('name')->pluck('name', 'id');
        $department = Department::orderBy('name')->pluck('name', 'id');
        $types = Type::all();
        $limit = [];
        foreach($types as $type){
            $typeLimit = $type->limit;
            $checkApplication = Application::where('user_id',Auth::user()->id)->where('type_id', $type->id)->where(function($query){ $query->orWhere('is_approve',NULL)->orWhere('is_approve','Y');})->count();
                
            if($checkApplication < $typeLimit){
                $limit[$type->id] = false;
            }else{
                $limit[$type->id] = true;
            }
        }

        return view('application.create',compact('application','position','department','types','limit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::extend('typeLimit', function($attribute, $value, $parameters){
            $typeLimit = Type::find($value)->limit;
            $application = Application::where('user_id',Auth::user()->id)->where('type_id', $value)->where(function($query){ $query->orWhere('is_approve',NULL)->orWhere('is_approve','Y');})->count();
            // $application = Application::where('user_id',Auth::user()->id)->where('type_id', $value)->where('is_approve','!=', 'N')->orWhereNull('is_approve')->count();
            
            return $application < $typeLimit;
        },'Anda telah mencapai had permohonan untuk perkara ini.');

        $attributes = [
            'fullname' => 'nama penuh',
            'position_id' => 'jawatan',
            'department_id' => 'bahagian/unit',
            'identity_no' => 'nombor kad pengnalan',
            'phone_no' => 'nombor telefon',
            'type_id' => 'perkara',
            'attemp' => 'bilangn tuntutan',
            'notes' => 'catatan',
            'relationship' => 'hubungan keluarga',
            'files' => 'dokumen',
        ];

        $this->validate($request, [
            'fullname' => 'bail|required',
            // 'position_id' => 'required|exists:positions,id',
            // 'department_id' => 'required|exists:departments,id',
            'identity_no' => 'required|regex: /^\d{6}-\d{2}-\d{4}$/',
            'phone_no' => 'required|regex:/(01)[0-9]{8,9}/',
            'type_id' => 'required|typeLimit',
            'attemp' => 'required_if:type,1',
            'notes' => 'nullable',
            'relationship' => 'required_if:type,4',
            'files' => 'required|array',
            'files.*' => 'mimes:jpeg,jpg,png,gif,pdf'

        ], [
            'type_id.required' => 'Ruangan perkara diperlukan, sila pilih perkara',
            'attemp.required_if' => 'Ruangan tuntutan diperlukan, sila pilih tuntutan',
            'relationship.required_if' => 'Ruangan hubungan keluarga diperlukan',
        ], $attributes);
        
        $request->merge(['user_id' => $request->user()->id,'is_approve'=>null]);
        if($application = Application::create($request->except('files','fullname','position_id','department_id','identity_no','phone_no'))) {

            foreach ($request->file('files') as $document) {
                $fileName = time().'_'.$document->getClientOriginalName();
                $document->move(public_path('storage/documents/application/'. $request->user()->id .'/'), $fileName);  
                $file = new File();
                $file->path = $fileName;
                $file->application_id = $application->id;
                $file->save();
            }

            Session::flash('success', 'Permohonan baru telah berjaya dicipta.');
        }else{
            Session::flash('error', 'Permohonan baru tidak dapat dicipta.');
        }
        return redirect()->route('application.index');
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

    public function approve(Request $request,$id)
    {

        $application = Application::findorFail($id);

        if(Auth::user()->can('approval-treasurer')) {
            $application->fill($request->except('payment_prove'));
            if($request->file('payment_prove')){
                $document = $request->file('payment_prove');
                $fileName = time().'_'.$document->getClientOriginalName();
                $document->move(public_path('storage/documents/application/'. $application->user_id .'/'), $fileName);
                $application->payment_prove = $fileName;
            }
            $application->is_approve = 'Y';
        }
        $approvalDetails = [
            'application_id' => $application->id,
            'user_id' => Auth::user()->id,
            'status' => 1,
        ];
        if($approvals = Approval::create($approvalDetails) && $application->save()) {
            Session::flash('success', 'Permohonan telah berjaya diluluskan.');
        }else{
            Session::flash('error', 'Permohonan tidak dapat diluluskan.');
        }

        return redirect()->back();
    }

    public function reject(Request $request ,$id)
    {
        $application = Application::findorFail($id);
        $application->fill($request->all());
		$application->is_approve = 'N';
        $approvalDetails = [
            'application_id' => $application->id,
            'user_id' => Auth::user()->id,
            'status' => 0,
        ];
        if($approvals = Approval::create($approvalDetails) && $application->save()) {
            Session::flash('success', 'Permohonan telah berjaya ditolak.');
        }else{
            Session::flash('error', 'Permohonan tidak dapat ditolak.');
        }

        return redirect()->back();
    }
}
