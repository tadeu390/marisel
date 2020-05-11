@extends('adminlte::page')

@section('title', 'Clientes')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.clientes.includes.alerts')
                <div class="card">
                    <div class="card-header">
                        <a href="javascript:history.back(1)" title="Voltar a página anterior"><i class="far fa-arrow-alt-circle-left" style="font-size: 30px;"></i></a>
                    </div>
                    <div class="card-header">
                        Novo cliente
                    </div>
                    <div class="card-body">
                        <form action="{{route('clientes.store')}}" method="post" id="form_cadastrar_passageiro">
                            @include('admin.clientes._partials.form')
                            <button class="btn btn-primary" type="submit">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop