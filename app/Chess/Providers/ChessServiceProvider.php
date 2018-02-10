<?php

namespace App\Chess\Providers;

use App\Chess\Contracts\ColumnFactoryInterface;
use App\Chess\Contracts\FieldFactoryInterface;
use App\Chess\Contracts\GridFactoryInterface;
use App\Chess\Factories\ColumnFactory;
use App\Chess\Factories\FieldFactory;
use App\Chess\Factories\GridFactory;
use Illuminate\Support\ServiceProvider;

class ChessServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ColumnFactoryInterface::class, ColumnFactory::class);
        $this->app->singleton(GridFactoryInterface::class, GridFactory::class);
        $this->app->singleton(FieldFactoryInterface::class, FieldFactory::class);
    }
}
