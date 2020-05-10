<?php

namespace App\Http\Controllers\Admin;

use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends \App\Http\Controllers\Controller
{
    /**
     * @var ClienteService
     */
    private $clietenService;

    public function  __construct(ClienteService $clietenService)
    {
        $this->clietenService = $clietenService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = $this->clietenService->index();

        return view('admin.clientes.index', ['clientes' => $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->clietenService->store($request);

        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->clietenService->findById($id);

        if (!$cliente) {
            return redirect()->back();
        }

        return view('admin.clientes.show', ['cliente' => $cliente]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = $this->clietenService->findById($id);

        if (!$cliente) {
            return redirect()->back();
        }

        return view('admin.clientes.edit', ['cliente' => $cliente]);
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
        $response = $this->clietenService->update($id, $request);

        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->clietenService->delete($id);

        return response($response);
    }

    /**
     * Filtra a listagem de clientes.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function busca(Request $request)
    {
        $clientes = $this->clietenService->search($request);

        $filtros = $request->except('_token');

        return view('admin.clientes.index', ['clientes' => $clientes, 'filtros' => $filtros]);
    }
}
