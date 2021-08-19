<div>
    <div class="form-row justify-content-end">
        <div class="col-md-4 mb-2">
            {!! Form::label('role', 'Peranan') !!}
            {!! Form::select('role',$roles,null,['class' => 'form-control form-control-sm select2 datatable-input','placeholder' => 'Pilih Peranan','data-col-index'=>'3']) !!}
        </div>
        <div class="col-md-4 mb-2">
            {!! Form::label('position', 'Jawatan') !!}
            {!! Form::select('position',$positions,null,['class' => 'form-control form-control-sm select2 datatable-input','placeholder' => 'Pilih Jawatan','data-col-index'=>'5']) !!}
        </div>
        <div class="col-md-4 mb-2">
            {!! Form::label('department', 'Bahagian/Unit') !!}
            {!! Form::select('department',$departments,null,['class' => 'form-control form-control-sm select2 datatable-input','placeholder' => 'Pilih Bahagian/Unit','data-col-index'=>'6']) !!}
        </div>
    </div>
    {{-- <button type="submit" class="float-right btn btn-sm btn-primary">Cari</button> --}}
</div>
  