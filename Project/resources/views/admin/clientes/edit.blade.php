@extends('adminlte::page')

@section('title', 'Clientes')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.clientes.includes.alerts')
                <div class="card">
                    <div class="card-header">
                        Editar cliente
                    </div>
                    <div class="card-body">
                        <form action="{{route('clientes.update', $cliente->id)}}" method="post" id="form_cadastrar_passageiro">
                            @method('PUT')
                            @include('admin.clientes._partials.form')
                            <button class="btn btn-primary" type="submit">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop