<div class="form-group">
    {!! Form::label('name', 'Nama',['class'=>'required']) !!}
    {!! Form::text('name', isset($position) ? $position->name : old('name'), ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : null), 'placeholder' => 'Nama']) !!}
    @if ($errors->has('name')) <small class="help-block text-danger">{{ $errors->first('name') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('description', 'Perincian',['class'=>'required']) !!}
    {!! Form::text('description', isset($position) ? $position->description : old('description'), ['class' => 'form-control'.($errors->has('description') ? ' is-invalid' : null), 'placeholder' => 'Perincian']) !!}
    @if ($errors->has('description')) <small class="help-block text-danger">{{ $errors->first('description') }}</small> @endif
</div>

