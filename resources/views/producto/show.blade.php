@extends('layouts.app2')

@section('template_title')
    {{ $producto->name ?? 'Show Producto' }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });

        @if ($message = Session::get('success') )
            swal({
                title: "{{session::get('success')}}",
                icon: "success",
                button: "Aceptar",
            });
        @endif
    </script>
@endsection

@section('content')
    <div class="container my-5">
        @if(count($insumos) > 0)
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-3 text-center">Detalle Producto</h2>
                    <hr>
                    <table id="example" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre Producto</th>
                                <th>Nombre Insumo</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($insumos as $value)
                                <tr>
                                    <td>{{$producto->nombre}}</td>
                                    <td>{{$value->Nombre}}</td>
                                    <td>{{$value->cantidad}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No hay Insumos Registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        <button onclick="history.back()" type="button" class="btn btn-primary me-2">Volver</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
