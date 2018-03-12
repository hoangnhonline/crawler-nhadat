<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Users;
use App\Models\Account;

use Helper, File, Session, Hash, Auth;

class UserController extends Controller
{    

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function loginForm()
    {
        /*User::create(array(
            'full_name'     => 'Andy',            
            'email'    => 'andy2016@gmail.com',
            'password' => Hash::make('matkhaucuatui'),
            'role' => 1,
            'status' => 1
        ));*/       
        if ( Auth::check() )
        {
            if(in_array(Auth::user()->role, [2,3,4,5])){
                return redirect()->route('sales.index');    
            }

            return redirect()->route('dashboard.index');
        }        
        return view('backend.login');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
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
        if (Auth::validate($dataArr)) {

            if (Auth::attempt($dataArr)) {
                $customer = Account::find(Auth::user()->id);
                if(Auth::user()->role == 5){
                    Session::put('login', true);
                    Session::put('userId', $customer->id);
                    Session::put('facebook_id', $customer->facebook_id);
                    Session::put('username', $customer->full_name);
                    Session::put('avatar', $customer->image_url);
                }
                
                if(in_array(Auth::user()->role, [2,3,4,5])){
                    return redirect()->route('sales.index');    
                }

                return redirect()->route('dashboard.index');
              
            }

        }else {
            // if any error send back with message.
            Session::flash('error', 'Email hoặc mật khẩu không đúng.'); 
            return redirect()->route('backend.login-form');
        }

        return redirect()->route('parent-cate.index');
    }
  
    public function logout()
    {
        Auth::logout();
        Session::forget('login');
        Session::forget('userId');
        Session::forget('username');
        Session::forget('avatar');
        Session::forget('facebook_id');  
        Session::forget('new-register');
        return redirect()->route('backend.login-form');
    }
   
}
