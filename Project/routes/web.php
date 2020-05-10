<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {

    Route::any('clientes/busca', 'Admin\ClienteController@busca')->name('clientes.busca');
    Route::resource('clientes', 'Admin\ClienteController');

    Route::any('viagens/exportarExcel/{id}', 'Admin\ViagemController@exportarExcel')->name('viagens.exportarExcel');
    Route::any('viagens/busca', 'Admin\ViagemController@busca')->name('viagens.busca');
    Route::get('viagens/buscaPassageiro', 'Admin\ViagemController@buscaPassageiro')->name('viagens.buscaPassageiro');
    Route::post('viagens/cadastrarPassageiro', 'Admin\ViagemController@cadastrarPassageiro')->name('viagens.cadastrarPassageiro');
    Route::get('viagens/removerPassageiro', 'Admin\ViagemController@removerPassageiro')->name('viagens.removerPassageiro');
    Route::resource('viagens', 'Admin\ViagemController');

    Route::get('usuario/perfil', 'Admin\UsuarioController@perfil')->name('usuarios.perfil');
    Route::resource('usuarios', 'Admin\UsuarioController');
});