@extends('layouts.app2')

@section('template_title')
Roles
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
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        }
    });
    });
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@if  (Session::has('success'))
<script>
    swal({
        title: "{{session::get('success')}}",
        icon: "success",
        button: "Aceptar",
    }).then(function() {
            @if(Session::has('reload'))
                window.location.reload();
            @endif
        });
</script>
@endif

@if(Session::has('error'))
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
    var respuesta=confirm("¿Seguro que desea eliminar este rol?");

    if(respuesta==true){
        return true;
    }else {
        return false;
    }

    //'onclick'=>'return confirmacion()'
}

</script>

@endsection


@section('content')

<section class="content container-fluid">

    @includeif('partials.errors')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Roles</span>
            @can('crear-rol')
            <a href="{{route('roles.create')}}" class="btn btn-primary btn-sm float-right" data-placement="left" > Crear Rol</a>
            @endcan
        </div>
        <div class="card-body">
            
            <table id="example" class="table table-striped table-hover">
                <thead class="thead">
                    <tr>
                        
                            <th>Rol</th>
                            <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($roles as $role)
                        
                        <td>{{ $role->name }}</td>
                        <td>
                            @can('editar-rol')
                            <a class="btn btn-primary" href="{{route('roles.edit',$role->id)}}"> Editar </a>
                            @endcan
                            <a href="{{ route('roles.showPermissions', $role->id) }}" class="btn btn-primary">Mostrar Permisos</a>
                            @can('borrar-rol')
                            {!!Form::open(['method'=>'DELETE','onclick'=>'return confirmacion()','route'=>['roles.destroy',$role->id],'style'=>'display:inline'])!!}
                            {!!Form::submit('Borrar',['class' => 'btn btn-danger'])!!}
                            {!!Form::close()!!}
                            @endcan

                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection