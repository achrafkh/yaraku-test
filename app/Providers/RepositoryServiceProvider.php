<?php

namespace App\Providers;

use App\Repositories\BooksRepository;
use App\Repositories\Interfaces\BooksRepositoryInterface;
use Illuminate\Support\ServiceProvider;

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
            BooksRepositoryInterface::class,
            BooksRepository::class
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
