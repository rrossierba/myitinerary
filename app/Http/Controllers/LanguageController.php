<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request, $language)
    {
        Session::put('language', $language);
        return redirect()->back();
    }
}
