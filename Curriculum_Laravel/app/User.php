<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','gender','birthday','height','target_weight','exercise_level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function recipe() {
        return $this->hasMany('App\Recipe');
    }
    public function like() {
        return $this->hasMany('App\Like');
    }
    public function history() {
        return $this->hasMany('App\History');
    }

    // ログインユーザーの１日の目標値を計算
    public function calDateTarget(){
        $user = Auth::user();
        $birthday = str_replace('-', '', $user['birthday']);
        $now = date('Ymd');
        $age = floor (( $now - $birthday ) / 10000);
        if($user['exercise_level'] == 1){
            $exercise_level = 1.5 ;
        }elseif($user['exercise_level'] == 2){
            $exercise_level = 1.75;
        }else{
            $exercise_level = 2.0;
        }
        // 基礎代謝量
        if($user['gender'] == 1){
        $basal_metabolic_rate = ( 0.0481 * $user['target_weight'] + 0.0234 * $user['height'] - 0.0138 * $age - 0.4235 ) * 1000 / 4.186;
        }else{
        $basal_metabolic_rate = ( 0.0481 * $user['target_weight'] + 0.0234 * $user['height'] - 0.0138 * $age - 0.9708 ) * 1000 / 4.186;
        }
        // エネルギー
        $param['energy'] = floor($basal_metabolic_rate * $exercise_level);
        if($age >= 50 && $age <= 60){
        $param['protain_lower'] = floor(($param['energy'] * 0.14)/4);
        }else{
        $param['protain_lower'] = floor(($param['energy'] * 0.13)/4);
        }
        $param['protain_upper'] = floor(($param['energy'] * 0.2)/4);
        $param['fat_lower'] = floor(($param['energy'] * 0.2)/9);
        $param['fat_upper'] = floor(($param['energy'] * 0.3)/9);
        $param['carbohydrate_lower'] = floor(($param['energy'] * 0.5)/4);
        $param['carbohydrate_upper'] = floor(($param['energy'] * 0.65)/4);

        return $param;
    }

    // エネルギーから一食の目標値を計算
    public function calRecipeTarget($energy){
        $user = Auth::user();
        $birthday = str_replace('-', '', $user['birthday']);
        $now = date('Ymd');
        $age = floor (( $now - $birthday ) / 10000);
        $param['energy'] = $energy;
        if($age >= 50 && $age <= 60){
        $param['protain_lower'] = floor(($param['energy'] * 0.14)/4);
        }else{
        $param['protain_lower'] = floor(($param['energy'] * 0.13)/4);
        }
        $param['protain_upper'] = floor(($param['energy'] * 0.2)/4);
        $param['fat_lower'] = floor(($param['energy'] * 0.2)/9);
        $param['fat_upper'] = floor(($param['energy'] * 0.3)/9);
        $param['carbohydrate_lower'] = floor(($param['energy'] * 0.5)/4);
        $param['carbohydrate_upper'] = floor(($param['energy'] * 0.65)/4);

        return $param;
    }

    // ログインユーザーの目標値($target)とレシピの合計($sum)からアラートを作る
    public function alert($target, $sum){
        if($target['carbohydrate_lower'] > $sum['carbohydrate']){
            $alerts[] = "栄養バランス：炭水化物が少ないです。";
        }
        if($target['carbohydrate_upper'] < $sum['carbohydrate']){
            $alerts[] = "栄養バランス：炭水化物が多いです！";
        }
        if($target['protain_lower'] > $sum['protain']){
            $alerts[] = "栄養バランス：タンパク質が少ないです！";
        }
        if($target['protain_upper'] < $sum['protain']){
            $alerts[] = "栄養バランス：タンパク質が多いです！";
        }
        if($target['fat_lower'] > $sum['fat']){
            $alerts[] = "栄養バランス：脂質が少ないです！";
        }
        if($target['fat_upper'] < $sum['fat']){
            $alerts[] = "栄養バランス：脂質が多いです！";
        }
        if(!empty($alerts)){
            $alerts[] = "バランスの良い食事を心がけましょう！";
        }else {
            $alerts[] = "バランスの良い食事です！";
        }
        return $alerts;
    }

    public function alertRecord($target, $sum){
        $user = Auth::user();
        if($user->gender == 1){
            $minimum_protain = 20;
        }else {
            $minimum_protain = 20;
        }
        if($minimum_protain > $sum['protain']){
            $alerts[] = "最低量：最低限ひつようタンパク質(" . $minimum_protain . ")を下回っています。";
        }
        if($target['carbohydrate_lower'] > $sum['carbohydrate']){
            $alerts[] = "栄養バランス：炭水化物が少ないです。";
        }
        if($target['carbohydrate_upper'] < $sum['carbohydrate']){
            $alerts[] = "栄養バランス：炭水化物が多いです！";
        }
        if($target['protain_lower'] > $sum['protain']){
            $alerts[] = "栄養バランス：タンパク質が少ないです！";
        }
        if($target['protain_upper'] < $sum['protain']){
            $alerts[] = "栄養バランス：タンパク質が多いです！";
        }
        if($target['fat_lower'] > $sum['fat']){
            $alerts[] = "栄養バランス：脂質が少ないです！";
        }
        if($target['fat_upper'] < $sum['fat']){
            $alerts[] = "栄養バランス：脂質が多いです！";
        }
        if(!empty($alerts)){
            $alerts[] = "バランスの良い食事を心がけましょう！";
        }else {
            $alerts[] = "バランスの良い食事です！";
        }
        return $alerts;
    }

}
