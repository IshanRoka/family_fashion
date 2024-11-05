<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Common;
use App\Models\QA;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HomePageController extends Controller
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'category_id',
        'color',
        'size',
        'material',
        'stock_quantity',
        'rating',
        'sold_qty',
        'review',
    ];
    public function index(Request $request)
    {
        try {
            $cart = session('cart.' . auth()->id(), []);
            $totalQuantity = array_sum(array_column($cart, 'quantity'));

            $prevPosts = Category::get();
            $products  = Product::with('category_name', 'orderDetails')->get();
            $data = [
                'prevPosts' => $prevPosts,
                'products' => $products
            ];
            // dd('yes');

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
                    'averageRating' => $product->orderDetails->avg('rating'),
                    'name' => $product->name,
                    'category' => $product->category_name->name,
                    'sold_qty' => $product->orderDetails->sum('qty'),
                    'size' => $product->size,
                    'description' => $product->description,
                    'color' => $product->color,
                    'price' => $product->price,
                    'material' => $product->material,
                    'stock_quantity' => $product->stock_quantity,
                ];
            }
            $data['type'] = 'success';
            $data['message'] = 'Successfully retrieved data.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return view('frontend.index', array_merge($data, ['totalQuantity' => $totalQuantity]));
    }

    public function product(Request $request)
    {
        // try {

        $cart = session('cart.' . auth()->id(), []);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        $prevPosts = DB::select("
            SELECT 
                products.id,
                products.name,
                products.description,
                products.price,
                products.stock_quantity,
                products.size,
                products.color,
                products.material,
                products.image,
                COALESCE(AVG(orders.rating), 0) AS average_rating,
                                COALESCE(SUM(orders.qty), 0) AS sold_qty,
                categories.name AS category_name 
            FROM 
                products 
            LEFT JOIN 
                orders ON products.id = orders.product_id 
            JOIN 
                categories ON products.category_id = categories.id
            GROUP BY 
                products.id, 
                products.name,
                products.description,
                products.price,
                products.stock_quantity,
                products.size,
                products.color,
                products.material,
                products.image,
                categories.name
            ORDER BY 
                products.created_at DESC
        ");
        // dd($prevPosts);
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
                'category' => $prevPost->category_name,
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
        // } catch (QueryException $e) {
        //     $data['type'] = 'error';
        //     $data['message'] = $this->queryMessage;
        // } catch (Exception $e) {
        //     $data['type'] = 'error';
        //     $data['message'] = $e->getMessage();
        // }

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
    {
        // try {
        $cart = session('cart.' . auth()->id(), []);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        $product =  Product::with('category_name', 'orderDetails')
            ->selectRaw("(SELECT COUNT(*) FROM products) 
    AS totalrecs, id, name, description, image,price, category_id,color,size,material,stock_quantity")->findOrFail($id);


        $question = QA::with('adminDetails', 'userDetails', 'productDetails')
            ->selectRaw("id, user_id, product_id,admin_id, answer, question, 
         (SELECT COUNT(*) FROM q_a_s WHERE product_id = ?) AS totalrecs", [$id])
            ->where('product_id', $id)
            ->get();

        $order = DB::select("
    SELECT 
        products.id,
        products.name,
        products.description,
        products.price,
        products.stock_quantity,
        products.size,
        products.color,
        products.material,
        products.image,
        orders.rating,
        orders.review AS review,
        categories.name AS category_name,
        users.username,
        GROUP_CONCAT(orders.created_at SEPARATOR ', ') AS order_dates
    FROM 
        products 
    LEFT JOIN 
        orders ON products.id = orders.product_id 
    JOIN 
        categories ON products.category_id = categories.id 
    JOIN 
        users ON orders.user_id = users.id 
    WHERE 
        products.id = ? 
    GROUP BY 
        products.id, 
        products.name,
        products.description,
        products.price,
        products.stock_quantity,
        products.size,
        products.color,
        products.material,
        products.image,
        orders.rating,
        categories.name,
        users.username,
        orders.review
", [$id]);


        $averageRatingData = DB::select("
SELECT 
    COALESCE(AVG(orders.rating), 0) AS avg_rating, 
    COALESCE(COUNT(orders.rating), 0) AS total_rating
FROM 
    products 
LEFT JOIN 
    orders ON products.id = orders.product_id 
WHERE 
    products.id = ? 
", [$id]);


        $averageRating = !empty($averageRatingData) ? $averageRatingData[0] : (object)['avg_rating' => 0, 'total_rating' => 0];

        


        $data = [
            'product' => $product,
            'order' => $order,
            'question' => $question,
            'totalRating' => $averageRating->total_rating,
            'averageRating' => $averageRating->avg_rating,
            'posts' => [],
            'type' => 'success',
            'message' => 'Successfully retrieved data.'
        ];

        // $data['posts'][] = [
        //     'id' => $product->id,
        //     'image' => $product->image
        //         ? '<img src="' . asset('/storage/product/' . $product->image) .
        //         '" class="_image" height="160px" width="160px" alt="No image" />'
        //         : '<img src="' . asset('/no-image.jpg') .
        //         '" class="_image" height="160px" width="160px" alt="No image" />',
        //     'name' => $product->name,
        //     'category' => $product->category_name->name,
        //     'size' => $product->size,
        //     'description' => $product->description,
        //     'color' => $product->color,
        //     'price' => $product->price,
        //     'material' => $product->material,
        //     'stock_quantity' => $product->stock_quantity,
        //     'sold_qty' => $product->orderDetails->sum('qty'),
        //     'available_qty' => $product->stock_quantity - $product->orderDetails->sum('qty'),
        // ];

        // foreach ($order as $order) {
        //     $data['posts'][] = [
        //         'product_name' => $order->name,
        //         'review' => $order->review,
        //         'rating' => $order->rating,
        //         'date' => $order->order_dates,
        //     ];
        //     dd($data);
        // }
        // foreach ($userName as $userName) {
        //     $data['posts'][] = [
        //         'username' => $userName->username,
        //     ];
        // }
        // } catch (QueryException $e) {
        //     $data['type'] = 'error';
        //     $data['message'] = 'Database query error occurred.';
        // } catch (Exception $e) {
        //     $data['type'] = 'error';
        //     $data['message'] = $e->getMessage();
        // }

        return view('frontend.productDetails', array_merge($data, ['totalQuantity' => $totalQuantity]));
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