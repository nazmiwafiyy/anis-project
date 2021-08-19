@extends('adminlte::page')

{{-- @section('title', 'AdminLTE') --}}

@section('content_header')
    <div class="clearfix">
        <div class="float-md-left float-lg-left">
            <h1 class="m-0 text-dark">Laporan Pengguna Sistem</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info collapsed-card">
                LAPORAN:Senarai pengguna sistem yang telah didaftarkan.
            </div>
            <div class="card collapsed-card">
                <div class="card-header">
                  <h3 class="card-title">Carian Terperinci</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body" style="display: none;">
                    @include('report._filterUser')
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
{!! $dataTable->scripts() !!}
<script>
    //Initialize Select2 Elements
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',
        allowClear: true,
        placeholder :'Pilih...'
    })

    $('.datatable-input').on('change', function(e) {
        var table = $('#usersdatatable-table').DataTable();
        e.preventDefault();
        var params = {};
        $('.datatable-input').each(function() {
            var i = $(this).data('col-index');
            if (params[i]) {
                params[i] += '|' + $(this).val();
            }
            else {
                params[i] = $(this).val();
            }
        });
        console.log(params);
        $.each(params, function(i, val) {
            // apply search params to datatable
            // table.column(i).search(val ? val : '', flase, false);//for LIKE search
            table.column(i).search(val ? '\\b' + val + '\\b' : '', true, false);//for id search
        });
        table.table().draw();
    });
</script>
@stop