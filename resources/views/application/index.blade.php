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
                PERMOHONAN: Senarai permohonan yang telah dibuat.
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