<div class="row p-2">
    <div class="col-md-12 mb-3 p-2" style="border: 1px solid silver;">
        <form action="" id="form_associar_passageiro">
            @csrf
            <input type="hidden" id="viagem_id" name="viagem_id" value="{{$viagem->id}}">
            <div class="form-row p-2">
                <div class="col-md-6 mb-3">
                    <label for="chamado_pessoa_busca">Passageiro</label>
                    <div class="input-group">
                        <input type="hidden" name="passageiro_id" id="passageiro_id" value="">
                        <input type="text" class="form-control ui-autocomplete-input" autocomplete="off" name="busca_passageiro"
                            id="busca_passageiro" maxlength="150" placeholder="Passageiro"
                            required
                        >
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="passageiro_filtro_limpar" name="passageiro_filtro_limpar">Limpar</button>
                        </span>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="poltrona">Poltrona</label>
                    <input type="number" class="form-control" id="poltrona" name="poltrona" placeholder="Poltrona" required>
                    <div class="valid-feedback">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="observacao">Observação</label>
                    <input type="text" class="form-control" id="observacao" name="observacao" placeholder="Observação">
                    <div class="valid-feedback">
                    </div>
                </div>
            </div>
            <div class="form-row p-2">
                <button class="btn btn-primary">Adicionar</button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3" style="border-top: 1px solid silver;">
        <div class="p-2 mt-2 text-right">
            <a href="{{route('viagens.exportarExcel', $viagem->id)}}" target="_blank" class="btn btn-primary">Exportar Excel</a>
        </div>
        <div class="p-2">
            <label>Lista de passageiros</label>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>RG</td>
                        <td>Poltrona</td>
                        <td>Observação</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody id="passageiros" class="passageiros">
                    @foreach ($viagem->passageiros as $item)
                        <tr id="linha{{$item->id}}">
                            <td>
                                <strong>
                                    <a title="Clique para abrir esse passageiro em outra guia" class="bold" target="_blank"
                                                    href="{{route('clientes.edit', $item->id)}}"> {{$item->nome}}
                                    </a>
                                </strong>
                            </td>
                            <td>{{$item->rg}}</td>
                            <td>{{$item->pivot->poltrona}}</td>
                            <td>{{$item->pivot->observacao}}</td>
                            <td>
                                <button title='Remover passageiro' id="remover_passageiro_viagem"
                                    class="btn btn-primary-outline p-0"
                                    data-toggle="modal" data-target="#modal_remover"
                                    value="{{$item->id}}"
                                    onclick="salvaIdPassageiroParaRemover(this.value)"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>