<?php

namespace App\Services;

use App\Repositories\Contracts\ClienteRepositoryInterface;
use Exception;

class ClienteService
{
    protected $repository;

    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get()
    {
        return $this->repository->getAll();
    }

    public function index()
    {
        return $this->repository->paginate();
    }

    private function validar($id, $data)
    {
        $this->validarRg($id, $data->rg);
    }

    private function validarRg($passageiro_id ,$rg)
    {
        $passageiro = $this->repository->buscaPassageiroComOMesmoRg($passageiro_id, $rg);

        if (count($passageiro)) {
            throw new Exception('RG informado já está em uso por outro cliente');
        }
    }

    public function store($data)
    {
        try {

            $this->validar(null, $data);

            $this->repository->store($data->all());

            return [
                'message' => 'Cliente cadastrado com sucesso',
                'status' => true
            ];

        } catch (\Exception $e) {

            return [
                'message' => $e->getMessage(),
                'status ' => false
            ];
        }
    }

    public function findById($id)
    {
        return $this->repository->relationships('viagens')->findById($id);
    }

    public function update($id, $data)
    {
        try {

            $this->validar($id, $data);

            $this->repository->update($id, $data->all());

            return [
                'message' => 'Cliente atualizado com sucesso',
                'status' => true
            ];

        } catch (\Exception $e) {

            return [
                'message' => $e->getMessage(),
                'status ' => false
            ];
        }
    }

    public function delete($id)
    {
        try {
            $this->repository->delete($id);

            return [
                'message' => 'Cliente apagado com sucesso.',
                'status' => true
            ];

        } catch(\Exception $e) {

            return [
                'message' => $e->getMessage(),
                'status' => false
            ];
        }
    }

    public function search($data)
    {
        return $this->repository->search((object) $data);
    }

    public function buscaPassageiro($data)
    {
        return $this->repository->buscaPassageiro((object) $data);
    }
}
