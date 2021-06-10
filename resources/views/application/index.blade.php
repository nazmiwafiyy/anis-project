@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Permohonan</h1>
        </div>
        <div class="float-md-right float-lg-right">
            <a href="{{ route('application.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-copy"></i> Permohonan Baru</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                MOD DEMO: Beberapa ciri tidak tersedia untuk pemasangan ini.
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="mb-0"></p>
                </div>
            </div>
        </div>
    </div>
@stop