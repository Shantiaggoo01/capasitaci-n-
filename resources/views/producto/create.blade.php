@extends('layouts.app2')

@section('template_title')
Crear Producto
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Crear Producto</span>

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

                <div class="card-body">
                    <div class="box box-info padding-1">
                        <div class="box-body">

                            <form method="POST" action="{{ route('productos.store') }}" id="form-producto">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card">
                                            <br>
                                            <div class="card-head">
                                            <h4>&nbsp;&nbsp;&nbsp;<i>Información de los productos</i></h4>
                                            </div>
                                            <div class="row card-body">
                                                

                                                <div class="form-group col-6">
                                                    <label for="">Nombre</label>
                                                    <input id="nombre" type="text" class="form-control" name="nombre">
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for=""> <i>Tamaño</i> </label>
                                                    <input id="tamaño" type="text" class="form-control" name="tamaño">
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for="">Sabor</label>
                                                    <input type="text" class="form-control" name="sabor" required>

                                                </div>

                                                <div class="form-group col-6">
                                                    <label for=""><i>Invima</i></label>
                                                    <input id="invima" type="number" class="form-control" name="invima">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for=""><i>Peso</i></label>
                                                    <input id="peso" type="text" class="form-control" name="peso">
                                                </div>
                                                {{ Form::hidden('cantidad', '0') }}
                                                <div class="form-group col-6">
                                                    <label for=""><i>Precio</i></label>
                                                    <input id="precio" type="text" class="form-control" name="precio">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">

                                        <div class="card">
                                            <br>
                                        <h4>&nbsp;&nbsp;&nbsp;<i>Información de los Insumos</i></h4>
                                            <div class="row card-body">
                                                <div class="form-group col-6">
                                                    <label for="">Insumo</label>
                                                    <select class="form-control" name="id_insumos" id="insumos" onchange="colocar_precio(this)">
                                                        <option value="0">Seleccione el insumo</option>
                                                        @foreach ($insumos as $insumo)
                                                        <option cantidadExistente='{{$insumo->cantidad}}' Precio="{{$insumo->Precio}}" value="{{$insumo->id}}">{{$insumo->Nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="">Cantidad Existente</label>
                                                    <input id="cantidadExistente" type="number" class="form-control" name="cantidadExistente" readonly>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="">Cantidad</label>
                                                    <input id="ccantidad" type="number" class="form-control" name="cantidad">
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="">Precio</label>
                                                    <input id="Precio" type="text" class="form-control" name="precio" readonly>
                                                </div>

                                                <div class="col-12">
                                                    <button onclick="agregar_insumo()" type="button" class="btn btn-success float-right">Agregar</button>
                                                </div>

                                            </div>
                                        </div class="card">
                                    </div>

                                    

                                </div>

                                <hr>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nombre Insumo </th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Subtotal</th>
                                                <th>Opciones</th>
                                            </tr>

                                        </thead>
                                        <tbody id="tblInsumos">

                                        </tbody>
                                    </table>

                                <hr>

                                <div class="col text-center">
                                    <div class="box-footer mt20">
                                        <button type="submit" class="btn btn-primary" onclick="return confirmacionGuardar()">Guardar</button>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>


                    @section('script')
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            // Agrega el Sweet Alert cuando se envía el formulario
                            $('#form-producto').on('submit', function(event) {
                                event.preventDefault();
                                swal({
                                    title: "¿Estás seguro?",
                                    text: "Una vez agregado el producto, no podrás editarlo.",
                                    icon: "warning",
                                    buttons: ["Cancelar", "Agregar"],
                                    dangerMode: true,
                                })
                                .then((willAdd) => {
                                    if (willAdd) {
                                        // Envía el formulario
                                        this.submit();
                                    } else {
                                        swal("El producto no se ha agregado.", {
                                            icon: "info",
                                        });
                                    }
                                });
                            });
                        });
                    </script>

                    <script>
                        function colocar_proveedor() {

                            let Nit = $("#proveedor option:selected").attr("Nit");
                            $("#Nit").val(Nit);
                            console.log(Nit);
                        }


                        function colocar_precio() {
                            let cantidadExistente =$("#insumos option:selected").attr("cantidadExistente");
        $("#cantidadExistente").val(cantidadExistente);
                            let Precio = $("#insumos option:selected").attr("Precio");
                            $("#Precio").val(Precio);
                            console.log(Precio);
                        }

                        function agregar_insumo() {
                            let cantidadExistente=$("#cantidadExistente").val();
                            let id_insumo = $("#insumos option:selected").val();
                            let insumo_text = $("#insumos option:selected").text();
                            let cantidad = $("#ccantidad").val();
                            let Precio = $("#Precio").val();
                            if(cantidad<=cantidadExistente){
                                if (cantidad > 0 && Precio > 0) {
                                $("#tblInsumos").append(`<tr id="tr-${id_insumo}"> 
                                
                    <td><input type="hidden" name="id_insumo[]" value="${id_insumo}"/> ${insumo_text}</td>

                    <td><input type="hidden" name="cantidades[]" value="${cantidad}"/> ${cantidad}</td>

                    <td>${Precio}</td>

                    <td>${parseInt(cantidad) * parseInt(Precio)}</td>

                    <td>
                        <button type="button" class="btn btn-danger" onclick="eliminar_insumo(${id_insumo}, ${parseInt(cantidad) * parseInt(Precio)})">X</button>
                    </td>
               </tr>
            `);

                                let precio_total = $("#precio_total").val() || 0;
                                $("#precio_total").val(parseInt(precio_total) + parseInt(cantidad) * parseInt(Precio));

                            }
                            else {
                                alert("se debe ingresar una cantidad o precio valido");
                            }
                            } else {
                                swal("La cantidad ingresada supera la disponible", {
                                            icon: "error",
                                        });
                            }
                             


                        }

                        function eliminar_insumo(id, subtotal) {



                            var respuesta = confirm("¿Seguro que desea eliminar el insumo agregado a la lista?");

                            if (respuesta == true) {
                                $("#tr-" + id).remove();
                                let precio_total = $("#precio_total").val() || 0;
                                $("#precio_total").val(parseInt(precio_total) - subtotal);

                                return true;
                            } else {
                                return false;
                            }

                        }
                    </script>

                    @endsection
                </div>
            </div>
        </div>
    </div>
</section>
@endsection