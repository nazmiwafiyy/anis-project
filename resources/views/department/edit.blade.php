@extends('adminlte::page')

{{-- @section('title', 'AdminLTE') --}}

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Bahagian/Unit</h1>
        </div>
        <div class="float-md-right float-lg-right">
            <a href="{{ route('department.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-chevron-left"></i> Kembali</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                BAHAGIAN/UNIT: Kemaskini bahagian/unit.
            </div>
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['department.update',$department->id], 'method' => 'PUT']) !!}
                    @include('department._form')
                    <div class="clearfix">
                        <div class="float-right">
                            {!! Form::button('<i class="fa fa-fw fa-check"></i> Simpan', ['type' => 'submit', 'class' => 'btn btn-primary btn-sm'] )  !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('adminlte_js')
    <script>
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    </script>
@stop

