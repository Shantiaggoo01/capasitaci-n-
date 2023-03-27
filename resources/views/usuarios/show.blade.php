@extends('layouts.app2')

@section('template_title')
Usuario
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


<!-- Body -->
<div class="container position-relative">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5 col-xxl-12">
            <div class="card mb-5">


                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="{{ asset('images/' . (Auth::user()->image ? Auth::user()->image : 'imgDefauld.jpg')) }}" width="180" height="160">

                    <h3 class="title mt-3"><b> {{ $user->name}} {{ $user->apellido }}</b></h3>
                    <hr>
                    <div class="mb-3">
                        <i class="title mt-3"><b>Documento&nbsp;:&nbsp;</b> </i> {{ $user->documento}}<br>
                        <i class="title mt-3"><b>Teléfono&nbsp;:&nbsp;</b></i>{{ $user->telefono }}<br>
                        <i class="title mt-3"><b>Rol&nbsp;:&nbsp;</b></i> @if(!empty($user->getRoleNames()))
                        <i style="color:red"> @foreach($user->getRoleNames() as $rolName)
                            {{$rolName}}
                            @endforeach
                            @endif
                        </i>
                        <br>
                        <i class="title mt-3"><b>Correo electrónico</b>&nbsp;:&nbsp;</i> {{ $user->email }}</i><br>

                        <h6 class="title mt-3"><b>Fecha de creación&nbsp;:&nbsp; {{ $user->created_at }}</b></h6>
                    </div>
                    
                  
                    @if(Auth::user()->id == $user->id)
                    @can('editar-usuario')
                    <a class="btn btn-primary float-center" href="{{ route('usuarios.edit', Auth::user()->id) }}">Editar</a>
                    @endcan
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection



























<!-- Esta linea de codigo es para subnir la imagen -->
<!-- <form action="/user/{{ $user->id }}/image" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Upload Image</button>
                    </form> -->