<?php

namespace App\Http\Controllers\Application;

use App\File;
use App\Type;
use App\Position;
use App\Department;
use App\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('application.index');
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
        
        return view('application.create',compact('application','position','department','types'));
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
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'identity_no' => 'required|regex: /^\d{6}-\d{2}-\d{4}$/',
            'phone_no' => 'required|regex:/(01)[0-9]{9}/',
            'type_id' => 'required',
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

        if($application = Application::create($request->except('files'))) {

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
        //
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
        //
    }
}
