<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Food;
use App\Http\Requests\CreateFood;
use Illuminate\Support\Facades\Storage;


class AdministratorController extends Controller
{
    // 管理者トップ画面
    public function administrator(Request $request) {
        $categories = Category::get();
        //検索に必要なパラメータの取得
        $category_id = $request->category_id;
        $keyword = $request->keyword;
        $clear = $request->param;
        $page = 10; //表示する食事の初期個数
        //検索によって場合分け
        if($clear){
            $foods = Food::orderBy('created_at', 'desc')->paginate($page);
        }else if($keyword){
            $foods = Food::where('name', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate($page);
        }else if($category_id){     //並べ替え処理
            $foods = Food::where('category_id', '=', $category_id)->orderBy('created_at', 'desc')->paginate($page);
        }else{
            $foods = Food::orderBy('created_at', 'desc')->paginate($page);
        }  
        return view('administrators/ad_home', [
            'categories' => $categories,
            'foods' => $foods,
            'keyword' => $keyword,
            'clear' => $clear,
            'category_id' =>$category_id
        ]);
    }

    // 食材登録画面
    public function food() {
        $categories = Category::select('id', 'category')->get()->pluck('category','id');
        return view('administrators/create_food', [
            'categories' => $categories,
        ]);
    }

    // 食材登録
    public function createFood(CreateFood $request) {
        $food = new Food;
        //画像の処理
        if ($file = $request->image) {
             // 画像フォームでリクエストした画像を取得
            $img = $request->file('image');
            // storage > public > img配下に画像が保存される
            $path = 'storage/' . $img->store('foods','public');
            // $fileName = time() . $file->getClientOriginalName();
            // $target_path = public_path('/foods_img');
            // $file->move($target_path, $fileName);
        } else {
            //登録されてない場合はデフォルト写真のパスを指定
            $path = "image/default.png";
        }
        //食事情報保存
        $food->image = $path;
        $columns = ['name', 'carbohydrate', 'protain', 'fat', 'general_weight', 'unit', 'category_id',];
        foreach ($columns as $column) {
            $food->$column = $request->$column;
        }
        $food->save();
        return redirect('/administrator');
    }

    // 食材編集画面
    public function foodEdit(Food $food) {
        $categories = Category::select('id', 'category')->get()->pluck('category','id');
        return view('Administrators/edit_food', [
            'categories' => $categories,
            'food' => $food,
        ]);
    }

    // 食材編集
    public function createfoodEdit(Food $food ,CreateFood $request) {
        //画像が存在すれば変更
        if ($file = $request->image) {
            $url = str_replace('storage/', '', $food->image);
            Storage::disk('public')->delete($url);
            $img = $request->file('image');
            $path = 'storage/' . $img->store('foods','public');
            $food->image = $path;
        }
        //情報をアップデート
        $columns = ['name', 'carbohydrate', 'protain', 'fat', 'general_weight', 'unit', 'category_id',];
        foreach ($columns as $column) {
            $food->$column = $request->$column;
        }
        $food->save();
        return redirect('/administrator');
    }

    // 食材消去
    public function foodDestory(Food $food) {
        //パスを修正してディスクの画像情報を消去
        $url = str_replace('storage/', '', $food->image);
        Storage::disk('public')->delete($url);
        $food->delete();
        return redirect('/administrator');
    }
}
