<div class="form-group">
    <div class="media">
        <img id="picture-preview" src="{{ Auth::user()->adminlte_image() }}" class="mr-4" style="width: 120px; height: 120px;">
    </div>

    
    
</div>
<div class="form-group col-md-4 col-sm-12">
    <div class="custom-file form-control-sm mt-1 mb-1">
        {!! Form::label('picture', 'Pilih gambar',['class'=>'custom-file-label col-form-label-sm required']) !!}
        {!! Form::file('picture',['id'=>'picture','class'=>'custom-file-input form-control-sm'])!!}
        @if ($errors->has('picture')) <small class="help-block text-danger">{{ $errors->first('picture') }}</small> @endif
    </div>
</div>
<small class="form-text text-muted mb-3">Dengan menukar gambar akan membuang gambar semasa anda</small>
<div class="form-group">
    {!! Form::label('fullname', 'Nama Penuh',['class'=>'required']) !!}
    {!! Form::text('fullname', isset($profile) ? $profile->fullname : old('fullname'), ['class' => 'form-control'.($errors->has('fullname') ? ' is-invalid' : null), 'placeholder' => 'Nama Penuh']) !!}
    @if ($errors->has('fullname')) <small class="help-block text-danger">{{ $errors->first('fullname') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('identity_no', 'No Kad Pengenalan',['class'=>'required']) !!}
    {!! Form::text('identity_no', isset($profile) ? $profile->identity_no : old('identity_no'), ['class' => 'form-control'.($errors->has('identity_no') ? ' is-invalid' : null), 'placeholder' => 'cth : 970124-14-5234']) !!}
    @if ($errors->has('identity_no')) <small class="help-block text-danger">{{ $errors->first('identity_no') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('phone_no', 'No Telefon',['class'=>'required']) !!}
    {!! Form::text('phone_no', isset($profile) ? $profile->phone_no : old('phone_no'), ['class' => 'form-control'.($errors->has('phone_no') ? ' is-invalid' : null), 'placeholder' => 'cth : 0191234568']) !!}
    @if ($errors->has('phone_no')) <small class="help-block text-danger">{{ $errors->first('phone_no') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('position_id', 'Jawatan',['class'=>'required']) !!}
    {!! Form::select('position_id', $position, isset($profile) ? $profile->position_id : old('position_id'),  ['class' => 'form-control select2'.($errors->has('position_id') ? ' is-invalid' : null), 'placeholder' => 'Sila pilih jawatan']) !!}
    @if ($errors->has('position_id')) <small class="help-block text-danger">{{ $errors->first('position_id') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('department_id', 'Bahagian / Unit',['class'=>'required']) !!}
    {!! Form::select('department_id', $department, isset($profile) ? $profile->department_id : old('department_id'),  ['class' => 'form-control select2'.($errors->has('department_id') ? ' is-invalid' : null), 'placeholder' => 'Sila pilih bahagian/unit']) !!}
    @if ($errors->has('department_id')) <small class="help-block text-danger">{{ $errors->first('department_id') }}</small> @endif
</div>

