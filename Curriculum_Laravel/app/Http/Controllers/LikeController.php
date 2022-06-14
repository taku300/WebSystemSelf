<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // ajaxいいね機能
    public function like(Request $request) {
        $user_id = Auth::user()->id; //1.ログインユーザーのid取得
        $recipe_id = $request->recipe_id; //2.投稿idの取得
        $likes_count = Like::where('recipe_id', '=', $recipe_id)->count(); //良いね数取得
        $like_data = Like::where('user_id', '=', $user_id)->where('recipe_id', '=', $recipe_id); //ログインユーザーがいいねしているか確認
        if(!$like_data->count() > 0){ //いいねしていなければDBにいいね情報を保存しいいね数に＋１する
        $like = new Like;
        $like->user_id = $user_id;
        $like->recipe_id = $recipe_id;
        $like->save();
        $param = ['likes_count' => $likes_count + 1];
        }else { //いいねをしていればDBのいいね情報を消去しいいね数を−１する
            $like_data->delete();
            $param = ['likes_count' => $likes_count - 1];
        }
        return response()->json($param);
    }
    
}
