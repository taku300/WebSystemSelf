<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeDetail extends Model
{
    public function recipe() {
        return $this->belongsTo('App\Recipe');
    }
    
    public function food() {
        return $this->belongsTo('App\Food', 'food_id', 'id');
    }

    // レシピ要素を取り出し、レシピの合計栄養素を計算する
    public function calNutrients() {
        // \DB::enableQueryLog();
        $recipes = RecipeDetail::join('foods', 'recipe_details.food_id', '=', 'foods.id')
        ->join('recipes', 'recipe_details.recipe_id', '=', 'recipes.id')
        ->select('recipes.id', 'recipes.name', 'recipes.image', 'recipes.memo', 'recipes.user_id', 'recipe_details.recipe_id', 'recipes.created_at')
        ->selectRaw('SUM(foods.carbohydrate) * 4 + SUM(foods.protain) * 4 + SUM(foods.fat) * 9 AS energy')
        ->selectRaw('SUM(foods.carbohydrate) AS carbohydrate')
        ->selectRaw('SUM(foods.protain) AS protain')
        ->selectRaw('SUM(foods.fat) AS fat')
        ->where('recipes.del_flg', '=', 0)
        ->groupBy('recipes.id')
        ->orderBy('created_at', 'desc');
        // dd(\DB::getQueryLog());
        return $recipes;
    }

    public function calNutrientsRecord() {
        // \DB::enableQueryLog();
        $recipes = RecipeDetail::join('foods', 'recipe_details.food_id', '=', 'foods.id')
        ->join('recipes', 'recipe_details.recipe_id', '=', 'recipes.id')
        ->select('recipes.id', 'recipes.name', 'recipes.image', 'recipes.memo', 'recipes.user_id', 'recipe_details.recipe_id', 'recipes.created_at')
        ->selectRaw('SUM(foods.carbohydrate) * 4 + SUM(foods.protain) * 4 + SUM(foods.fat) * 9 AS energy')
        ->selectRaw('SUM(foods.carbohydrate) AS carbohydrate')
        ->selectRaw('SUM(foods.protain) AS protain')
        ->selectRaw('SUM(foods.fat) AS fat')
        ->groupBy('recipes.id');
        // dd(\DB::getQueryLog());
        return $recipes;
    }

}
