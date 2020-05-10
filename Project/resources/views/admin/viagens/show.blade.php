@extends('adminlte::page')

@section('title', 'Visualizar viagem')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.viagens.includes.alerts')
                <div class="card">
                    <div class="card-header">
                        Visualizar viagem
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-striped">
                            <tr>
                                <td>Nome</td>
                                <td>{{$viagem->nome}}</td>
                            </tr>
                            <tr>
                                <td>Data</td>
                                <td>{{$viagem->data}}</td>
                            </tr>
                            <tr>
                                <td>Hora</td>
                                <td>{{$viagem->hora}}</td>
                            </tr>
                            <tr>
                                <td>Quantidade de passageiros</td>
                                <td>{{count($viagem->passageiros)}}</td>
                            </tr>
                            <tr>
                                <td>Registrado em</td>
                                <td>{{$viagem->created_at}}</td>
                            </tr>
                            <tr>
                                <td>Última alteração em</td>
                                <td>{{$viagem->updated_at}}</td>
                            </tr>
                        </table>
                        <div class="row p-2">
                            <form action="{{route('viagens.destroy', $viagem->id)}}" method="POST" style="display: inline;" id="form_remover_viagem">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" id="id" value="{{$viagem->id}}">

                                <button type="button" title='Inativar' class="btn btn-danger"
                                    data-toggle="modal" data-target="#modal_remover"
                                    id="button_remover_viagem"
                                >
                                    Apagar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#button_remover_viagem").click(function() {
                $("#modal_remover_titulo").html("Remover viagem");
                $("#modal_remover_corpo").html("Você tem certeza que deseja remover a viagem cadastrada?");
            });

            $("#button_modal_confirmar_remover").click(function() {
                $.ajax({
                    url: "/admin/viagens/"+$("#id").val(),
                    type : "POST",
                    data : $("#form_remover_viagem").serialize(),
                    dataType: "json",
                    success: function (data) {

                        $("#modal_remover").modal('hide');

                        if (data.status) {
                            window.location.assign('/admin/viagens');
                        }  else {
                            alert(data.message);
                        }
                    }
                });
            });
        });
    </script>

@stop