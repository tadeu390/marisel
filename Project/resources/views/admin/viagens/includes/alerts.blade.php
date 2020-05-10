@if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if(session('danger'))
    <div class="alert alert-danger">
        {{session('danger')}}
    </div>
@endif

<div class="modal fade" id="modal_remover" tabindex="-1" role="dialog" aria-labelledby="modal_remover_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_remover_titulo"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal_remover_corpo">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="button_modal_confirmar_remover">Remover</button>
        </div>
        </div>
    </div>
</div>

<div class="notifyjs-corner" style="top: 0px; right: 0px; display:none;">
    <div class="notifyjs-wrapper notifyjs-hidable">
        <div class="notifyjs-arrow" style=""></div>
        <div class="notifyjs-container" style="">
            <div class="notifyjs-bootstrap-base notifyjs-bootstrap-success">
                <span data-notify-text=""></span>
            </div>
        </div>
    </div>
</div>