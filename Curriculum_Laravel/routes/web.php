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
    //管理者以上の権限
    Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
        // AdministratorController
        Route::get('/administrator', [AdministratorController::class, 'administrator'])->name('administrator');
        Route::get('/food', [AdministratorController::class, 'food']);
        Route::post('/food', [AdministratorController::class, 'createFood']);
        Route::get('/food/edit/{food}', [AdministratorController::class, 'foodEdit'])->name('food.edit');
        Route::post('/food/edit/{food}', [AdministratorController::class, 'createFoodEdit'])->name('food.edit');
        Route::get('/food/destory/{food}', [AdministratorController::class, 'foodDestory'])->name('food.destory');
    });
    //一般ユーザー以上の権限
    Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
        // RegisterController
        Route::get('/user_edit', [RegisterController::class, 'userEdit']);
        Route::post('/user_edit', [RegisterController::class, 'createUserEdit']);
        Route::get('/add_food/{food}', [RegisterController::class, 'addFood'])->name('add_food');
        Route::get('/remove_food/{food}', [RegisterController::class, 'removeFood'])->name('remove_food');
        Route::get('/registers', [RegisterController::class, 'register'])->name('registers');
        Route::post('/registers', [RegisterController::class, 'createRegister'])->name('registers');
        Route::get('/record', [RegisterController::class, 'record']);
        Route::get('/record/destory/{history}', [RegisterController::class, 'recordDestory'])->name('record.destory');
        Route::get('/record/register', [RegisterController::class, 'recordRegister'])->name('record.register');
        Route::get('/record/register/{recipe}', [RegisterController::class, 'createRecord'])->name('record.register.get');
        // RecipeController
        Route::get('/recipe', [RecipeController::class, 'recipe'])->name('recipe');
        Route::get('/recipe/detail/{recipe}', [RecipeController::class, 'recipeDetail'])->name('recipe.detail');
              
        // LikeController
        Route::get('/like', [LikeController::class, 'like'])->name('like');
        //ajaxController
        Route::get('/addfood', [AjaxController::class, 'addFood']);
        Route::get('/addrecipe', [AjaxController::class, 'addRecipe']);

        //レシピ登録のみのポリシー
        Route::group(['middleware' => 'can:view,recipe'], function(){
            // RegisterController
            Route::get('/recipe/create_session/{recipe}', [RegisterController::class, 'createSession'])->name('create.session');
            Route::get('/recipe/edit/{recipe}', [RegisterController::class, 'recipeEdit'])->name('recipe.edit');
            Route::post('/recipe/edit/{recipe}', [RegisterController::class, 'createRecipeEdit'])->name('recipe.edit');
            Route::get('/add_food/edit/{food}/{recipe}', [RegisterController::class, 'addFoodEdit'])->name('add_food.edit');
            Route::get('/remove_food/edit/{food}/{recipe}', [RegisterController::class, 'removeFoodEdit'])->name('remove_food.edit');
            // RecipeController
            Route::get('/recipe/destory/{recipe}', [RecipeController::class, 'recipeDestory'])->name('recipe.destory');
        });
    });
    
    

});
