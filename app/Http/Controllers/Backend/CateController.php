<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cate;
use App\Models\MetaData;
use App\Models\EstateType;
use Helper, File, Session, Auth, Image, DB;

class CateController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {     
        
        $type = isset($request->type) ? $request->type : 1;
        $is_hot = isset($request->is_hot) ? $request->is_hot : null;                   
        $estate_type_id = isset($request->estate_type_id) ? $request->estate_type_id : null;        
        if( $estate_type_id ){
            $estate_type_id = $request->estate_type_id;
            //$estateTypeDetail = EstateType::find($estate_type_id);
        }

        $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';  
        
        $query = Cate::where('status', 1);

        if( $is_hot ){
            $query->where('is_hot', $is_hot);
        }        
       
        if( $name != ''){
            $query->where('name', 'LIKE', '%'.$name.'%');            
        }       

        if( $estate_type_id ){
            $query->where('estate_type_id', $estate_type_id);           
        }        
        $items = $query->orderBy('display_order')->get();       

        $cateParentList = EstateType::where('type', $type)->get(); 
        //dd($cateParentList);
        return view('backend.cate.index', compact( 'items', 'estate_type_id', 'type_id', 'name', 'is_hot', 'cateParentList', 'type'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {   
        $estate_type_id = $request->estate_type_id ? $request->estate_type_id : null;
        $type = $request->type ? $request->type : 1;    
        
        if( $type ){            
            $cateParentList = EstateType::where('type', $type)->select('id', 'name')->orderBy('display_order', 'desc')->get();
        }  
                    
        return view('backend.cate.create', compact( 'estate_type_id', 'cateParentList', 'estate_type_id', 'type_id', 'type'));
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
            'type' => 'required',
            'estate_type_id' => 'required',
            'name' => 'required',
            'slug' => 'required'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên danh mục',
            'slug.required' => 'Bạn chưa nhập slug',
        ]);
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;
        
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;       
        $dataArr['display_order'] = Helper::getNextOrder('cate', ['estate_type_id' => $dataArr['estate_type_id']]);       
        $rs = Cate::create($dataArr);        
        $id = $rs->id;

        $this->storeMeta( $id, 0, $dataArr);

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('cate.index',['estate_type_id' => $dataArr['estate_type_id'], 'type' => $dataArr['type']]);
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
    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = [ 'title' => $dataArr['meta_title'], 'description' => $dataArr['meta_description'], 'keywords'=> $dataArr['meta_keywords'], 'custom_text' => $dataArr['custom_text'], 'updated_user' => Auth::user()->id ];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;            
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;
            
            $modelSp = Cate::find( $id );
            $modelSp->meta_id = $meta_id;
            $modelSp->save();
        }else {
            $model = MetaData::find($meta_id);           
            $model->update( $arrData );
        }              
    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
          
        $detail = Cate::find($id);                
        $cateParentList = EstateType::orderBy('display_order')->get();
        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }        
        return view('backend.cate.edit', compact( 'detail', 'meta', 'cateParentList'));
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
            'type' => 'required',
            'estate_type_id' => 'required',
            'name' => 'required',
            'slug' => 'required',            
            
        ],
        [
            'name.required' => 'Bạn chưa nhập tên danh mục',
            'slug.required' => 'Bạn chưa nhập slug',
        ]);

        $model = Cate::find($dataArr['id']);

        $dataArr['updated_user'] = Auth::user()->id;
        
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;   
        
        $model->update($dataArr);

        $this->storeMeta( $dataArr['id'], $dataArr['meta_id'], $dataArr);
        Session::flash('message', 'Cập nhật thành công');

        return redirect()->route('cate.edit', $dataArr['id']);
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
        $model = Cate::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('cate.index',['estate_type_id' => $model->estate_type_id, 'type' => $model->type]);
    }
}
