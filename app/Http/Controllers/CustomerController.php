<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class CustomerController extends Controller
{

    public function index()
    {
        return view('backend.customer.index');
    }

    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Customer::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['name'] = $row->name;
                $array[$i]['email'] = $row->email;
                $array[$i]['address'] = $row->address;
                $array[$i]['phone_number'] = $row->phone_number;
                $image = asset('images/no-image.jpg');
                if (!empty($row->image) && file_exists(public_path('/storage/product/' . $row->image))) {
                    $image = asset("storage/product/" . $row->image);
                }
                $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
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
            $customerDetails = Customer::where('id', $post['id'])
                ->where('status', 'Y')
                ->first();
            $data = [
                'customerDetails' => $customerDetails,
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
        return view('backend.customer.view', $data);
    }
}