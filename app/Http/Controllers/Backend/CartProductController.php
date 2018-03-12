<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use Helper, File, Session, Auth;

class CartProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $cart_id = $request->cart_id;
        $items = CartProduct::where('cart_id', $request->cart_id)->paginate(48);
        $cartDetail = Cart::find($request->cart_id);

        return view('backend.cart-product.index', compact( 'items', 'cartDetail', 'cart_id'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        $cart_id = $request->cart_id;

        $cartDetail = Cart::find($cart_id);
  
        return view('backend.cart-product.create', compact('cart_id', 'cartDetail'));
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
        
        $this->validate($request,[
            'name' => 'required'            
        ],
        [
            'name.required' => 'Bạn chưa nhập tên'
            
        ]);
        
        $dataArr['user_id'] = Auth::user()->id;

        CartProduct::create($dataArr);

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('cart-product.index', ['cart_id' => $dataArr['cart_id']]);
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
        $detail = CartProduct::find($id);
        $cart_id = $detail->cart_id;
        $cartDetail = Cart::find($cart_id);
        return view('backend.cart-product.edit', compact( 'detail', 'cartDetail', 'cart_id'));
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
            'name.required' => 'Bạn chưa nhập tên'           
        ]);       
        
        $dataArr['slug'] = Helper::changeFileName($dataArr['name']);
        
        $model = CartProduct::find($dataArr['id']);        

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật thành công');

        return redirect()->route('cart-product.index', ['cart_id' => $dataArr['cart_id']]);
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
        $model = CartProduct::find($id);
        $cart_id = $model->cart_id;
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('cart-product.index', ['cart_id' => $cart_id]);
    }
}
