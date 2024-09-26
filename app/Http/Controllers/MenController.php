<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenController extends Controller
{
    public  function men()
    {
        return view('frontend.category.men.index');
    }
}
