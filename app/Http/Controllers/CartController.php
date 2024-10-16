<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'User not authenticated.',
            ], 401);
        }

        // Get the user's current cart from the session
        $cart = session()->get('cart.' . auth()->id(), []);

        // Retrieve product information from the request
        $product_id = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

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

        // Update the cart in the session
        session()->put('cart.' . auth()->id(), $cart);

        // Calculate the total quantity after updating the cart
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => $cart,
            'totalQuantity' => $totalQuantity,
        ]);
    }


    public function showCart()
    {
        try {
            $cart = session('cart.' . auth()->id(), []);

            $totalQuantity = array_sum(array_column($cart, 'quantity'));

            foreach ($cart as $id => &$details) {
                $quantity = $details['quantity'] ?? 0;
                $availableQty = $details['available_qty'] ?? 0;

                if ($quantity > $availableQty) {
                    $details['quantity'] = $availableQty;
                }
            }

            session()->put('cart.' . auth()->id(), $cart);

            $data = [];

            return view('frontend.cart', compact('cart'))->with('totalQuantity', $totalQuantity);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function removeFromCart(Request $request)
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

        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'message' => 'Product removed from cart successfully!',
            'cart' => $cart,
            'totalQuantity' => $totalQuantity,
        ]);
    }
}
