@extends('layouts.app2')

@section('content')
    <div class="container">
        <h1>Detalles de la producción</h1>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2>Producción:</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha de producción</th>
                            <th>Cantidad</th>
                            <th>Fecha de vencimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $produccion->fecha_producción }}</td>
                            <td>{{ $produccion->cantidad }}</td>
                            <td>{{ $produccion->fecha_vencimiento }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <h2>Productos:</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad Producida</th>
                            <th>Cantidad Disponible</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->nombre }}</td>
                                <td>{{ $produccion->cantidad }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{ route('produccion.index') }}" class="btn btn-primary">Regresar</a>
    </div>
@endsection
