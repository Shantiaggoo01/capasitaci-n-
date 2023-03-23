@extends('layouts.app2')

@section('template_title')
    Cliente
@endsection
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script>$(document).ready(function () {
     $('#example').DataTable({
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        }
    });
});</script>
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
                                {{ __('Cliente') }}
                            </span>
                            
                             <div class="float-right">
                             @can('crear-cliente')
                                <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Agregar Cliente') }}
                                </a>
                                @endcan
                               
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
                            <table id="example" class="table table-striped table-hover">
                            <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
                                        <th>Nit</th>
										<th>Tipo de Cliente</th>
										<th>Nombre</th>
										<th>Apellido</th>
										<th>Teléfono</th>
										<th>Dirección</th>
                                        <th>Estado</th>
                                        @can('cambiar-estado')
                                        <th>Cambiar estado</th>
                                        @endcan
                                        <th>Acciones</th>
										

                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $cliente->NIT }}</td>
											<td>{{ $cliente->tipoCliente->Nombre }}</td>
											<td>{{ $cliente->Nombre }}</td>
											<td>{{ $cliente->Apellido }}</td>
											<td>{{ $cliente->Telefono }}</td>
											<td>{{ $cliente->Direccion }}</td>
                                            <td>{{ $cliente->Estado ? 'Activo' : 'Inactivo' }}</td>
                                            @can('cambiar-estado')
                                            <td>
                                                <form action="{{ route('cliente.updateStatus',$cliente->id) }}" method="post">
                                                    @csrf
                                                    @method('post')
                                                    <button type="submit" class="btn btn-sm btn-{{ $cliente->Estado ? 'danger' : 'success' }}">
                                                        {{ $cliente->Estado ? 'Desactivar' : 'Activar' }}
                                                    </button> 
                                                    

                                                </form>  
                                            </td>
                                            @endcan

                                            <td>
                                                <form action="{{ route('clientes.destroy',$cliente->id) }}" method="POST">
                                                    
                                                    @can('editar-cliente')
                                                    <a class="btn btn-sm btn-success" href="{{ route('clientes.edit',$cliente->id) }}"><i class="fa fa-fw fa-edit"></i> Editar</a>
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
                {!! $clientes->links() !!}
            </div>
        </div>
    </div>
@endsection
