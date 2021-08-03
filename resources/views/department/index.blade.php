@extends('adminlte::page')

{{-- @section('title', 'AdminLTE') --}}

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Bahagian/Unit</h1>
        </div>
        @can('create-department')
            <div class="float-md-right float-lg-right">
                <a href="{{ route('department.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-building"></i>Bahagian/Unit Baru</a>
            </div>
        @endcan
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                BAHAGIAN/UNIT: Senarai bahagian/unit yang telah didaftarkan.
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