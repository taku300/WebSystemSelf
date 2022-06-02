<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateUser;
use App\Category;
use App\Food;

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

    public function selection(Request $request) {
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

        if(session()->has('add')){
            $id = session('add');
        }else{
            $id = null;
        }
       
        if(!session()->has('add')){
                session()->push('add', 0);
        }

        session()->push('add', 1);

        return view('registers/selection', [
            'categories' => $categories,
            'foods' => $foods,
        ]);
    }
    
    public function addFood(int $id) {
        if(session()->has('add')){
            if(!in_array($id, session('add'))){
                session()->push('add', $id);
            }
        }else{
            session()->push('add', $id);
        }
        return redirect('/selection');
    }

    public function removeFood(int $id) {
        $array = session('add');
        $session_id = array_search($id, session('add'));
        unset($array[$session_id]);
        session()->forget('add');
        foreach($array as $array){
            session()->push('add', $array);
        }
        return redirect('/selection');
    }

    public function register() {

    }

    public function createRegister() {

    }

    public function record() {
        // エネルギー、炭水化物、タンパク質、脂質計算
        function calculation($user){
            $birthday = str_replace('-', '', $user['birthday']);
            $now = date('Ymd');
            $age = floor (( $now - $birthday ) / 10000);
            // 基礎代謝量
            if($user['gender'] == '男性'){
            $basal_metabolic_rate = ( 0.0481 * $user['weight'] + 0.0234 * $user['height'] - 0.0138 * $age - 0.4235 ) * 1000 / 4.186;
            }else{
            $basal_metabolic_rate = ( 0.0481 * $user['weight'] + 0.0234 * $user['height'] - 0.0138 * $age - 0.9708 ) * 1000 / 4.186;
            }
            // エネルギー
            $param['energy'] = floor($basal_metabolic_rate * $user['exercise_level']);
            if($age >= 50 && $age <= 60){
            $param['carbohydrate_lower'] = floor(($param['energy'] * 0.14)/4);
            }else{
            $param['carbohydrate_lower'] = floor(($param['energy'] * 0.13)/4);
            }
            $param['carbohydrate_upper'] = floor(($param['energy'] * 0.2)/4);
            $param['protain_lower'] = floor(($param['energy'] * 0.2)/4);
            $param['protain_upper'] = floor(($param['energy'] * 0.3)/4);
            $param['fat_lower'] = floor(($param['energy'] * 0.5)/9);
            $param['fat_upper'] = floor(($param['energy'] * 0.65)/9);
    
            return $param;
        }

        $user = Auth::user();
        $param = calculation($user);

        return view('registers/record', [
            'user' => $user,
            'param' => $param,
        ]);
    }

    public function changeDate() {

    }

    public function recordRegister() {

    }

    public function createRecord() {
        
    }
}

