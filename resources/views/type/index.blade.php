@extends('adminlte::page')

{{-- @section('title', 'AdminLTE') --}}

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Jenis Permohonan</h1>
        </div>
        @can('create-departments')
            <div class="float-md-right float-lg-right">
                {{-- <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-building"></i>New Department</a> --}}
            </div>
        @endcan
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                Perkara: Jenis permohonan.
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