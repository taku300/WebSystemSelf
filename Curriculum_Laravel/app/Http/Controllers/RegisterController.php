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
        // session()->forget('add');
        //並び替え検索
        $categories = Category::get();
        $category_id = $request->category_id;
        $keyword = $request->keyword;
        $clear = $request->param;
        if($clear){
            $foods = Food::get();
        }else if($keyword){
            $foods = Food::where('name', 'LIKE', "%{$keyword}%")->get();
        }else if($category_id){     //並べ替え処理
            $foods = Food::where('category_id', '=', $category_id)->get();
        }else{
            $foods = Food::get();
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
                $carbohydrate += $food['carbohydrate'] * $amount / 100; 
                $protain += $food['protain'] * $amount / 100; 
                $fat += $food['fat'] * $amount / 100;     
            }
            $energy += $carbohydrate * 4 + $protain * 4 + $fat * 9;
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

        ]);
    }
    
    public function addFood(int $food_id, Request $request) {
        // session()->forget('add');
        // セッションに入れる準備
        $food = Food::find($food_id);
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

    public function removeFood(int $food_id) {
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


        return redirect('/registers');
    }

    public function record() {
        // エネルギー、炭水化物、タンパク質、脂質計算
        

        $user = Auth::user();
        $target = $user->calDateTarget();

        return view('registers/record', [
            'user' => $user,
            'target' => $target,
        ]);
    }

    public function changeDate() {

    }

    public function recordRegister() {

    }

    public function createRecord() {
        
    }
}

