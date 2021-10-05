<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
  

Route::get('itemlist', [ItemController::class, 'fristindex']);

Route::post("create-ice",[ItemController::class,'createIce']);

Route::get("students", [ItemController::class,'studentsListing']);

Route::get("student/{id}", [ItemController::class,'studentDetail']);

Route::delete("ice/{id}", [ItemController::class,'IceDelete']);

Route::resource('items', ItemController::class);
Route::resource('products', ProductController::class);
// Route::middleware('auth:sanctum')->group( function () {
//     Route::resource('products', ProductController::class);
// });