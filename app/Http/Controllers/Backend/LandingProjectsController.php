<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LandingProjects;
use App\Models\MetaData;
use App\Models\Tab;
use App\Models\ProjectTab;

use Helper, File, Session, Auth, Image;

class LandingProjectsController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {

        $name = isset($request->name) && $request->name != '' ? $request->name : '';
        
        $query = LandingProjects::whereRaw('1');

        
        // check editor
        if( Auth::user()->role > 1 ){
            $query->where('created_user', Auth::user()->id);
        }
        if( $name != ''){
            $query->where('name', 'LIKE', '%'.$name.'%');
        }
        $items = $query->orderBy('id', 'desc')->paginate(20);
        
        return view('backend.landing-projects.index', compact( 'items' , 'name' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        $tabList = Tab::all();
        return view('backend.landing-projects.create', compact('tabList'));
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
            'name' => 'required',            
            'slug' => 'required|unique:articles,slug',
        ],
        [         
            'name.required' => 'Bạn chưa nhập tên dự án',
            'slug.required' => 'Bạn chưa nhập slug',
            'slug.unique' => 'Slug đã được sử dụng.'
        ]);       
        if($dataArr['image_url'] && $dataArr['image_name']){
            
            $tmp = explode('/', $dataArr['image_url']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }
            if(!is_dir('uploads/thumbs/projects/'.date('Y/m/d'))){
                mkdir('uploads/thumbs/projects/'.date('Y/m/d'), 0777, true);
            }
            if(!is_dir('uploads/thumbs/projects/306x194/'.date('Y/m/d'))){
                mkdir('uploads/thumbs/projects/306x194/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('moigioi.upload_path').$dataArr['image_url'], config('moigioi.upload_path').$destionation); 
            $img = Image::make(config('moigioi.upload_path').$destionation);
                            $w_img = $img->width();
                            $h_img = $img->height();          
            $tile2 = 0.06232734;
            $w_tile2 = $w_img/306;
            $h_tile2 = $h_img/194;
         
            if($w_tile2- $h_tile2 <= $tile2){
                Image::make(config('moigioi.upload_path').$destionation)->resize(306, null, function ($constraint) {
                        $constraint->aspectRatio();
                })->crop(306, 194)->save(config('moigioi.upload_thumbs_path_projects').'306x194/'.$destionation);
            }else{
                Image::make(config('moigioi.upload_path').$destionation)->resize(null, 194, function ($constraint) {
                        $constraint->aspectRatio();
                })->crop(306, 194)->save(config('moigioi.upload_thumbs_path_projects').'306x194/'.$destionation);
            }           
            $dataArr['image_url'] = $destionation;
        }

        if($dataArr['logo_url'] && $dataArr['logo_name']){
            
            $tmp = explode('/', $dataArr['logo_url']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }
            if(!is_dir('uploads/thumbs/projects/'.date('Y/m/d'))){
                mkdir('uploads/thumbs/projects/'.date('Y/m/d'), 0777, true);
            }         

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('moigioi.upload_path').$dataArr['logo_url'], config('moigioi.upload_path').$destionation);                       
           
            $dataArr['logo_url'] = $destionation;
        }        
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;
        
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;  

        $rs = LandingProjects::create($dataArr);

        $object_id = $rs->id;

        $this->storeMeta( $object_id, 0, $dataArr);
         // xu ly tags
        if( !empty( $dataArr['tab'] ) && $object_id ){
            

            foreach ($dataArr['tab'] as $tab_id) {
                $model = new ProjectTab;
                $model->project_id = $object_id;
                $model->tab_id  = $tab_id;                
                $model->save();
            }
        }
        Session::flash('message', 'Tạo mới dự án thành công');

        return redirect()->route('landing-projects.index');
    }
    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = [ 'title' => $dataArr['meta_title'], 'description' => $dataArr['meta_description'], 'keywords'=> $dataArr['meta_keywords'], 'custom_text' => $dataArr['custom_text'], 'updated_user' => Auth::user()->id ];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;            
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;
            
            $modelSp = LandingProjects::find( $id );
            $modelSp->meta_id = $meta_id;
            $modelSp->save();
        }else {
            $model = MetaData::find($meta_id);           
            $model->update( $arrData );
        }              
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
        $tabSelected = [];

        $detail = LandingProjects::find($id);
        if( Auth::user()->role > 1 ){
            if($detail->created_user != Auth::user()->id){
                return redirect()->route('dashboard.index');
            }
        }       
        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }

        $tmpArr = ProjectTab::where('project_id', $id)->get();
        
        if( $tmpArr->count() > 0 ){
            foreach ($tmpArr as $value) {
                $tabSelected[] = $value->tab_id;
            }
        }

        $tabList = Tab::all();
        return view('backend.landing-projects.edit', compact('detail', 'meta', 'tabList', 'tabSelected'));
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
            'slug' => 'required|unique:articles,slug,'.$dataArr['id'],
        ],
        [            
            'name.required' => 'Bạn chưa nhập tên dự án',
            'slug.required' => 'Bạn chưa nhập slug',
            'slug.unique' => 'Slug đã được sử dụng.'
        ]);       
        
        if($dataArr['image_url'] && $dataArr['image_name']){
            
            $tmp = explode('/', $dataArr['image_url']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }
            if(!is_dir('uploads/thumbs/projects/'.date('Y/m/d'))){
                mkdir('uploads/thumbs/projects/'.date('Y/m/d'), 0777, true);
            }
            if(!is_dir('uploads/thumbs/projects/306x194/'.date('Y/m/d'))){
                mkdir('uploads/thumbs/projects/306x194/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('moigioi.upload_path').$dataArr['image_url'], config('moigioi.upload_path').$destionation);            
            $img = Image::make(config('moigioi.upload_path').$destionation);
                            $w_img = $img->width();
                            $h_img = $img->height();
            $tile2 = 0.06232734;
            $w_tile2 = $w_img/306;
            $h_tile2 = $h_img/194;
         
            if($w_tile2- $h_tile2 <= $tile2){
                Image::make(config('moigioi.upload_path').$destionation)->resize(306, null, function ($constraint) {
                        $constraint->aspectRatio();
                })->crop(306, 194)->save(config('moigioi.upload_thumbs_path_projects').'306x194/'.$destionation);
            }else{
                Image::make(config('moigioi.upload_path').$destionation)->resize(null, 194, function ($constraint) {
                        $constraint->aspectRatio();
                })->crop(306, 194)->save(config('moigioi.upload_thumbs_path_projects').'306x194/'.$destionation);
            }           
            $dataArr['image_url'] = $destionation;
        }
        if($dataArr['logo_url'] && $dataArr['logo_name']){
            
            $tmp = explode('/', $dataArr['logo_url']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }
            if(!is_dir('uploads/thumbs/projects/'.date('Y/m/d'))){
                mkdir('uploads/thumbs/projects/'.date('Y/m/d'), 0777, true);
            }            
            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('moigioi.upload_path').$dataArr['logo_url'], config('moigioi.upload_path').$destionation);                       
           
            $dataArr['logo_url'] = $destionation;
        }
        $dataArr['updated_user'] = Auth::user()->id;
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;  
        //$dataArr['status'] = isset($dataArr['status']) ? 1 : 0;  
        $model = LandingProjects::find($dataArr['id']);

        $model->update($dataArr);

        $this->storeMeta( $dataArr['id'], $dataArr['meta_id'], $dataArr);

        ProjectTab::where(['project_id' => $dataArr['id']])->delete();
        // xu ly tags
        if( !empty( $dataArr['tab'] ) ){
                       
            foreach ($dataArr['tab'] as $tab_id) {
                $model = new ProjectTab; 
                $model->project_id = $dataArr['id'];
                $model->tab_id  = $tab_id;                
                $model->save();
            }
        }
        Session::flash('message', 'Cập nhật dự án thành công');        
        return redirect()->route('landing-projects.edit', $dataArr['id']);
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
        $model = LandingProjects::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa dự án thành công');
        return redirect()->route('landing-projects.index');
    }
}
