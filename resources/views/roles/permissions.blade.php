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
    });
    {{ session()->forget('success') }}
</script>
@endif

@if(Session::has('error'))
<script>
    swal({
        title: "{{session::get('error')}}",
        icon: "error",
        button: "Aceptar",
    });
    {{ session()->forget('success') }}
</script>
@endif

<style>
.custom-table {
    width: 50%; /* ajusta el ancho según tu preferencia */
    margin: auto; /* centra la tabla */
    border-collapse: collapse; /* fusiona las celdas de la tabla */
}
.custom-table th, .custom-table td {
    padding: 8px; /* ajusta el espaciado interno */
    text-align: center; /* centra el contenido de las celdas */
}
</style>

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
    <div class="container">
        <h2>Permisos asignados al rol: {{ $role->name }}</h2>
        <table id="example" class="table table-striped table-hover custom-table">
            <thead>
                <tr>
                    <th>Nombre del Permiso</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ ucwords(str_replace('-', ' ', $permission->name)) }}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection