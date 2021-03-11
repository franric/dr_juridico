<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\PessoaRepository::class, \App\Repositories\PessoaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReceitaRepository::class, \App\Repositories\ReceitaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContratoRepository::class, \App\Repositories\ContratoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContratoPessoasRepository::class, \App\Repositories\ContratoPessoasRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContratoReceitaRepository::class, \App\Repositories\ContratoReceitaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContasReceberRepository::class, \App\Repositories\ContasReceberRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HistoricoRepository::class, \App\Repositories\HistoricoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PessoaHistoricoRepository::class, \App\Repositories\PessoaHistoricoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProcuracaoRepository::class, \App\Repositories\ProcuracaoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReciboControleRepository::class, \App\Repositories\ReciboControleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HistoricoProcessoRepository::class, \App\Repositories\HistoricoProcessoRepositoryEloquent::class);
        //:end-bindings:
    }
}
