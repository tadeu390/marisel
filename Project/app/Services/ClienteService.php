<?php

namespace App\Services;

use App\Repositories\Contracts\ClienteRepositoryInterface;

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
        return $this->repository->paginate(2);
    }

    public function store($data)
    {
        return $this->repository->store($data);
    }

    public function show($id)
    {
        return $this->repository->findById($id);
    }

    public function edit($id)
    {
        return $this->repository->findById($id);
    }

    public function update($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        if (count($this->repository->findById($id)->produtos) == 0) {
            $this->repository->delete($id);
            return (object) [
                'success' => true,
                'message' => 'Categoria removida com sucesso.'
            ];
        }

        return (object) [
            'success' => false,
            'message' => 'A categoria não pode ser removida pois existe produtos associados a ela.'
        ];
    }

    public function search($data)
    {
        return $this->repository->search((object) $data);
    }
}
