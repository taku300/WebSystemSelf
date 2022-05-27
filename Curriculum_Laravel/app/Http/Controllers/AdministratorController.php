<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function administrator() {
        return view('administrator/ad_home');
    }

    public function food() {
        return view('administrator/create_food');
    }

    public function createFood() {

    }

    public function foodEdit() {

    }

    public function createfoodEdit() {

    }

    public function foodDestory() {

    }
}
