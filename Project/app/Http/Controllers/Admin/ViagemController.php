<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Viagem\ExportarViagem;
use App\Services\ClienteService;
use App\Services\ViagemService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ViagemController extends \App\Http\Controllers\Controller
{
    /**
     * @var ViagemService
     */
    private $viagemService;

    /**
     * @var ClienteService
     */
    private $clienteService;

    public function __construct(ViagemService $viagemService, ClienteService $clienteService)
    {
        $this->viagemService = $viagemService;
        $this->clienteService = $clienteService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viagens = $this->viagemService->index();

        return view('admin.viagens.index', ['viagens' => $viagens]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $viagem = new \App\Models\Viagem();

        return view('admin.viagens.create', ['viagem' => $viagem]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->viagemService->store($request->all());

        return redirect()
                ->route('viagens.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $viagem = $this->viagemService->findById($id);

        if (!$viagem) {
            return redirect()->back();
        }

        return view('admin.viagens.show', ['viagem' => $viagem]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $viagem = $this->viagemService->findById($id);

        if (!$viagem) {
            return redirect()->back();
        }

        return view('admin.viagens.edit', ['viagem' => $viagem]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->viagemService->update($id, $request->all());

        return redirect()
                ->route('viagens.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->viagemService->delete($id);

        return response($response);
    }

    /**
     * Filtra a listagem de viagens.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function busca(Request $request)
    {
        $filtros = $request->except('_token');

        $response = $this->viagemService->search($request);

        return view('admin.viagens.index', ['viagens' => $response->viagens, 'filtros' => $filtros])
                ->withErrors($response->errors);
    }

    /**
     * Filtra a listagem de clientes para a adição de passageiros em uma viagem.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buscaPassageiro(Request $request)
    {
        $clientes = $this->clienteService->buscaPassageiro($request);

        return response($clientes->toArray()['data']);
    }

    /**
     * Adiciona um passageiro em uma determinada viagem
     */
    public function cadastrarPassageiro(Request $request)
    {
        $response = $this->viagemService->cadastrarPassageiro($request);

        return response($response);
    }

    /**
     * Remove um passageiro de uma determinada viagem
     */
    public function removerPassageiro(Request $request)
    {
        $response = $this->viagemService->removerPassageiro($request);

        return response($response);
    }

    public function exportarExcel($id)
    {
        $viagem = $this->viagemService->findById($id);

        $invoice = new ExportarViagem($viagem->toArray());

        return Excel::download($invoice, "{$viagem->nome}.xlsx");
    }
}
