@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ayudas</div>
                <div class="card-body">
                    <h3  class="d-flex justify-content-center" >Descargar manuales</h3>
                    <div class="d-flex justify-content-center"> <!-- agregado -->
                        <div class="btn-group" role="group">
                            <a href="{{ route('ayuda.descargar', ['archivo' => 'manual_instalacion.pdf']) }}" class="btn btn-primary mx-2"><i class="fa fa-download"></i>Descargar manual de instalación </a>
                            <a href="{{ route('ayuda.descargar-instalacion', ['archivo' => 'Manualde UsuarioTRYP(Final).pdf']) }}" class="btn btn-primary mx-2"><i class="fa fa-download"></i>Descargar manual de usuario </a>
                        </div>
                    </div> <!-- agregado -->
                    <hr>
                    <h3>Videos de ayuda</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div class="col-md-6">
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection