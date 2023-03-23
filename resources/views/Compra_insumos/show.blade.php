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
        $('#example').DataTable();
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
@endsection

@section('content')


@if(count($insumos) > 0)
<!-- 
 
detalle de el proveedor

<div class="row">
    <div class="row">
        <h1 colspan="4" class="text-center"><I>DETALLE DE LA COMPRA</I></h1>
        <hr>
        @forelse ($compras as $value)
        <tr>
            <div class="col-5">
                <h4><I>NUMERO FACTURA: {{$value->nFactura}}</I></h4>
            </div>
            <div class="col-5">
                <h4><I>TOTAL COMPRA: {{$value->Total}}</I></h4>
            </div>
        </tr>
        @empty
        @endforelse
    </div>

</div> -->

<div class="card-body">
    <div class="table-responsive">
        <div class="col">
            <h2 colspan="4" class="text-center">INSUMOS COMPRADOS</h2>
            <hr>
            <!-- Primera sección: lista de insumos comprados -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre Insumo</th>
            <th>Cantidad Compradas</th>
            <th>Precio Unitario</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total = 0;
        @endphp
        @forelse ($insumos as $value)
        <tr>
            <td>{{ $value->Nombre }}</td>
            <td>{{ $value->cantidad }}</td>
            <td>{{ $value->Precio }}</td>
            <td>{{ $value->Precio * $value->cantidad }}</td>
            @php
            $total += $value->Precio * $value->cantidad;
            @endphp
        </tr>
        @empty
        <tr>
            <td colspan="4">No hay Insumos Registrados</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total de la compra</th>
            <th>{{ $total }}</th>
        </tr>
    </tfoot>
</table>

<!-- Segunda sección: detalles del comprador y fecha de creación -->
<table class="table table-bordered">
    <tbody>
        <tr>
            <th>Compra Realizada por:</th>
            <td>{{ $compra->user->name }} {{ $compra->user->apellido }}</td>
        </tr>
        <tr>
            <th>Documento:</th>
            <td>{{ $compra->user->documento }}</td>
        </tr>
        <tr>
            <th>Fecha de Creación:</th>
            <td>{{ $compras[0]->created_at }}</td>
        </tr>
    </tbody>
</table>

        </div>
        <br>
        <button onclick="history.back()" type="button" class="btn btn-primary col">Atrás</button>

        @endif
    </div>
</div>


@endsection