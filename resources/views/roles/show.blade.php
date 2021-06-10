@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Peranan</h1>
        </div>
        <div class="float-md-right float-lg-right">
            <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-chevron-left"></i>Kembali</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                PERANAN: Perincian peranan.
            </div>
            <div class="mb-2">
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-9">
                            <label>Nama Peranan</label> 
                            <div class="form-control">{{$role->display_name}}</div>
                        </div> 
                        <div class="form-group col-sm-3">
                            <label>Slug</label> 
                            <div class="form-control">{{$role->name}}</div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Slug</label> 
                            <div class="form-control">{{$role->name}}</div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Keizinan</label><br>
                            <small class="help-block"><i>Senarai keizinan bagi peranan ini.</i></small><br>
                            @foreach ($role->permissions as $permission)
                                <span class="badge bg-info text-dark">{{$permission->display_name}}</span>
                            @endforeach
                        </div>
                        <div class="col-sm-12">
                            <label>Pengguna</label><br>
                            <small class="help-block"><i>Ini adalah senarai pengguna yang menggunakan peranan ini.</i></small><br>
                            @foreach ($role->users as $user)
                                <span class="badge bg-info text-dark">{{$user->name}}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop