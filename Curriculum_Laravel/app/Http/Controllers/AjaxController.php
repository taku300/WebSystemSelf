<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;
use App\RecipeDetail;
use App\Like;
use App\Recipe;
use Illuminate\Support\Facades\Auth;
class AjaxController extends Controller
{
    public function addFood(Request $request) {
        $count = intval($request->count);
        $keyword = $request->keyword;
        $clear = $request->clear;
        $category_id = $request->category_id;
        $page = 10;
        if($clear){
            $foods = Food::orderBy('created_at', 'desc')->offset($count)->limit($page)->get();
        }else if($keyword){
            $foods = Food::where('name', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->offset($count)->limit($page)->get();
        }else if($category_id){     //並べ替え処理
            $foods = Food::where('category_id', '=', $category_id)->orderBy('created_at', 'desc')->offset($count)->limit($page)->get();
        }else{
            $foods = Food::orderBy('created_at', 'desc')->offset($count)->limit($page)->get();
        }
        $data = compact("foods");
        return response()->json($data);
    }

    public function addRecipe(Request $request) {
        $count = intval($request->count);
        $myrecipe = $request->myrecipe;
        $keyword = $request->keyword;
        $clear = $request->clear;
        $category_id = $request->category_id;
        $date = $request->date;
        $page = 10;
        if($clear){  //元の状態に戻す
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients()->offset($count)->limit($page)->get();
        }else if($myrecipe){  //myrecipe
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients();
            $recipes = $recipes->where('user_id', '=', Auth::user()->id)->offset($count)->limit($page)->get();
        }else if($keyword || $date){   //検索ワードで絞る
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients();
            if($keyword){
            $recipes = $recipes->where('recipes.name', 'LIKE', "%{$keyword}%");
            }
            if($date){
                $recipes = $recipes->where('recipes.created_at', 'LIKE', "%{$date}%");
            }
            $recipes = $recipes->offset($count)->limit($page)->get();
        }else{   //初期状態
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients()->offset($count)->limit($page)->get();
        }
        
        $login_user_like = array();
        $like_counts = array();
        $myrecipe_judge = array();
        // いいねの判定 myrecipe判定
        $likes = Like::get();
        foreach($recipes as $recipe){
            $login_user_like[] = $likes->where('user_id', '=', Auth::user()->id)->where('recipe_id', '=', $recipe->id)->count() > 0;
            $like_counts[] = $likes->where('recipe_id', '=', $recipe->id)->count();
            $myrecipe_judge[] = Recipe::where('id', '=', $recipe->id)->where('user_id', '=',  Auth::user()->id)->count() > 0;
        }
        $data = compact("recipes", "login_user_like", "like_counts", "myrecipe_judge");
        return response()->json($data);
    }
}
