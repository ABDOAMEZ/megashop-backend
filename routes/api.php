<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthenticatConroller;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductImagesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//* Authentication
Route::get('/get_users', [AuthenticatConroller::class, 'get_data']);
Route::post('/register', [AuthenticatConroller::class, 'register']);
Route::post('/login', [AuthenticatConroller::class, 'login']);

//* categories 
Route::get('/get_categories', [CategorieController::class, 'index']);
Route::get('/get_main_categories', [CategorieController::class, 'main_categories']);
Route::get('/get_sous_categories', [CategorieController::class, 'sous_categories']);

//* products 
Route::get('/get_products', [ProductsController::class, 'index']);

//* product Images
Route::get('/get_product_images', [ProductImagesController::class, 'index']);




Route::middleware('auth:sanctum')->group(function () {
    //* Authentication
    Route::post('/logout', [AuthenticatConroller::class, 'logout']);
    Route::put('/updateprofile', [AuthenticatConroller::class, 'updateProfile']);
    Route::delete('/deleteProfile', [AuthenticatConroller::class, 'deleteProfile']);
    Route::put('/becomeseller', [AuthenticatConroller::class, 'Change_role']);
    Route::post('/get_user', [AuthenticatConroller::class, 'get_user']);

    //* categories
    Route::post('/add_categorie', [CategorieController::class, 'store']);
    Route::put('/update_categorie', [CategorieController::class, 'update_categorie']);
    Route::delete('/delete_categorie', [CategorieController::class, 'delete_categorie']);

    //* products 
    Route::post('/add_product', [ProductsController::class, 'store']);
    Route::put('/update_product', [ProductsController::class, 'update_product']);
    Route::delete('/delete_product', [ProductsController::class, 'delete_product']);

    //* product Images
    Route::post('/add_product_images', [ProductImagesController::class, 'store']);
    Route::put('/update_product_images', [ProductImagesController::class, 'update_image']);
    Route::delete('/delete_product_images', [ProductImagesController::class, 'delete_image']);
});
