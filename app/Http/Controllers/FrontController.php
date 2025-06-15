<?php

namespace App\Http\Controllers;

class FrontController extends Controller
{
    public function home(){
        return view('index');
    }
}
