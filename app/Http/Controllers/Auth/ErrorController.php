<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    public function error403()
    {
        return view('error.error403');
    }

    public function error404()
    {
        return view('error.error404');
    }
}
