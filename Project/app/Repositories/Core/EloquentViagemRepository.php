<?php

namespace App\Repositories\Core;

use App\Constants\PaginateConst;
use App\Models\Viagem;
use Illuminate\Support\Facades\DB;
use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\ViagemRepositoryInterface;
use Carbon\Carbon;

class EloquentViagemRepository extends BaseEloquentRepository implements ViagemRepositoryInterface
{
    public function entity()
    {
        return Viagem::class;
    }

    public function search(Object $data)
    {
        return $this->entity->where(function($query) use($data) {
            if (isset($data->nome)) {
                $query = $query->where('nome', 'LIKE', "%{$data->nome}%");
            }

            if (isset($data->motorista)) {
                $query = $query->where('motorista', 'LIKE', "%{$data->motorista}%");
            }

            if (isset($data->data_inicio)) {
                $query = $query->where('data', '>=', Carbon::createFromFormat('d/m/Y', $data->data_inicio)->toDateString());
            }

            if (isset($data->data_fim)) {
                $query = $query->where('data', '<=', Carbon::createFromFormat('d/m/Y', $data->data_fim)->toDateString());
            }
        })->paginate(PaginateConst::QUANTIDADE);
    }

    public function buscaHistoricoViagem($passageiro_id)
    {
        return DB::table('viagens as v')
            ->join('cliente_viagem as cv', 'v.id', '=', 'cv.viagem_id')
            ->select(DB::raw('DATE_FORMAT(v.data, "%d/%m/%Y") as data_pt, v.*, cv.*'))
            ->where('cv.cliente_id', $passageiro_id)
            ->paginate(PaginateConst::QUANTIDADE);
    }

    public function buscarPassageiroNaViagem($viagem_id, $passageiro_id)
    {
        return $this->entity->with([
            'passageiros' => function ($query) use($passageiro_id) {
                $query->where('cliente_id', $passageiro_id);
            }
        ])->where('id', $viagem_id)->first();
    }

    public function poltronaEstaDisponível($viagem_id, $poltrona)
    {
        return $this->entity->with([
            'passageiros' => function ($query) use($poltrona) {
                $query->where('poltrona', $poltrona);
            }
        ])->where('id', $viagem_id)->first();
    }
}
