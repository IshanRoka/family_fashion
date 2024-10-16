<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Common;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HomePageController extends Controller
{
    public function index(Request $request)
    {
        try {
            $prevPosts = Category::get();
            $products = Product::take(6)->get();

            $data = [
                'prevPosts' => $prevPosts,
                'products' => $products
            ];

            foreach ($prevPosts as $prevPost) {
                $data['posts'][] = [
                    'id' => $prevPost->id,
                    'image' => $prevPost->image
                        ? '<img src="' . asset('/storage/category/' . $prevPost->image) . '" class="_image" height="160px" width="160px" alt="No image" />'
                        : '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="No image" />',
                    'name' => $prevPost->name
                ];
            }

            foreach ($products as $product) {
                $data['posts'][] = [
                    'id' => $product->id,
                    'image' => $product->image
                        ? '<img src="' . asset('/storage/product/' . $product->image) . '" class="_image" height="160px" width="160px" alt="No image" />'
                        : '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="No image" />',
                    'name' => $product->name,
                    'category' => $product->category_name->name,
                    'size' => $product->size,
                    'description' => $product->description,
                    'color' => $product->color,
                    'price' => $product->price,
                    'material' => $product->material,
                    'stock_quantity' => $product->stock_quantity
                ];
            }

            $data['type'] = 'success';
            $data['message'] = 'Successfully retrieved data.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            // $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return view('frontend.index', $data);
    }

    public function product(Request $request)
    {
        try {
            $prevPosts = Product::with('category_name', 'orderDetails')->get();
            $data = [
                'prevPosts' => $prevPosts,
            ];
            foreach ($prevPosts as $prevPost) {
                $data['posts'][] = [
                    'id' => $prevPost->id,
                    'image' => $prevPost->image
                        ? '<img src="' . asset('/storage/product/' . $prevPost->image) . '" class="_image" height="160px" width="160px" alt="No image" />'
                        : '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="No image" />',
                    'name' => $prevPost->name,
                    'category' => $prevPost->category_name->name,
                    'size' => $prevPost->size,
                    'description' => $prevPost->description,
                    'color' => $prevPost->color,
                    'price' => $prevPost->price,
                    'material' => $prevPost->material,
                    'stock_quantity' => $prevPost->stock_quantity,
                    'sold_qty' => $prevPost->orderDetails->sum('qty'),
                    'available_qty' => $prevPost->stock_quantity - $prevPost->orderDetails->sum('qty'),
                ];
            }
            $data['type'] = 'success';
            $data['message'] = 'Successfully retrieved data.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return view('frontend.product', $data);
    }

    public function productDetails($id)
    {
        try {
            $product = Product::with('category_name', 'orderDetails')->findOrFail($id);

            $data = [
                'product' => $product,
            ];

            $data['posts'][] = [
                'id' => $product->id,
                'image' => $product->image
                    ? '<img src="' . asset('/storage/product/' . $product->image) . '" class="_image" height="160px" width="160px" alt="No image" />'
                    : '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="No image" />',
                'name' => $product->name,
                'category' => $product->category_name->name,
                'size' => $product->size,
                'description' => $product->description,
                'color' => $product->color,
                'price' => $product->price,
                'material' => $product->material,
                'stock_quantity' => $product->stock_quantity,
                'sold_qty' => $product->orderDetails->sum('qty'),
                'available_qty' => $product->stock_quantity - $product->orderDetails->sum('qty'),
            ];
            $data['type'] = 'success';
            $data['message'] = 'Successfully retrieved data.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return view('frontend.productDetails', $data);
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

    public function userdetails()
    {
        return view('frontend.userdetails');
    }
}
