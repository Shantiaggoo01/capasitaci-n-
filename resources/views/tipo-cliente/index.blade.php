@extends('layouts.app2')

@section('template_title')
    Tipo Cliente
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
                                {{ __('Tipo Cliente') }}
                            </span>
                            
                             <div class="float-right">
                             @can('crear-tipocliente')
                                <a href="{{ route('tipo-clientes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
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

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tipoClientes as $tipoCliente)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $tipoCliente->Nombre }}</td>

                                            <td>
                                                <form action="{{ route('tipo-clientes.destroy',$tipoCliente->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('tipo-clientes.show',$tipoCliente->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    @can('editar-tipocliente')
                                                    <a class="btn btn-sm btn-success" href="{{ route('tipo-clientes.edit',$tipoCliente->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @endcan
                                                    @csrf
                                                    
                                                    @method('DELETE')
                                                    @can('borrar-tipocliente')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                    @endcan
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $tipoClientes->links() !!}
            </div>
        </div>
    </div>
@endsection
