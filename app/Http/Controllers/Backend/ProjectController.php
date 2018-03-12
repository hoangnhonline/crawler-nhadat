<?php

namespace App\Http\Controllers\Backend;

use App\Models\Account;
use App\Models\CtvJoinSale;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\MetaData;
use App\Models\City;
use App\Models\District;

use Helper, File, Session, Auth, Hash, URL, Image;

class ProjectController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {        
        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;        
        $arrSearch['city_id'] = $city_id = isset($request->city_id) ? $request->city_id : null;
        $arrSearch['district_id'] = $district_id = isset($request->district_id) ? $request->district_id : null;       

        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';

        $query = Project::where('project.status', $status);        
        if( $city_id ){
            $query->where('project.city_id', $city_id);
        }
        if( $district_id ){
            $query->where('project.district_id', $district_id);
        }
        
        if( $name != ''){
            $query->where('project.name', 'LIKE', '%'.$name.'%');            
        }

        $query->orderBy('project.id', 'desc');   
        $items = $query->paginate(50);
        
        $cityList = City::all();        
        $districtList = District::where('city_id', $city_id)->where('status', 1)->get();      
      
        return view('backend.project.index', compact( 'items', 'arrSearch', 'cityList', 'districtList'));        
    }
   
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        $city_id = $request->city_id ? $request->city_id : 1;
        $district_id = $request->district_id ? $request->district_id : 2;
        $districtList = District::where('city_id', $city_id)->where('status', 1)->get();       
        return view('backend.project.create', compact('districtList','city_id', 'district_id'));
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
            'district_id' => 'required',
            'city_id' => 'required',            
            'name' => 'required'
        ],
        [   
            'district_id.required' => 'Bạn chưa chọn quận',
            'ward_id.required' => 'Bạn chưa chọn phường',
            'name.required' => 'Bạn chưa nhập tên'            
        ]);          
   
        $dataArr['slug'] = str_slug($dataArr['name']);
        $dataArr['alias'] = str_slug($dataArr['name'], " ");
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;  
        $dataArr['status'] = 1;
        $dataArr['created_user'] = Auth::user()->id;
        $dataArr['updated_user'] = Auth::user()->id;              
        $rs = Project::create($dataArr);

        $product_id = $rs->id;
       
        $this->storeMeta($product_id, 0, $dataArr);
        //$this->processRelation($dataArr, $product_id);
        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('project.index', ['city_id' => $dataArr['city_id']]);
    }
    
    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = ['title' => $dataArr['meta_title'], 'description' => $dataArr['meta_description'], 'keywords'=> $dataArr['meta_keywords'], 'custom_text' => $dataArr['custom_text'], 'updated_user' => Auth::user()->id];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;
            //var_dump(MetaData::create( $arrData ));die;
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;
            //var_dump($meta_id);die;
            $modelSp = Project::find( $id );
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
        $detail = Project::find($id);
              
        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }
        $districtList = District::where('city_id', 1)->where('status', 1)->get();               
        return view('backend.project.edit', compact( 'detail',  'meta', 'districtList'));
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
            'city_id' => 'required',
            'district_id' => 'required',
            'name' => 'required'
        ],
        [   
            'district_id.required' => 'Bạn chưa chọn quận',
            'ward_id.required' => 'Bạn chưa chọn phường',
            'name.required' => 'Bạn chưa nhập tiêu đề'
        ]);                  
        
        $dataArr['slug'] = str_slug($dataArr['name'], "-");
        $dataArr['alias'] = str_slug($dataArr['name'], " ");
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;
       
        $model = Project::find($dataArr['id']);

        $model->update($dataArr);
        
        $product_id = $dataArr['id'];

        $this->storeMeta( $product_id, $dataArr['meta_id'], $dataArr);

        Session::flash('message', 'Chỉnh sửa thành công');

        return redirect()->route('project.edit', $product_id);
        
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
        $model = Project::find($id);        
        $model->delete();        
        // redirect
        Session::flash('message', 'Xóa thành công');
        
        return redirect(URL::previous());//->route('project.short');
        
    } 
}
