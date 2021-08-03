<a href="{{ route($entity.'.show', $id)  }}" class="btn btn-xs btn-secondary"><i class="fa fa-eye"></i> </a>
@if ($entity != 'application')
<a href="{{ route($entity.'.edit', $id)  }}" class="btn btn-xs btn-secondary"><i class="fa fa-edit"></i> </a>
{!! Form::open( ['method' => 'delete', 'url' => route($entity.'.destroy',  $id), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Anda pasti untuk menghapuskan data ini?")']) !!}
<button type="submit" class="btn btn-xs btn-secondary"><i class="fa fa-trash"></i> </button>
{!! Form::close() !!}
@endif

@if ($entity == 'application' && $canEdit)
<a href="{{ route($entity.'.edit', $id)  }}" class="btn btn-xs btn-secondary"><i class="fa fa-edit"></i> </a>
{!! Form::open( ['method' => 'delete', 'url' => route($entity.'.destroy',  $id), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Anda pasti untuk menghapuskan data ini?")']) !!}
<button type="submit" class="btn btn-xs btn-secondary"><i class="fa fa-trash"></i> </button>
{!! Form::close() !!}
@endif
