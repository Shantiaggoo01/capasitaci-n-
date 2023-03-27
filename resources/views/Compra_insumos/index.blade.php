@extends('layouts.app2')

@section('template_title')
Compra_insumos
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

@if(Session::has('error'))
<script>
    swal({
        title: "{{session::get('error')}}",
        icon: "error",
        button: "Aceptar",
    });
</script>
@endif

@endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div>
                        @if (session('status'))
                        <div class="alert alert-danger">
                            {{session('status')}}
                        </div>
                        @endif


                    </div>
                    @if($errors->any())
                    <div class="alert alert-dark alert-dismissible fade show" role="alert">
                        <strong>¡Revise los campos !</strong>
                        @foreach($errors->all() as $error)
                        <span class="badge badge-danger">{{$error}}</span>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div>

                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Compra') }}
                        </span>
                        @can('Crear-Compra')
                        <div class="float-right">
                            <a href="{{ route('compra_insumos.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Nueva Compra') }}
                            </a>
                        </div>

                        @endcan
                    </div>
                </div>


                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Total de compras por fecha</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('compra_insumos.index') }}" method="GET">
                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            @if(request()->has('fecha'))
                            <a href="{{ route('compra_insumos.index') }}" class="btn btn-secondary">Mostrar todo</a>
                            @endif
                        </form>

                        @if ($totalComprasFecha)
                        <div class="mt-3">
                            <h5>Total de compras para la fecha seleccionada: ${{ $totalComprasFecha }}</h5>
                        </div>
                        @else
                        <div class="mt-3">
                            <h5>No se encontraron compras para la fecha seleccionada</h5>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Compras</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>ID</th>
                                        <th>#Factura</th>
                                        <th>Proveedor</th>
                                        <th>Fecha de compra </th>
                                        <th>$Total Compra</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($compras as $comp)
                                    <tr>
                                        <td>{{ $comp->id }}</td>
                                        <td>{{ $comp->nFactura }}</td>
                                        <td>{{ $comp->nombreProveedor }}</td>
                                        <td>{{ $comp->FechaCompra }}</td>
                                        <td>{{ $comp->Total }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="compra_insumos/show?id={{$comp->id}}">Detalles</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection