@extends('layouts.app2')

@section('template_title')
    Create Tipo Cliente
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Tipo Cliente</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('tipo-clientes.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('tipo-cliente.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
