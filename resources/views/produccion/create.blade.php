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
                        <span class="card-title">Crear Producción</span>
                    </div>
                    <div class="card-body">
                    <div class="box box-info padding-1">
    <div class="box-body">
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
        
        <form method="POST" action="{{ route('produccion.store') }}" id="form-produccion">
            @csrf
            <input type="hidden" name="detalles" value="">
            @csrf
                <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-head">
                                 <h4>Información de la producción</h4>
                                </div>
                                <div class="row card-body">
                                    <div class="form-group col-6">
                                        <label for="">Fecha Producción</label>
                                       <input type="datetime" class="form-control" name="FechaP" value='<?php echo date('Y-m-d');?>'>
                                    </div>
                                
                                    
                                    <div class="form-group col-6">
                                        <label for="">Fecha de Vencimiento</label>
                                        <input type="date" class="form-control" name="FechaV">
                                                
                                    </div>

                                    
                                </div>
                            </div>
                                
                          

                        </div>
                        <div class="col-6">
                            
                            <div class="card">
                                <div class="card-head">
                                  <h4>Información de productos</h4>
                                </div>
                                <div class="row card-body">
                                    <div class="form-group col-6">
                                        <label for="">Producto</label>
                                        <select class="form-control" name="producto" id="producto" onchange="colocar_precio()">
                                        <option value="0">Seleccion</option>
                                        @foreach ($productos as $producto)
                                            <option precio="{{$producto->precio}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                            @endforeach

                                        </select>
                                        
                                    </div>
                                
                                    
                                    <div class="form-group col-3">
                                        <label for="">Cantidad</label>
                                        <input id="cantidad" type="number" class="form-control" name="cantidad" min="150">
                                                
                                    </div>

                                    <div class="form-group col-3">
                                    <label for="">Precio</label>
                                        <input id="precio" type="text" value="0" class="form-control" readonly >
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
                                                <th>Opciones</th>
                                            </tr>

                                        </thead>
                                        <tbody id="tblproductos">

                                        </tbody>
                                    </table>
                </div>
                <div class="row text-center">
                    <div class="box-footer mt20">
                       <button type="submit" class="btn btn-primary"  onclick="confirmacion()">Guardar</button>
                    </div>
                </div>    
    </div>
        </form>
</div>
    

@section("script")
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        // Agrega el Sweet Alert cuando se envía el formulario
        $('#form-produccion').on('submit', function(event) {
            event.preventDefault();
            swal({
                title: "¿Estás seguro?",
                text: "Una vez agregada la producción, no podrás editarla.",
                icon: "warning",
                buttons: ["Cancelar", "Agregar"],
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
                    // Envía el formulario
                    this.submit();
                } else {
                    swal("La producción no se ha agregado.", {
                        icon: "info",
                    });
                }
            });
        });
    });
</script>
Asegúrate también de que no haya errores de sintaxis o de referencia en tu vista o en tu archivo de configuración de SweetAlert.





<script>
    function colocar_precio(){
        
        let precio = $("#producto option:selected").attr("precio");
        $("#precio").val(precio);
        console.log(precio);
    }

    function agregar_producto(){
        let detalles = [];
        let producto_id = $("#producto option:selected").val();
let producto_text = $("#producto option:selected").text();
let cantidad = $("#cantidad").val();
let precio = $("#precio").val();
let detalle = {
    producto_id: producto_id,
    cantidad: cantidad
};
detalles.push(detalle);


        if(cantidad >= 150 && precio > 0){
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
                    <td>
                        <button type="button" class="btn btn-danger" onclick="eliminar_producto(${producto_id}, ${parseInt(cantidad) * parseInt(precio)})">X</button>
                    </td>
               </tr>
            `);

            let precio_total = $("#precio_total").val() || 0;
            $("#precio_total").val( parseInt(cantidad) + parseInt(precio_total));

        }else if(cantidad<150){
            //mostrar error con sweet alert
            swal("Error", "La cantidad debe ser mayor a 150", "error");
        }


    }

    function eliminar_producto(id,subtotal){
        $("#tr-"+id).remove();
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