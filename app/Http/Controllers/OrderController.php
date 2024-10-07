<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use App\Models\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        return view('frontend.cart');
    }

    public function orderDetails()
    {
        return view('backend.order.index');
    }

    public function save(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';
            DB::beginTransaction();
            $result = Order::saveData($post);
            // dd($result);
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
        return view('frontend.orderConfirm');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:orders,id',
            'status' => 'required|string|in:ordered,on_delivery,delivered',
        ]);
        $order = Order::find($request->id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Status updated successfully']);
    }


    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Order::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['customerName'] = $row->userDetails->username;
                $array[$i]['customerEmail'] = $row->userDetails->email;
                $array[$i]['productName'] = $row->productDetails->name;
                $array[$i]['qty'] = $row->cartDetails->qty;
                $array[$i]['price'] = $row->cartDetails->price;
                $array[$i]['size'] = $row->cartDetails->size;
                $array[$i]['status'] = $row->status;
                $image = asset('images/no-image.jpg');
                if (!empty($row->productDetails->image) && file_exists(public_path('/storage/product/' . $row->productDetails->image))) {
                    $image = asset("storage/product/" . $row->productDetails->image);
                }
                $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action = '<select class="status-select" data-id="' . $row->id . '">';

                    if ($row->status === 'delivered') {
                        $action .= '<option value="delivered" selected>Delivered</option>';
                    } else {
                        $action .= '<option value="ordered" ' . ($row->status === 'ordered' ? 'selected' : '') . '>Ordered</option>';
                        $action .= '<option value="on_delivery" ' . ($row->status === 'on_delivery' ? 'selected' : '') . '>On Delivery</option>';
                        $action .= '<option value="delivered" ' . ($row->status === 'delivered' ? 'selected' : '') . '>Delivered</option>';
                    }

                    $action .= '</select>';
                }

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

    public function addTocart(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';
            if (!empty($post['id'])) {
                $message = 'Records updated successfully';
            }
            DB::beginTransaction();
            $result = Order::saveOrder($post);
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
            $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }
}
