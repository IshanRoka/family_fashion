<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use App\Models\User;
use App\Models\Cart;
use Database\Seeders\OrderSeeder;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invoice;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'cart_id',
        'total_price',
        'qty',
        'rating',
        'status',
        'review',
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
        return $this->hasOne(Rating::class, 'order_id');
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

    public static function saveBulk($post)
    {
        // try {

        $cart = session()->get('cart.' . auth()->id(), []);

        $orderDataArray = [];

        if (isset($post['product']) && is_array($post['product'])) {
            foreach ($post['product'] as $productId => $productDetails) {
                $dataArray[] = [
                    'user_id' => auth()->id(),
                    'product_id' => $productId,
                    'qty' => (int) $productDetails['quantity'],
                    'total_price' => (float) str_replace(['Rs', ',', ' '], '', $productDetails['total_price']),
                    'created_at' => Carbon::now(),

                ];
                $product = Product::where('id', $productId,)->first();
                $userDetails = User::where('id', auth()->id())->first();
                $userName = $userDetails->username;
                $productName = $product->name;

                $orderDataArray[] = [
                    'username' => $userName,
                    'product_name' => $productName,
                    'user_id' => auth()->id(),
                    'product_id' => $productId,
                    'qty' => (int) $productDetails['quantity'],
                    'total_price' => (float) str_replace(['Rs', ',', ' '], '', $productDetails['total_price']),
                    'created_at' => Carbon::now(),
                ];

                unset($cart[$productId]);
            }
        }
        if (!Order::insert($dataArray)) {
            throw new Exception("Couldn't save records for products.");
        }
        session()->put('cart.' . auth()->id(), $cart);
        $user = User::find(auth()->id());

        // Mail::to($user->email)->send(new Invoice($orderDataArray));
        return true;
        // } catch (Exception $e) {
        //     throw $e;
        // }
    }
    public static function saveData($post)
    {
        try {
            $dataArray = [ // Remove the [] to define it as a single associative array
                [
                    'user_id' => auth()->id(),
                    'product_id' => $post['product_id'],
                    'qty' => (int) $post['quantity'],
                    'total_price' => (float) str_replace(['Rs', ',', ' '], '', $post['total_price']),
                    'created_at' => Carbon::now(), // Include created_at here
                ]
            ];

            // Insert the data
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
