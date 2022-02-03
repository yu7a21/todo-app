<?php

namespace App\Providers;

use App\TodoApp\Category\Infrastructure\Interface\CategoryRepositoryInterface;
use App\TodoApp\Category\Infrastructure\Mock\CategoryMockRepository;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;
use App\TodoApp\Todo\Infrastructure\Mock\TodoMockRepository;
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
            return new CategoryMockRepository();
        });

        $this->app->singleton(TodoRepositoryInterface::class, function () {
            //return new TodoRepository();
            return new TodoMockRepository();
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
