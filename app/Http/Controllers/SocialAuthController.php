<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use App\Models\Account;
use Helper, File, Session, Auth;
use App, Hash;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $providerUser = Socialite::driver('google')->user();
        $data['email'] = $providerUser->email;

        $getCustomer = Account::where('email', $data['email'])->first();

        if(is_null($getCustomer)) {
            Session::put('gg_id', $providerUser->user);

            if(!$providerUser->getName()) {
                 Session::put('gg_name', $providerUser->user['name']['familyName'] . $providerUser->user['name']['givenName']);
            }

            if(!$providerUser->getEmail()) {
                Session::put('gg_email', $providerUser->email);
            }

            return redirect()->route('shipping-step-1');

        } else {
            Session::put('login', true);
            Session::put('userId', $getCustomer->id);

            return redirect()->route('shipping-step-2');
        }
    }

    public function fbLogin(Request $request)
    {
        $fb_token = $request->token;

        $fb            = App::make('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');
        $response      = $fb->get('/me?fields=id,name,email,picture.width(200).height(200)', $fb_token);
       
        $facebook_user = $response->getGraphUser();
        
        $facebook['email'] = $facebook_user['email'];
        $facebook['id']    = $facebook_user['id'];
        $facebook['name']  = $facebook_user['name'];
        $facebook['avatar']= $facebook_user['picture']['url'];

        $getCustomer = Account::where('email', $facebook['email'])->first();

        if(is_null($getCustomer)) {
            Session::put('fb_id', $facebook['id']);

            if(!$facebook['name']) {
                Session::put('fb_name',  $facebook['name']);
            }

            if(!$facebook['email']) {
                Session::put('fb_email',  $facebook['email']);
            }

            $customer = new Account;
            $customer->full_name    =  $facebook['name'];
            $customer->email        =  $facebook['email'] ;
            $customer->facebook_id  =  $facebook['id'];
            $customer->password = Hash::make('9116e0c17187fa4805bfaaa2aca44fb9');
            $customer->role  =  5; // ctv
            $customer->image_url    =  $facebook['avatar'];
            $customer->last_login    =  date('Y-m-d H:i:s');
            $cs_min = null;
            $listcs = Account::where(['status'=>1, 'role' => 4])->select(['id'])->get();              
            $arr = [];
            if($listcs->count() > 0){
                foreach($listcs as $cs){
                    $count = Account::where('leader_id', $cs->id)->get()->count();
                    $arr[$cs->id] = $count;
                }
            }
          
            $cs_min = array_search(min($arr), $arr);
            $customer->leader_id = $cs_min; 
            $customer->save();
            $dataLoginBE = ['email' => $facebook['email'], 'password' => '9116e0c17187fa4805bfaaa2aca44fb9'];
            if (Auth::validate($dataLoginBE)) {
                Auth::attempt($dataLoginBE);
            }

            Session::flash('register', 'true');
            Session::put('login', true);
            Session::put('userId', $customer->id);
            Session::put('facebook_id', $customer->facebook_id);
            Session::put('username', $customer->full_name);
            Session::put('avatar', $customer->image_url);
            Session::put('new-register', true);
            Session::flash('new-register-fb', 'true');
            return response()->json([
                'success' => 1
            ]);


        } else {

            if(!$getCustomer->image_url) {
                $getCustomer->image_url = $facebook['avatar'];
                //$getCustomer->last_login    =  date('Y-m-d H:i:s');
                
            }
            $cs_min = null;
            //update leader_id
            if(!$getCustomer->leader_id){
                $listcs = Account::where(['status'=>1, 'role' => 4])->select(['id'])->get();              
                $arr = [];
                if($listcs->count() > 0){
                    foreach($listcs as $cs){
                        $count = Account::where('leader_id', $cs->id)->get()->count();
                        $arr[$cs->id] = $count;
                    }
                }
              
                $cs_min = array_search(min($arr), $arr);
                $getCustomer->leader_id = $cs_min; 
                $getCustomer->save();
            }
            $dataLoginBE = ['email' => $getCustomer->email, 'password' => '9116e0c17187fa4805bfaaa2aca44fb9'];
            
            if (Auth::validate($dataLoginBE)) {              
                Auth::attempt($dataLoginBE);
            }

            Session::put('login', true);
            Session::put('userId', $getCustomer->id);
            Session::put('facebook_id', $getCustomer->facebook_id);
            Session::put('username', $getCustomer->full_name);
            Session::put('avatar', $getCustomer->image_url);
            

             
            return response()->json([
                'success' => 0
            ]);
        }

        return response()->json(['fb_token' => $fb_token, 'fbUser' => $facebook]);
    }

}
