<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CrawlData;
use App\Models\ProductImg;
use Helper, File, Session, Auth, Image;

class DataController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        $arrSearch['type'] = $type = isset($request->type) ? $request->type : null; 
        $arrSearch['keyword'] = $keyword = isset($request->keyword) ? trim($request->keyword) : null; 
        $arrSearch['moigioi'] = $moigioi = isset($request->moigioi) ? $request->moigioi : null; 
        $arrSearch['site_id'] = $site_id = isset($request->site_id) ? $request->site_id : null; 
        $arrSearch['status_1'] = $status_1 = isset($request->status_1) ? $request->status_1 : null; 
        $arrSearch['status_2'] = $status_2 = isset($request->status_2) ? $request->status_2 : null; 
        $arrSearch['status_3'] = $status_3 = isset($request->status_3) ? $request->status_3 : null;  
        $query = CrawlData::whereRaw(1);        
        if($type){

            $query->where('type', $type);
        }
        if($moigioi){
            $query->where('moigioi', $moigioi);
        }  
        if($keyword){
            $query->where('phone', $keyword);
        }        
        if($site_id){
            $query->where('site_id', $site_id);            
        }
        if($status_1){
            $query->where('status_1', $status_1);
        }        
        if($status_2){
            $query->where('status_2', $status_2);
        }        
        if($status_3){
            $query->where('status_3', $status_3);
        }
        if($role == 3){
            $query->where('status_1', 3);
        }
        if($role == 4){
            $query->where('status_2', 5);

        }
        $query->leftJoin('product_img', 'product_img.id', '=','crawl_data.thumbnail_id'); 
        $items = $query->orderBy('id', 'desc')->select(['product_img.image_url as image_url','crawl_data.*'])->paginate(100);
      
        $henList = CrawlData::userHen();        
        return view('backend.data.index', compact( 'items', 'type', 'moigioi', 'status_2', 'status_3', 'arrSearch', 'status_1', 'site_id', 'henList'));
    }
    public function storeUpload(Request $request)
    {
        $dataArr = $request->all();        
        $dataArr['updated_user'] = Auth::user()->id;
        $product_id = $dataArr['product_id'];
        $rs = CrawlData::find($product_id);
        $rs->update($dataArr);
        $this->storeImage( $product_id, $dataArr);                
        Session::flash('message', 'Cập nhật thành công');

        return redirect()->route('data.index');
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
        return view('backend.data.create', compact('block_id', 'name'));
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
            'phone' => 'required',            
            'address' => 'required'                     
        ]);       

        $rs = CrawlData::create($dataArr);

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('data.index');
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
    public function storeImage($id, $dataArr){        
        //process old image
        $imageIdArr = isset($dataArr['image_id']) ? $dataArr['image_id'] : [];
        $hinhXoaArr = ProductImg::where('product_id', $id)->whereNotIn('id', $imageIdArr)->lists('id');
        if( $hinhXoaArr )
        {
            foreach ($hinhXoaArr as $image_id_xoa) {
                $model = ProductImg::find($image_id_xoa);
                $urlXoa = config('moigioi.upload_path')."/".$model->image_url;
                if(is_file($urlXoa)){
                    unlink($urlXoa);
                }
                $model->delete();
            }
        }       

        //process new image
        if( isset( $dataArr['thumbnail_id'])){
            $thumbnail_id = $dataArr['thumbnail_id'];

            $imageArr = []; 

            if( !empty( $dataArr['image_tmp_url'] )){

                foreach ($dataArr['image_tmp_url'] as $k => $image_url) {
                    
                    $origin_img = base_path().$image_url;
                    if( $image_url ){

                        $imageArr['is_thumbnail'][] = $is_thumbnail = $dataArr['thumbnail_id'] == $image_url  ? 1 : 0;

                        $img = Image::make($origin_img);
                        $w_img = $img->width(); // 283 
                        $h_img = $img->height(); // 200

                        $tmpArrImg = explode('/', $origin_img);
                        
                        $new_img = config('moigioi.upload_thumbs_path').end($tmpArrImg);
                       
                        if($w_img/$h_img > 283/200){

                            Image::make($origin_img)->resize(null, 200, function ($constraint) {
                                    $constraint->aspectRatio();
                            })->crop(283, 200)->save($new_img);
                        }else{
                            Image::make($origin_img)->resize(283, null, function ($constraint) {
                                    $constraint->aspectRatio();
                            })->crop(283, 200)->save($new_img);
                        }                           

                        $imageArr['name'][] = $image_url;
                        
                    }
                }
            }
            if( !empty($imageArr['name']) ){
                foreach ($imageArr['name'] as $key => $name) {
                    $rs = ProductImg::create(['product_id' => $id, 'image_url' => $name, 'display_order' => 1]);                
                    $image_id = $rs->id;
                    if( $imageArr['is_thumbnail'][$key] == 1){
                        $thumbnail_id = $image_id;
                    }
                }
            }
            $model = CrawlData::find( $id );
            $model->thumbnail_id = $thumbnail_id;
            $model->save();
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
        $detail = CrawlData::find($id);     
        return view('backend.data.edit', compact('detail'));
    }
    public function upload($id)
    {
        $detail = CrawlData::find($id);     
        $hinhArr = (object) [];        
       // var_dump($detail->type);die;
        $hinhArr = ProductImg::where('product_id', $id)->lists('image_url', 'id');     
        return view('backend.data.upload', compact('detail', 'hinhArr'));
    }

    public function detail($id)
    {
        $detail = CrawlData::find($id);     
        return view('backend.data.detail', compact('detail'));
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
            'name' => 'required',               
            'phone' => 'required',            
            'address' => 'required',                
        ]);       
        
        if(isset($dataArr['moigioi'])){
            $dataArr['moigioi'] = 1;
        }
        
        $model = CrawlData::find($dataArr['id']);

        $model->update($dataArr);        

        Session::flash('message', 'Cập nhật thành công');        

        return redirect()->route('data.index');
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
        $model = CrawlData::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('data.index');
    }
}
