<?php

namespace App\Repositories\Core;

use App\Constants\PaginateConst;
use App\Models\Cliente;
use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\ClienteRepositoryInterface;
use Carbon\Carbon;

class EloquentClienteRepository extends BaseEloquentRepository implements ClienteRepositoryInterface
{
    public function entity()
    {
        return Cliente::class;
    }

    public function search(object $data)
    {
        return $this->entity->where(function($query) use ($data){
            if (isset($data->nome)) {
                $query = $query->where('nome', 'LIKE', "%{$data->nome}%");
            }

            if (isset($data->rg)) {
                $query = $query->where('rgl', $data->rg);
            }
        })
        ->orderBy('id', 'DESC')
        ->paginate(PaginateConst::QUANTIDADE);
    }

    public function buscaPassageiro(object $data)
    {
        return $this->entity->where(function($query) use ($data) {
            if (isset($data->busca)) {
                $query = $query->where('nome', 'LIKE', "%{$data->busca}%");
            }
        })
        ->orderBy('nome')
        ->paginate(PaginateConst::QUANTIDADE);
    }

    public function passageiroExisteEmOutraViagemComAMesmaData($passageiro_id, $data_viagem)
    {
        return $this->entity->with('viagens')->where(function($query) use ($passageiro_id, $data_viagem) {

            $query = $query->where('id', $passageiro_id);

            $query = $query->whereHas('viagens', function($query) use($data_viagem) {
                $query = $query->where('data', Carbon::createFromFormat('d/m/Y', $data_viagem)->toDateString());
            });

        })->get();
    }

    public function buscaPassageiroComOMesmoRg($passageiro_id, $rg)
    {
        return $this->entity->where(function($query) use ($passageiro_id, $rg) {

            $query = $query->where('rg', $rg);

            if ($passageiro_id) {
                $query = $query->where('id', '<>', $passageiro_id);
            }

        })
        ->orderBy('nome')
        ->get();
    }
}
