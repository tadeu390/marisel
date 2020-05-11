@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form class="form-inline" action="{{route('clientes.busca')}}" method="POST">
                    @csrf
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="nome" class="sr-only">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{$filtros['nome'] ?? ''}}">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="rg" class="sr-only">RG</label>
                        <input type="text" class="form-control" id="rg" name="rg" placeholder="RG" value="{{$filtros['rg'] ?? ''}}">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid index-cliente-page">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.clientes.includes.alerts')
                <div class="card">
                    <div class="card-header text-right">
                        <a class="btn btn-primary" style="color: white !important;" href="{{route('clientes.create')}}">Adicionar</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Nome</td>
                                        <td>Telefone</td>
                                        <td>RG</td>
                                        <td class="text-right">Ações</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->nome}}</td>
                                            <td>{{$item->telefone}}</td>
                                            <td>{{$item->rg}}</td>
                                            <td style="letter-spacing: 10px;" class="text-right">
                                                <a href="{{route('clientes.edit', $item->id)}}" title='Editar'><i class="fas fa-edit"></i></a>
                                                <a href="{{route('clientes.show', $item->id)}}" title='Detalhes'><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                       <div class="row mt-4">
                            <div class="col-lg-12">
                                @if(isset($filtros))
                                    {!! $clientes->appends($filtros)->links() !!}
                                @else
                                    {!! $clientes->links() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop