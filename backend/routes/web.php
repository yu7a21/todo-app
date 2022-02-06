<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Todo\HomeController')->name('home');

Route::post('/create', 'Todo\CreateController')->name('create');

Route::post('/delete', 'Todo\DeleteController')->name('delete_todo');

Route::get('/deleted', 'Todo\DeletedTodoController')->name('deleted_todo');

Route::get('/{category_name}', 'Todo\CategoryHomeController')->name('category');
