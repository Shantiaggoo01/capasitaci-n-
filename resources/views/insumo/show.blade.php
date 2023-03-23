@extends('layouts.app2')

@section('template_title')
    {{ $insumo->name ?? 'Show Insumo' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Insumo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('insumos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $insumo->Nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Precio:</strong>
                            {{ $insumo->Precio }}
                        </div>
                        <div class="form-group">
                            <strong>Tipocantidad:</strong>
                            {{ $insumo->TipoCantidad }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $insumo->Estado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
