<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
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
        return redirect()->back()->with('success', 'Product added to cart!');
        // return response()->json(['type' => $type, 'message' => $message]);
    }

    public function listAddtocart(Request $request)
    {
        try {
            $post = $request->all();
            $data = Cart::list($post);
            $i = 0;
            $array = [];
            foreach ($data as $row) {
                $array[$i]['product_name'] = $row->product->name;
                $array[$i]['product_id'] = $row->product_id;
                $array[$i]['price'] = $row->price;
                $array[$i]['id'] = $row->id;
                $array[$i]['qty'] = $row->qty;
                $image = asset('images/no-image.jpg');
                if (!empty($row->product->image) && file_exists(public_path('/storage/product/' . $row->product->image))) {
                    $image = asset("storage/product/" . $row->product->image);
                }
                $array[$i]["image"] = $image;
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
