@extends('layouts.app2')

@section('template_title')
Crear Usuarios
@endsection
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            }
        });
    });
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if ($message = Session::get('success') )
<script>
    swal({
        title: "{{session::get('success')}}",
        icon: "success",
        button: "Aceptar",
    });
</script>
@endif
<script>
    $(document).ready(function() {
        // Agrega el Sweet Alert cuando se envía el formulario
        $('#form-usuario').on('submit', function(event) {
            event.preventDefault();
            swal({
                    title: "¿Seguro que desea editar este usuario ?",
                    icon: "warning",
                    buttons: ["Cancelar", "Guardar"],
                    dangerMode: true,
                })
                .then((willAdd) => {
                    if (willAdd) {
                        // Envía el formulario
                        this.submit();
                    } else {
                        swal("El usuario no se ha editado.", {
                            icon: "info",
                        });
                    }
                });
        });
    });
</script>

@endsection
@section('content')

<section class="content container-fluid">

    @includeif('partials.errors')






    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['usuarios.update', $user->id], 'enctype' => 'multipart/form-data', 'id' => 'form-usuario']) !!}


    <div class="card card-default">

        <div class="card card-default">

            <div class="card-header text-center">
                <span class="card-title">
                    <label>
                        <h4>Asignar rol al usuario: <i style="color:RED">{{$user->name}} {{$user->apellido}}&nbsp;&nbsp;&nbsp;
                            </i>Rol actual : @if(!empty($user->getRoleNames()))
                            <strong style="color:red">
                                @foreach($user->getRoleNames() as $rolName)
                                {{$rolName}}
                                @endforeach
                            </strong>
                            @else
                            <em>No hay roles asignados</em>
                            @endif</i>
                        </h4>
                </span>
            </div>


            <br>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="roles">Rol del usuario</label>
                    <?php
                    // Establece el valor seleccionado en el menú desplegable como el rol actual del usuario
                    $selectedRole = !empty($selectedRoles) ? $selectedRoles[0] : null;
                    $roles = array_merge(['' => '--- Ninguno ---'], $roles);
                    ?>
                    @if(Auth::user()->hasRole('Administrador'))
                    {!! Form::select('roles[]', $roles, $selectedRole, ['class' => 'form-control']) !!}
                    @if ($errors->has('roles'))
                    <span class="help-block">
                        <strong>{{ $errors->first('roles') }}</strong>
                    </span>
                    @endif
                    @else
                    {!! Form::select('roles[]', $roles, $selectedRoles, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                    <input type="hidden" name="roles[]" value="{{ $selectedRole }}">
                    @endif
                </div>
            </div>

        </div>
        <br>
        <hr>
        <br>

        <div class="card-header">
            <div class="card-header text-center">
                <img class="rounded-circle mb-3 mt-4" src="{{asset('images/' . $user->image) }}" alt="{{ $user->name }}" width="180" height="160">
                <div class="form-group">
                    <img id="preview" style="width: 200px;">
                    <input type="file" name="image" id="image" class="form-control">
                    @error('image')
                    <div class="text-danger">{{ str_replace("image", "Imagen", $errors->first('image')) }}</div>
                    @enderror
                    <br>
                </div>
                <span class="card-title">
                    <h3>Informacion del usuario : <i style="color:RED">{{$user->name}} {{$user->apellido}}</i></h3>
                </span>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                    <label for="roles">Documento</label>
                        @if(Auth::user()->hasRole('Administrador'))
                        {!!Form::text('documento',null,array('class'=>'form-control'))!!}
                        @if ($errors->has('documento'))
                        @error('documento')
                        <div class="text-danger">{{ str_replace("documento", "Documento", $errors->first('documento')) }}</div>
                        @enderror
                        @endif
                        @else
                        {!!Form::text('documento',null,array('class'=> 'form-control', 'disabled' => 'disabled')) !!}
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            {!!Form::text('name',null,array('class'=>'form-control'))!!}
                            @error('name')
                            <div class="text-danger">{{ str_replace("name", "Nombre", $errors->first('name')) }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            {!!Form::text('apellido',null,array('class'=>'form-control'))!!}
                            @error('apellido')
                            <div class="text-danger">{{ str_replace("apellido", "Apellido", $errors->first('apellido')) }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            {!!Form::text('telefono',null,array('class'=>'form-control'))!!}
                            @error('telefono')
                            <div class="text-danger">{{ str_replace("telefono", "Teléfono", $errors->first('telefono')) }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            {!!Form::text('direccion',null,array('class'=>'form-control'))!!}
                            @error('direccion')
                            <div class="text-danger">{{ str_replace("direccion", "Dirección", $errors->first('direccion')) }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form group">
                            <label for="email">E-mail</label>
                            {!!Form::text('email',null,array('class'=>'form-control'))!!}
                            @error('email')
                            <div class="text-danger">{{ str_replace("email", "E-Mail", $errors->first('email')) }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password"> Cambiar Contraseña </label>
                            {!!Form::password('password',array('class'=>'form-control'))!!}
                            @error('password')
                            <div class="text-danger">{{ str_replace("password", "Contraseña", $errors->first('password')) }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="confirm-password"> Confirmar contraseña </label>
                            {!!Form::password('confirm-password',array('class'=>'form-control'))!!}
                            @error('confirm-password')
                            <div class="text-danger">{{ str_replace("confirm-password", "Confirmar Contraseña", $errors->first('confir-password')) }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">

                        <button onclick="history.back()" type="button" class="btn btn-primary float-left">Cancelar</button>
                        <button type="submit" class="btn btn-primary float-right" onclick="return confirmacionGuardar();" history.back()">Editar</button>
                    </div>



                </div>

                {!!Form::close()!!}


            </div>
        </div>

</section>




@endsection