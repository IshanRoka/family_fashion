<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KidController extends Controller
{
    public  function kid()
    {
        return view('frontend.category.kid.index');
    }
}
