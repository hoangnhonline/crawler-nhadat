<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ArticlesCate;
use App\Models\Tag;
use App\Models\TagObjects;
use App\Models\LandingProjects;
use App\Models\Articles;
use App\Models\MetaData;

use Helper, File, Session, Auth, Image;

class ProContentController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {

        $cate_id = 999; // project

        $project_id = $request->project_id;
        $tabList = LandingProjects::getListTabProject($project_id);       
        $query = Articles::where(['cate_id' => $cate_id, 'project_id' => $project_id]);
        $projectDetail = LandingProjects::find($project_id);
        // check editor
        if( Auth::user()->role > 1 ){
            $query->where('created_user', Auth::user()->id);
        }
        
        $items = $query->orderBy('id', 'desc')->paginate(20);
        
        return view('backend.pro-content.index', compact( 'items', 'tabList', 'project_id', 'projectDetail'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        
        $project_id = $request->project_id;
        $tabList = LandingProjects::getListTabProject($project_id);  
        
        $projectDetail = LandingProjects::find($project_id);
        return view('backend.pro-content.create', compact( 'project_id', 'tabList', 'projectDetail'));
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
            'tab_id' => 'required',            
            'title' => 'required'            
        ],
        [            
            'tab_id.required' => 'Bạn chưa chọn tab',            
            'title.required' => 'Bạn chưa nhập tiêu đề'            
        ]);       
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['title']);
        $dataArr['slug'] = Helper::changeFileName($dataArr['title']);             
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;
        
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;  

        $rs = Articles::create($dataArr);

        $object_id = $rs->id;       
        $this->storeMeta( $object_id, 0, $dataArr);
        Session::flash('message', 'Tạo mới bài viêt thành công');

        return redirect()->route('pro-content.index',['project_id' => $dataArr['project_id']]);
    }
    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = [ 'title' => $dataArr['meta_title'], 'description' => $dataArr['meta_description'], 'keywords'=> $dataArr['meta_keywords'], 'custom_text' => $dataArr['custom_text'], 'updated_user' => Auth::user()->id ];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;            
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;
            
            $modelSp = Articles::find( $id );
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
        $tagSelected = [];

        $detail = Articles::find($id);
        if( Auth::user()->role > 1 ){
            if($detail->created_user != Auth::user()->id){
                return redirect()->route('dashboard.index');
            }
        }
        $project_id = $detail->project_id;
        $projectDetail = LandingProjects::find($project_id);
        $tabList = LandingProjects::getListTabProject($project_id);
        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }  
        return view('backend.pro-content.edit', compact('detail', 'project_id', 'projectDetail', 'tabList', 'meta'));
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
            'cate_id' => 'required',            
            'title' => 'required'           
        ],
        [            
            'cate_id.required' => 'Bạn chưa chọn danh mục',            
            'title.required' => 'Bạn chưa nhập tiêu đề'            
        ]);       
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['title']);        
       
        $dataArr['updated_user'] = Auth::user()->id;
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;  
        //$dataArr['status'] = isset($dataArr['status']) ? 1 : 0;  
        $model = Articles::find($dataArr['id']);

        $model->update($dataArr);
        
        $this->storeMeta( $dataArr['id'], $dataArr['meta_id'], $dataArr);

        TagObjects::where(['object_id' => $dataArr['id'], 'type' => 2])->delete();
        // xu ly tags
        if( !empty( $dataArr['tags'] ) ){
                       
            foreach ($dataArr['tags'] as $tag_id) {
                $modelTagObject = new TagObjects; 
                $modelTagObject->object_id = $dataArr['id'];
                $modelTagObject->tag_id  = $tag_id;
                $modelTagObject->type = 2;
                $modelTagObject->save();
            }
        }
        Session::flash('message', 'Cập nhật bài viết thành công');        

        return redirect()->route('pro-content.edit', $dataArr['id']);
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
        $model = Articles::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa bài viết thành công');
        return redirect()->route('pro-content.index');
    }
}
