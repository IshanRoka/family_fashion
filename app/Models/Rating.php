<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;

class Rating extends Model
{
    use HasFactory;

    public function productDetails()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function orderDetails()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public static function saveData($post)
    {
        try {
            $dataArray = [
                'rating' => $post['rating'],
            ];
            if (!empty($post['id'])) {
                $dataArray['updated_at'] = Carbon::now();
                if (!Order::where('id', $post['id'])->update($dataArray)) {
                    throw new Exception("Couldn't update Products", 1);
                }
            } else {
                $dataArray['created_at'] = Carbon::now();
                if (!Order::insert($dataArray)) {
                    throw new Exception("Couldn't Save Products", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
