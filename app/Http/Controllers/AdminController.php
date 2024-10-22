<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\UserAccount;
use App\Models\Admin;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function adminLogin()
    {
        return view('backend.login.index');
    }

    public function adminCheck(Request $request)
    {
        try {
            // $rules = [
            //     'email' => 'required|email|min:3|max:50',
            //     'password' => 'required|max:50',
            // ];
            // $message = [
            //     /* Email validation */
            //     'email.required' => 'Email field is required',
            //     'email.email' => 'Email must be valid email.',
            //     'email.min' => 'Email must be of 3 character long.',
            //     'email.max' => 'Email should not greater than 50 characters.',
            //     /* Password Validation */
            //     'password.required' => 'Password field is required',
            //     'password.max' => 'Email should not greater than 50 characters.',

            // ];
            // $validate = Validator::make($request->all(), $rules, $message);
            // if ($validate->fails()) {
            //     throw new Exception($validate->errors()->first(), 1);
            // }
            // $post = $request->all();
            // $type = 'success';
            // $message = 'Logged in Successfully !!!!';
            // $credentials = [
            //     'email' => $post['email'],
            //     'password' => $post['password'],
            // ];
            // if (Auth::attempt($credentials)) {
            //     $user = Auth::user();

            //     if ($user->id === 1) {
            //         return view('backend.dashboard.index');
            //     }


            $admin = Admin::where('email', $request->email)->first();

            if ($admin && Hash::check($request->password, $admin->password)) {
                Session::put('admin_id', $admin->id);
                return redirect()->route('admin.dashboard');
            }


            // return response()->json([
            //     'type' => 'success',
            //     'message' => 'Logged in Successfully !',
            //     'route' => route('product')
            // ]);
            else {
                throw new Exception('Invallid user or password');
            }
        } catch (QueryException) {
            $type = 'error';
            $route = route('admin.login');
            //  $message = $this->queryMessage;
        } catch (Exception $e) {
            $type = 'error';
            $route = route('admin.login');
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message, 'route' => $route]);
    }
}
