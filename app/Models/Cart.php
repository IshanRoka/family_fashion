<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;

class Cart extends Model
{
    use HasFactory;
    public static function saveData($post)
    {
        try {
            $product = Product::findOrFail($post['id']);
            $new = $product->name;
            // dd($product);
            $dataArray = [
                'product_name' => $product->name,
                'qty' => $post['quantity'],
                'size' => $product->size,
                'image' => $product->image,
                'price' => $product->price * $post['quantity']
            ];
            if (!empty($post['id'])) {
                // Check if the record exists in the database
                $cart = Cart::find($post['id']);

                if ($cart) {
                    // If record exists, update it
                    $dataArray['updated_at'] = Carbon::now();
                    if (!Cart::where('id', $post['id'])->update($dataArray)) {
                        throw new Exception("Couldn't update Records", 1);
                    }
                } else {
                    // If record doesn't exist, insert it
                    $dataArray['created_at'] = Carbon::now();
                    if (!Cart::insert($dataArray)) {
                        throw new Exception("Couldn't Save Records", 1);
                    }
                }
            } else {
                // Insert new record if no ID is provided
                $dataArray['created_at'] = Carbon::now();
                if (!Cart::insert($dataArray)) {
                    throw new Exception("Couldn't Save Records", 1);
                }
            }

            // dd('yes');
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
