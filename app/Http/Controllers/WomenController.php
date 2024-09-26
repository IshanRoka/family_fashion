<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WomenController extends Controller
{
    public  function women()
    {
        return view('frontend.category.women.index');
    }
}
