<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use App\Models\User;
use App\Models\Cart;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'cart_id',
        'total_price',
        'qty',
        'status', // If you want to allow mass assignment for the status as well
    ];
    public function userDetails()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cartDetails()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function productDetails()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function ratingDetails()
    {
        return $this->hasOne(Rating::class, 'order_id');  // Ensure correct foreign key
    }

    public static function list($post)
    {
        try {
            $get = $post;
            $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : 'asc';
            $orderby = " order_number " . $sorting . "";
            if (!empty($get['order'][0]['column']) && $get['order'][0]['column'] == 6) {
                $orderby = " order_number " . $sorting . "";
            }
            foreach ($get['columns'] as $key => $value) {
                $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }
            $limit = 15;
            $offset = 0;
            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }
            $query = Order::with('userDetails', 'productDetails')->selectRaw("(SELECT COUNT(*) FROM orders) AS totalrecs, id,user_id,product_id,status,total_price,qty");

            if ($limit > -1) {
                $result = $query->offset($offset)->limit($limit)->get();
            } else {
                $result = $query->get();
            }
            if ($result) {
                $ndata = $result;
                $ndata['totalrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
                $ndata['totalfilteredrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
            } else {
                $ndata = array();
            }
            return $ndata;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function saveBulk($post, $selectedProducts)
    {
        try {
            $cart = session()->get('cart.' . auth()->id(), []);
            foreach ($selectedProducts as $productId) {
                $product = $cart[$productId] ?? null;
                if ($product) {
                    $dataArray = [
                        'user_id' => auth()->id(),
                        'product_id'  => $productId,
                        'total_price' => (float) str_replace(['Rs', ',', ' '], '', $post['total_price']),
                        'qty' => (int) $post['quantity'],
                    ];
                    $dataArray['created_at'] = Carbon::now();
                    if (!Order::insert($dataArray)) {
                        throw new Exception("Couldn't Save Records", 1);
                    }
                    // foreach ($selectedProducts as $productId) {
                    unset($cart[$productId]);
                    // }
                    session()->put('cart.' . auth()->id(), $cart);
                }
            }
            session()->put('cart.' . auth()->id(), $cart);

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public static function saveData($post)
    {
        try {
            $dataArray = [
                'user_id' => $post['user_id'],
                'product_id' => $post['product_id'],
                'total_price' => (float) str_replace(['Rs', ',', ' '], '', $post['total_price']),
                'qty' => (int) $post['qty'],
            ];
            $dataArray['created_at'] = Carbon::now();
            if (!Order::insert($dataArray)) {
                throw new Exception("Couldn't Save Records", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function cancelOrder($post)
    {
        try {
            $id = $post['id'];

            $order = Order::find($id);

            if ($order) {
                $order->delete();

                return true;
            } else {
                throw new Exception("Order not found.");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
