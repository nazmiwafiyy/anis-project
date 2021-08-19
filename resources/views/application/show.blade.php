@extends('adminlte::page')

{{-- @section('title', 'AdminLTE') --}}

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Permohonan</h1>
        </div>
        <div class="float-md-right float-lg-right">
            @php
                $approvalCount = $application->approvals->where('status', 1)->count();
                $isRejected = $application->is_approve == 'N' || $application->approvals->where('status', 0)->count() > 0 ? true : false;
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
                @if (!in_array(Auth::user()->id,$application->approvals->pluck('user_id')->toArray()) && $currentLevel == 0 && Auth::user()->profile->department->id == $application->user->profile->department->id)
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal"><i class="fas fa-fw fa-times"></i>Tolak Permohonan</button>
                    <button type="button" class="btn btn-success btn-sm approveButton"><i class="fas fa-fw fa-check"></i>Luluskan Permohonan</button>
                @elseif (!in_array(Auth::user()->id,$application->approvals->pluck('user_id')->toArray()) && $currentLevel > 0)
                    {{-- <a href="{{ route('application.reject',$application->id) }}" class="btn btn-danger btn-sm "><i class="fas fa-fw fa-times"></i>Tolak permohonan</a> --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal"><i class="fas fa-fw fa-times"></i>Tolak Permohonan</button>
                    @if ($userLevel == 4)
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModal"><i class="fas fa-fw fa-check"></i>Luluskan Permohonan</button>
                    @else
                        <button type="button" class="btn btn-success btn-sm approveButton"><i class="fas fa-fw fa-check"></i>Luluskan Permohonan</button>
                    @endif
                @endif
            @endif
            @if ($approvalCount < 4 && !$isRejected && $userLevel == 99)
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModalSu"><i class="fas fa-fw fa-times"></i>Tolak Permohonan(Super Admin)</button>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModalSu"><i class="fas fa-fw fa-check"></i>Luluskan Permohonan(Super Admin)</button>
            @endif
            @endcanany
            

            <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-chevron-left"></i>Kembali</a>
        </div>
    </div>
@stop

@section('content')
    <!-- Modal -->
    @canany(['approval-head-department', 'approval-welfare-social-bureaus', 'approval-secretary-sports-welfare','approval-treasurer'])
    @if ($approvalCount < 4 && !$isRejected && $userLevel == $currentLevel+1)
        @if (!in_array(Auth::user()->id,$application->approvals->pluck('user_id')->toArray()))
            @include('application._approveModal')
            @include('application._rejectModal')
        @endif
    @endif
    @if ($approvalCount < 4 && !$isRejected && $userLevel == 99)
        @include('application._approveModalSu')
        @include('application._rejectModalSu') 
    @endif
    @endcanany

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
                            // dd($application->approvals );
                        @endphp
                        @foreach ($application->approvals as $approval)
                            @if($approval->approved_by->hasPermissionTo('approval-head-department') && !$approval->su_approval)
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Perakuan Ketua Jabatan</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;
                                @endphp
                            @endif
                            @if($approval->su_level == 1 && $approval->su_approval)
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Perakuan Ketua Jabatan(Super Admin)</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;
                                @endphp
                            @endif
                            @if($approval->approved_by->hasPermissionTo('approval-welfare-social-bureaus') && !$approval->su_approval)
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
                            @if($approval->su_level == 2 && $approval->su_approval)
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Kelulusan Biro Kebajikan dan Sosial(Super Admin)</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;   
                                @endphp
                            @endif     
                            @if($approval->approved_by->hasPermissionTo('approval-secretary-sports-welfare') && !$approval->su_approval)
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
                            @if($approval->su_level == 3 && $approval->su_approval)
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Kelulusan Setiausaha / Penolong Setiausha Kelab Sukan dan Kebajikan JKMM(Super Admin)</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;   
                                @endphp
                            @endif
                            @if($approval->approved_by->hasPermissionTo('approval-treasurer') && !$approval->su_approval)
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Pengesahan Bendahari / Penolong Bendahari</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;    
                                @endphp
                            @endif 
                            @if($approval->su_level == 4 && $approval->su_approval)
                                <div>
                                    <i class="{{ $approval->status == 1 ? 'fas fa-check bg-success' : 'fas fa-times bg-danger'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$approval->created_at}}</span>
                                        <h3 class="timeline-header">Pengesahan Bendahari / Penolong Bendahari</h3>
                                    </div>
                                </div>
                                @php
                                    $approval->status == 1 ? $totalApproved++ : $totalReject++;    
                                @endphp
                            @endif 
                        @endforeach
                        <div>
                            @if ($totalReject > 0 || $isRejected)
                                <i class="fas fa-times bg-danger"></i>
                            @elseif($totalApproved == 4)
                                <i class="fas fa-check bg-success"></i>
                            @else
                                <i class="fas fa-clock bg-blue"></i>
                            @endif
                        </div>
                    </div>
                    @if($application->is_approve == 'N')
                        <blockquote class="blockquote">
                            <footer class="blockquote-footer">{{$application->reject_reason}}</footer>
                        </blockquote>
                    @endif
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
                                            <li><i class="fa-li fa fa-file"></i><a target="_blank" href="{{Storage::url('documents/application/'.$application->user_id.'/'.$file->path)}}">{{$file->path}}</a></li>
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
                                            <li><i class="fa-li fa fa-file"></i><a target="_blank" href="{{Storage::url('documents/application/'.$application->user_id.'/'.$file->path)}}">{{$file->path}}</a></li>
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
                                            <li><i class="fa-li fa fa-file"></i><a target="_blank" href="{{Storage::url('documents/application/'.$application->user_id.'/'.$file->path)}}">{{$file->path}}</a></li>
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
                                            <li><i class="fa-li fa fa-file"></i><a target="_blank" href="{{Storage::url('documents/application/'.$application->user_id.'/'.$file->path)}}">{{$file->path}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if ($application->is_approve == 'Y')
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Perincian Bayaran</h4>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Jumlah Bayaran</label>
                            <div class="form-control">RM{{$application->payment}}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Tarikh Bayaran</label> 
                            <div class="form-control">{{$application->payment_date}}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Bukti Bayaran</label> 
                            <div>
                                <ul class="fa-ul">
                                    @foreach ($application->files as $file)
                                        <li><i class="fa-li fa fa-file"></i><a target="_blank" href="{{Storage::url('documents/application/'.$application->user_id.'/'.$application->payment_prove)}}">{{$application->payment_prove}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@stop

@section('adminlte_js')
    <script>
        $(function() {          
            //Initialize custom-file-input
            bsCustomFileInput.init();
            $('#payment').hide();

            $('#payment_date').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                drops: 'bottom',
                locale: {
                    format: 'YYYY-MM-DD',
                }
            }, function(date) {
                $('#payment_date').val(date.format('YYYY-MM-DD'));
            });

            $('.clear-payment-date').click(function() {
                $('#payment_date').val('');
            });

            $('#payment_date_su').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                drops: 'bottom',
                locale: {
                    format: 'YYYY-MM-DD',
                }
            }, function(date) {
                $('#payment_date_su').val(date.format('YYYY-MM-DD'));
            });

            $('.clear-payment-date-su').click(function() {
                $('#payment_date_su').val('');
            });

            $('.approveButton').click( function() {
                $('#approveForm').submit();
            });
            
            $('#level-1').change(function () {
                if($('#level-1').is(':checked')){

                }else{
                    $('#level-2').prop('checked', false).change();
                }
            });

            $('#level-2').change(function () {
                if($('#level-2').is(':checked')){
                    $('#level-1').prop('checked', true).change();
                }else{
                    $('#level-3').prop('checked', false).change();
                }
            });

            $('#level-3').change(function () {
                if($('#level-3').is(':checked')){
                    $('#level-2').prop('checked', true).change();
                }else{
                    $('#level-4').prop('checked', false).change();
                }
            });

            $('#level-4').change(function () {
                if($('#level-4').is(':checked')){
                    $('#level-3').prop('checked', true).change();
                    $('#payment').show();
                    $('input[name=payment]').prop('required',true);
                    $('input[name=payment_date]').prop('required',true);
                }else{
                    $('#payment').hide();
                    $('input[name=payment]').prop('required',false);
                    $('input[name=payment_date]').prop('required',false); 
                }
            });
        });

        function validateForm() {
            if( $('#approveFormSu input[type=checkbox]:checked').length == 0){
                alert('Sila pilih jenis kelulusan.');
                return false;
            }
        }
    </script>
@stop