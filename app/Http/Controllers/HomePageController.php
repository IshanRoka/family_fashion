<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Common;
use App\Models\Order;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HomePageController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cart = session('cart.' . auth()->id(), []);
            $totalQuantity = array_sum(array_column($cart, 'quantity'));

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

        return view('frontend.index', array_merge($data, ['totalQuantity' => $totalQuantity]));
    }

    public function product(Request $request)
    {
        try {

            $cart = session('cart.' . auth()->id(), []);
            $totalQuantity = array_sum(array_column($cart, 'quantity'));

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

        return view('frontend.product', array_merge($data, ['totalQuantity' => $totalQuantity]));
    }

    // public function productDetails($id)
    // {
    //     try {
    //         $cart = session('cart.' . auth()->id(), []);
    //         $totalQuantity = array_sum(array_column($cart, 'quantity'));
    //         $product = Product::with('category_name', 'orderDetails')->findOrFail($id);

    //         // $targetRatings = Order::where('product_id', $id)->get();
    //         // $allProducts = Product::where('id', '!=', $id)->get();
    //         // dd($allProducts);

    //         $data = [
    //             'product' => $product,
    //         ];

    //         $data['posts'][] = [
    //             'id' => $product->id,
    //             'image' => $product->image
    //                 ? '<img src="' . asset('/storage/product/' . $product->image) . '" class="_image" height="160px" width="160px" alt="No image" />'
    //                 : '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="No image" />',
    //             'name' => $product->name,
    //             'category' => $product->category_name->name,
    //             'size' => $product->size,
    //             'description' => $product->description,
    //             'color' => $product->color,
    //             'price' => $product->price,
    //             'material' => $product->material,
    //             'stock_quantity' => $product->stock_quantity,
    //             'sold_qty' => $product->orderDetails->sum('qty'),
    //             'available_qty' => $product->stock_quantity - $product->orderDetails->sum('qty'),
    //         ];
    //         $data['type'] = 'success';
    //         $data['message'] = 'Successfully retrieved data.';
    //     } catch (QueryException $e) {
    //         $data['type'] = 'error';
    //         $data['message'] = $this->queryMessage;
    //     } catch (Exception $e) {
    //         $data['type'] = 'error';
    //         $data['message'] = $e->getMessage();
    //     }

    //     return view('frontend.productDetails', array_merge($data, ['totalQuantity' => $totalQuantity]));
    // }
    public function productDetails($id)
    { {
            try {
                $cart = session('cart.' . auth()->id(), []);
                $totalQuantity = array_sum(array_column($cart, 'quantity'));
                $userid = auth()->id();
                $product = Product::with('category_name', 'orderDetails')->findOrFail($id);

                $targetRatings = Order::where('product_id', $id)->get('rating');

                $allProducts = Product::where('id', '!=', $id)->get();
                $similarities = [];

                foreach ($allProducts as $otherProduct) {
                    $otherRatings = Order::where('product_id', $otherProduct->id)->get('rating');

                    if ($targetRatings->isNotEmpty() && $otherRatings->isNotEmpty()) {
                        $similarity = $this->cosineSimilarity($targetRatings, $otherRatings);
                        $similarities[$otherProduct->id] = $similarity;
                    } else {
                        $similarities[$otherProduct->id] = 0;
                    }
                }

                arsort($similarities);
                $recommendedProductsIds = array_slice(array_keys($similarities), 0, 5);
                $recommendedProducts = Product::find($recommendedProductsIds);
                $data = [
                    'product' => $product,
                    'recommendedProducts' => $recommendedProducts,
                    'posts' => [],
                ];

                foreach ($recommendedProducts as $recommendedProduct) {
                    $data['posts'][] = [
                        'id' => $recommendedProduct->id,
                        'image' => $recommendedProduct->image
                            ? '<img src="' . asset('/storage/product/' . $recommendedProduct->image) . '" class="_image" height="160px" width="160px" alt="No image" />'
                            : '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="No image" />',
                        'name' => $recommendedProduct->name,
                        'category' => $recommendedProduct->category_name->name,
                        'size' => $recommendedProduct->size,
                        'description' => $recommendedProduct->description,
                        'color' => $recommendedProduct->color,
                        'price' => $recommendedProduct->price,
                        'material' => $recommendedProduct->material,
                        'stock_quantity' => $recommendedProduct->stock_quantity,
                    ];
                }

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

            return view('frontend.productDetails', array_merge($data, ['totalQuantity' => $totalQuantity]));
        }
    }

    private function cosineSimilarity($ratingsA, $ratingsB)
    {
        $dotProduct = $sumA = $sumB = 0;

        $ratingsArrayA = $ratingsA->pluck('rating')->toArray();
        $ratingsArrayB = $ratingsB->pluck('rating')->toArray();

        foreach ($ratingsArrayA as $userId => $ratingA) {
            $ratingB = $ratingsArrayB[$userId] ?? null;
            if ($ratingB !== null) {
                $dotProduct += $ratingA * $ratingB;
                $sumA += pow($ratingA, 2);
                $sumB += pow($ratingB, 2);
            }
        }

        return ($sumA && $sumB) ? $dotProduct / (sqrt($sumA) * sqrt($sumB)) : 0;
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
        $cart = session('cart.' . auth()->id(), []);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        return view('frontend.login', array_merge(['totalQuantity' => $totalQuantity]));
    }

    public function userdetails()
    {
        $cart = session('cart.' . auth()->id(), []);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        return view('frontend.userdetails', array_merge(['totalQuantity' => $totalQuantity]));
    }
}
