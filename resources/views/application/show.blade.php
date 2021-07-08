@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Permohonan</h1>
        </div>
        <div class="float-md-right float-lg-right">
            @php
                $approvalCount = $application->approvals->where('status', 1)->count();
                $isRejected = $application->approvals->where('status', 0)->count() > 0 ? true : false;
                if($isRejected){
                    $textColor = 'text-danger';
                    $status = 'Gagal';
                }elseif($approvalCount == 4){
                    $textColor = 'text-success';
                    $status = 'Berjaya';
                }else{
                    $textColor = 'text-primary';
                    $status = 'Dalam Proses';
                }
                $currentLevel = $application->currentApproveLevel();
                $userLevel = Auth::user()->approvalLevel();
            @endphp
            @canany(['approval-head-department', 'approval-welfare-social-bureaus', 'approval-secretary-sports-welfare','approval-treasurer'])
            @if ($approvalCount < 4 && !$isRejected && $userLevel == $currentLevel+1)
                @if (!in_array(Auth::user()->id,$application->approvals->pluck('user_id')->toArray()))
                <a href="{{ route('application.reject',$application->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-times"></i>Tolak permohonan</a>
                <a href="{{ route('application.approve',$application->id) }}" class="btn btn-success btn-sm"><i class="fas fa-fw fa-check"></i>Luluskan Permohonan</a>
                @endif
            @endif
            @endcanany
            
            <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-chevron-left"></i>Kembali</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                PERMOHONAN: Perincian permohonan.
            </div>
            <div class="mb-2">
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Status Permohonan : <span class="{{$textColor}}">{{$status}}</span></h4>
                    <div class="timeline timeline-inverse">
                        @php
                            $totalApproved = 0; 
                            $totalReject = 0;   
                        @endphp
                        @foreach ($application->approvals as $approval)
                            @if($approval->approved_by->hasPermissionTo('approval-head-department'))
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Kelulusan Ketua Jabatan</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;
                                @endphp
                            @endif
                            @if($approval->approved_by->hasPermissionTo('approval-welfare-social-bureaus'))
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Kelulusan Biro Kebajikan dan Sosial</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;   
                                @endphp
                            @endif     
                            @if($approval->approved_by->hasPermissionTo('approval-secretary-sports-welfare'))
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Kelulusan Setiausaha / Penolong Setiausha Kelab Sukan dan Kebajikan JKMM</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;   
                                @endphp
                            @endif
                            @if($approval->approved_by->hasPermissionTo('approval-treasurer'))
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Kelulusan Bendahari / Penolong Bendahari</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;    
                                @endphp
                            @endif 
                        @endforeach
                        <div>
                            @if ($totalReject > 0)
                                <i class="fas fa-times bg-danger"></i>
                            @elseif($totalApproved == 4)
                                <i class="fas fa-check bg-success"></i>
                            @else
                                <i class="fas fa-clock bg-blue"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Nama Pemohon</label> 
                            <div class="form-control">{{$application->user->profile->fullname}}</div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>No. Kad Pengenalan</label> 
                            <div class="form-control">{{$application->user->profile->identity_no}}</div>
                        </div> 
                        <div class="form-group col-md-3">
                            <label>No Telefon</label> 
                            <div class="form-control">{{$application->user->profile->phone_no}}</div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Jawatan</label> 
                            <div class="form-control">{{$application->user->profile->position->name}}</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Bahagian / Unit</label> 
                            <div class="form-control">{{$application->user->profile->department->name}}</div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Perkara</label> 
                            <div class="form-control">{{$application->type->name}}</div>
                        </div>
                    </div>
                    @if ($application->type->slug == 'get_baby')
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Tuntutan kali ke</label> 
                                <div class="form-control">{{$application->attemp}}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Catatan</label> 
                                <div class="form-control">{{$application->notes}}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Dokumen Sokongan</label> 
                                <div>
                                    <ul class="fa-ul">
                                        @foreach ($application->files as $file)
                                            <li><i class="fa-li fa fa-file"></i><a target="_blank" href="{{Storage::url('documents/application/'.Auth::user()->id.'/'.$file->path)}}">{{$file->path}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @elseif($application->type->slug == 'get_married' || $application->type->slug == 'warded' || $application->type->slug == 'hajj_and_umra') 
                        <div class="row">    
                            <div class="form-group col-md-12">
                                <label>Catatan</label> 
                                <div class="form-control">{{$application->notes}}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Dokumen Sokongan</label> 
                                <div>
                                    <ul class="fa-ul">
                                        @foreach ($application->files as $file)
                                            <li><i class="fa-li fa fa-file"></i><a target="_blank" href="{{Storage::url('documents/application/'.Auth::user()->id.'/'.$file->path)}}">{{$file->path}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @elseif($application->type->slug == 'family_death')
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Hubungan Keluarga</label> 
                                <div class="form-control">{{$application->relationship}}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Dokumen Sokongan</label> 
                                <div>
                                    <ul class="fa-ul">
                                        @foreach ($application->files as $file)
                                            <li><i class="fa-li fa fa-file"></i><a target="_blank" href="{{Storage::url('documents/application/'.Auth::user()->id.'/'.$file->path)}}">{{$file->path}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Catatan</label> 
                                <div class="form-control">{{$application->notes}}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Dokumen Sokongan</label> 
                                <div>
                                    <ul class="fa-ul">
                                        @foreach ($application->files as $file)
                                            <li><i class="fa-li fa fa-file"></i><a target="_blank" href="{{Storage::url('documents/application/'.Auth::user()->id.'/'.$file->path)}}">{{$file->path}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop