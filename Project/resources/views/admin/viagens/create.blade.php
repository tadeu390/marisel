@extends('adminlte::page')

@section('title', 'Clientes')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.viagens.includes.alerts')
                <div class="card">
                    <div class="card-header">
                        <a href="javascript:history.back(1)" title="Voltar a página anterior"><i class="far fa-arrow-alt-circle-left" style="font-size: 30px;"></i></a>
                    </div>
                    <div class="card-header">
                        Nova viagem
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Informações</a>
                            </li>
                            <li class="nav-item" style="display: none;">
                              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Passageiros</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form action="{{route('viagens.store')}}" method="post">
                                    @include('admin.viagens._partials.form')
                                    <button class="btn btn-primary" type="submit">Salvar</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                @if ($viagem->id)
                                    @include('admin.viagens._partials.passageiros')
                                @endif
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop