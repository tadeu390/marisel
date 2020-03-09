<?php

namespace App\Repositories\Core;

use App\Models\Viagem;
use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\ViagemRepositoryInterface;
use Illuminate\Http\Request;

class EloquentViagemRepository extends BaseEloquentRepository implements ViagemRepositoryInterface
{
    public function entity()
    {
        return Viagem::class;
    }

    public function search(Request $request)
    {
        return $this->entity->where(function($query) use($request) {
            if ($request->name) {
                $query = $query->where('name', 'LIKE', "%{$request->name}%");
            }
        })->paginate(2);
    }
}
