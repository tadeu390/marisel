@extends('adminlte::page')

@section('title', 'Viagens')

@section('content_header')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                <form class="form-inline" action="{{route('viagens.busca')}}" method="POST">
                    @csrf
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="nome" class="sr-only">Nome da viagem</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{$filtros['nome'] ?? ''}}">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="nome" class="sr-only">Motorista</label>
                        <input type="text" class="form-control" id="motorista" name="motorista" placeholder="Motorista" value="{{$filtros['motorista'] ?? ''}}">
                    </div>
                    <div class="form-group mx-sm-3 mb-2" id="div_data_inicio">
                        <label for="data_inicio" class="sr-only">Data início</label>
                        <input type="text" autocomplete="off" class="form-control" id="data_inicio" name="data_inicio" placeholder="Data inicio" value="{{$filtros['data_inicio'] ?? ''}}">
                    </div>
                    <div class="form-group mx-sm-3 mb-2" id="div_data_fim">
                        <label for="data_fim" class="sr-only">Data Fim</label>
                        <input type="text" autocomplete="off" class="form-control" id="data_fim" name="data_fim" placeholder="Data fim" value="{{$filtros['data_fim'] ?? ''}}">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                </form>
            </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid index-viagem-page">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.viagens.includes.alerts')
                <div class="card">
                    <div class="card-header text-right">
                        <a class="btn btn-primary" style="color: white !important;" href="{{route('viagens.create')}}">Adicionar</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Nome</td>
                                        <td>Data da viagem</td>
                                        <td>Quantidade de passageiros</td>
                                        <td>Motorista</td>
                                        <td class="text-right">Ações</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($viagens as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->nome}}</td>
                                            <td>{{$item->data}}</td>
                                            <td>{{count($item->passageiros)}}</td>
                                            <td>{{$item->motorista}}</td>
                                            <td style="letter-spacing: 10px;" class="text-right">
                                                <a href="{{route('viagens.edit', $item->id)}}" title='Editar'><i class="fas fa-edit"></i></a>
                                                <a href="{{route('viagens.show', $item->id)}}" title='Detalhes'><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                       <div class="row mt-4">
                           <div class="col-lg-12">
                                @if(isset($filtros))
                                        {!! $viagens->appends($filtros)->links() !!}
                                @else
                                        {!! $viagens->links() !!}
                                @endif
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function() {
            $('#div_data_inicio input').datepicker({
                language: "pt-BR"
            });

            $('#div_data_fim input').datepicker({
                language: "pt-BR"
            });
        });
    </script>
@stop