<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Product;
use App\Models\CtvJoinSale;

use Helper, File, Session, Auth, Image;

class SalesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $arrSearch['type_sale'] = $type_sale = isset($request->type_sale) ? $request->type_sale : null; 
        $arrSearch['keyword'] = $keyword = isset($request->keyword) ? $request->keyword : null; 
        $arrSearch['cskh_status'] = $cskh_status = isset($request->cskh_status) ? $request->cskh_status : null; 
        $arrSearch['product_id'] = $product_id = isset($request->product_id) ? $request->product_id : null; 
        $arrSearch['pr_status'] = $pr_status = isset($request->pr_status) ? $request->pr_status : null; 
        $arrSearch['pr_id'] = $pr_id = isset($request->pr_id) ? $request->pr_id : null; 
        $arrSearch['ctv_id'] = $ctv_id = isset($request->ctv_id) ? $request->ctv_id : null;  
        $query = CtvJoinSale::whereRaw(1);
        $type_sale = (Auth::user()->role == 2 || Auth::user()->role == 3 ) ? 2: $type_sale;
        if($type_sale){

            $query->where('type_sale', $type_sale);
        }
        if($cskh_status){
            $query->where('cskh_status', $cskh_status);
        }
        $detailProduct = [];
        if($product_id){
            $query->where('product_id', $product_id);
            $detailProduct = Product::find($product_id);
        }
        if($pr_status){
            $query->where('pr_status', $pr_status);
        }
        if($keyword){
            $query->where('phone', 'LIKE', '%'.$keyword.'%')
                ->orWhere('cmnd', 'LIKE', '%'.$keyword.'%');
        }
        if($pr_id){
            $query->where('pr_id', $pr_id);
        }
        if(Auth::user()->role == 3){ // pr
            $query->where('pr_id', Auth::user()->id );   
        }
        if(Auth::user()->role == 4){ // cs ctv
            $arrId = [];
            $listCtv = Account::where('leader_id', Auth::user()->id)->pluck('id');
            if($listCtv->count() > 0){
                foreach($listCtv as $ctv){                    
                    $arrId[] = $ctv;
                }
            }            
            $query->whereIn('ctv_id', $arrId );   
        }
        
        if($ctv_id){
            $query->where('ctv_id', $ctv_id);
        }
        if(Auth::user()->role == 5){ // pr
            $query->where('ctv_id', Auth::user()->id );   
        }
        $query->orderBy('co_hen', 'desc');
        $items = $query->orderBy('id', 'desc')->paginate(100);
        
        if(Auth::user()->role == 4){
             $ctvList = Account::where('leader_id', Auth::user()->id)->where('role' , 5)->get();
        }else{
            $ctvList = Account::where(['role' =>5, 'status' => 1])->get();    
        }
        $prList = Account::where(['role' =>3, 'status' => 1])->get();
        $henList = CtvJoinSale::userHen();        
        return view('backend.sales.index', compact( 'items', 'type_sale', 'cskh_status', 'ctvList', 'prList', 'pr_id', 'ctv_id', 'arrSearch', 'pr_status','detailProduct', 'product_id', 'henList'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {

        $block_id = isset($request->block_id) ? $request->block_id : 1;
        if($block_id == 1){
            $name = "Liên kết nổi bật";
        }elseif($block_id == 2){
            $name = "Link footer";
        }
        return view('backend.sales.create', compact('block_id', 'name'));
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
            'full_name' => 'required',            
            'cmnd' => 'required',
            'phone' => 'required',            
            'address' => 'required',
            'vung_quan_tam' => 'required',            
            'nhu_cau' => 'required',            
            'loai_bds' => 'required',            
        ]);       

        $rs = CtvJoinSale::create($dataArr);

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('sales.index');
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
        $detail = CtvJoinSale::find($id);     
        return view('backend.sales.edit', compact('detail'));
    }

    public function detail($id)
    {
        $detail = CtvJoinSale::find($id);     
        return view('backend.sales.detail', compact('detail'));
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
        if($dataArr['type_sale'] == 2){
            $this->validate($request,[            
                'full_name' => 'required',            
                'cmnd' => 'required',
                'phone' => 'required',            
                'address' => 'required',
                'vung_quan_tam' => 'required',            
                'nhu_cau' => 'required',            
                'loai_bds' => 'required',            
            ]);       
        }
        
        $model = CtvJoinSale::find($dataArr['id']);

        $model->update($dataArr);        
        
        if(isset($dataArr['cskh_status']) && $dataArr['cskh_status'] == 3 && !$model->pr_id){ // gan cho PR
            $pr_min = null;
            $pr_list = Account::where(['status'=>1, 'role' => 3])->select(['id'])->get();              
            $arr = [];
            if($pr_list->count() > 0){
                foreach($pr_list as $pr){
                    $count = CtvJoinSale::where('pr_id', $pr->id)->get()->count();
                    $arr[$pr->id] = $count;
                }
            }
          
            $pr_min = array_search(min($arr), $arr);
            $sales = CtvJoinSale::find($dataArr['id']);
            $sales->pr_id = $pr_min;
            $sales->updated_user = Auth::user()->id;
            $sales->save();
        }

        Session::flash('message', 'Cập nhật thành công');        

        return redirect()->route('sales.index');
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
        $model = CtvJoinSale::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('sales.index');
    }
}
