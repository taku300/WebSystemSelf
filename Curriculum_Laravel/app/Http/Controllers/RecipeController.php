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
use App\Category;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    // レシピ一覧画面
    public function recipe(Request $request) {
         // session()->forget('add');
        //並び替え検索
        $myrecipe = $request->myrecipe;
        $keyword = $request->keyword;
        $clear = $request->param;
        $category_id = $request->category_id;
        $date = $request->date;
        $page = 10;
        if($clear){  //元の状態に戻す
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients()->paginate($page);
        }else if($myrecipe){  //myrecipe
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients();
            $recipes = $recipes->where('user_id', '=', Auth::user()->id)->paginate($page);
        }else if($keyword || $date){   //検索ワードで絞る
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients();
            if($keyword){ //キーワードで検索
            $recipes = $recipes->where('recipes.name', 'LIKE', "%{$keyword}%");
            }
            if($date){ //日にちで検索
                $recipes = $recipes->where('recipes.created_at', 'LIKE', "%{$date}%");
            }
            $recipes = $recipes->paginate($page);
        }else{   //初期状態
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients()->paginate($page);
        }
        //変数の初期化
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
        return view('recipes/recipe', [
            'recipes' => $recipes,
            'login_user_like' => $login_user_like,
            'like_counts' => $like_counts,
            'myrecipe_judge' => $myrecipe_judge,
            'myrecipe' => $myrecipe,
            'keyword' => $keyword,
            'clear' => $clear,
            'category_id' => $category_id,
            'date' => $date,
            // 'sum' => $sum,
        ]);
    }

    // レシピ詳細画面
    public function recipeDetail(Recipe $recipe) {
        $recipe_id = $recipe->id;
        $recipe_details = new RecipeDetail;
        // レシピの栄養素の合計を計算
        $recipes = $recipe_details->calNutrients(); //RecipeDetailクラスより継承
        $recipe = $recipes->where('recipe_id', '=', $recipe_id)->first(); //レシピidと一致するものを取得

        //  \DB::enableQueryLog();
        // レシピに含まれる食材を抽出
        $foods = Food::join('recipe_details', 'recipe_details.food_id', '=', 'foods.id')
        ->where('recipe_details.recipe_id', '=', $recipe_id )
        ->select('foods.*','recipe_details.amount')
        ->get();
        $user = new User;
        //レシピの栄養素の目標値
        $target = $user->calRecipeTarget($recipe->energy); //userクラスより継承　各ユーザーの目標値を計算
        $alerts = $user->alert($target,$recipe); //userクラスより継承　作成したレシピに対してアラートを算出
        // dd(\DB::getQueryLog());
        return view('recipes/recipe_detail', [
            'recipe' => $recipe,
            'foods' => $foods,
            'target' => $target,
            'alerts' => $alerts,
        ]);
    }

    // レシピ消去画面
    public function recipeDestory(Recipe $recipe) {
        //レシピを理論消去する。
        $recipe_id = $recipe->id;
        $recipe->del_flg = 1;
        $recipe->save();
        return redirect('/recipe');

    }
}
