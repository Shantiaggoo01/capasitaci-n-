@extends('layouts.app2')

@section('template_title')
    Create Cliente
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Nuevo Cliente</span>
                    </div>
                    <div class="card-body">
                        <form id="form-cliente" method="POST" action="{{ route('clientes.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('cliente.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @section("script")
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
                            // Agrega el Sweet Alert cuando se envía el formulario
        $('#form-cliente').on('submit', function(event) {
            event.preventDefault();
            swal({
                title: "¿Está seguro?",
                text: "Una vez agregado el cliente, no se podrá editar su NIT.",
                icon: "warning",
                buttons: ["Cancelar", "Agregar"],
                dangerMode: true,
            })
                .then((willAdd) => {
                    if (willAdd) {
                                        // Envía el formulario
                    this.submit();
                } else {
                    swal("El cliente no se ha agregado.", {
                        icon: "info",
                    });
                }
            });
        });
    });
</script>
@endsection
@endsection
