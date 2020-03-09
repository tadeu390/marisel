<?php

namespace App\Repositories\Core;

use App\Models\Cliente;
use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\ClienteRepositoryInterface;

class EloquentClienteRepository extends BaseEloquentRepository implements ClienteRepositoryInterface
{
    public function entity()
    {
        return Cliente::class;
    }

    public function search(object $data)
    {
        return $this->entity->where(function($query) use ($data){//funcao de callback
            if (isset($data->title)) {
                $query = $query->where('title', 'LIKE', "%{$data->title}%");
            }

            if (isset($data->url)) {
                $query = $query->where('url', $data->url);
            }

            if (isset($data->description)) {
                $query = $query->where('description', 'LIKE', "%{$data->description}%");
            }
        })
        ->orderBy('id', 'DESC')
        ->paginate(2);
    }

    //polimorfismo, reescrevendo alguns métodos
    public function store(array $data)
    {
        $data['url'] = kebab_case($data['title']);
        return $this->entity->create($data);
    }

    public function update($id, array $data)
    {
        $data['url'] = kebab_case($data['title']);
        $entity = $this->findById($id);

        return $entity->update($data);
    }
}
