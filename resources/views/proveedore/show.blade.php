@extends('layouts.app2')

@section('content')
<div class="container">
    <h1>Proveedor: {{ $proveedore->nombre }}</h1>

    <div class="row">
        <div class="col-md-6">
            <h3>Datos del proveedor</h3>
            <p><strong>Nombre:</strong> {{ $proveedore->nombre }}</p>
            <p><strong>NIT:</strong> {{ $proveedore->nit }}</p>
            <p><strong>Teléfono:</strong> {{ $proveedore->telefono }}</p>
            <p><strong>Dirección:</strong> {{ $proveedore->direccion }}</p>
            <h3>Datos del contacto</h3>
            <p><strong>Nombre:</strong> {{ $proveedore->NombreContacto }}</p>
            <p><strong>Teléfono:</strong> {{ $proveedore->TelefonoContacto }}</p>
        </div>
        <div class="col-md-6">
            <h3>Datos de facturación</h3>
            <p><strong>Tipo de proveedor:</strong> {{ $proveedore->tipoproveedor->nombre }}</p>
            <p><strong>Regimen:</strong> {{ $proveedore->regimen }}</p>
            <p><strong>Tipo de cuenta:</strong> {{ $proveedore->tipos_cuenta }}</p>
            <p><strong>Numero de cuenta:</strong> {{ $proveedore->cuenta }}</p>
            <p><strong>Dirección:</strong> {{ $proveedore->direccion }}</p>
        </div>
    </div>

    <h3>Usuario que registró el proveedor</h3>
    <p><strong>Nombre:</strong> {{ $proveedore->user->name }}</p>
    <p><strong>Email:</strong> {{ $proveedore->user->email }}</p>

</div>
<div style="text-align:center;">
    <a  onclick="history.back()"class="btn btn-primary my-3">Regresar</a>
</div>

@endsection