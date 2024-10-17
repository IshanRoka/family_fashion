<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use App\Models\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Product;
use App\Models\Rating;

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
            if (!auth()->check()) {
                return response()->json([
                    'message' => 'User not authenticated.',
                ], 401);
            }
            $product_id = $request->input('product_id');
            $cart = session()->get('cart.' . auth()->id(), []);

            if (isset($cart[$product_id])) {
                unset($cart[$product_id]);
                session()->put('cart.' . auth()->id(), $cart);
            }
            $post = $request->all();
            DB::beginTransaction();
            $result = Order::saveData($post);
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
                $array[$i]['qty'] = $row->qty;
                $array[$i]['price'] = $row->total_price;
                $array[$i]['size'] = $row->productDetails->size;
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


    public function listProduct(Request $request)
    {
        // try {
        $post = $request->all();
        $data = Product::listProduct($post);
        $i = 0;
        $array = [];
        $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
        $totalrecs = $data['totalrecs'];
        unset($data['totalfilteredrecs']);
        unset($data['totalrecs']);
        foreach ($data as $row) {
            $array[$i]['sno'] = $i + 1;
            $array[$i]['name'] = $row->name;
            $array[$i]['category'] = $row->category_name->name;
            $array[$i]['size'] = $row->size;
            $array[$i]['description'] = $row->description;
            $array[$i]['color'] = $row->color;
            $array[$i]['price'] = $row->price;
            $array[$i]['material'] = $row->material;
            $array[$i]['stock_quantity'] = $row->stock_quantity;
            $image = asset('images/no-image.jpg');

            // $array[$i]['price'] = $row->order_details->qty;
            // dd($row->order_details->qty);
            if (!empty($row->image) && file_exists(public_path('/storage/product/' . $row->image))) {
                $image = asset("storage/product/" . $row->image);
            }
            $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
            $action = '';
            if (!empty($post['type']) && $post['type'] != 'trashed') {
                $action .= ' <a href="javascript:;" class="viewPost" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                $action .= '<span style="margin-left: 10px;"></span>';
                $action .= '|';
                $action .= '<span style="margin-left: 10px;"></span>';
                $action .= '<a href="javascript:;" class="editNews" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                $action .= '<span style="margin-left: 10px;"></span>';
                $action .= '|';
                $action .= '<span style="margin-left: 10px;"></span>';
            } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> ';
                $action .= '<span style="margin-left: 10px;"></span>';
                $action .= '|';
                $action .= '<span style="margin-left: 10px;"></span>';
            }
            $action .= ' <a href="javascript:;" class="deleteNews" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
            $array[$i]['action'] = $action;
            $i++;
        }
        if (!$filtereddata)
            $filtereddata = 0;
        if (!$totalrecs)
            $totalrecs = 0;
        // } catch (QueryException $e) {
        //     $array = [];
        //     $totalrecs = 0;
        //     $filtereddata = 0;
        // } catch (Exception $e) {
        //     $array = [];
        //     $totalrecs = 0;
        //     $filtereddata = 0;
        // }
        return response()->json(['recordsFiltered' => $filtereddata, 'recordsTotal' => $totalrecs, 'data' => $array]);
    }

    public function history(Request $request)
    {
        // try {
        // Get all request data (ensure you're using it correctly)
        $post = $request->all();

        // Query orders with related data
        $historyDetails = Order::with('userDetails', 'productDetails')
            ->selectRaw("(SELECT COUNT(*) FROM orders) AS totalrecs, id, user_id, product_id, total_price, qty, status,rating")
            ->get();

        $data = [
            'historyDetails' => $historyDetails,
        ];

        $data['type'] = 'success';
        $data['message'] = 'Successfully fetched data of Order.';
        // } catch (QueryException $e) {
        //     $data['type'] = 'error';
        //     // $data['message'] = $this->queryMessage;
        // } catch (Exception $e) {
        //     $data['type'] = 'error';
        //     $data['message'] = $e->getMessage();
        // }
        return view('frontend.orderHistory', $data);
    }

    public function cancel(Request $request)
    {
        try {
            $post = $request->all();
            DB::beginTransaction();
            $cancel = Order::cancelOrder($post);
            if (!$cancel) {
                throw new Exception('Could not save record', 1);
            }
            DB::commit();
        } catch (QueryException $e) {
            $data['type'] = 'error';
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return response()->json(['success' => true, 'message' => 'Order cancelled successfully.']);
    }
}
