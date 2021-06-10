@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Profil</h1>
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
                PROFIL: Masukkan maklumat profil anda.
            </div>
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['profile.update',$profile->id],'files'=>true, 'method' => 'PUT']) !!}
                    @include('profile._form')
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
        });

        $(function () {
            bsCustomFileInput.init();
            $('#picture').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => { 
                    $('#picture-preview').attr('src', e.target.result); 
                }
                reader.readAsDataURL(this.files[0]); 
            });
        });
        
    </script>
@stop

