<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Common;
use App\Models\Product;
use App\Models\Order;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{

    public function index()
    {
        return view('backend.product.index');
    }

    public function save(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Products added successfully';
            DB::beginTransaction();
            $result = Product::saveData($post);
            if (!$result) {
                throw new Exception('Could not save record', 1);
            }
            DB::commit();
        } catch (ValidationException $e) {
            $type = 'error';
            $message = $e->getMessage();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            // $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Product::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['name'] = $row->name;
                $array[$i]['category'] = $row->category_name->name;
                $array[$i]['size'] = $row->size;
                $array[$i]['description'] = $row->description;
                $array[$i]['color'] = $row->color;
                $array[$i]['price'] = $row->price;
                $array[$i]['material'] = $row->material;
                $array[$i]['stock_quantity'] = $row->stock_quantity;
                $array[$i]['sold_qty'] = $row->orderDetails->sum('qty');
                $array[$i]['available_qty'] = $row->stock_quantity - $row->orderDetails->sum('qty');
                $image = asset('images/no-image.jpg');
                if (!empty($row->image) && file_exists(public_path('/storage/product/' . $row->image))) {
                    $image = asset("storage/product/" . $row->image);
                }
                $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
                $action = '';
                $action .= '<span style="margin-left: 10px;"></span>';
                $action .= '<a href="javascript:;" class="editNews" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                $action .= '<span style="margin-left: 10px;"></span>';
                $action .= '|';
                $action .= '<span style="margin-left: 10px;"></span>';
                $action .= ' <a href="javascript:;" class="deleteNews" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                $array[$i]['action'] = $action;
                $i++;
            }
            if (!$filtereddata)
                $filtereddata = 0;
            if (!$totalrecs)
                $totalrecs = 0;
        } catch (QueryException $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        } catch (Exception $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        }
        return response()->json(['recordsFiltered' => $filtereddata, 'recordsTotal' => $totalrecs, 'data' => $array]);
    }

    public function form(Request $request)
    {
        try {
            $post = $request->all();
            $prevPost = [];
            $category = Category::get();
            if (!empty($post['id'])) {
                $prevPost = Product::where('id', $post['id'])
                    ->first();
                if (!$prevPost) {
                    throw new Exception("Couldn't found details.", 1);
                }
            }
            $data = [
                'prevPost' => $prevPost,
                'category' => $category,
            ];
            if ($prevPost->image) {
                $data['image'] = '<img src="' . asset('/storage/product') . '/' . $prevPost->image . '" class="_image" height="160px" width="160px" alt="' . ' No image"/>';
            } else {
                $data['image'] = '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="' . ' No image"/>';
            }
            $data['type'] = 'success';
            $data['message'] = 'Successfully get data.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.product.form', $data);
    }

    public function delete(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Record deleted successfully';
            $directory = storage_path('app/public/Course');
            $post = $request->all();
            $class = new Product();
            DB::beginTransaction();
            $result = Common::deleteCoureRelation($post, $class, $directory);
            if (!$result) {
                throw new Exception("Couldn't delete record", 1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }



    public function menProducts()
    {
        try {
            $prevPosts = Product::with('category_name')->where('category_id', 1)->get();
            $data = [
                'prevPosts' => $prevPosts,
            ];
            $cart = session('cart.' . auth()->id(), []);
            $totalQuantity = array_sum(array_column($cart, 'quantity'));
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
            // $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return view('frontend.category.men.index', array_merge($data, ['totalQuantity' => $totalQuantity]));
    }

    public function womenProducts()
    {
        try {
            $prevPosts = Product::with('category_name')->where('category_id', 2)->get();
            $data = [
                'prevPosts' => $prevPosts,
            ];
            $cart = session('cart.' . auth()->id(), []);
            $totalQuantity = array_sum(array_column($cart, 'quantity'));

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
            // $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return view('frontend.category.women.index', array_merge($data, ['totalQuantity' => $totalQuantity]));
    }

    public function kidProducts()
    {
        try {
            $cart = session('cart.' . auth()->id(), []);
            $totalQuantity = array_sum(array_column($cart, 'quantity'));
            $prevPosts = Product::with('category_name')->where('category_id', 3)->get();
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
            // $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return view('frontend.category.kid.index', array_merge($data, ['totalQuantity' => $totalQuantity]));
    }

    public function searchProducts(Request $request)
    {
        try {
            $cart = session('cart.' . auth()->id(), []);
            $totalQuantity = array_sum(array_column($cart, 'quantity'));
            $searchTerm = $request->input('search');
            $prevPosts = Product::with('category_name')->where('name', 'LIKE', '%' . $searchTerm . '%')->get();
            $data = [
                'prevPosts' => $prevPosts,
                'searchTerm' => $searchTerm,

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
                ];
            }
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = 'Query Exception: ' . $e->getMessage();
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = 'Error: ' . $e->getMessage();
        }

        return view('frontend.search', array_merge($data, ['totalQuantity' => $totalQuantity]));
    }

    public function productSale()
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
                sold_qty DESC
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

    public function productPrice()
    {
        try {

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
                price DESC
        ");
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
                    'sold_qty' => $prevPost->qty,
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
<<<<<<< HEAD
}
=======
    public function productRating()
    {
        try {

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
                average_rating DESC
        ");

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
                    'rating' => $prevPost->average_rating,
                    'size' => $prevPost->size,
                    'description' => $prevPost->description,
                    'color' => $prevPost->color,
                    'price' => $prevPost->price,
                    'material' => $prevPost->material,
                    'stock_quantity' => $prevPost->stock_quantity,
                    'sold_qty' => $prevPost->sold_qty,
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

        return view('frontend.product', array_merge($data, ['totalQuantity' => $totalQuantity]));
    }
}
>>>>>>> 02b81abbed359ec47be5d10aa2c19dff09eaae9b
