<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    // public static function saveData($post)
    // {
    //     // try {
    //     $product = Product::findOrFail($post['product_id']);
    //     $re = $post['product_id'];
    //     // dd($re);
    //     $dataArray = [
    //         'user_id' => $post['user_id'],
    //         'product_id' => $post['product_id'],
    //         'qty' => $post['quantity'],
    //         'price' => $product->price * $post['quantity']
    //     ];
    //     if (!empty($post['product_id'])) {
    //         // Check if the record exists in the database

    //         // Assuming $post is an array containing 'product_id'
    //         $cart = Cart::where('product_id', $re)->first();
    //         // dd($carts);

    //         if ($cart) {
    //             // If record exists, update it
    //             $dataArray['updated_at'] = Carbon::now();
    //             if (!Cart::where('product_id', $post['product_id'])->update($dataArray)) {
    //                 throw new Exception("Couldn't update Records", 1);
    //             }
    //         } else {
    //             // If record doesn't exist, insert it
    //             $dataArray['created_at'] = Carbon::now();
    //             if (!Cart::insert($dataArray)) {
    //                 throw new Exception("Couldn't Save Records", 1);
    //             }
    //         }
    //     } else {
    //         // Insert new record if no ID is provided
    //         $dataArray['created_at'] = Carbon::now();
    //         if (!Cart::insert($dataArray)) {
    //             throw new Exception("Couldn't Save Records", 1);
    //         }
    //     }
    //     return true;
    //     // } catch (Exception $e) {
    //     //     throw $e;
    //     // }
    // }

    // public static function list()
    // {
    //     try {
    //         $orderCarts = Order::pluck('cart_id')->toArray();
    //         $availableCarts = Cart::whereNotIn('id', $orderCarts)->get();
    //         $ndata = [];
    //         if ($availableCarts->isNotEmpty()) {
    //             $query = Cart::with('product')
    //                 ->whereNotIn('id', $orderCarts)
    //                 ->select('id', 'product_id', 'user_id', 'qty', 'price')
    //                 ->get();

    //             if ($query) {
    //                 $ndata = $query;
    //             }
    //         }
    //         return $ndata;
    //     } catch (Exception $e) {
    //         throw $e;
    //     }
    // }
  
}
