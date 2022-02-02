<?php

namespace App\Providers;

use App\TodoApp\Category\Infrastructure\CategoryRepositoryInterface;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CategoryRepositoryInterface::class, function () {
            //return new CategoryRepository();
        });

        $this->app->singleton(TodoRepositoryInterface::class, function () {
            //return new TodoRepository();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
