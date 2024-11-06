<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Common;
use App\Models\QA;
use App\Models\Order;
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



    public function productDetails($id)
    {
        try {
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

            $userId = auth()->id();
            $gender = session('gender');

            $targetRatings = Order::where('product_id', $id)
                ->where('user_id', $userId)
                ->pluck('rating')
                ->toArray();

            if (empty($targetRatings)) {
                if ($gender === 'male') {
                    $allProducts = Product::whereIn('category_id', [1, 3])->get();
                } elseif ($gender === 'female') {
                    $allProducts = Product::where('category_id', 2)->get();
                } else {
                    $allProducts = Product::all();
                }

                $data = [
                    'product' => $product,
                    'order' => $order,
                    'question' => $question,
                    'recommendedProducts' => $allProducts,
                    'totalRating' => $averageRating->total_rating,
                    'averageRating' => $averageRating->avg_rating,
                    'posts' => [],
                    'type' => 'success',
                    'message' => 'Successfully retrieved data.'
                ];

                return view('frontend.productDetails', array_merge($data, ['totalQuantity' => $totalQuantity]));
            }


            $allProducts = Product::where('id', '!=', $id)->get();

            $similarities = [];

            // Loop through each product and calculate similarity with the target product
            foreach ($allProducts as $otherProduct) {
                // Get ratings for the other product by the same user
                $otherRatings = Order::where('product_id', $otherProduct->id)
                    ->where('user_id', $userId) // Ensure to get ratings for this user
                    ->pluck('rating')
                    ->toArray();

                if (!empty($targetRatings) && !empty($otherRatings)) {
                    // Calculate the cosine similarity between the target product and the other product
                    $similarity = $this->cosineSimilarity($targetRatings, $otherRatings);
                    $similarities[$otherProduct->id] = $similarity;
                } else {
                    $similarities[$otherProduct->id] = 0;
                }
            }

            // Sort the products by similarity score (descending)
            arsort($similarities);
            // dd($similarities);

            // Get the top 5 recommended products based on similarity
            $recommendedProductsIds = array_slice(array_keys($similarities), 0, 5);
            $recommendedProducts = Product::find($recommendedProductsIds);

            $data = [
                'product' => $product,
                'order' => $order,
                'question' => $question,
                'recommendedProducts' => $recommendedProducts,
                'totalRating' => $averageRating->total_rating,
                'averageRating' => $averageRating->avg_rating,
                'posts' => [],
                'type' => 'success',
                'message' => 'Successfully retrieved data.'
            ];
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = 'Database query error occurred.';
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return view('frontend.productDetails', array_merge($data, ['totalQuantity' => $totalQuantity]));
    }


    private function cosineSimilarity(array $vec1, array $vec2): float
    {
        $dotProduct = array_sum(array_map(fn($a, $b) => $a * $b, $vec1, $vec2));
        $magnitude1 = sqrt(array_sum(array_map(fn($a) => $a * $a, $vec1)));
        $magnitude2 = sqrt(array_sum(array_map(fn($a) => $a * $a, $vec2)));

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        return $dotProduct / ($magnitude1 * $magnitude2);
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
