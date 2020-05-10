<?php

namespace App\Services;

use App\Repositories\Contracts\ViagemRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ViagemService
{
    /**
     * @var GroupRepositoryInterface
     */
    protected $repository;

    /**
     * @var ClienteService
     */
    private $clienteService;

    /**
     * Carrega as instâncias das dependências desta classe.
     */
    public function __construct(ViagemRepositoryInterface $repository, ClienteService $clienteService)
    {
        $this->repository = $repository;
        $this->clienteService = $clienteService;
    }

    /**
     * Retorna os dados do registro
     *
     * @return object mixed
     */
    public function index()
    {
        return $this->repository->paginate();
    }

    /**
     * Retorna os dados do registro
     *
     * @param  integer $id
     * @return object mixed
     */
    public function findById($id)
    {
        return $this->repository->relationships('passageiros')->findById($id);
    }

    /**
     * Envia os dados para o repositório registrar no banco.
     *
     * @param mixed $data
     * @return object mixed
     */
    public function store($data)
    {
        $this->repository->store($data);
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

            return [
                'message' => 'Viagem apagada com sucesso.',
                'status' => true
            ];

        } catch(\Exception $e) {

            return [
                'message' => $e->getMessage(),
                'status' => false
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
        if ($request->data_inicio && $request->data_fim) {
            if (Carbon::createFromFormat('d/m/Y', $request->data_inicio) > Carbon::createFromFormat('d/m/Y', $request->data_fim)) {
                return (object) [
                    'viagens' => $this->index(),
                    'errors' => 'Data inicial deve ser menor que a data final'
                ];
            }
        }

        return (object) [
            'viagens' => $this->repository->search($request),
            'errors' => null
        ];
    }

    private function validar($data)
    {
        $viagem = $this->viagemExiste($data->viagem_id);
        $this->passageiroExiste($data->passageiro_id);
        $this->passageiroExisteNaViagem($viagem, $data->passageiro_id);
        $this->clienteService->passageiroExisteEmOutraViagemComAMesmaData($data->passageiro_id, $viagem->data);
        $this->poltronaEstaDisponível($data->viagem_id, $data->poltrona);
    }

    private function viagemExiste($viagem_id)
    {
        $viagem = $this->findById($viagem_id);

        if (!$viagem) {
            throw new Exception('Viagem inexistente.');
        }

        return $viagem;
    }

    private function passageiroExiste($passageiro_id)
    {
        $passageiro = $this->clienteService->findById($passageiro_id);

        if (!$passageiro) {
            throw new Exception('Passageiro inexistente.');
        }

        return $passageiro;
    }

    private function passageiroExisteNaViagem($viagem, $passageiro_id)
    {
        $viagem = $this->repository->buscarPassageiroNaViagem($viagem->id, $passageiro_id);

        if (count($viagem->passageiros)) {
            throw new Exception('Passageiro já se encontra cadastrado nessa viagem.');
        }
    }

    private function poltronaEstaDisponível($viagem_id, $poltrona)
    {
        $viagem = $this->repository->poltronaEstaDisponível($viagem_id, $poltrona);

        if (count($viagem->passageiros)) {
            throw new Exception('A poltrona informada já está ocupada por outra pessoa nesta viagem. Por favor, Escolha outra.');
        }
    }

    public function cadastrarPassageiro($data)
    {
        try {
            $this->validar($data);

            $viagem = $this->findById($data->viagem_id);
            $viagem->passageiros()->attach($data->passageiro_id, ['poltrona' => $data->poltrona, 'observacao' => $data->observacao]);

            $this->update($data->viagem_id, $viagem->toArray());

            $viagem = $this->repository->buscarPassageiroNaViagem($data->viagem_id, $data->passageiro_id);

            return [
                'message' => 'Passageiro adicionado com sucesso a viagem.',
                'passageiro' => $viagem->passageiros[0]->toArray(),
                'status' => true
            ];

        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'status' => false
            ];
        }
    }

    public function removerPassageiro($data)
    {
        try {
            $viagem = $this->findById($data->viagem_id);
            $viagem->passageiros()->detach($data->passageiro_id);

            $this->update($data->viagem_id, $viagem->toArray());

            return  [
                'message' => 'Passageiro removido com sucesso da viagem.',
                'status' => true
            ];

        } catch (Exception $e) {
            return [
                'message' => $e->getMessage(),
                'status' => false
            ];
        }
    }
}
