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
                $query = $query->where('rg', $data->rg);
            }
        })
        ->orderBy('nome')
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
