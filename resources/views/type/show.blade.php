@extends('adminlte::page')

{{-- @section('title', 'AdminLTE') --}}

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Jenis Permohonan</h1>
        </div>
        <div class="float-md-right float-lg-right">
            <a href="{{ route('type.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-chevron-left"></i>Kembali</a>
            <a href="{{ route('type.edit', $type->id)  }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i>Kemaskini</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                DEPARTMENT: Department details.
            </div>
            <div class="mb-2">
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label> 
                        <div class="form-control">{{$type->name}}</div>
                    </div> 
                    <div class="form-group">
                        <label>Had Permohonan</label> 
                        <div class="form-control">{{$type->limit}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop