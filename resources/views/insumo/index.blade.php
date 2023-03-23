@extends('layouts.app2')

@section('template_title')
Insumo
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
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Insumo') }}
                        </span>

                        <div class="float-right">
                            @can('crear-insumos')
                            <a href="{{ route('insumos.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Agregar Insumo') }}
                            </a>
                            @endcan
                        </div>

                    </div>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>

                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Unidad de medida</th>
                                    <th>Medida</th>
                                    <th>Cantidad de insumo</th>
                                    <th>Total de insumo</th>

                                    <th>Estado</th>
                                    @can('cambiar-estado')
                                    <th>Cambiar estado</th>
                                    @endcan
                                    <th>Acciones</th>
                                   

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insumos as $insumo)
                                <tr>

                                    <td>{{ ++$i }}</td>

                                    <td>{{ $insumo->Nombre }}</td>
                                    <td>{{ $insumo->Precio }}</td>
                                    <td>{{ $insumo->TipoCantidad }}</td>
                                    <td>{{ $insumo->Medida}}</td>
                                    <td>{{ $insumo->cantidad }}</td>
                                    <td>{{ $insumo->cantidadxMedida }}</td>

                                    <td>{{ $insumo->Estado ? 'Activo' : 'Inactivo' }}</td>

                                    @can('cambiar-estado')
                                    <td>
                                        <form action="{{ route('insumo.updateStatus',$insumo->id) }}" method="POST">
                                            @csrf
                                            @method('post')
                                            <button type="submit" class="btn btn-sm btn-{{ $insumo->Estado ? 'danger' : 'success' }}">
                                                {{ $insumo->Estado ? 'Desactivar' : 'Activar' }}
                                            </button>


                                        </form>
                                    </td>
                                    @endcan

                                    <td>
                                        <form action="{{ route('insumos.destroy',$insumo->id) }}" method="POST">
                                            
                                            @can('editar-insumos')
                                            <a class="btn btn-sm btn-success" href="{{ route('insumos.edit',$insumo->id) }}"><i class="fa fa-fw fa-edit"></i> Editar</a>
                                            @endcan
                                            @csrf


                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $insumos->links() !!}
        </div>
    </div>
</div>
@endsection