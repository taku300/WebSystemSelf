<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AjaxController;
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
    Route::get('/add_food/{id}', [RegisterController::class, 'addFood'])->name('add_food');
    Route::get('/remove_food/{id}', [RegisterController::class, 'removeFood'])->name('remove_food');
    Route::get('/registers', [RegisterController::class, 'register'])->name('registers');
    Route::post('/registers', [RegisterController::class, 'createRegister'])->name('registers');
    Route::get('/record', [RegisterController::class, 'record']);
    Route::get('/record/destory/{id}', [RegisterController::class, 'recordDestory'])->name('record.destory');
    Route::get('/record/register', [RegisterController::class, 'recordRegister'])->name('record.register');
    Route::get('/record/register/{id}', [RegisterController::class, 'createRecord'])->name('record.register.get');
    Route::get('/recipe/create_session/{id}', [RegisterController::class, 'createSession'])->name('create.session');
    Route::get('/recipe/edit/{id}', [RegisterController::class, 'recipeEdit'])->name('recipe.edit');
    Route::post('/recipe/edit/{id}', [RegisterController::class, 'createRecipeEdit'])->name('recipe.edit');
    Route::get('/add_food/edit/{recipe_id}/{food_id}', [RegisterController::class, 'addFoodEdit'])->name('add_food.edit');
    Route::get('/remove_food/edit/{recipe_id}/{food_id}', [RegisterController::class, 'removeFoodEdit'])->name('remove_food.edit');
    // RecipeController
    Route::get('/recipe', [RecipeController::class, 'recipe'])->name('recipe');
    Route::get('/recipe/detail/{id}', [RecipeController::class, 'recipeDetail'])->name('recipe.detail');
    Route::post('/recipe/new/{id}', [RecipeController::class, 'newRecipe'])->name('new.recipe');
    Route::get('/recipe/destory/{id}', [RecipeController::class, 'recipeDestory'])->name('recipe.destory');
    // LikeController
    Route::get('/like', [LikeController::class, 'like'])->name('like');
    // TweetController
    Route::get('/recipe/tweet/{id}', [TweetController::class, 'tweet'])->name('tweet');
    Route::post('/recipe/tweet/{id}', [TweetController::class, 'createtweet'])->name('tweet');
    //Controller
    Route::post('/food/search', [SearchController::class, 'foodSearch'])->name('food.search');
    Route::get('/myrecipe', [SearchController::class, 'myrecipe']);
    Route::get('/recipe_search', [SearchController::class, 'recipeSearch']);
    //ajaxController
    Route::get('/addfood', [AjaxController::class, 'addFood']);
    Route::get('/addrecipe', [AjaxController::class, 'addRecipe']);

    

});
