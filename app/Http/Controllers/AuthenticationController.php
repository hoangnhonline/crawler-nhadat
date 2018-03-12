<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Account;
use Session, Auth;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkLogin(Request $request)
    {
        $dataArr = $request->all();

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ],
        [
            'email.required' => 'Bạn chưa nhập email',
            'password.required' => 'Bạn chưa nhập mật khẩu'
        ]);

        $dataArr = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $customer = Account::where('email', $request->email)->where('role', 5)->first();
        if(is_null($customer) || !password_verify($request->password, $customer->password) ) {
            Session::flash('error', 'Email hoặc mật khẩu không đúng.');
        } else {
            Session::put('login', true);
            Session::put('userId', $customer->id);
            Session::put('facebook_id', $customer->facebook_id);
            Session::put('username', $customer->full_name);
            Session::put('avatar', $customer->image_url); 
        }
        return redirect()->back();
    }

    public function checkLoginAjax(Request $request)
    {
        $dataArr = $request->all();

        $customer = Account::where('email', $request->email)->where('role', 5)->first();
        if(is_null($customer) || !password_verify($request->password, $customer->password) ) {
            Session::flash('error', 'Email hoặc mật khẩu không đúng.');
            return response()->json(['error' => 1]);
        } else {
            Session::put('login', true);
            Session::put('userId', $customer->id);
            Session::put('facebook_id', $customer->facebook_id);
            Session::put('username', $customer->full_name);
            Session::put('avatar', $customer->image_url);
            return response()->json(['error' => 0]);         
        }
    }

    public function logout(Request $request)
    {
        Session::forget('login');
        Session::forget('userId');
        Session::forget('username');
        Session::forget('avatar');
        Session::forget('facebook_id');  
        Session::forget('new-register');
        if(Auth::check()){
            Auth::logout();
        }
        return redirect()->route('home');
    }
}
