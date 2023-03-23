@extends('layouts.app2')

@section('template_title')
Usuario
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

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}",
        icon: "success",
        button: "Aceptar",
    }).then(function() {
            @if(Session::has('reload'))
                window.location.reload();
            @endif
        });
</script>
@endif


@if(session('error'))
<script>
    swal({
        title: "{{session::get('error')}}",
        icon: "error",
        button: "Aceptar",
    }).then(function() {
            @if(Session::has('reload'))
                window.location.reload();
            @endif
        });
</script>
@endif

<script>
    //confirmacion de eliminar 
    function confirmacion() {
        var respuesta = confirm("¿Seguro que desea eliminar este usuario?");

        if (respuesta == true) {
            return true;
        } else {
            return false;
        }

        //'onclick'=>'return confirmacion()'
    }
</script>

<style>
    .role-label {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 8px;
        background-color: red;
        color: white;
        font-size: 0.8em;
        text-align: center;
    }
</style>

<style>
    .estado-label {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.8em;
        text-align: center;
    }

    .estado-activo {
        background-color: green;
        color: white;
    }

    .estado-inactivo {
        background-color: yellow;
        color: black;
    }
</style>

@endsection


@section('content')




<div class="card card-default">
    <div class="card-header">
        <span class="card-title">Usuarios</span>

        @can('crear-usuario')
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
            {{ __('Nuevo Usuario') }}
        </a>
        @endcan
    </div>
    <div class="card-body">

        <table id="example" class="table table-striped table-hover">
            <thead class="thead">
                <tr>
                    <th >ID</th>
                    <th >Nombre</th>
                    <th >Apellido</th>
                    <th class="text-center">Rol</th>
                    <th class="text-center">Estado del usuario</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->apellido }}</td>
                    <td class="text-center" >
                        @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $rolName)
                        <h5><span class="role-label">{{$rolName}}</span></h5>
                        @endforeach
                        @endif
                    </td>
                    <td class="text-center" >
                        @if ($user->estado == 1)
                        <h5> <span class="estado-label estado-activo">Activo</span> </h5>
                        @else
                        <h5> <span class="estado-label estado-inactivo">Inactivo</span> </h5>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(auth()->user()->hasRole('Empleado') && auth()->user()->id == $user->id)
                        <a class="btn btn-primary btn-sm d-inline-block" href="{{ route('usuarios.show', $user->id) }}">Ver Perfil</a>
                        @else
                        <a class="btn btn-primary btn-sm d-inline-block" href="{{ route('usuarios.show', $user->id) }}">Ver Perfil</a>
                        @endif

                        @can('editar-usuario')
                        @if ($user->id !== 1)
                        <a class="btn btn-success btn-sm d-inline-block" href="{{ route('usuarios.edit', $user->id) }}">
                            <i class="fas fa-pencil-alt"></i> Editar
                            <span class="badge badge-secondary">Asignar rol</span>
                        </a>
                        @endif
                        @endcan

                        @if ($user->id !== 1)
                        @if($user->estado == 1)
                        <form action="{{ route('usuarios.desactivar', $user->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Inactivar usuario</button>
                        </form>
                        @else
                        <form action="{{ route('usuarios.activar', $user->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Activar usuario</button>
                        </form>
                        @endif
                        @endif
                    </td>


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    @endsection