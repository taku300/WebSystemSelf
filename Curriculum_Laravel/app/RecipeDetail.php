<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeDetail extends Model
{
    public function recipe() {
        return $this->belongsTo('App\Recipe');
    }
    
    public function food() {
        return $this->belongsTo('App\Food');
    }
}
