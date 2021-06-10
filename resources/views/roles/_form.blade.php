<div class="form-group">
    {!! Form::label('display_name', 'Nama Peranan',['class'=>'required']) !!}
    {!! Form::text('display_name', isset($role) ? $role->display_name : old('display_name'), ['class' => 'form-control'.($errors->has('display_name') ? ' is-invalid' : null), 'placeholder' => 'Nama peranan']) !!}
    @if ($errors->has('display_name')) <small class="help-block text-danger">{{ $errors->first('display_name') }}</small> @endif
</div>

<div class="form-group">
    {!! Form::label('name', 'Slug',['class'=>'required']) !!}
    {!! Form::text('name', isset($role) ? $role->name : old('name'), ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : null), 'placeholder' => '', 'readonly' => 'readonly']) !!}
    @if ($errors->has('name')) <small class="help-block text-danger">{{ $errors->first('name') }}</small> @endif
</div>

<div class="card-header px-0 bg-transparent">
    <strong>Keizinan</strong><br> 
    <small class="text-muted">Aktifkan atau matikan keizinan dan pilih akses ke modul.</small><br>
    @if ($errors->has('permissions')) <small class="help-block text-danger">{{ $errors->first('permissions') }}</small> @endif
</div>
<div class="card-body">
    <div class="form-group row">
        @foreach ($modules as $module)
            @if ($module->permissions()->exists())
                <label class="col-md-2"><strong>{{$module->display_name}}</strong></label>
                <div class="col-md-10">   
                    @foreach ($module->permissions as $permission)
                        <div class="clearfix">
                            <span>{{$permission->display_name}}</span> 
                            <label class="switch float-right">
                                {!! Form::checkbox('permissions[]', $permission->id,isset($role) && in_array($permission->id,$role->permissions->pluck('id')->toArray()) ?  true : false) !!}
                                <span class="slider round"></span>
                            </label> 
                            <hr>
                        </div>
                    @endforeach 
                </div>
            @endif
        @endforeach
    </div>
</div>