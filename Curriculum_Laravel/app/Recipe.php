<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function like() {
        return $this->hasMany('App\Like');
    }
    public function recipeDetail() {
        return $this->hasMany('App\RecipeDetail');
    }
    public function history() {
        return $this->hasMany('App\History');
    }
}
