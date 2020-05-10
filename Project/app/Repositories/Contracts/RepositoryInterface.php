<?php
namespace App\Repositories\Contracts;

use App\Constants\PaginateConst;

interface RepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function findWhere($column, $value);
    public function findWhereFirst($column, $value);
    public function paginate($totalPage = PaginateConst::QUANTIDADE);
    public function store(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function orderBy($column, $order = 'DESC');
}