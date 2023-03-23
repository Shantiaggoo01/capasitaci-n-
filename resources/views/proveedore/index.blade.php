@extends('layouts.app2')

@section('template_title')
Proveedores
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
                            {{ __('Proveedores') }}
                        </span>

                        <div class="float-right">
                            @can('crear-proveedor')
                            <a href="{{ route('proveedores.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                <i class="fa fa-plus"></i> {{ __('Agregar proveedor') }}
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

                                    <th>Nit</th>
                                    <th>Nombre</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Banco</th>
                                    <th>Cuenta</th>
                                    <th>Tipo proveedor</th>
                                    <th>Estado</th> <!-- agregue esto para el estado  -->
                                    @can('cambiar-estado')
                                    <th>Cambiar Estado</th>
                                    @endcan
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proveedores as $proveedore)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{ $proveedore->nit }}</td>
                                    <td>{{ $proveedore->nombre }}</td>
                                    <td>{{ $proveedore->direccion }}</td>
                                    <td>{{ $proveedore->telefono }}</td>
                                    <td>{{ $proveedore->banco }}</td>
                                    <td>{{ $proveedore->cuenta }}</td>
                                    <td>{{ $proveedore->tipoProveedor->nombre }}</td>
                              
                                    <td>{{ $proveedore->estado ? 'Activo' : 'Inactivo' }}</td>
                                    @can('cambiar-estado')
                                    <td>
                                        <form action="{{ route('provider.updateStatus',$proveedore->id) }}" method="post">
                                            @csrf
                                            @method('post')
                                           
                                            <button type="submit" class="btn btn-sm btn-  mr-2-{{ $proveedore->estado ? 'danger' : 'success' }}">
                                                {{ $proveedore->estado ? 'Desactivar' : 'Activar' }}
                                            </button>
                                           


                                        </form>
                                    </td>
                                    @endcan

                                    <td>

                                        <form action="{{ route('proveedores.destroy',$proveedore->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary  mr-2 " href="{{ route('proveedores.show',$proveedore->id) }}"><i class="fa fa-fw fa-eye"></i> Ver detalle</a> 
                                            @can('editar-proveedor')
                                            <a class="btn btn-sm btn-success mr-2" href="{{ route('proveedores.edit',$proveedore->id) }}"><i class="fa fa-fw fa-edit"></i> Editar</a>
                                            @endcan
                                            @csrf

                                            {{-- @method('DELETE')
                                            @can('borrar-proveedor')
                                            <button type="submit" class="btn btn-danger btn-sm mr-2 mt-2"><i class="fa fa-fw fa-trash"></i> Eliminar</button>
                                            @endcan --}}
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $proveedores->links() !!}
        </div>
    </div>
</div>
@endsection