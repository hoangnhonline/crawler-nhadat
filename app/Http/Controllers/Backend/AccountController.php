<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Mail;
use Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\UserMod;
use Helper, File, Session, Auth;

class AccountController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {         
        if(Auth::user()->role > 1){
            return redirect()->route('data.index');
        }
        $role = $leader_id = 0;
        $role = Auth::user()->role;
        $query = Account::where('status', '>', 0);

        if( $role == 2){
            $leader_id = Auth::user()->id;
            $query->where('role',1);
                $query->join('user_mod', 'user_mod.user_id', '=', 'users.id')
                    ->where('user_mod.mod_id', $leader_id);
        }else{
            $role = $request->role ? $request->role : 0;
            if($role > 0){
                $query->where('role', $role);
            }
            $leader_id = $request->leader_id ? $request->leader_id : 0;
            if($leader_id > 0){
                $query->join('user_mod', 'user_mod.user_id', '=', 'users.id')
                    ->where('user_mod.mod_id', $leader_id);
            }
        }
        $items = $query->orderBy('id', 'desc')->get();
        $modList = Account::where(['role' => 2, 'status' => 1])->get();
        return view('backend.account.index', compact('items', 'role', 'leader_id', 'modList'));
    }
    public function ctv(Request $request)
    {         
        if(!in_array(Auth::user()->role, [1, 4])){
            return redirect()->route('data.index');
        }
        $query = Account::where('status', '>', 0);
    
        $query->where('role', 5);
         
        if(Auth::user()->role == 4){
            $query->where('leader_id', Auth::user()->id);
        }        
        $items = $query->orderBy('id', 'desc')->get();        
        return view('backend.account.ctv', compact('items'));
    }
    public function create()
    {        
        if(Auth::user()->role > 1){
            return redirect()->route('data.index');
        }
        $csctvList = Account::where(['role' => 4, 'status' => 1])->get();
        
        return view('backend.account.create', compact('csctvList'));
    }
    public function changePass(){
        return view('backend.account.change-pass');   
    }

    public function storeNewPass(Request $request){
        $user_id = Auth::user()->id;
        $detail = Account::find($user_id);
        $old_pass = $request->old_pass;
        $new_pass = $request->new_pass;
        $new_pass_re = $request->new_pass_re;
        if( $old_pass == '' || $new_pass == "" || $new_pass_re == ""){
            return redirect()->back()->withErrors(["Chưa nhập đủ thông tin bắt buộc!"])->withInput();
        }
       
        if(!password_verify($old_pass, $detail->password)){
            return redirect()->back()->withErrors(["Nhập mật khẩu hiện tại không đúng!"])->withInput();
        }
        
        if($new_pass != $new_pass_re ){
            return redirect()->back()->withErrors("Xác nhận mật khẩu mới không đúng!")->withInput();   
        }

        $detail->password = Hash::make($new_pass);
        $detail->save();
        Session::flash('message', 'Đổi mật khẩu thành công');

        return redirect()->route('account.change-pass');

    }
    public function store(Request $request)
    {
       
        $dataArr = $request->all();
         
        $this->validate($request,[
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
        ],
        [
            'full_name.required' => 'Bạn chưa nhập họ tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Sai định dạng email',
            'email.unique' => 'Email đã được sử dụng.'
        ]);       
        
        $tmpPassword = str_random(10);
                
        $dataArr['password'] = Hash::make('123465@');
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;

        $rs = Account::create($dataArr);

        if(!empty($dataArr['mod_id'])){
            foreach($dataArr['mod_id'] as $mod_id){
                UserMod::create(['user_id' => $rs->id, 'mod_id' => $mod_id]);
            }
        }
        /*
        if ( $rs->id > 0 ){
            Mail::send('backend.account.mail', ['full_name' => $request->full_name, 'password' => $tmpPassword, 'email' => $request->email], function ($message) use ($request) {
                $message->from( config('mail.username'), config('mail.name'));

                $message->to( $request->email, $request->full_name )->subject('Mật khẩu đăng nhập hệ thống');
            });   
        }*/

        Session::flash('message', 'Tạo mới tài khoản thành công. Mật khẩu mặc định là : 123465@');

        return redirect()->route('account.index');
    }
    public function destroy($id)
    {
        if(Auth::user()->role > 1){
            return redirect()->route('data.index');
        }
        // delete
        $model = Account::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa tài khoản thành công');
        return redirect()->route('account.index');
    }
    public function edit($id)
    {
        if(Auth::user()->role != 1 && Auth::user()->role != 4){
            return redirect()->route('data.index');
        }
        if(Auth::user()->role == 4){
            if($id != Auth::user()->id){
                return redirect()->route('data.index');       
            }
        }
        $detail = Account::find($id);
        $csctvList = Account::where(['role' => 4, 'status' => 1])->get();        
        return view('backend.account.edit', compact( 'detail', 'csctvList'));
    }
    public function update(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[
            'full_name' => 'required'            
        ],
        [
            'full_name.required' => 'Bạn chưa nhập họ tên'        
        ]);      

        $model = Account::find($dataArr['id']);

        $dataArr['updated_user'] = Auth::user()->id;

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật tài khoản thành công');

        return redirect()->route('account.index');
    }
   
    public function updateStatus(Request $request)
    {       

        $model = Account::find( $request->id );

        
        $model->updated_user = Auth::user()->id;
        $model->status = $request->status;

        $model->save();
        $mess = $request->status == 1 ? "Mở khóa tài khoản thành công" : "Khóa tài khoản thành công";
        Session::flash('message', $mess);

        return redirect()->route('account.index');
    }
}
