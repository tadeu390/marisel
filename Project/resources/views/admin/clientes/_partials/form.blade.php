@csrf
<div class="form-row">
    <div class="col-md-4 mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" max="100" name="nome" placeholder="Nome" value="{{$cliente->nome ?? old('nome')}}" required>
        <div class="valid-feedback">
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" maxlength="12" name="telefone" placeholder="Telefone" value="{{$cliente->telefone ?? old('telefone')}}">
        <div class="valid-feedback">
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="rg">RG</label>
        <input type="text" class="form-control" id="rg" name="rg" maxlength="100" placeholder="RG" value="{{$cliente->rg ?? old('rg')}}">
        <div class="valid-feedback">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-12 mb-3">
        <label for="rg">Orçamento</label>
        <textarea style="height: 200px;" class="form-control" id="orcamento" name="orcamento" maxlength="300000" placeholder="Orçamento">{{$cliente->orcamento ?? old('orcamento')}}</textarea>
        <div class="valid-feedback">
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $("#form_cadastrar_passageiro").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: $("#form_cadastrar_passageiro").attr('action'),
                dataType: "json",
                type : "POST",
                cache : false,
                data : $("#form_cadastrar_passageiro").serialize(),
                success: function (data) {
                    console.log(data);
                    if (data.status) {
                        window.location.assign('/admin/clientes');
                    } else {
                        $.notify(data.message, "error");
                    }
                }
            });
        });

    });
</script>