<?php
namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface UsuarioRepositoryInterface
{
    public function search(Request $request);
}