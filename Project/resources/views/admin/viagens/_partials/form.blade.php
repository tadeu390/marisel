@csrf
<div class="form-row">
    <div class="col-md-6 mb-3">
        <label for="nome">Nome da viagem</label>
        <input type="text" class="form-control" maxlength="100" id="nome" name="nome" placeholder="Nome" value="{{$viagem->nome ?? old('nome')}}" required>
        <div class="valid-feedback">
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label for="nome">Motorista</label>
        <input type="text" class="form-control" maxlength="100" id="motorista" name="motorista" placeholder="Nome" value="{{$viagem->motorista ?? old('motorista')}}" required>
        <div class="valid-feedback">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-4 mb-3" id="data_viagem">
        <label for="data">Data da viagem</label>
        <input type="text" class="form-control" id="data" name="data" placeholder="Data da viagem" value="{{$viagem->data ?? old('data')}}" required>
        <div class="valid-feedback">
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="data">Hora da viagem</label>
        <input type="time" class="form-control" id="hora" name="hora" placeholder="Hora da viagem" value="{{$viagem->hora ?? old('hora')}}" required>
        <div class="valid-feedback">
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="tipo_veiculo">Tipo de Veículo</label>
        <select id="tipo_veiculo" name="tipo_veiculo" class="form-control" required>
            <option value="">Selecione.</option>
            @if($viagem->tipo_veiculo == 1)
                <option selected value="1">Van 16 lugares</option>
            @else
                <option value="1">Van 16 lugares</option>
            @endif
            @if($viagem->tipo_veiculo == 2)
                <option selected value="2">Ônibus 44 lugares</option>
            @else
                <option value="2">Ônibus 44 lugares</option>
            @endif
            @if($viagem->tipo_veiculo == 3)
                <option selected value="3">Ônibus 46 lugares</option>
            @else
                <option value="3">Ônibus 46 lugares</option>
            @endif
        </select>
    </div>
</div>

<script type="text/javascript">
    var passageiro_id = 0;

    $(document).ready(function() {

        $('#data_viagem input').datepicker({
            language: "pt-BR"
        });

        $("#busca_passageiro").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/admin/viagens/buscaPassageiro",
                    dataType: "json",
                    data: {
                        busca: request.term
                    },
                    success: function (data) {
                        response($.map(data, function (item) {
                            return {label: item.nome, id: item.id};
                        }));
                    }
                });
            },
            select: function (event, ui) {
                $("#passageiro_id").val(ui.item.id);
                document.getElementById("busca_passageiro").title = ui.item.label;
                $("#busca_passageiro").attr("disabled", "disabled");
            },
            open: function () {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            var busca = $("#busca_passageiro").val();

            result = item.label.replace(new RegExp(eval('/(' + busca + ')/ig')), function (v) {
                return '<b class=\'autocomplete-highlight\'>' + v + '</b>';
            });

            return $("<li>").append(result).appendTo(ul);
        };

        $("#passageiro_filtro_limpar").click(function () {
            limparFiltroNome();
        });

        function limparFiltroNome()
        {
            if ($("#busca_passageiro").is(":disabled")) {
                $("#busca_passageiro").removeAttr("disabled");
                $("#busca_passageiro").val("");
                $("#passageiro_id").val("");
            }
        }

        function limparFiltros()
        {
            limparFiltroNome();
            $("#poltrona").val("");
            $("#observacao").val("");
        }

        $("#form_associar_passageiro").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "/admin/viagens/cadastrarPassageiro",
                dataType: "json",
                type : "POST",
                cache : false,
                data : $("#form_associar_passageiro").serialize(),
                success: function (data) {
                   if (data.status) {
                       adicionarPassageiroNaTela(data.passageiro);
                       $.notify(data.message, "success");
                   } else {
                    $.notify(data.message, "error");
                   }
                }
            });
        });

        function adicionarPassageiroNaTela(passageiro)
        {
            var elementTr = document.createElement('TR');
                elementTr.setAttribute('id', 'linha'+passageiro.id);

            var elementTd = document.createElement('TD');
            var elementStrong = document.createElement('strong');
            var elementA = document.createElement('A');
                elementA.setAttribute("href", "/admin/clientes/"+passageiro.id);
                elementA.setAttribute("target", "_blank");
                elementA.innerHTML = passageiro.nome;

            elementStrong.appendChild(elementA);
            elementTd.appendChild(elementStrong);
            elementTr.appendChild(elementTd);

            var elementTd = document.createElement('TD');
                elementTd.innerHTML = passageiro.rg;
            elementTr.appendChild(elementTd);

            var elementTd = document.createElement('TD');
                elementTd.innerHTML = passageiro.pivot.poltrona;
            elementTr.appendChild(elementTd);

            var elementTd = document.createElement('TD');
                elementTd.innerHTML = passageiro.pivot.observacao;
            elementTr.appendChild(elementTd);

            var elementTd = document.createElement('TD');

            var elementI = document.createElement('i');
                elementI.setAttribute('class', 'fas fa-times');

            var elementButton = document.createElement('BUTTON');
                elementButton.setAttribute('title', 'Remover passageiro');
                elementButton.setAttribute('class', 'btn btn-primary-outline p-0');
                elementButton.setAttribute('data-toggle', 'modal');
                elementButton.setAttribute('data-target', '#modal_remover');
                elementButton.setAttribute('value', passageiro.id);
                elementButton.setAttribute('onclick', 'salvaIdPassageiroParaRemover(this.value)');
                elementButton.appendChild(elementI);

            elementTd.appendChild(elementButton);
            elementTr.appendChild(elementTd);

            document.getElementById('passageiros').appendChild(elementTr);

            limparFiltros();
        }

        $("#button_modal_confirmar_remover").click(function() {

            $.ajax({
                url: "/admin/viagens/removerPassageiro",
                dataType: "json",
                data : {
                    "passageiro_id" : passageiro_id,
                    "viagem_id" : $("#viagem_id").val()
                },
                success: function (data) {
                    $("#modal_remover").modal('hide');

                    if (data.status) {
                        removePassageiroTela();
                        $.notify(data.message, "success");
                    } else {
                        $.notify(data.message, "error");
                    }
                }
            });
        });

        function removePassageiroTela ()
        {
            var node = document.getElementById('linha'+passageiro_id);
            node.parentNode.removeChild(node);
        }

    });

    function salvaIdPassageiroParaRemover (id)
    {
        $("#modal_remover_titulo").html("Remover passageiro");
        $("#modal_remover_corpo").html("Você tem certeza que deseja remover o passageiro da viagem?");
        passageiro_id = id;
    }
</script>