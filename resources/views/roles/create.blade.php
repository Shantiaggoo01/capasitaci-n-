@extends('layouts.app2')

@section('template_title')
Crear Usuarios
@endsection

@section('css')
<!-- agregamos para los estilos de la datatable  -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css">
@endsection
@section('js')
<!-- agregamos para los estilos de la datatable  -->

<!-- datos anteriores  -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            }
        });

        // Checkbox de selección "todos"
        $('#select-all').click(function() {
            $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        });
    });
</script>

<script>
    $(document).ready(function() {
    $('#exampledos').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        },
        "order": [[1, "asc"]]
    });

    // Checkbox de selección "todos"
    $('#select-all').click(function() {
        $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
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
        $('#form-roles').on('submit', function(event) {
            event.preventDefault();
            swal({
                    title: "¿Seguro que desea crear este rol ?",
                    icon: "warning",
                    buttons: ["Cancelar", "Guardar"],
                    dangerMode: true,
                })
                .then((willAdd) => {
                    if (willAdd) {
                        // Envía el formulario
                        this.submit();
                    } else {
                        swal("El rol no se ha creado.", {
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

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Crear Rol</span>
        </div>
        <div class="card-body">

            {!! Form::open(array('route' => 'roles.store', 'method' => 'POST', 'id' => 'form-roles')) !!}

            <div class="form-group">
                <label for="">
                    <h3>Nombre del rol</h3>
                </label>
                {!!Form::text('name',null,array('class'=>'form-control'))!!}

                @error('name')
                <div class="text-danger">{{ str_replace("name", "Nombre", $errors->first('name')) }}</div>
                @enderror

            </div>

            <h3>Permisos del menú:</h3>
            <table id="example" class="table table-striped table-hover">
                <thead class="thead">
                    <tr>
                        <th class="col-md-1 "><label>Seleccione</label></th>
                        <th><label for="">Permisos para este Rol:</label></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permission as $value)
                    @if($value->name == 'Ver-Menu-Configuracion' || $value->name == 'Ver-Menu-Compras' || $value->name == 'Ver-Menu-Ventas' || $value->name == 'Ver-Menu-Produccion' || $value->name == 'Ver-Menu-Reportes')
                    <tr>
                        <td>{{Form::checkbox('permission[]',$value->id,false,array('class'=>'name'))}}</td>
                        <td>{{ ucwords(str_replace('-', ' ', $value->name)) }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            <br><hr>

            <h3>Otros permisos:</h3>
            <table id="exampledos" class="table table-striped table-hover">
                <thead class="thead">
                    <tr>
                        <th class="col-md-1 "><label>Seleccione</label></th>
                        <th><label for="">Permisos para este Rol:</label></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permission as $value)
                    @if($value->name != 'Ver-Menu-Configuracion' && $value->name != 'Ver-Menu-Compras' && $value->name != 'Ver-Menu-Ventas' && $value->name != 'Ver-Menu-Produccion' && $value->name != 'Ver-Menu-Reportes')
                    <tr>
                        <td>{{Form::checkbox('permission[]',$value->id,false,array('class'=>'name'))}}</td>
                        <td>{{ ucwords(str_replace('-', ' ', $value->name)) }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>

            @error('permission')
            <div class="text-danger">{{ str_replace("permission", "Seleccione", $errors->first('permission')) }}</div>
            @enderror

            <br>

            <div class="col-md-12">

                <button onclick="history.back()" type="button" class="btn btn-primary float-left">Cancelar</button>

                <button type="submit" class="btn btn-primary float-right">Guardar</button>
            </div>
        </div>
        {!!Form::close()!!}


    </div>
</section>




@endsection