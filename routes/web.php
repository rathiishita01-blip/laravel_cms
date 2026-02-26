<?php

use App\Models\Project;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TypesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


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
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'aboutUs']);
Route::get('/contact', [HomeController::class, 'contactUs']);

Route::get('/console/contacts/list', [ContactController::class, 'index']);
Route::post('/contact-submit', [ContactController::class, 'store'])
     ->name('contact.store');

Route::get('/project/{project:slug}', function (Project $project) {
    return view('project', [
        'project' => $project,
    ]);
})->where('project', '[A-z\-]+');

Route::get('/console/logout', [ConsoleController::class, 'logout'])->middleware('auth');
Route::get('/console/login', [ConsoleController::class, 'loginForm'])->middleware('guest');
Route::post('/console/login', [ConsoleController::class, 'login'])->middleware('guest');
Route::get('/console/dashboard', [ConsoleController::class, 'dashboard'])->middleware('auth');

Route::get('/console/users/list', [UsersController::class, 'list'])->middleware('auth');
Route::get('/console/users/add', [UsersController::class, 'addForm'])->middleware('auth');
Route::post('/console/users/add', [UsersController::class, 'add'])->middleware('auth');
Route::get('/console/users/edit/{user:id}', [UsersController::class, 'editForm'])->where('user', '[0-9]+')->middleware('auth');
Route::post('/console/users/edit/{user:id}', [UsersController::class, 'edit'])->where('user', '[0-9]+')->middleware('auth');
Route::get('/console/users/delete/{user:id}', [UsersController::class, 'delete'])->where('user', '[0-9]+')->middleware('auth');

Route::get('/console/types/list', [TypesController::class, 'list'])->middleware('auth');
Route::get('/console/types/add', [TypesController::class, 'addForm'])->middleware('auth');
Route::post('/console/types/add', [TypesController::class, 'add'])->middleware('auth');
Route::get('/console/types/edit/{type:id}', [TypesController::class, 'editForm'])->where('type', '[0-9]+')->middleware('auth');
Route::post('/console/types/edit/{type:id}', [TypesController::class, 'edit'])->where('type', '[0-9]+')->middleware('auth');
Route::get('/console/types/delete/{type:id}', [TypesController::class, 'delete'])->where('type', '[0-9]+')->middleware('auth');

// Dynamic page route - must be last so it doesn't collide with other routes
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '[A-z0-9\-]+');

// Console: pages and page sections
Route::get('/console/pages/list', [App\Http\Controllers\PagesController::class, 'list'])->middleware('auth');
Route::get('/console/pages/add', [App\Http\Controllers\PagesController::class, 'addForm'])->middleware('auth');
Route::post('/console/pages/add', [App\Http\Controllers\PagesController::class, 'add'])->middleware('auth');
Route::get('/console/pages/edit/{page:id}', [App\Http\Controllers\PagesController::class, 'editForm'])->where('page', '[0-9]+')->middleware('auth');
Route::post('/console/pages/edit/{page:id}', [App\Http\Controllers\PagesController::class, 'edit'])->where('page', '[0-9]+')->middleware('auth');
Route::get('/console/pages/delete/{page:id}', [App\Http\Controllers\PagesController::class, 'delete'])->where('page', '[0-9]+')->middleware('auth');

Route::get('/console/pages/sections/{page:id}/list', [App\Http\Controllers\PageSectionsController::class, 'list'])->where('page', '[0-9]+')->middleware('auth');
Route::get('/console/pages/sections/{page:id}/add', [App\Http\Controllers\PageSectionsController::class, 'addForm'])->where('page', '[0-9]+')->middleware('auth');
Route::post('/console/pages/sections/{page:id}/add', [App\Http\Controllers\PageSectionsController::class, 'add'])->where('page', '[0-9]+')->middleware('auth');
Route::get('/console/pages/sections/{page:id}/edit/{section:id}', [App\Http\Controllers\PageSectionsController::class, 'editForm'])->where('page', '[0-9]+')->where('section', '[0-9]+')->middleware('auth');
Route::post('/console/pages/sections/{page:id}/edit/{section:id}', [App\Http\Controllers\PageSectionsController::class, 'edit'])->where('page', '[0-9]+')->where('section', '[0-9]+')->middleware('auth');
Route::get('/console/pages/sections/{page:id}/delete/{section:id}', [App\Http\Controllers\PageSectionsController::class, 'delete'])->where('page', '[0-9]+')->where('section', '[0-9]+')->middleware('auth');

