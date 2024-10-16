<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
                "available_qty" => $request->input('available_qty'),
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
        foreach ($cart as $id => &$details) {
            $quantity = $details['quantity'] ?? 0;
            $availableQty = $details['available_qty'] ?? 0;

            if ($quantity > $availableQty) {
                $details['quantity'] = $availableQty;
            }
        }
        session()->put('cart.' . auth()->id(), $cart);
        return view('frontend.cart', compact('cart'));
    }


    public function removefromCart(Request $request)
    {
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
