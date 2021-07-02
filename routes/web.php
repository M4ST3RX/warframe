<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [HomeController::class, 'index'])->name('index');

Auth::routes();

// Auth only
Route::group(['middleware' => 'auth'], function() {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
});

// Guest
Route::get('/items', [ItemController::class, 'index'])->name('items');
Route::get('/item/{slug}', [ItemController::class, 'view'])->name('item.view');

Route::get('/items/{username}', [ItemController::class, 'viewOthers'])->name('items.others');

// API
Route::get('/api/items', [APIController::class, 'getItems']);
Route::post('/api/item/{id}/update', [APIController::class, 'updateItem']);
Route::post('/api/recipe/create', [APIController::class, 'createRecipe']);
Route::get('/api/inventory', [APIController::class, 'getInventory']);
Route::post('/api/inventory/add', [APIController::class, 'addItemInventory']);

