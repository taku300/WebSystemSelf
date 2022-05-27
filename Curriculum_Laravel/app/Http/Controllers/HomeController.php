<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
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
            $param['carbohydrate_lower'] = floor($param['energy'] * 0.14);
            }else{
            $param['carbohydrate_lower'] = floor($param['energy'] * 0.13);
            }
            $param['carbohydrate_upper'] = floor($param['energy'] * 0.2);
            $param['protain_lower'] = floor($param['energy'] * 0.2);
            $param['protain_upper'] = floor($param['energy'] * 0.3);
            $param['fat_lower'] = floor($param['energy'] * 0.5);
            $param['fat_upper'] = floor($param['energy'] * 0.65);
    
            return $param;
        }

        $user = Auth::user();
        $param = calculation($user);

        return view('home/home', [
            'user' => $user,
            'param' => $param,
        ]);
    }

}
