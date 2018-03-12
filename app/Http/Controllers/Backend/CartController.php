<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\UserCart;
use App\Models\Account;

use Helper, File, Session, Auth;

class CartController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $type = isset($request->type) ? $request->type : null;
        if($type){
            $query = Cart::where('type', $type);
        }else{
            $query = Cart::whereRaw('1');    
        }        

        if(Auth::user()->role < 3){
            $query->join('user_cart', 'user_cart.cart_id', '=' ,'cart.id')->where('user_cart.user_id', $user_id);
        }
        
        $name = isset($request->name) && $request->name != '' ? $request->name : '';
        
        
        if( $name !='' ){
            $query->where('name', 'LIKE', '%'.$name.'%');
        }
        $items = $query->paginate(1000);
        if(Auth::user()->role == 2){ // Mod
            $editorList = Account::where(['status' => 1, 'role' => 1, 'leader_id' => Auth::user()->id])->get();
        }else{ // admin
            $editorList = Account::where(['status' => 1, 'role' => 1])->get();
        }
        $modList = Account::where(['status' => 1, 'role' => 1])->get();
        
        return view('backend.cart.index', compact( 'items', 'type', 'name', 'editorList', 'modList'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        if(Auth::user()->role > 1){
            return redirect()->route('dashboard.index');
        }
        $type = $request->type ? $request->type : 1;
        if(Auth::user()->role == 2){ // Mod
            $editorList = Account::where(['status' => 1, 'role' => 1, 'leader_id' => Auth::user()->id])->get();
        }else{ // admin
            $editorList = Account::where(['status' => 1, 'role' => 1])->get();
        }
        $modList = Account::where(['status' => 1, 'role' => 2])->get();
        return view('backend.cart.create', compact('type', 'editorList', 'modList'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $dataArr = $request->all();
        $userArr = isset($dataArr['user_id']) ? $dataArr['user_id'] : [];
        $this->validate($request,[
            'name' => 'required'            
        ],
        [
            'name.required' => 'Bạn chưa nhập tên giỏ hàng'
            
        ]);

        $dataArr['slug'] = Helper::changeFileName($dataArr['name']);  
        $dataArr['user_id'] = Auth::user()->id;

        $rs = Cart::create($dataArr);
        $cart_id = $rs->id;
        if(Auth::user()->role > 1){
            // xu ly user        
            if( !empty( $userArr ) && $cart_id ){            

                foreach ($userArr as $user_id) {
                    $model = new UserCart;
                    $model->cart_id = $cart_id;
                    $model->user_id  = $user_id;                
                    $model->save();
                }
            }
        }

        Session::flash('message', 'Tạo mới giỏ hàng thành công');

        return redirect()->route('cart.index', ['type' => $dataArr['type']]);
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        if(Auth::user()->role > 1){
            if(Cart::checkUserAccess($id, Auth::user()->id) == false){
                return redirect()->route('dashboard.index');
            }
        }
        $detail = Cart::find($id);
        $cartUser = Cart::cartUser($id);
        if(Auth::user()->role == 2){ // Mod
            $editorList = Account::where(['status' => 1, 'role' => 1, 'leader_id' => Auth::user()->id])->get();
        }else{ // admin
            $editorList = Account::where(['status' => 1, 'role' => 1])->get();
        }
        $modList = Account::where(['status' => 1, 'role' => 2])->get();
        return view('backend.cart.edit', compact( 'detail', 'cartUser', 'editorList', 'modList'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[
            'name' => 'required'            
        ],
        [
            'name.required' => 'Bạn chưa nhập tên giỏ hàng'           
        ]);       
        
        $dataArr['slug'] = Helper::changeFileName($dataArr['name']);
        
        $model = Cart::find($dataArr['id']);        
        
        $model->update($dataArr);
        if(Auth::user()->role > 1){
            $userArr = $dataArr['user_id'];
            // xu ly user   
            UserCart::where('cart_id', $dataArr['id'])->delete();     
            if( !empty( $userArr )){            

                foreach ($userArr as $user_id) {
                    $model = new UserCart;
                    $model->cart_id = $dataArr['id'];
                    $model->user_id  = $user_id;                
                    $model->save();
                }
            }
        }
        Session::flash('message', 'Cập nhật giỏ hàng thành công');

        return redirect()->route('cart.edit', $dataArr['id']);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        // delete
        $model = Cart::find($id);
        $model->delete();

        CartProduct::where('cart_id', $id)->delete();

        // redirect
        Session::flash('message', 'Xóa giỏ hàng thành công');
        return redirect()->route('cart.index');
    }
}
