<div class="form-group">
    {!! Form::label('name', 'Nama',['class'=>'required']) !!}
    {!! Form::text('name', isset($type) ? $type->name : old('name'), ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : null), 'placeholder' => 'Nama']) !!}
    @if ($errors->has('name')) <small class="help-block text-danger">{{ $errors->first('name') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('limit', 'Had Permohonan',['class'=>'required']) !!}
    {!! Form::number('limit', isset($type) ? $type->limit : old('limit'), ['min' => '1','class' => 'form-control'.($errors->has('limit') ? ' is-invalid' : null), 'placeholder' => 'Had permohonan']) !!}
    @if ($errors->has('limit')) <small class="help-block text-danger">{{ $errors->first('limit') }}</small> @endif
</div>

