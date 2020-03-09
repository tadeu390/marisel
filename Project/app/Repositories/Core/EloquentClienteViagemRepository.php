<?php

namespace App\Repositories\Core;

use App\Models\ClienteViagem;
use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\ClienteViagemRepositoryInterface;

class EloquentClienteViagemRepository extends BaseEloquentRepository implements ClienteViagemRepositoryInterface
{
    public function entity()
    {
        return ClienteViagem::class;
    }
}
