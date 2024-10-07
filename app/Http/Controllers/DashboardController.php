<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;


class DashboardController extends Controller
{
    public function index()
    {
        $totalCategory = Category::count();
        $totalProducts = Product::count();
        $totalUser = User::count();
        $totalOrder = Order::where('status', 'delivered');
        if ($totalOrder) {
            $totalRevenue = Cart::sum('price');
        }
        return view('backend.dashboard.index', compact('totalProducts', 'totalUser', 'totalRevenue', 'totalCategory'));
    }

    // public function record()
    // {

    // }
}