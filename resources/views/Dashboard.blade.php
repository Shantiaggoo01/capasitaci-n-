@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script>
    var ctx = document.getElementById('ventas-chart').getContext('2d');
    var ventasData = {!! $ventas !!};

    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ventasData.map(v => v.fecha),
            datasets: [{
                label: 'Ventas',
                data: ventasData.map(v => v.total),
                backgroundColor: 'rgba(0, 119, 204, 0.3)',
                borderColor: 'rgba(0, 119, 204, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return '$' + value;
                        }
                    }
                }]
            }
        }
    });
</script>
<script>
    var ctx = document.getElementById('productos-chart').getContext('2d');
    var productosData = {!! $productos !!};

    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: productosData.map(p => p.nombre),
            datasets: [{
                data: productosData.map(p => p.cantidad),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: 'white',
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 12
                }
            }
        }
    });
    
</script>
<script>
    var ctx = document.getElementById('VeCo').getContext('2d');

var ventasData = @json($ventasA);
var comprasData = @json($comprasA);

var meses = [];
var ventas = [];
var compras = [];

ventasData.forEach(function(item) {
    meses.push('Mes ' + item.mes );
    ventas.push(item.total_ventas);
});

comprasData.forEach(function(item) {
    compras.push(item.total_compras);
});

var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: meses,
        datasets: [{
            label: 'Ventas',
            data: ventas,
            backgroundColor: 'green',
            borderColor: 'green',
            fill: false,
        },
        {
            label: 'Compras',
            data: compras,
            backgroundColor: 'red',
            borderColor: 'red',
            fill: false,
        }]
    },
    options: {
        responsive: true,
        title: {
            display: true,
            text: 'Ventas vs Compras del año actual'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

</script>
<script>
    var ctx = document.getElementById('clientes-chart').getContext('2d');

    var nombres = @json($clientes->pluck('Nombre'));
    var ventas = @json($clientes->pluck('TotalVentas'));

    var chart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: nombres,
            datasets: [{
                label: 'Total de ventas',
                data: ventas,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Clientes que generan mayor ingreso'
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
<script>
    function downloadPDFC() {
    // Obtener la referencia del canvas de la gráfica
    var canvas = document.getElementById('VeCo');

    // Convertir el canvas en una imagen base64
    var imgData = canvas.toDataURL('image/png');

    // Crear un objeto jsPDF y agregar la imagen
    var doc = new jsPDF();
    doc.addImage(imgData, 'PNG', 10, 10);

    // Descargar el archivo PDF
    doc.save('Compras-Vs-Ventas.pdf');
}

</script>
<script>
    function downloadPDF3() {
    // Obtener la referencia del canvas de la gráfica
    var canvas = document.getElementById('clientes-chart');

    // Convertir el canvas en una imagen base64
    var imgData = canvas.toDataURL('image/png');

    // Crear un objeto jsPDF y agregar la imagen
    var doc = new jsPDF();
    doc.addImage(imgData, 'PNG', 10, 10);

    // Descargar el archivo PDF
    doc.save('Mejores-Clientes.pdf');
}

</script>
<script>
    function downloadPDF2() {
    // Obtener la referencia del canvas de la gráfica
    var canvas = document.getElementById('productos-chart');

    // Convertir el canvas en una imagen base64
    var imgData = canvas.toDataURL('image/png');

    // Crear un objeto jsPDF y agregar la imagen
    var doc = new jsPDF();
    doc.addImage(imgData, 'PNG', 10, 10);

    // Descargar el archivo PDF
    doc.save('Productos-Mas-Vendidos.pdf');
}

</script>
<script>
    function downloadPDF1() {
    // Obtener la referencia del canvas de la gráfica
    var canvas = document.getElementById('ventas-chart');

    // Convertir el canvas en una imagen base64
    var imgData = canvas.toDataURL('image/png');

    // Crear un objeto jsPDF y agregar la imagen
    var doc = new jsPDF();
    doc.addImage(imgData, 'PNG', 10, 10);

    // Descargar el archivo PDF
    doc.save('Ventas-Semanales.pdf');
}

</script>
@endsection


@extends('layouts.app2')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total de ventas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                               Total de Ventas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalVenta">
                                {{$cantidad}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-basket fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total de Ingresos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total de Ingresos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 fas fa-dollar-sign fa-2x text-gray-300" id="totalIngresos">{{$total}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total de Productos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total de Productos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalProductos">{{$cproducto}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    

        <!-- Total de Categorias -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total de Producciones</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalCategorias">{{$cproduccion}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart - Ventas de los ultimos 7 días -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 bg-second-primary">
                    <h6 class="m-0 font-weight-bold text-white">Ventas de los ultimos 7 días</h6>
                    <button onclick="downloadPDF1()" style="background-color: #4e73df; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
    Descargar gráfica en PDF
</button>

                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area" style="height: 350px !important;">
                        <canvas id="ventas-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart - Productos más vendidos-->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 bg-second-primary">
                    <h6 class="m-0 font-weight-bold text-white">Productos más vendidos</h6>
                    <button onclick="downloadPDF2()" style="background-color: #4e73df; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Descargar gráfica en PDF</button>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie" style="height: 350px !important ;">
                        <canvas id="productos-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 bg-second-primary">
                    <h6 class="m-0 font-weight-bold text-white">Ventas y compras del año</h6>
                    <button onclick="downloadPDFC()" style="background-color: #4e73df; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Descargar gráfica en PDF</button>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie" style="height: 350px !important ;">
                        <canvas id="VeCo"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 bg-second-primary">
                    <h6 class="m-0 font-weight-bold text-white">Clientes que generan mayores ingresos</h6>
                    <button onclick="downloadPDF3()" style="background-color: #4e73df; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Descargar gráfica en PDF</button>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie" style="height: 350px !important ;">
                        <canvas id="clientes-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- /.container-fluid -->
 <!-- ============================================================
=SCRIPTS PARA ESTA PAGINA
===============================================================-->
<script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>

<!-- SOLO ES DE EJEMPLO - IGNORAR -->
<script src="{{asset('js/vistas/chart-bar-demo.js')}}"></script>
<script src="{{asset('js/vistas/chart-pie-demo.js')}}"></script>


@endsection