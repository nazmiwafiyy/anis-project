<?php

namespace App\Http\Controllers\Profile;

use App\Profile;
use App\Position;
use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $profile = $request->user()->profile;
        $position = Position::orderBy('name')->pluck('name', 'id');
        $department = Department::orderBy('name')->pluck('name', 'id');

        if($profile){
            return redirect()->route('profile.edit',$profile->id);
        }else{
            return view('profile.create',compact('position','department'));
        }
    }

    public function edit($id)
    {
        $profile = Profile::findOrfail($id);

        $position = Position::orderBy('name')->pluck('name', 'id');
        $department = Department::orderBy('name')->pluck('name', 'id');

        return view('profile.edit',compact('profile','position','department'));
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
            'picture' => 'gambar',
        ];

        $this->validate($request, [
            'fullname' => 'bail|required',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'identity_no' => 'required|regex: /^\d{6}-\d{2}-\d{4}$/',
            'phone_no' => 'required|regex:/(01)[0-9]{9}/',
            'picture' => 'mimes:jpeg,jpg,png,gif|nullable'
        ], [], $attributes);
        $data = $request->all();
        if($request->hasFile('picture')){
            $image = $request->file('picture');
            $imageName = 'profile.'.$request->picture->extension(); 
            Image::make($image)->resize(300,300)->save(public_path('storage/profiles/'. $request->user()->id .'/' . $imageName));
            $data['picture'] =  $imageName;
        }
        $data['user_id'] =  $request->user()->id;
        
        if($profile = Profile::create($data)) {
            Session::flash('success', 'Profil berjaya disimpan.');

        }else{
            Session::flash('error', 'Profil tidak berjaya disimpan.');
        }

        return redirect()->route('home');
    }

    public function update(Request $request, $id)
    {
        $attributes = [
            'fullname' => 'nama penuh',
            'position_id' => 'jawatan',
            'department_id' => 'bahagian/unit',
            'identity_no' => 'nombor kad pengnalan',
            'phone_no' => 'nombor telefon',
            'picture' => 'gambar',
        ];

        $this->validate($request, [
            'fullname' => 'bail|required',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'identity_no' => 'required|regex: /^\d{6}-\d{2}-\d{4}$/',
            'phone_no' => 'required|regex:/(01)[0-9]{9}/',
            'picture' => 'mimes:jpeg,jpg,png,gif|nullable'
        ], [], $attributes);

        $profile = Profile::findOrFail($id);

        if($request->hasFile('picture')){
            $image = $request->file('picture');
            $imageName = 'profile.'.$request->picture->extension(); 
            Image::make($image)->resize(300,300)->save(public_path('storage/profiles/'. $request->user()->id .'/' . $imageName));
            $profile->picture =  $imageName;
        }
        
        $profile->fill($request->except('picture'));

        if ($profile->save()){
            Session::flash('success', 'Profil berjaya dikemas kini.');
        }else{
            Session::flash('error', 'Profil tidak berjaya dikemas kini.');
        }

        return redirect()->route('home');
    }
}
