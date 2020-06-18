<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\ActionRepository;
use App\Repositories\Interfaces\ActionRepositoryInterface;
use App\Repositories\ConfigRepository;
use App\Repositories\Interfaces\ConfigRepositoryInterface;
use App\Repositories\UserRegistryRepository;
use App\Repositories\Interfaces\UserRegistryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( ActionRepositoryInterface::class, ActionRepository::class );
        $this->app->bind( ConfigRepositoryInterface::class, ConfigRepository::class );
        $this->app->bind( UserRegistryRepositoryInterface::class, UserRegistryRepository::class );
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
