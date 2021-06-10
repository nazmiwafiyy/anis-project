@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Permohonan</h1>
        </div>
        <div class="float-md-right float-lg-right">
            <a href="{{ route('application.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-chevron-left"></i> Kembali</a>
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
                    {!! Form::open(['route' => 'application.store','files'=>true ]) !!}
                    @include('application._form')
                    <div class="clearfix">
                        <div class="float-right">
                            {!! Form::button('<i class="fa fa-check"></i> Simpan', ['type' => 'submit', 'class' => 'btn btn-primary btn-sm'] )  !!}
                        </div>
                    </div>
                    {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} --}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('adminlte_js')
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            })
            
            //Initialize custom-file-input
            bsCustomFileInput.init();

            $('.files-div').hide();

            $('.handleType').each(function(event) {
                var content = $(this).attr('id');
                var type = parseInt($(this).attr('data-type-id'));
                var selectedType =  parseInt($('#type').val());

                if(type != selectedType){
                    $('.'+content).hide();
                }else{
                    $('.files-div').show();
                }
            });

            $('.handleType').click(function(event) {
                var content = $(this).attr('id');
                var type = $(this).attr('data-type-id');
                $('#type').val(type);
                $('#files').val('');
                $('#files').next('label').html('Pilih dokumen');
                $('.dropdown-item').removeClass('active');
                $(this).addClass('active');
                $('.handleType').each(function(event) {
                    var content = $(this).attr('id');
                    $('.'+content).hide();
                });
                $('.'+content).show();
                $('.files-div').show();
            });
        });
    </script>
@stop