<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\BackPanel\Program;
use App\Models\Common;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';
            DB::beginTransaction();
            $result = Cart::saveData($post);
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
            //$message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return view('frontend.cart');
        // return response()->json(['type' => $type, 'message' => $message]);
    }

    public function addTocart() {}

    public function listAddtocart(Request $request)
    {
        try {
            $data = DB::select('SELECT * FROM Carts');
            // $total = DB::select('SELECT SUM(price) from Carts');
            $i = 0;
            $array = [];

            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['product_name'] = $row->product_name;
                $array[$i]['price'] = $row->price;
                $array[$i]['qty'] = $row->qty;
                $array[$i]['size'] = $row->size;
                $array[$i]['id'] = $row->id;
                $image = asset('images/no-image.jpg');
                if (!empty($row->image) && file_exists(public_path('/storage/product/' . $row->image))) {
                    $image = asset("storage/product/" . $row->image);
                }
                $array[$i]["image"] = $image;
                // $array[$i]["totalPrice"] = $total;
                $i++;
            }
        } catch (QueryException $e) {
            $array = [];
        } catch (Exception $e) {
            $array = [];
        }
        return view('frontend.cart', ['cartItems' => $array]);
    }
}
