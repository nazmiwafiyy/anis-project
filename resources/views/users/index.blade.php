@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Pengguna</h1>
        </div>
        <div class="float-md-right float-lg-right">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-user"></i>Pengguna Baru</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                PENGGUNA: Senarai pengguna yang telah didaftarkan.
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {!! $html->table() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    {!! $html->scripts() !!}
@stop