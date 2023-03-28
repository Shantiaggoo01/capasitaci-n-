@extends('layouts.app2')

@section('template_title')
Crear venta
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Crear venta</span>
                </div>
                <div class="card-body">
                    <div class="box box-info padding-1">
                        <div class="box-body">

                            <form id="form-venta" method="POST" action="{{ route('detalle_ventas.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-head">
                                                <h4>Información de la venta</h4>
                                            </div>
                                            <div class="row card-body">
                                                <div class="form-group col-6">
                                                    <label for="">Cliente</label>
                                                    <select class="form-control" name="Cliente" id="Cliente" placeholder="Seleccion" onchange="colocar()" required>
                                                        <option value="">Seleccion</option>
                                                        @foreach ($clientes as $cliente)
                                                        <option NIT="{{$cliente->NIT}}" TipoCliente="{{$cliente->tipoCliente->Nombre}}" value="{{$cliente->id}}">{{$cliente->Nombre}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for="">Fecha de venta</label>
                                                    <input type="datetime" class="form-control" name="FechaVenta" value='<?php echo date('Y-m-d'); ?>' readonly>
                                                    @error('FechaVenta')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for="">NIT</label>
                                                    <input id="NIT" type="text" value="0" class="form-control" readonly>
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for="">Tipo de cliente</label>
                                                    <input id="TipoCliente" type="text" value="" class="form-control" readonly>
                                                </div>




                                                <div class="form-group col-6">
                                                    <label for="">Total</label>
                                                    <input id="precio_total" type="text" class="form-control" name="precio_total" readonly>

                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="col-6">

                                        <div class="card">
                                            <div class="card-head">
                                                <h4>Informacion de productos</h4>
                                            </div>
                                            <div class="row card-body">
                                                <div class="form-group col-6">
                                                    <label for="">Producto</label>
                                                    <select class="form-control" name="producto" id="producto" onchange="colocar_precio()" required>
                                                        <option value="0">Seleccion</option>
                                                        @foreach ($productos as $producto)
                                                        <option cantidadExistente="{{$producto->cantidad}}" tamaño="{{$producto->tamaño}}" peso="{{$producto->peso}}" sabor="{{$producto->sabor}}" precio="{{$producto->precio}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                        @endforeach

                                                    </select>

                                                </div>


                                                <div class="form-group col-3">
                                                    <label for="">Cantidad</label>
                                                    <input id="cantidad" type="number" class="form-control" name="cantidad">
                                                    @error('cantidad')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="">Cantidad Existente</label>
                                                    <input id="cantidadExistente" type="text" value="0" class="form-control" readonly>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="">Peso</label>
                                                    <input id="peso" type="text" value="0" class="form-control" readonly>
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for="">Sabor</label>
                                                    <input id="sabor" type="text" value="" class="form-control" readonly>
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for="">Tamaño</label>
                                                    <input id="tamaño" type="text" value="" class="form-control" readonly>
                                                </div>



                                                <div class="form-group col-6">
                                                    <label for="">Precio</label>
                                                    <input id="precio" type="text" value="0" class="form-control" readonly>
                                                </div>

                                                <div class="col-12">
                                                    <button onclick="agregar_producto()" type="button" class="btn btn-success float-right">Agregar</button>
                                                </div>

                                            </div>
                                        </div class="card">

                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Subtotal</th>
                                                <th>Opciones</th>
                                            </tr>

                                        </thead>
                                        <tbody id="tblproductos">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row text-center">
                                    <div class="box-footer mt20">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>


                    @section("script")
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            // Agrega el Sweet Alert cuando se envía el formulario
                            $('#form-venta').on('submit', function(event) {
                                event.preventDefault();
                                swal({
                                        title: "¿Está seguro?",
                                        text: "Una vez agregada la venta, no podrá ser editada.",
                                        icon: "warning",
                                        buttons: ["Cancelar", "Agregar"],
                                        dangerMode: true,
                                    })
                                    .then((willAdd) => {
                                        if (willAdd) {
                                            // Envía el formulario
                                            this.submit();
                                        } else {
                                            swal("La venta no se ha agregado.", {
                                                icon: "info",
                                            });
                                        }
                                    });
                            });
                        });
                    </script>

                    <script>
                        function colocar() {
                            let nit = $("#Cliente option:selected").attr("NIT");
                            let tipo = $("#Cliente option:selected").attr("TipoCliente");
                            $("#NIT").val(nit);
                            console.log(nit);
                            $("#TipoCliente").val(tipo);
                            console.log(tipo);
                        }

                        function colocar_precio() {

                            let cantidadExistente = $("#producto option:selected").attr("cantidadExistente");
                            $("#cantidadExistente").val(cantidadExistente);
                            console.log(cantidadExistente);

                            let precio = $("#producto option:selected").attr("precio");
                            $("#precio").val(precio);
                            console.log(precio);

                            let sabor = $("#producto option:selected").attr("sabor");
                            $("#sabor").val(sabor);
                            console.log(sabor);


                            let peso = $("#producto option:selected").attr("peso");
                            $("#peso").val(peso);
                            console.log(peso);

                            let tamaño = $("#producto option:selected").attr("tamaño");
                            $("#tamaño").val(tamaño);
                            console.log(tamaño);
                        }

                        function agregar_producto() {
                            let cantidadExistente = $("#cantidadExistente").val();
                            let producto_id = $("#producto option:selected").val();
                            let producto_text = $("#producto option:selected").text();
                            let cantidad = $("#cantidad").val();
                            let precio = $("#precio").val();

                            if (cantidad > cantidadExistente) {
                                if (cantidad > 0 && precio > 0) {
                                    $("#tblproductos").append(`
               <tr id="tr-${producto_id}"> 
                    <td>
                        <input type="hidden" name="producto_id[]" value="${producto_id}"/>
                        ${producto_text}
                    </td>
                    <td>
                        <input type="hidden" name="cantidades[]" value="${cantidad}"/>
                        ${cantidad}
                    </td>
                    <td>${precio}</td>
                    <td>${parseInt(cantidad) * parseInt(precio)}</td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="eliminar_producto(${producto_id}, ${parseInt(cantidad) * parseInt(precio)})">X</button>
                    </td>
               </tr>
            `);

                                    let precio_total = $("#precio_total").val() || 0;
                                    $("#precio_total").val(parseInt(precio_total) + parseInt(cantidad) * parseInt(precio));

                                } else {
                                    alert("se debe ingresar una cantidad o precio valido");
                                }

                            } else {
                                alert("La cantidad ingresada es mayor a la existente");
                            }




                        }

                        function eliminar_producto(id, subtotal) {
                            $("#tr-" + id).remove();
                            let precio_total = $("#precio_total").val() || 0;
                            $("#precio_total").val(parseInt(precio_total) - subtotal);

                        }
                    </script>
                    @endsection
                </div>
            </div>
        </div>
    </div>
</section>
@endsection