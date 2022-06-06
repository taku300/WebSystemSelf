<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Food;
use App\Recipe;
use App\RecipeDetail;
use App\History;
use App\Like;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function recipe(Request $request) {
         // session()->forget('add');
        //並び替え検索
        $myrecipe = $request->myrecipe;
        $keyword = $request->keyword;
        $clear = $request->param;
        if($clear){
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients();
        }else if($myrecipe){
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients();
            $recipes = $recipes->where('user_id', '=', Auth::user()->id);
        }else if($keyword){
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients();
            $recipes = $recipe_details->calNutrientsSearch($keyword);
        }else{
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients();
        }
        
        $likes = Like::get();
        return view('recipes/recipe', [
            'recipes' => $recipes,
            'likes' => $likes,
            // 'sum' => $sum,
        ]);
    }

    public function recipeDetail(int $recipe_id) {
        $recipe_details = new RecipeDetail;
        // レシピの栄養素の合計を計算
        $recipes = $recipe_details->calNutrients();
        $recipe = $recipes->where('recipe_id', '=', $recipe_id)->first();

        //  \DB::enableQueryLog();
        // レシピに含まれる食材を抽出
        $foods = Food::join('recipe_details', 'recipe_details.food_id', '=', 'foods.id')
        ->where('recipe_details.recipe_id', '=', $recipe_id )
        ->select('foods.*')
        ->get();
        $user = new User;
        //レシピの栄養素の目標値
        $target = $user->calRecipeTarget($recipe->energy);
        $alerts = $user->alert($target,$recipe);


        // dd(\DB::getQueryLog());

        return view('recipes/recipe_detail', [
            'recipe' => $recipe,
            'foods' => $foods,
            'target' => $target,
            'alerts' => $alerts,
        ]);
    }

    public function recipeEdit() {

    }

    public function createRecipeEdit() {

    }

    public function newRecipe() {
        
    }

    public function recipeDestory(int $recipe_id) {
        $recipe = Recipe::find($recipe_id);
        $recipe->del_flg = 1;
        $recipe->save();
        
        return redirect('/recipe');

    }
}
