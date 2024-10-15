<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'User not authenticated.',
            ], 401);
        }
        $product_id = $request->input('product_id');
        $quantity = (int) $request->input('quantity');
        $cart = session()->get('cart.' . auth()->id(), []);

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            $cart[$product_id] = [
                "product_id" => $product_id,
                "name" => $request->input('product_name'),
                "price" => $request->input('product_price'),
                "size" => $request->input('size'),
                "image" => $request->input('image'),
                "quantity" => $quantity,
            ];
        }

        session()->put('cart.' . auth()->id(), $cart);

        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => $cart
        ]);
    }

    public function showCart()
    {
        $cart = session()->get('cart.' . auth()->id(), []);
        return view('frontend.cart', compact('cart'));
    }

    public function removeFromCart(Request $request)
    {
        // dd("yes");
        if (!auth()->check()) {
            return response()->json([
                'message' => 'User not authenticated.',
            ], 401);
        }

        $product_id = $request->input('product_id');

        $cart = session()->get('cart.' . auth()->id(), []);

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart.' . auth()->id(), $cart);
        }

        return response()->json([
            'message' => 'Product removed from cart successfully!',
            'cart' => $cart
        ]);
    }
}
