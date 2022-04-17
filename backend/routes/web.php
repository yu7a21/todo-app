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

Route::post('/update', 'Todo\UpdateController')->name('update');

Route::post('/delete', 'Todo\DeleteController')->name('delete_todo');

Route::post('/complete', 'Todo\CompleteController')->name('complete_todo');

Route::get('/deleted', 'Todo\DeletedTodoController')->name('deleted_todo');

Route::get('/completed', 'Todo\CompletedTodoController')->name('completed_todo');

Route::post('/category', 'Category\CategoryController')->name('category_edit');

Route::get('/issue_import', 'Todo\IssueImportController')->name('import');

//NOTE: 新しいルーティングを追加する時はこれより上に書く
Route::get('/{category_name}', 'Todo\CategoryHomeController')->name('category');

