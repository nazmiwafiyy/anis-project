@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Peranan</h1>
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
                PENGGUNA: Buat peranan baru dan pilih keizinan supaya anda dapat memberikannya kepada pengguna.
            </div>
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['roles.store'] ]) !!}
                    @include('roles._form',['modules' => $modules])
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
        $('#display_name').keyup(function() {
            let slug = $(this).val().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');
            $('#name').val(slug);
        });
    </script>
@stop

