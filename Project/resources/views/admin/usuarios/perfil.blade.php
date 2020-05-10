@extends('adminlte::page')

@section('title', 'Perfil')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.usuarios.includes.alerts')
                <div class="card">
                    <div class="card-header">
                        Perfil
                    </div>
                    <div class="card-body">
                        <form action="{{route('usuarios.update', $usuario->id)}}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="{{$usuario->name ?? old('name')}}" required>
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="E-mail">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" value="{{$usuario->email ?? old('email')}}" required>
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="password">Nova senha</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Nova senha">
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="conf_password">Confirmar senha</label>
                                    <input type="password" class="form-control" id="conf_password" name="conf_password" placeholder="Confirmar senha">
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button class="btn btn-primary" type="submit">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop