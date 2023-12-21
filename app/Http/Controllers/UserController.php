<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return "Ai Brasiiiiiiiiil";
    }

    public function store(Request $request){
        var_dump($request->input('name'));
    }
}
