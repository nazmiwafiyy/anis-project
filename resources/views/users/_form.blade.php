<div class="form-group">
    {!! Form::label('name', 'Nama',['class'=>'required']) !!}
    {!! Form::text('name', isset($user) ? $user->name : old('name'), ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : null), 'placeholder' => 'Nama']) !!}
    @if ($errors->has('name')) <small class="help-block text-danger">{{ $errors->first('name') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('email', 'E-mel',['class'=>'required']) !!}
    {!! Form::text('email', isset($user) ? $user->email : old('email'), ['class' => 'form-control'.($errors->has('email') ? ' is-invalid' : null), 'placeholder' => 'E-mel']) !!}
    @if ($errors->has('email')) <small class="help-block text-danger">{{ $errors->first('email') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('password', 'Kata Laluan',['class'=>(isset($user) ? null : 'required')]) !!}
    {!! Form::password('password', ['class' => 'form-control'.($errors->has('password') ? ' is-invalid' : null), 'placeholder' => 'Kata Laluan']) !!}
    @if (isset($user)) <small class="help-block"><i>*Kata laluan baharu (tinggalkan kosong jika tidak berubah)</i></small> @endif
    @if ($errors->has('password')) <small class="help-block text-danger">{{ $errors->first('password') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('roles[]', 'Peranan',['class'=>'required']) !!}
    {!! Form::select('roles[]', $roles, isset($user) ? $user->roles->pluck('id')->toArray() : null,  ['class' => 'form-control select2'.($errors->has('roles') ? ' is-invalid' : null), 'multiple']) !!}
    @if ($errors->has('roles')) <small class="help-block text-danger">{{ $errors->first('roles') }}</small> @endif
</div>