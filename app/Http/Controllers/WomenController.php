<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
use Illuminate\Database\QueryException;

class WomenController extends Controller
{
    public  function index()
    {
        try {
            $prevPosts = Product::with('category_name')->where('status', 'Y')->where('category_id', 2)->get();
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

        return view('frontend.category.men.index', $data);
    }
}