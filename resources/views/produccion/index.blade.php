@extends('layouts.app2')

@section('template_title')
    Produccion
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
@if ($message = Session::get('error') )
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
@if($productos->count() > 0)
    <div class="alert alert-danger">
        <h4>Productos con cantidad menor a 25:</h4>
        <ul>
            @foreach($productos as $producto)
                <li>{{ $producto->nombre }} ({{ $producto->cantidad }})</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Producción') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('produccion.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Agregar Producción') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Fecha Producción</th>
										<th>Cantidad</th>
										<th>Fecha Vencimiento</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produccions as $produccion)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $produccion->fecha_producción }}</td>
											<td>{{ $produccion->cantidad }}</td>
											<td>{{ $produccion->fecha_vencimiento }}</td>

                                            <td>
                                                <form action="{{ route('produccion.destroy',$produccion->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('produccion.show',$produccion->id) }}"><i class="fa fa-fw fa-eye"></i> Ver Detalle</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $produccions->links() !!}
            </div>
        </div>
    </div>
@endsection