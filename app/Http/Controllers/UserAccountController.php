<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\UserAccount;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Validator;

class UserAccountController extends Controller
{
    public function signup(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Record saved successfully';
            DB::beginTransaction();
            $result = UserAccount::saveUser($post);
            if (!$result) {
                throw new Exception("Couldn't save records", 1);
            }
            DB::commit();
        } catch (ValidationException $e) {
            $type = 'error';
            $message = $e->errors();
        } catch (QueryException $e) {
            DB::rollback();
            $type = 'error';
            // $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollback();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
        return view('frontend.login');
    }

    public function delete(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = "Record deleted successfully";
            DB::beginTransaction();
            $result = UserAccount::deleteData($post);
            if (!$result) {
                throw new Exception("Could not delete information. Please try again", 1);
            }
            DB::commit();
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

    function loginCheck(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email|min:3|max:50',
                'password' => 'required|max:50',
            ];
            $messages = [
                /* Email validation */
                'email.required' => 'Email field is required',
                'email.email' => 'Email must be a valid email.',
                'email.min' => 'Email must be at least 3 characters long.',
                'email.max' => 'Email should not be greater than 50 characters.',
                /* Password Validation */
                'password.required' => 'Password field is required',
                'password.max' => 'Password should not be greater than 50 characters.',
            ];

            $validate = Validator::make($request->all(), $rules, $messages);
            if ($validate->fails()) {
                throw new Exception($validate->errors()->first(), 1);
            }
            $cart = session('cart.' . auth()->id(), []);
            $totalQuantity = array_sum(array_column($cart, 'quantity'));
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                session(['gender' => $user->gender]);

                return view('frontend.userdetails', array_merge(['totalQuantity' => $totalQuantity]));
                // return response()->json([
                //     'type' => 'success',
                //     'message' => 'Logged in Successfully !!!!',
                //     'user' => $user
                // ]);
            } else {
                throw new Exception('Invalid email or password');
            }
        } catch (QueryException $e) {
            $type = 'error';
            $route = route('frontend.login');
            $message = "Invalid email or password.";
        } catch (Exception $e) {
            $type = 'error';
            $route = route('frontend.login');
            $message = $e->getMessage();
        }

        return response()->json(['type' => $type, 'message' => $message, 'route' => $route]);
    }
    public function logout()
    {
        if (!Auth::user()) {
            return redirect()->route('frontend.login');
        }
        Auth::logout();
        return view('frontend.login');
        session()->flush();
        Artisan::call('cache:clear');
        // return redirect()->route('frontend.login')->with('success', 'Logged out successfully');
    }





    public function index()
    {
        return view('backend.customer.index');
    }

    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = UserAccount::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['name'] = $row->username;
                $array[$i]['email'] = $row->email;
                $array[$i]['address'] = $row->address;
                $array[$i]['phone_number'] = $row->phone;
                $image = asset('images/no-image.jpg');
                if (!empty($row->image) && file_exists(public_path('/storage/product/' . $row->image))) {
                    $image = asset("storage/product/" . $row->image);
                }
                $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
                $action = '';
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
}
