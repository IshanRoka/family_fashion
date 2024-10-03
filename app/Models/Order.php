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
    public function userDetails()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cartDetails()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
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
            if ($get['columns'][1]['search']['value'])
                $cond .= " and lower(name) like '%" . $get['columns'][1]['search']['value'] . "%'";
            $limit = 15;
            $offset = 0;
            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }
            $query = Order::with('userDetails', 'cartDetails')->selectRaw("(SELECT COUNT(*) FROM orders) AS totalrecs, id,user_id,cart_id,status");
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

    public static function saveData($post)
    {
        try {
            $product = Product::findOrFail($post['user_id']);
            $dataArray = [
                'cart_id' => $post['cart_id'],
                'user_id' => $post['user_id']
            ];
            if (!empty($post['id'])) {
                $cart = Order::find($post['id']);

                if ($cart) {
                    $dataArray['updated_at'] = Carbon::now();
                    if (!Order::where('id', $post['id'])->update($dataArray)) {
                        throw new Exception("Couldn't update Records", 1);
                    }
                } else {
                    $dataArray['created_at'] = Carbon::now();
                    if (!Order::insert($dataArray)) {
                        throw new Exception("Couldn't Save Records", 1);
                    }
                }
            } else {
                $dataArray['created_at'] = Carbon::now();
                if (!Order::insert($dataArray)) {
                    throw new Exception("Couldn't Save Records", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
