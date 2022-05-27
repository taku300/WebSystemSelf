<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateUser;

class RegisterController extends Controller
{
    public function userEdit() {
        $user = Auth::user();
        return view('Auth/register_edit', [
            'user' => $user,
        ]);
    }

    public function createUserEdit(CreateUser $request) {
        $user = Auth::user();
        $columns = ['name', 'gender', 'birthday', 'height', 'weight', 'exercise_level'];
        foreach($columns as $column){
            $user->$column = $request->$column;
        }
        $user->save();

        return redirect('/');

    }

    public function selection() {
        return view('register/register');
    }
    
    public function addFood() {

    }

    public function removeFood() {

    }

    public function register() {

    }

    public function createRegister() {

    }

    public function foodSearch() {

    }
}

