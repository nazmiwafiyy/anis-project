@extends('adminlte::page')

{{-- @section('title', 'AdminLTE') --}}

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Tukar Kata Laluan</h1>
        </div>
        <div class="float-md-right float-lg-right">
            <a href="{{ route('home') }}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-chevron-left"></i>Kembali</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                TUKAR KATA LALUAN: Tukar kata laluan.
            </div>
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['profile.update-password'] ]) !!}
                    <div class="form-group">
                        {!! Form::label('current', 'Kata Laluan Semasa',['class'=>'required']) !!}
                        {!! Form::password('current', ['class' => 'form-control'.($errors->has('current') ? ' is-invalid' : null), 'placeholder' => 'Kata laluan semasa']) !!}
                        @if ($errors->has('current')) <small class="help-block text-danger">{{ $errors->first('current') }}</small> @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Kata Laluan Baru',['class'=>'required']) !!}
                        {!! Form::password('password', ['class' => 'form-control'.($errors->has('password') ? ' is-invalid' : null), 'placeholder' => 'Minimum lapan aksara, sekurang-kurangnya satu huruf besar, satu huruf kecil dan satu nombor']) !!}
                        @if ($errors->has('password')) <small class="help-block text-danger">{{ $errors->first('password') }}</small> @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Pengesahan Kata Laluan',['class'=>'required']) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control'.($errors->has('password_confirmation') ? ' is-invalid' : null), 'placeholder' => 'Pengesahan kata laluan']) !!}
                        @if ($errors->has('password_confirmation')) <small class="help-block text-danger">{{ $errors->first('password_confirmation') }}</small> @endif
                    </div>
                    <div class="clearfix">
                        <div class="float-right">
                            {!! Form::button('<i class="fa fa-fw fa-check"></i>Simpan', ['type' => 'submit', 'class' => 'btn btn-primary btn-sm'] )  !!}
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

