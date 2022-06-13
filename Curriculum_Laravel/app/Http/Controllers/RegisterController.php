<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateUser;
use App\Http\Requests\CreateRecipe;
use App\Category;
use App\Food;
use App\User;
use App\Recipe;
use App\History;
use App\RecipeDetail;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function userEdit() {
        $user = Auth::user();
        return view('Auth/register_edit', [
            'user' => $user,
        ]);
    }

    public function createUserEdit(CreateUser $request) {
        $user = Auth::user();
        $columns = ['name', 'gender', 'birthday', 'height', 'target_weight', 'exercise_level'];
        foreach($columns as $column){
            $user->$column = $request->$column;
        }
        $user->save();

        return redirect('/');

    }

    public function register(Request $request) {
        //並び替え検索
        $categories = Category::get();
        $category_id = $request->category_id;
        $keyword = $request->keyword;
        $clear = $request->param;
        $page = 10;
        if($clear){
            $foods = Food::orderBy('created_at', 'desc')->paginate($page);
        }else if($keyword){
            $foods = Food::where('name', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate($page);
        }else if($category_id){     //並べ替え処理
            $foods = Food::where('category_id', '=', $category_id)->orderBy('created_at', 'desc')->paginate($page);
        }else{
            $foods = Food::orderBy('created_at', 'desc')->paginate($page);
        }
        
        // 合計を計算
        $carbohydrate = $protain = $fat = $energy = 0;
        $sum = ["energy" => 0, "carbohydrate" => 0, "protain" => 0, "fat" => 0];
        $target = ["carbohydrate_lower" => 0, "carbohydrate_upper" => 0, "protain_lower" => 0, "protain_upper" => 0, "fat_lower" => 0, "fat_upper" => 0 ];
        $alerts = array();
        $add_foods =null;
        if(session()->has('add')){
            $add_foods = session('add');
            foreach($add_foods as $food){
                $amount = $food['amount'];
                $carbohydrate += round($food['carbohydrate'] * $amount / 100, 2); 
                $protain += round($food['protain'] * $amount / 100, 2); 
                $fat += round($food['fat'] * $amount / 100, 2);     
            }
            $energy += round($carbohydrate * 4 + $protain * 4 + $fat * 9, 2);
            $sum = compact("energy", "carbohydrate", "protain", "fat");
            $user = new User;
            //一食の目標値(栄養バランス)を計算
            $target = $user->calRecipeTarget($energy);
            //アラートを鳴らす
            $alerts = $user->alert($target, $sum);

        }
        
        return view('registers/register', [
            'categories' => $categories,
            'foods' => $foods,
            'add_foods' => $add_foods,
            'sum' => $sum,
            'target' => $target,
            'alerts' => $alerts,
            'keyword' => $keyword,
            'clear' => $clear,
            'category_id' =>$category_id

        ]);
    }
    
    public function addFood(Food $food, Request $request) {
        // session()->forget('add');
        // セッションに入れる準備
        $food_id = $food->id;
        $name = $food->name;
        $carbohydrate = $food->carbohydrate;
        $protain = $food->protain;
        $fat = $food->fat;
        $image = $food->image;
        $general_weight = $food->general_weight;
        $unit = $food->unit;
        $num_id = 'num-' . $food_id; 
        $amount_id = 'amount-' . $food_id; 
        $num = $request->$num_id; 
        $amount = $request->$amount_id;
        if($num != null){
            $amount = $general_weight * $num;
        }
        $data = compact("food_id", "name", "carbohydrate", "protain", "fat", "image", "general_weight", "unit", "amount");
        // すでにセッションにあるか確認し、なければ格納
        if(session()->has('add')){
            $add_foods = session('add');
            $length = count($add_foods); 
            for($i = 0; $i < $length; $i++){    //セッションにあるか確認
                if($add_foods[$i]['food_id'] == $food_id){
                    $target = $i;
                    break;
                }
            }
            if(!isset($target)){    //あれば格納
                session()->push('add', $data);
            }
        }else{  //セッション自体が存在しなければ格納
            session()->push('add', $data);
        }
        // dd(session('add'));
        return redirect('/registers');
    }

    public function removeFood(Food $food) {
        $food_id = $food->id;
        $add_foods = session('add');
        $length = count($add_foods); 
        // $session_id = array_search($food_id, session('add'));
        // unset($array[$session_id]);
        // foreach($add_foods as $food){
            
            // }
        for($i = 0; $i < $length; $i++){
            if($add_foods[$i]['food_id'] == $food_id){
                $target = $i;
                break;
            }
        }
        unset($add_foods[$target]);
        session()->forget('add');
        if($length != 1){
            foreach($add_foods as $food){
            session()->push('add', $food);
            }
        }
        return redirect('/registers');
    }

    public function createRegister(CreateRecipe $request) {
        if(!session()->has('add')){
            return redirect('/registers');
        }
        $user = Auth::user();
        //レシピ保存
        $recipe = new Recipe;
        if ($file = $request->image) {
           $img = $request->file('image');
           $path = 'storage/' . $img->store('recipes','public');
       } else {
           $path = "image/default.png";
       }
       $recipe->image = $path;
        $columns = ['name', 'memo'];
        foreach($columns as $column){
            $recipe->$column = $request->$column;
        }
        $recipe->user_id = $user->id;
        $recipe->save();
        //レシピ詳細保存
        $add_foods = session('add');
        $columns = ['amount', 'food_id'];
        foreach($add_foods as $food){
            $recipe_detail = new RecipeDetail;
            foreach($columns as $column){
                $recipe_detail->$column = $food[$column];
            }
            $recipe_detail->recipe_id = $recipe->id;
            $recipe_detail->save();
        }
        //食事記録保存
        if($request->date){
            $history = new History;
            $history->date = $request->date;
            $history->user_id = $user->id;
            $history->recipe_id = $recipe->id;
            $history->save();
        }
        session()->forget('add');
        return redirect('/registers');
    }

    public function record(Request $request) {
        // エネルギー、炭水化物、タンパク質、脂質計算
        $user = Auth::user();
        $target = $user->calDateTarget();
        $history = array();
        $date = date("Y-m-d"); 
        if($request->date){
            $date = $request->date;
        }

        $recipes = $sum = $alerts = $param = $history_key = array();
        $historys = History::where('user_id', '=', Auth::user()->id)->where('date', 'LIKE', "%{$date}%")->orderBy('created_at','asc');
        $historys = History::where('user_id', '=', Auth::user()->id)->where('date', 'LIKE', "%{$date}%")->orderBy('created_at','asc')->get();
        $check = History::where('user_id', '=', Auth::user()->id)->where('date', 'LIKE', "%{$date}%")->orderBy('created_at','asc')->count() > 0;
        if($check){
            foreach($historys as $history){
                $param[] = $history['recipe_id'];
                $history_key[] = $history['id'];
            }
            $recipe_detail = new RecipeDetail;
            $ids_order = implode(',', $param);
            foreach($param as $param){
                $recipes[] = $recipe_detail->calNutrientsRecord()->where('recipe_id',$param)->first();
            }
            
            // １日の合計栄養素を計算
            $carbohydrate = $protain = $fat = $energy = 0;
            foreach($recipes as $reicpe){
                $carbohydrate += $reicpe['carbohydrate']; 
                $protain += $reicpe['protain']; 
                $fat += $reicpe['fat'];     
            }
            $energy += $carbohydrate * 4 + $protain * 4 + $fat * 9;
            $sum = compact("energy", "carbohydrate", "protain", "fat");
            //アラートを鳴らす
            $alerts = $user->alertRecord($target, $sum);
        }
        return view('registers/record', [
            'user' => $user,
            'target' => $target,
            'recipes' => $recipes,
            'sum' => $sum,
            'alerts' => $alerts,
            'date' => $date,
            'history_key' => $history_key,

        ]);
    }

    public function recordDestory(History $history){
        $history_id = $history->id;
        $history = History::find($history_id);
        $history->delete();
        return redirect('/record');
    }

    public function recordRegister(Request $request) {
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
            if($keyword){
            $recipes = $recipes->where('recipes.name', 'LIKE', "%{$keyword}%");
            }
            if($date){
                $recipes = $recipes->where('recipes.created_at', 'LIKE', "%{$date}%");
            }
            $recipes = $recipes->paginate($page);
        }else{   //初期状態
            $recipe_details = new RecipeDetail;
            $recipes = $recipe_details->calNutrients()->paginate($page);
        }
        $myrecipe_judge = array();
        foreach($recipes as $recipe){
            $myrecipe_judge[] = Recipe::where('id', '=', $recipe->id)->where('user_id', '=',  Auth::user()->id)->count() > 0;
        }
        return view('/registers/register_record', [
            'recipes' => $recipes,
            'myrecipe_judge' => $myrecipe_judge,
            'myrecipe' => $myrecipe,
            'keyword' => $keyword,
            'clear' => $clear,
            'category_id' => $category_id,
            'date' => $date,
        ]);
        return view('');
    }

    public function createRecord(Recipe $recipe, Request $request) {
        $recipe_id = $recipe->id;
        $history = new History;
        $history->date = $request->date;
        $history->user_id = Auth::user()->id;
        $history->recipe_id = $recipe_id;
        $history->save();
        return redirect('/record');

    }

    public function createSession(Recipe $recipe){
        $recipe_id = $recipe->id;
        if(session()->has('add_edit')){
        session()->forget('add_edit');
        }
        $param = array();
        $recipes_num = RecipeDetail::where('recipe_id', '=', $recipe_id)->get();
        foreach($recipes_num as $recipe_num){
            $param[] = $recipe_num['food_id'];
        }
        // \DB::enableQueryLog();
        $foods = Food::join('recipe_details', 'foods.id', '=', 'recipe_details.food_id')
        ->select('foods.*','recipe_details.recipe_id', 'recipe_details.amount')
        ->where('recipe_details.recipe_id', '=', $recipe_id)
        ->find($param);
        // dd(\DB::getQueryLog());
        var_dump($param);
        foreach($foods as $food){
            $food_id = $food->id;
            $name = $food->name;
            $carbohydrate = $food->carbohydrate;
            $protain = $food->protain;
            $fat = $food->fat;
            $image = $food->image;
            $general_weight = $food->general_weight;
            $unit = $food->unit; 
            $amount = $food->amount;
            $data = compact("food_id", "name", "carbohydrate", "protain", "fat", "image", "general_weight", "unit", "amount");
            session()->push('add_edit', $data);
            var_dump($data);
        }
        return redirect(route('recipe.edit', [$recipe_id]));
    }

    public function recipeEdit(Recipe $recipe, Request $request) {
        $recipe_id = $recipe->id;
        // session()->forget('add_edit');
        //並び替え検索
        $categories = Category::get();
        $category_id = $request->category_id;
        $keyword = $request->keyword;
        $clear = $request->param;
        $page = 10;
        if($clear){
            $foods = Food::orderBy('created_at', 'desc')->paginate($page);
        }else if($keyword){
            $foods = Food::where('name', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate($page);
        }else if($category_id){     //並べ替え処理
            $foods = Food::where('category_id', '=', $category_id)->orderBy('created_at', 'desc')->paginate($page);
        }else{
            $foods = Food::orderBy('created_at', 'desc')->paginate($page);
        }
        
        // 合計を計算
        $carbohydrate = $protain = $fat = $energy = 0;
        $sum = ["energy" => 0, "carbohydrate" => 0, "protain" => 0, "fat" => 0];
        $target = ["carbohydrate_lower" => 0, "carbohydrate_upper" => 0, "protain_lower" => 0, "protain_upper" => 0, "fat_lower" => 0, "fat_upper" => 0 ];
        $alerts = array();
        $add_foods =null;
        if(session()->has('add_edit')){
            $add_foods = session('add_edit');
            foreach($add_foods as $food){
            $amount = $food['amount'];
            $carbohydrate += round($food['carbohydrate'] * $amount / 100, 2); 
            $protain += round($food['protain'] * $amount / 100, 2); 
            $fat += round($food['fat'] * $amount / 100, 2);     
            }
        $energy += round($carbohydrate * 4 + $protain * 4 + $fat * 9, 2);
        $sum = compact("energy", "carbohydrate", "protain", "fat");
        $user = new User;
        //一食の目標値(栄養バランス)を計算
        $target = $user->calRecipeTarget($energy);
        //アラートを鳴らす
        $alerts = $user->alert($target, $sum);

        }
    
        return view('/recipes/recipe_edit', [
            'categories' => $categories,
            'foods' => $foods,
            'add_foods' => $add_foods,
            'sum' => $sum,
            'target' => $target,
            'alerts' => $alerts,
            'keyword' => $keyword,
            'clear' => $clear,
            'category_id' => $category_id,
            'recipe_id' => $recipe_id,
            'recipe' => $recipe,
        ]);
    }

    public function addFoodEdit(Food $food, Recipe $recipe, Request $request) {
        // session()->forget('add_edit');
        // セッションに入れる準備
        $recipe_id = $recipe->id;
        $food_id = $food->id;
        $name = $food->name;
        $carbohydrate = $food->carbohydrate;
        $protain = $food->protain;
        $fat = $food->fat;
        $image = $food->image;
        $general_weight = $food->general_weight;
        $unit = $food->unit;
        $num_id = 'num-' . $food_id; 
        $amount_id = 'amount-' . $food_id; 
        $num = $request->$num_id; 
        $amount = $request->$amount_id;
        if($num != null){
            $amount = $general_weight * $num;
        }
        $data = compact("food_id", "name", "carbohydrate", "protain", "fat", "image", "general_weight", "unit", "amount");
        // すでにセッションにあるか確認し、なければ格納
        if(session()->has('add_edit')){
            $add_foods = session('add_edit');
            $length = count($add_foods); 
            for($i = 0; $i < $length; $i++){    //セッションにあるか確認
                if($add_foods[$i]['food_id'] == $food_id){
                    $target = $i;
                    break;
                }
            }
            if(!isset($target)){    //あれば格納
                session()->push('add_edit', $data);
            }
        }else{  //セッション自体が存在しなければ格納
            session()->push('add_edit', $data);
        }
        // dd(session('add_edit'));
        return redirect(route('recipe.edit', [$recipe_id]));
    }

    public function removeFoodEdit(Food $food, Recipe $recipe) {
        $recipe_id = $recipe->id;
        $food_id = $food->id;
        $add_foods = session('add_edit');
        $length = count($add_foods); 
        // $session_id = array_search($food_id, session('add_edit'));
        // unset($array[$session_id]);
        // foreach($add_foods as $food){
            
            // }
        for($i = 0; $i < $length; $i++){
            if($add_foods[$i]['food_id'] == $food_id){
                $target = $i;
                break;
            }
        }
        unset($add_foods[$target]);
        session()->forget('add_edit');
        if($length != 1){
            foreach($add_foods as $food){
            session()->push('add_edit', $food);
            }
        }
        return redirect(route('recipe.edit', [$recipe_id]));
    }

    public function createRecipeEdit(Recipe $recipe, CreateRecipe $request) {
        $recipe_id = $recipe->id;
        if(!session()->has('add_edit')){
            return redirect(route('recipe.edit', [
                'id' => $recipe_id,
            ]));
        }
        $old_recipe = Recipe::find($recipe_id);
        $old_recipe->del_flg = 1;
        $old_recipe->save();
        $recipe = new Recipe;
        $user = Auth::user();
        if ($file = $request->image) {
            $img = $request->file('image');
            $path = 'storage/' . $img->store('recipes','public');
        }else{
            $path =$old_recipe->image;
        }
        $recipe->image = $path;
        $columns = ['name', 'memo'];
        foreach($columns as $column){
            $recipe->$column = $request->$column;
        }
        $recipe->user_id = $user->id;
        $recipe->save();
        //レシピ詳細保存
        $add_foods = session('add_edit');
        $columns = ['amount', 'food_id'];
        foreach($add_foods as $food){
            $recipe_detail = new RecipeDetail;
            foreach($columns as $column){
                $recipe_detail->$column = $food[$column];
            }
            $recipe_detail->recipe_id = $recipe->id;
            $recipe_detail->save();
        }
        //食事記録保存
        if($request->date){
            $history = new History;
            $history->date = $request->date;
            $history->user_id = $user->id;
            $history->recipe_id = $recipe->id;
            $history->save();
        }
        session()->forget('add');
        return redirect('/recipe');
    }

    
}

