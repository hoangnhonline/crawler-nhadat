<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Support;

use Helper, File, Session, Auth, Image;

class SupportController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = Support::all();
        
        return view('backend.support.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {

        return view('backend.support.create');
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
            'phone' => 'required'
        ],
        [            
            'name.required' => 'Bạn chưa nhập tên',            
            'phone.required' => 'Bạn chưa nhập số điện thoại'            
        ]); 
        
        if($dataArr['image_url'] && $dataArr['image_name']){
            
            $tmp = explode('/', $dataArr['image_url']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }         
            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('moigioi.upload_path').$dataArr['image_url'], config('moigioi.upload_path').$destionation);           

            $dataArr['image_url'] = $destionation;
        }        
        $dataArr['display_order'] = Helper::getNextOrder('support');
        $rs = Support::create($dataArr);

        $object_id = $rs->id;

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('support.index');
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

        $detail = Support::find($id);        

        return view('backend.support.edit', compact( 'detail' ));
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
            'phone' => 'required'
        ],
        [            
            'name.required' => 'Bạn chưa nhập tên',            
            'phone.required' => 'Bạn chưa nhập số điện thoại'            
        ]);       
        
        if($dataArr['image_url'] && $dataArr['image_name']){
            
            $tmp = explode('/', $dataArr['image_url']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }           

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('moigioi.upload_path').$dataArr['image_url'], config('moigioi.upload_path').$destionation);            
           
            $dataArr['image_url'] = $destionation;
        }
        
        $model = Support::find($dataArr['id']);

        $model->update($dataArr);        
     
        Session::flash('message', 'Cập nhật thành công');        

        return redirect()->route('support.index');
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
        $model = Support::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('support.index');
    }
}
