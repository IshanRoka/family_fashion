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
            $query = Product::with('category_name')->selectRaw("(SELECT COUNT(*) FROM products) AS totalrecs, id, name, description, image,price, category_id,color,size,material,stock_quantity");

            $prevPosts = Category::where('status', 'Y')->get();
            $products = Product::where('status', 'Y')->take(6)->get();

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
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return view('frontend.index', $data);
    }

    public function product(Request $request)
    {
        try {
            // Fetch products with status 'Y'
            $prevPosts = Product::with('category_name')->where('status', 'Y')->get();
            $data = [
                'prevPosts' => $prevPosts,
            ];
            $query = Product::with('category_name')->selectRaw("(SELECT COUNT(*) FROM products) AS totalrecs, id, name, description, image,price, category_id,color,size,material,stock_quantity");

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

    // Method for displaying product details
    public function productDetails($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Return a view with the product data
        return view('frontend.productDetails', compact('product'));
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
    public function logincheck() {}

    public function userdetails()
    {
        return view('frontend.userdetails');
    }
}