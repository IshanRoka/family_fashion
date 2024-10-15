<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Get the cart from the session or create an empty one
        $cart = session()->get('cart', []);

        // Check if product is already in the cart
        if (isset($cart[$product_id])) {
            // If the product exists, update the quantity
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            // Add new product to the cart
            $cart[$product_id] = [
                "product_id" => $product_id,
                "name" => $request->input('product_name'),
                "price" => $request->input('product_price'),
                "quantity" => $quantity,
            ];
        }

        // Update the session with the new cart
        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => $cart
        ]);
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart', compact('cart'));
    }

    public function removeFromCart(Request $request)
    {
        $product_id = $request->input('product_id');

        // Get the cart from session
        $cart = session()->get('cart', []);

        // Remove the product from the cart
        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'message' => 'Product removed from cart successfully!',
            'cart' => $cart
        ]);
    }
}
