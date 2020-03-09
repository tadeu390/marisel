<?php
namespace App\Repositories\Core;

use App\Models\User;
use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\UsuarioRepositoryInterface;
use Illuminate\Http\Request;

class EloquentUsuarioRepository extends BaseEloquentRepository implements UsuarioRepositoryInterface
{
    public function entity()
    {
        return User::class;
    }

    public function search(Request $request)
    {
        return $this->entity->where(function($query) use($request) {
            if ($request->name) {
                $query = $query->where('name', 'LIKE', "%{$request->name}%");
            }
        })->paginate(2);
    }

    //polimorfismo, reescrevendo alguns métodos
    public function store(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->entity->create($data);
    }

    public function update($id, array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $entity = $this->findById($id);

        return $entity->update($data);
    }
}
