<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Food;
use App\Http\Requests\CreateFood;
use Illuminate\Support\Facades\Storage;


class AdministratorController extends Controller
{
    public function administrator(Request $request) {
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
        //  offset(0)->limit(10)
        return view('administrators/ad_home', [
            'categories' => $categories,
            'foods' => $foods,
            'keyword' => $keyword,
            'clear' => $clear,
            'category_id' =>$category_id
        ]);
    }

    public function food() {
        $categories = Category::select('id', 'category')->get()->pluck('category','id');
        return view('administrators/create_food', [
            'categories' => $categories,
        ]);
    }

    public function createFood(CreateFood $request) {
        $food = new Food;

        if ($file = $request->image) {
             // 画像フォームでリクエストした画像を取得
            $img = $request->file('image');
            // storage > public > img配下に画像が保存される
            $path = 'storage/' . $img->store('foods','public');
            // $fileName = time() . $file->getClientOriginalName();
            // $target_path = public_path('/foods_img');
            // $file->move($target_path, $fileName);
        } else {
            $path = "image/default.png";
        }

        $food->image = $path;
        $columns = ['name', 'carbohydrate', 'protain', 'fat', 'general_weight', 'unit', 'category_id',];
        foreach ($columns as $column) {
            $food->$column = $request->$column;
        }
        $food->save();
        return redirect('/administrator');
    }

    public function foodEdit(Food $food) {
        $categories = Category::select('id', 'category')->get()->pluck('category','id');
        return view('Administrators/edit_food', [
            'categories' => $categories,
            'food' => $food,
        ]);
    }

    public function createfoodEdit(Food $food ,CreateFood $request) {
        if ($file = $request->image) {
            $url = str_replace('storage/', '', $food->image);
            Storage::disk('public')->delete($url);
            $img = $request->file('image');
            $path = 'storage/' . $img->store('foods','public');
            $food->image = $path;
        }
        $columns = ['name', 'carbohydrate', 'protain', 'fat', 'general_weight', 'unit', 'category_id',];
        foreach ($columns as $column) {
            $food->$column = $request->$column;
        }
        $food->save();
        return redirect('/administrator');
    }

    public function foodDestory(Food $food) {
        $url = str_replace('storage/', '', $food->image);
        Storage::disk('public')->delete($url);
        $food->delete();
        return redirect('/administrator');
    }
}
