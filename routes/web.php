<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ThanksController;
use App\Http\Controllers\ItemDeleteController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/items', [ItemController::class, 'index'])->name("items.index");
Route::post('/order', [OrderController::class, 'confirm'])->name("order.confirm");
Route::post('/thanks', [ThanksController::class, 'store'])->name("thanks.store"); 
Route::delete('/items/delete/{itemId}', [ItemDeleteController::class, 'itemDelete'])->name("items.delete");
//Route::delete('/items/delete/{itemId}', [ItemDeleteController::class])->name("items.delete");


Route::get("/tweet", \App\Http\Controllers\Tweet\IndexController::class)->name("tweet.index");
Route::middleware("auth")->group(function() {
    Route::post("/tweet/create", \App\Http\Controllers\Tweet\CreateController::class)->name("tweet.create"); //->middleware("auth")は削除
    Route::get("/tweet/update/{tweetId}", \App\Http\Controllers\Tweet\Update\IndexController::class)->name("tweet.update.index");
    Route::put("/tweet/update/{tweetId}", \App\Http\Controllers\Tweet\Update\PutController::class)->name("tweet.update.put");
    Route::delete("/tweet/delete/{tweetId}", \App\Http\Controllers\Tweet\DeleteController::class)->name("tweet.delete");
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
