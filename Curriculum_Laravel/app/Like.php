<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Recipe;

class Like extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function recipe() {
        return $this->belongsTo('App\Recipe');
    }

    // public function isLikedBy($recipe_id): bool {
    //     $user = Auth::user();
    //     return Like::where('user_id', $user->id)->where('recipe_id', $recipe_id)->first() !==null;
    // }
}
