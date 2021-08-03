<div class="form-group row">
    {!! Form::label('fullname', 'Nama Pemohon',['class' => 'col-md-2']) !!}
    {!! Form::text('fullname', isset($application) ? $application->fullname : old('fullname'), ['class' => 'no-border col-md-10', 'placeholder' => 'Nama Pemohon', 'readonly'=> true]) !!}
</div>

<div class="form-group row">
    {!! Form::label('identity_no', 'No. Kad Pengenalan',['class' => 'col-md-2']) !!}
    {!! Form::text('identity_no', isset($application) ? $application->identity_no : old('identity_no'), ['class' => 'no-border col-md-10', 'placeholder' => 'No. Kad Pengenalan', 'readonly'=> true]) !!}
</div>

<div class="form-group row">
    {!! Form::label('position_id', 'Jawatan',['class'=>'col-md-2']) !!}
    {!! Form::select('position_id', $position, isset($application) ? $application->position_id : old('position_id'),  ['class' => 'no-border col-md-10'.($errors->has('position_id') ? ' is-invalid' : null), 'placeholder' => 'Sila pilih jawatan', 'disabled'=> true]) !!}
    {{-- @if ($errors->has('position_id')) <small class="help-block text-danger">{{ $errors->first('position_id') }}</small> @endif --}}
</div>

<div class="form-group row">
    {!! Form::label('department_id', 'Bahagian / Unit',['class'=>'col-md-2']) !!}
    {!! Form::select('department_id', $department, isset($application) ? $application->department_id : old('department_id'),  ['class' => 'no-border col-md-10'.($errors->has('department_id') ? ' is-invalid' : null), 'placeholder' => 'Sila pilih bahagian/unit', 'disabled'=> true]) !!}
    {{-- @if ($errors->has('department_id')) <small class="help-block text-danger">{{ $errors->first('department_id') }}</small> @endif --}}
</div>

<div class="form-group row">
    {!! Form::label('phone_no', 'No Telefon',['class'=>'col-md-2']) !!}
    {!! Form::text('phone_no', isset($application) ? $application->phone_no : old('phone_no'), ['class' => 'no-border col-md-10'.($errors->has('phone_no') ? ' is-invalid' : null), 'placeholder' => 'cth : 0191234568', 'readonly'=> true]) !!}
    {{-- @if ($errors->has('phone_no')) <small class="help-block text-danger">{{ $errors->first('phone_no') }}</small> @endif --}}
</div>

<div class="form-group dropdown row">
    {!! Form::label('', 'Perkara',['class'=>'col-md-2']) !!}
    {!! Form::button('Jenis Permohonan', ['type' => 'button', 'class' => 'col-md-10 form-control dropdown-toggle', 'data-toggle'=>'dropdown','aria-expanded'=>'false', 'aria-haspopup'=>'true','id'=>'dropdownMenuButton'] )  !!}
    {!! Form::hidden('type_id', null, ['id' => 'type']) !!}
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @foreach ($types as $type)
            <a id="{{ $type->slug }}" data-type-id = "{{ $type->id }}" class="dropdown-item handleType">{{ $type->name }}</a>
        @endforeach
    </div>
    <br>
    @if ($errors->has('type_id')) <small class="help-block text-danger">{{ $errors->first('type_id') }}</small> @endif
</div>



<div class="get_baby">
    <div class="text-center">
        <h6>Menerima Cahaya Mata</h6>
        <small>(*3 orang anak sahaja termasuk anak angkat)</small>
    </div>
    <hr>
    <div class="form-group">
        {!! Form::label('attemp', 'Sila pilih tuntutan',['class'=>'required']) !!} 
        <div class="form-check">
            {!! Form::radio('attemp', 1 , (isset($application) && $application->attemp == 1) ||  old('attemp') == 1 ? true : false, ['class'=>'form-check-input'.($errors->has('attemp') ? ' is-invalid' : null)]) !!}
            {!! Form::label('attemp', 'Tuntutan Pertama',['class'=>'form-check-label']) !!}
        </div> 
        <div class="form-check">
            {!! Form::radio('attemp', 2 , (isset($application) && $application->attemp == 1) ||  old('attemp') == 2 ? true : false, ['class'=>'form-check-input'.($errors->has('attemp') ? ' is-invalid' : null)]) !!}
            {!! Form::label('attemp', 'Tuntutan Kedua',['class'=>'form-check-label']) !!}
        </div>
        <div class="form-check">
            {!! Form::radio('attemp', 3 , (isset($application) && $application->attemp == 1) ||  old('attemp') == 3 ? true : false, ['class'=>'form-check-input'.($errors->has('attemp') ? ' is-invalid' : null)]) !!}
            {!! Form::label('attemp', 'Tuntutan Ketiga',['class'=>'form-check-label']) !!}
        </div>
        @if ($errors->has('attemp')) <small class="help-block text-danger">{{ $errors->first('attemp') }}</small> @endif
    </div>
    <div class="form-group">
        {!! Form::label('notes', 'Catatan') !!}
        {!! Form::text('notes', null, ['class' => 'form-control'.($errors->has('notes') ? ' is-invalid' : null), 'placeholder' => 'Catatan']) !!}
        @if ($errors->has('notes')) <small class="help-block text-danger">{{ $errors->first('notes') }}</small> @endif
    </div>
</div>

<div class="get_married">
    <div class="text-center">
        <h6>Berkahwin</h6>
        <small></small>
    </div>
    <hr>
    <div class="form-group">
        {!! Form::label('notes', 'Catatan') !!}
        {!! Form::text('notes', null, ['class' => 'form-control'.($errors->has('notes') ? ' is-invalid' : null), 'placeholder' => 'Catatan']) !!}
        @if ($errors->has('notes')) <small class="help-block text-danger">{{ $errors->first('notes') }}</small> @endif
    </div>
</div>

<div class="warded">
    <div class="text-center">
        <h6>Ditahan Wad</h6>
        <small>(*1 kali kemasukan sahaja)</small>
    </div>
    <hr>
    <div class="form-group">
        {!! Form::label('notes', 'Catatan') !!}
        {!! Form::text('notes', null, ['class' => 'form-control'.($errors->has('notes') ? ' is-invalid' : null), 'placeholder' => 'Catatan']) !!}
        @if ($errors->has('notes')) <small class="help-block text-danger">{{ $errors->first('notes') }}</small> @endif
    </div>
</div>

<div class="family_death">
    <div class="text-center">
        <h6>Kematian Keluarga</h6>
        <small>(*Sila nyatakan hubungan keluarga)</small>
    </div>
    <hr>
    <div class="form-group">
        {!! Form::label('relationship', 'Sila nyatakan hubungan keluarga',['class'=>'required']) !!}
        {!! Form::text('relationship', null, ['class' => 'form-control'.($errors->has('relationship') ? ' is-invalid' : null), 'placeholder' => 'Hubungan keluarga']) !!}
        @if ($errors->has('relationship')) <small class="help-block text-danger">{{ $errors->first('relationship') }}</small> @endif
    </div>
</div>

<div class="hajj_and_umra">
    <div class="text-center">
        <h6>Haji dan Umrah</h6>
        <small>(*1 kali sahaja)</small>
    </div>
    <hr>
    <div class="form-group">
        {!! Form::label('notes', 'Catatan') !!}
        {!! Form::text('notes', null, ['class' => 'form-control'.($errors->has('notes') ? ' is-invalid' : null), 'placeholder' => 'Catatan']) !!}
        @if ($errors->has('notes')) <small class="help-block text-danger">{{ $errors->first('notes') }}</small> @endif
    </div>
</div>

<div class="form-group files-div">
    {!! Form::label('', 'Muat Naik Dokumen',['class'=>'required']) !!}
    <div class="custom-file form-control-sm mt-1 mb-1">
        {!! Form::file('files[]',['multiple'=>true,'id'=>'files','class'=>'custom-file-input form-control-sm'])!!}
        {!! Form::label('files', 'Pilih dokumen',['class'=>'custom-file-label col-form-label-sm required']) !!}
        @if ($errors->has('files')) <small class="help-block text-danger">{{ $errors->first('files') }}</small> @endif
        @if ($errors->has('files.*')) <small class="help-block text-danger">{{ $errors->first('files.*') }}</small> @endif
    </div>
</div> 