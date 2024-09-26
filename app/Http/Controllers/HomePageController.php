<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
    public function product()
    {
        return view('frontend.product');
    }
    public function productDetails()
    {
        return view('frontend.productDetails');
    }
    public function cart()
    {
        return view('frontend.cart');
    }
    public function signup()
    {
        return view('frontend.signup');
    }
    public function login()
    {
        return view('frontend.login');
    }
}
