<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // ajax
    public function like(Request $request) {
        $user_id = Auth::user()->id; //1.ログインユーザーのid取得
        $recipe_id = $request->recipe_id; //2.投稿idの取得
        $likes_count = Like::where('recipe_id', '=', $recipe_id)->count();
        $like_data = Like::where('user_id', '=', $user_id)->where('recipe_id', '=', $recipe_id);
        if(!$like_data->count() > 0){
        $like = new Like;
        $like->user_id = $user_id;
        $like->recipe_id = $recipe_id;
        $like->save();
        $param = ['likes_count' => $likes_count + 1];
        }else {
            $like_data->delete();
            
            $param = ['likes_count' => $likes_count - 1];
        }
        return response()->json($param);
    }
}
