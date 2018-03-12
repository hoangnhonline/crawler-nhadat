<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\LichHen;
use App\Models\CtvJoinSale;

use Helper, File, Session, Auth, Image;

class HenController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $arrSearch['join_id'] = $join_id = isset($request->join_id) ? $request->type_sale : 2; 
        $arrSearch['user_id'] = $user_id = isset($request->user_id) ? $request->user_id : null; 
        
        $query = LichHen::where('type_sale', $type_sale);
        if($join_id){
            $query->where('join_id', $join_id);
        }
        if($user_id){
            $query->where('user_id', $user_id);
        }
        $items = $query->orderBy('id', 'desc')->paginate(1000);
        
        return view('backend.hen.index', compact( 'items', 'type_sale', 'cskh_status', 'ctvList', 'prList', 'pr_id', 'ctv_id', 'arrSearch'));
    }
    public function ajaxList(Request $request)
    {
        $arrSearch['join_id'] = $join_id = isset($request->join_id) ? $request->join_id : null; 
        $query = LichHen::where('ngay_hen', '>=', date('Y-m-d'));
        if($join_id){
            $query->where('join_id', $join_id);
        }
        
            $query->where('user_id', Auth::user()->id);
        
        $items = $query->orderBy('ngay_hen')->get();
        
        return view('backend.hen.ajax-list', compact( 'items'));
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
        return view('backend.hen.create', compact('block_id', 'name'));
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
        //dd($dataArr);
        $this->validate($request,[            
            'ngay_hen' => 'required'    
        ]);       

        $dataArr['ngay_hen'] = date('Y-m-d', strtotime($dataArr['ngay_hen']));
        $dataArr['user_id'] = Auth::user()->id;
        $rs = LichHen::create($dataArr);
        $join = CtvJoinSale::find($dataArr['join_id']);
        $join->co_hen = 1;
        $join->save();
        Session::flash('message', 'Tạo mới thành công');

        //return redirect()->route('hen.index');
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
        $detail = LichHen::find($id);     
        return view('backend.hen.edit', compact('detail'));
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
            'full_name' => 'required',            
            'cmnd' => 'required',
            'phone' => 'required',            
            'address' => 'required',
            'vung_quan_tam' => 'required',            
            'nhu_cau' => 'required',            
            'loai_bds' => 'required',            
        ]);       
        
        $model = LichHen::find($dataArr['id']);

        $model->update($dataArr);        
        
        Session::flash('message', 'Cập nhật thành công');        

        return redirect()->route('hen.index');
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
        $model = LichHen::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('hen.index');
    }
}
