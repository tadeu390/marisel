<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    UsuarioRepositoryInterface,
    ClienteRepositoryInterface,
    ClienteViagemRepositoryInterface,
    ViagemRepositoryInterface
};

use Illuminate\Support\ServiceProvider;

use App\Repositories\Core\{
    EloquentUsuarioRepository,
    EloquentClienteRepository,
    EloquentClienteViagemRepository,
    EloquentViagemRepository
};

/* use App\Repositories\Core\QueryBuilder\{
    QueryBuilderCategoriaRepository
}; */

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ClienteViagemRepositoryInterface::class,
            EloquentClienteViagemRepository::class
        );

        $this->app->bind(
            ClienteRepositoryInterface::class,
            EloquentClienteRepository::class
        );

        $this->app->bind(
            UsuarioRepositoryInterface::class,
            EloquentUsuarioRepository::class
        );

        $this->app->bind(
            ViagemRepositoryInterface::class,
            EloquentViagemRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
