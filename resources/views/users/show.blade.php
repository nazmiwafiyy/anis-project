@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Pengguna</h1>
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
                PENGGUNA: Perincian pengguna.
            </div>
            <div class="mb-2">
            </div>
            <div class="card">
                <div class="card-body">
                    <img class="profile-user-img img-fluid img-circle mb-3" src="{{ Storage::url('avatars/'.$user->id.'/'.$user->avatar) }}" alt="User profile picture">
                    <h4 class="text-primary"></i>{{ $user->name }}</h4>
                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label>Nama</label> 
                            <div class="form-control">{{$user->name}}</div>
                        </div> 
                        <div class="form-group col-sm-4">
                            <label>E-mel</label> 
                            <div class="form-control">{{$user->email}}</div>
                        </div>
                        <div class="col-sm-12">
                            <label>Peranan</label><br>
                            <small class="help-block"><i>Ini adalah senarai peranan bagi pengguna ini.</i></small><br>
                            @foreach($user->roles as $role)
                                <span class="badge bg-info text-dark">{{ $role->display_name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop