@extends('adminlte::page')

{{-- @section('title', 'AdminLTE') --}}

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Position</h1>
        </div>
        <div class="float-md-right float-lg-right">
            <a href="{{ route('position.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-chevron-left"></i>Back</a>
            <a href="{{ route('position.edit', $position->id)  }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i>Edit</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                POSITION: Position details.
            </div>
            <div class="mb-2">
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label> 
                        <div class="form-control">{{$position->name}}</div>
                    </div> 
                    <div class="form-group">
                        <label>Description</label> 
                        <div class="form-control">{{$position->description}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop