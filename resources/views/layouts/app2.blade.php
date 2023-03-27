<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema Tryp </title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i')}}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/sweetalert/sweetalert.css')}}" rel="stylesheet">
    @yield('css')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon">
                    <img src="{{asset('images/TRYP-1.jpg')}}" style="width: 50px" alt="">
                </div>  
                <div class="sidebar-brand-text mx-3">The Tryp</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Nav Item - Administración Collapse Menu -->
            @can('Ver-Menu-Configuracion')
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdministracion">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Configuración</span>
                </a>
                <div id="collapseAdministracion" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @can('ver-usuario')
                        <a class="collapse-item" href="{{route('usuarios.index')}}">Usuarios</a>
                        @endcan

                        @can('ver-roles')
                        <a class="collapse-item" href="{{route('roles.index')}}">Roles</a>
                        @endcan
                    </div>
                </div>
            </li>
            @endCan


            @can('Ver-Menu-Compras')
            <!-- Nav Item - Inventario Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventario">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Compras</span>
                </a>
                <div id="collapseInventario" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @can('ver-proveedor')
                        <a class="collapse-item" href="{{route('proveedores.index')}}">Proveedores</a>
                        @endCan
                        @can('ver-insumos')
                        <a class="collapse-item" href="{{route('insumos.index')}}">Insumos</a>
                        @endCan
                        @can('ver-compras')
                        <a class="collapse-item" href="{{route('compra_insumos.index')}}">Compras</a>
                        @endCan
                    </div>
                </div>
            </li>
            @endcan


            @can('Ver-Menu-Ventas')
            <!-- Nav Item - Venta Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVenta">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Ventas</span>
                </a>
                <div id="collapseVenta" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @can('ver-venta')
                        <a class="collapse-item" href="{{route('detalle_ventas.index')}}">Gestion de Ventas</a>
                        @endcan
                        @can('ver-cliente')
                        <a class="collapse-item" href="{{route('clientes.index')}}">Clientes</a>
                        @endcan
                        @can('ver-producto')
                        <a class="collapse-item" href="{{route('productos.index')}}">Productos</a>
                        @endcan
                    </div>
                </div>
            </li>
            @endcan


            <!-- Nav Item - Produccion Collapse Menu -->
            @can('Ver-Menu-Produccion')
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducción">
                    <i class="fas fa-fw fa-tag"></i>
                    <span>Producción</span>
                </a>
                <div id="collapseProducción" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @can( 'ver-produccion')
                        <a class="collapse-item" href="{{route('produccion.index')}}">Gestión de Producción</a>
                        @endcan
                    </div>
                </div>
            </li>
            @endcan

            <!-- Nav Item - Reportes Collapse Menu -->
            @can('Ver-Menu-Reportes')
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportes">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Ayudas</span>
                </a>
                <div id="collapseReportes" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{route('ayuda.index')}}">Seccion de Ayudas </a>
                    </div>
                </div>
            </li>
            @endcan



            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }} {{ Auth::user()->apellido }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset('images/' . (Auth::user()->image ? Auth::user()->image : 'imgDefauld.jpg')) }}">



                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('usuarios.show',  Auth::user()->id) }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Ver Perfil
                                </a>
                                <hr>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir

                                </a>
                            </div>
                        </li>

                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Tryp 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <!-- Bootstrap core JavaScript-->


    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.js')}}"></script>
    <script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('vendor/sweetalert/sweetalert.js')}}"></script>
    <script src="{{asset('vendor/loadingoverlay/loadingoverlay.min.js')}}"></script>

    @yield('js')

    @yield("script")
</body>

</html>