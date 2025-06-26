<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage($language)
    {
        Session::put('language', $language);
        return redirect()->back();
    }
}
