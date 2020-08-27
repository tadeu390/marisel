@extends('adminlte::page')

@section('title', 'Visualizar cliente')

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
                        Dados do cliente
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-striped">
                            <tr>
                                <td>Nome</td>
                                <td>{{$cliente->nome}}</td>
                            </tr>
                            <tr>
                                <td>Telefone</td>
                                <td>{{$cliente->telefone}}</td>
                            </tr>
                            <tr>
                                <td>RG</td>
                                <td>{{$cliente->rg}}</td>
                            </tr>
                            <tr>
                                <td>Registrado em</td>
                                <td>{{$cliente->created_at}}</td>
                            </tr>
                            <tr>
                                <td>Última alteração em</td>
                                <td>{{$cliente->updated_at}}</td>
                            </tr>
                        </table>
                        <table class="table table-hover table-striped">
                            <thead style="font-weight: normal !important;">
                                <tr>
                                    <td class="text-left">Orçamento</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$cliente->orcamento}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row p-2">
                            <form action="{{route('clientes.destroy', $cliente->id)}}" method="POST" style="display: inline;" id="form_remover_cliente">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" id="id" value="{{$cliente->id}}">

                                <button type="button" class="btn btn-danger"
                                    data-toggle="modal" data-target="#modal_remover"
                                    id="button_remover_cliente"
                                >
                                    Apagar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card show-historico-viagem">
                    <div class="card-header">
                        Histórico de viagens
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <td>Viagem</td>
                                        <td>Motorista</td>
                                        <td>Data</td>
                                        <td>Hora</td>
                                        <td>Poltrona</td>
                                        <td>Observação</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($viagens as $item)
                                        <tr>
                                            <td>
                                                <a title="Clique para abrir essa viagem em outra guia" target="_blank"
                                                    href="{{route('viagens.edit', $item->id)}}"> {{$item->nome}}</a
                                                >
                                            </td>
                                            <td>{{$item->motorista}}</td>
                                            <td>{{$item->data_pt}}</td>
                                            <td>{{$item->hora}}</td>
                                            <td>{{$item->poltrona}}</td>
                                            <td>{{$item->observacao}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                {!! $viagens->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#button_remover_cliente").click(function() {
                $("#modal_remover_titulo").html("Remover cliente");
                $("#modal_remover_corpo").html("Você tem certeza que deseja remover o cliente cadastrado?");
            });

            $("#button_modal_confirmar_remover").click(function() {
                $.ajax({
                    url: "/admin/clientes/"+$("#id").val(),
                    type : "POST",
                    data : $("#form_remover_cliente").serialize(),
                    dataType: "json",
                    success: function (data) {

                        $("#modal_remover").modal('hide');

                        if (data.status) {
                            window.location.assign('/admin/clientes');
                        }  else {
                            alert(data.message);
                        }
                    }
                });
            });
        });
    </script>

@stop