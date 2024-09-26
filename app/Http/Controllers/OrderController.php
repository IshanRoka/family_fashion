<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class OrderController extends Controller
{
    public function index()
    {
        return view('backend.order.index');
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
                $array[$i]['user'] = $row->user_id;
                $array[$i]['product'] = $row->product_id;
                $array[$i]['qty'] = $row->qty;
                $array[$i]['total_amount'] = $row->total_amount;
                $array[$i]['order_status'] = $row->order_status;
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="viewPost" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
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

    public function view(Request $request)
    {
        try {
            $post = $request->all();
            $orderDetails = order::where('id', $post['id'])
                ->where('status', 'Y')
                ->first();
            $data = [
                'orderDetails' => $orderDetails,
            ];
            $data['type'] = 'success';
            $data['message'] = 'Successfully fetched data of course.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.order.view', $data);
    }
}
