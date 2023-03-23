@extends('layouts.app2')

@section('template_title')
Crear Compra
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Crear Compra</span>

                </div>



                <div class="card-body">
                    <div class="box box-info padding-1">
                        <div class="box-body">

                            <form method="POST" action="{{ route('compra_insumos.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card">
                                            <br>
                                            <div class="card-head">
                                                <h4>&nbsp;&nbsp;&nbsp;<i>Informacion de la compra</i></h4>
                                            </div>
                                            <div class="row card-body">
                                                <div class="form-group col-6">
                                                    <label for="">Proveedor</label>
                                                    <select class="form-control" name="id_proveedor" id="proveedor" onchange="colocar_proveedor(this)" required>
                                                        <option value="">Seleccione el proveedor</option>
                                                        @foreach ($proveedores as $proveedor)
                                                        <option Nit="{{$proveedor->nit}}" value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for="">Código de factura</label>
                                                    <input id="nFactura" type="text" class="form-control" name="nFactura" value="{{ old('nFactura') }}">
                                                    @error('nFactura')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for=""> <i>NIT</i> </label>
                                                    <input id="Nit" type="text" class="form-control" name="nit" readonly>
                                                </div>

                                                <div class="form-group col-6">
                                                    <label for="">Fecha de compra</label>
                                                    <input type="date" class="form-control" name="FechaCompra" required max="{{ now()->toDateString() }}">
                                                    @error('FechaCompra')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                <div class="form-group col-6">
                                                    <label for=""><i>Precio total de la compra</i></label>
                                                    <input id="precio_total" type="text" class="form-control" name="precio_total" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">

                                        <div class="card">
                                            <br>
                                            <h4>&nbsp;&nbsp;&nbsp;<i>Informacion de los Insumos</i></h4>
                                            <div class="row card-body">
                                                <div class="form-group col-6">
                                                    <label for="">Insumo</label>
                                                    <select class="form-control" name="id_insumos" id="insumos" onchange="colocar_precio(this)" required>
                                                        <option value="">Seleccione el insumo</option>
                                                        @foreach ($insumos as $insumo)
                                                        <option Precio="{{$insumo->Precio}}" value="{{$insumo->id}}">{{$insumo->Nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-3">
                                                    <label for="">Cantidad</label>
                                                    <input id="cantidad" type="number" class="form-control" name="cantidad">
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


                    @section("js")


                    <script>
                        //confirmacion de Guardar 
                        function confirmacionGuardar() {
                            var respuesta = confirm("¡Confirme para guardar la información!");

                            if (respuesta == true) {
                                return true;
                            } else {
                                return false;
                            }

                            //'onclick'=>'return confirmacionGuardar()'
                        }
                    </script>

                    <script>
                        function colocar_proveedor() {

                            let Nit = $("#proveedor option:selected").attr("Nit");
                            $("#Nit").val(Nit);
                            console.log(Nit);
                        }


                        function colocar_precio() {

                            let Precio = $("#insumos option:selected").attr("Precio");
                            $("#Precio").val(Precio);
                            console.log(Precio);
                        }

                        function agregar_insumo() {
                            let id_insumo = $("#insumos option:selected").val();
                            let insumo_text = $("#insumos option:selected").text();
                            let cantidad = $("#cantidad").val();
                            let Precio = $("#Precio").val();

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

                            } else {
                                alert("se debe ingresar una cantidad o precio valido");
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