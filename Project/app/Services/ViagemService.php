<?php

namespace App\Services;

use App\Repositories\Contracts\ViagemRepositoryInterface;
use Illuminate\Http\Request;

class ViagemService
{
    /**
     * @var GroupRepositoryInterface
     */
    protected $repository;

    /**
     * Carrega as instâncias das dependências desta classe.
     */
    public function __construct(ViagemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retorna os dados do registro
     *
     * @return object mixed
     */
    public function index()
    {
        return $this->repository->paginate(30);
    }

    /**
     * Retorna os dados do registro
     *
     * @param  integer $id
     * @return object mixed
     */
    public function show($id)
    {
        return $this->repository->findWhereFirst('id', $id);
    }

    /**
     * Envia os dados para o repositório registrar no banco.
     *
     * @param mixed $data
     * @return object mixed
     */
    public function store($data)
    {
        try {

            $this->repository->store($data);

            return (object) [
                'success' => true,
                'message' => 'Grupo cadastrado com sucesso.'
            ];
        } catch(\Exception $e) {
            return (object) [
                'success' => false,
                'message' => $e->getMessage(),
                'class' => get_class($e)
            ];
        }
    }

    /**
     * Retorna os dados do registro
     *
     * @param  int $id
     * @return object mixed
     */
    public function edit($id)
    {
        return $this->repository->findById($id);
    }

    /**
     * Envia os dados para o repositório alterar no banco.
     *
     * @param mixed $data
     * @param int $id
     * @return object mixed
     */
    public function update($id, $data)
    {
        try {
            $this->repository->update($id, $data);

            return (object) [
                'success' => true,
                'message' => 'Grupo atualizado com sucesso.'
            ];
        } catch(\Exception $e) {
            return (object) [
                'success' => false,
                'message' => $e->getMessage(),
                'class' => get_class($e)
            ];
        }
    }

    /**
     * Faz com que o repositório exclua um determinado registro no banco de dados.
     *
     * @param int $id
     * @return object mixed
     */
    public function delete($id)
    {
        try {
            $this->repository->delete($id);

            return (object) [
                'success' => true,
                'message' => 'Grupo apagado com sucesso.'
            ];

        } catch(\Exception $e) {
            return (object) [
                'success' => false,
                'message' => $e->getMessage(),
                'class' => get_class($e)
            ];
        }
    }

    /**
     * Solicita a repositório para que faça busca no banco de dados conforme os parâmetros de busca contidos
     * no objeto $request.
     *
     * @param  \Illuminate\Http\Requests $request
     * @return object mixed
     */
    public function search(Request $request)
    {
        return $this->repository->search($request);
    }

    /**
     * Atualiza as funções de um usuário.
     *
     * @param array $data
     * @param int $id
     */
    public function updateRoles($data, $id)
    {
        try {
            $group = $this->repository->findById($id);

            if (isset($data['roles'])) {
                $group->roles()->sync($data['roles']);
            } else {
                $group->roles()->detach();
            }

            return (object) [
                'success' => true,
                'message' => 'Funções alteradas com sucesso.'
            ];

        } catch (\Exception $e) {
            return (object) [
                'success' => false,
                'message' => $e->getMessage(),
                'class' => get_class($e)
            ];
        }
    }
}
