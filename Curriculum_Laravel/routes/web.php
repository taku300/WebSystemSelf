<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\SearchController;
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

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    // HomeController
    Route::get('/', [HomeController::class, 'index']);
    // AdministratorController
    Route::get('/administrator', [AdministratorController::class, 'administrator'])->name('administrator');
    Route::get('/food', [AdministratorController::class, 'food']);
    Route::post('/food', [AdministratorController::class, 'createFood']);
    Route::get('/food/edit/{food}', [AdministratorController::class, 'foodEdit'])->name('food.edit');
    Route::post('/food/edit/{food}', [AdministratorController::class, 'createFoodEdit'])->name('food.edit');
    Route::get('/food/destory/{food}', [AdministratorController::class, 'foodDestory'])->name('food.destory');
    // RegisterController
    Route::get('/user_edit', [RegisterController::class, 'userEdit']);
    Route::post('/user_edit', [RegisterController::class, 'createUserEdit']);
    Route::get('/selection', [RegisterController::class, 'selection']);
    Route::get('/add_food/{id}', [RegisterController::class, 'addFood'])->name('add_food');
    Route::get('/remove_food/{id}', [RegisterController::class, 'removeFood'])->name('remove_food');
    Route::get('/registers', [RegisterController::class, 'register']);
    Route::post('/registers', [RegisterController::class, 'createRegister']);
    Route::get('/record', [RegisterController::class, 'record']);
    Route::get('/record/change/{date}', [RegisterController::class, 'changeDate'])->name('change.data');
    Route::get('/record/register', [RegisterController::class, 'recordRegister']);
    Route::post('/record/register/{id}', [RegisterController::class, 'createRecord'])->name('record.register');
    // RecipeController
    Route::get('/recipe', [RecipeController::class, 'recipe']);
    Route::get('/recipe/detail/{id}', [RecipeController::class, 'recipeDetail'])->name('recipe.detail');
    Route::get('/recipe/edit/{id}', [RecipeController::class, 'recipeEdit'])->name('recipe.edit');
    Route::post('/recipe/edit/{id}', [RecipeController::class, 'createRecipeEdit'])->name('recipe.edit');
    Route::post('/recipe/new/{id}', [RecipeController::class, 'newRecipe'])->name('new.recipe');
    Route::get('/recipe/remove/{id}', [RecipeController::class, 'recipeRemove'])->name('recipe.remove');
    // LikeController
    Route::get('/like/{id}', [LikeController::class, 'createLike'])->name('like');
    Route::get('/like/destory/{id}', [LikeController::class, 'likeDestory'])->name('like.destory');
    // TweetController
    Route::get('/tweet/{id}', [TweetController::class, 'tweet'])->name('tweet');
    Route::post('/tweet/{id}', [TweetController::class, 'createtweet'])->name('tweet');
    //SearchController
    Route::post('/food/search', [SearchController::class, 'foodSearch'])->name('food.search');
    Route::get('/myrecipe', [SearchController::class, 'myrecipe']);
    Route::get('/recipe_search', [SearchController::class, 'recipeSearch']);

    

});
