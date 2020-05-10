@csrf
<div class="form-row">
    <div class="col-md-4 mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{$cliente->nome ?? old('nome')}}" required>
        <div class="valid-feedback">
    </div>
  </div>
  <div class="col-md-4 mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" value="{{$cliente->telefone ?? old('telefone')}}" required>
        <div class="valid-feedback">
        </div>
  </div>
  <div class="col-md-4 mb-3">
        <label for="rg">RG</label>
        <input type="text" class="form-control" id="rg" name="rg" placeholder="RG" value="{{$cliente->rg ?? old('rg')}}" required>
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