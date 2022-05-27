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
    Route::get('/administrator', [AdministratorController::class, 'administrator']);
    Route::get('/food', [AdministratorController::class, 'food']);
    Route::post('/food', [AdministratorController::class, 'createFood']);
    Route::get('/food/edit/{id}', [AdministratorController::class, 'foodEdit'])->name('food.edit');
    Route::post('/food/edit/{id}', [AdministratorController::class, 'createFoodEdit'])->name('food.edit');
    Route::get('/food/destory/{id}', [AdministratorController::class, 'foodDestory'])->name('food.destory');
    // RegisterController
    Route::get('/user_edit', [RegisterController::class, 'userEdit']);
    Route::post('/user_edit', [RegisterController::class, 'createuserEdit']);
    Route::get('/selection', [RegisterController::class, 'selection']);
    Route::get('/add_food/{id}', [RegisterController::class, 'addFood'])->name('add_food');
    Route::get('/remove_food/{id}', [RegisterController::class, 'removeFood'])->name('remove_food');
    Route::get('/registers', [RegisterController::class, 'register']);
    Route::post('/registers', [RegisterController::class, 'createregister']);
    // RecipeController
    Route::get('/record', [RecipeController::class, 'record']);
    Route::get('/change/{date}', [RecipeController::class, 'changeDate'])->name('change.data');
    Route::get('/record/register', [RecipeController::class, 'recordRegister']);
    Route::post('/record/register/{id}', [RecipeController::class, 'createRecord'])->name('record.register');
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
    Route::get('/change', [SearchController::class, 'change']);
    Route::post('/food/search', [SearchController::class, 'foodSearch']);
    Route::get('/myrecipe', [RecipeController::class, 'myrecipe']);
    Route::get('/recipe_search', [RecipeController::class, 'recipeSearch']);

    

});
