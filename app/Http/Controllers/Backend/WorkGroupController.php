<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\WorkGroup;
use Helper, File, Session, Auth;

class WorkGroupController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        if(Auth::user()->role > 1){
            return redirect()->route('dashboard.index');
        }
        $items = WorkGroup::all()->sortBy('display_order');
        return view('backend.work-group.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        if(Auth::user()->role > 1){
            return redirect()->route('dashboard.index');
        }
        return view('backend.work-group.create');
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
            'name.required' => 'Bạn chưa nhập tên nhóm công việc'            
        ]);        
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;

        WorkGroup::create($dataArr);

        Session::flash('message', 'Tạo mới nhóm công việc thành công');

        return redirect()->route('work-group.index');
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
            return redirect()->route('dashboard.index');
        }
        $detail = WorkGroup::find($id);

        return view('backend.work-group.edit', compact( 'detail' ));
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
            'name.required' => 'Bạn chưa nhập tên nhóm công việc'            
        ]);
        
        $model = WorkGroup::find($dataArr['id']);
        
        $dataArr['updated_user'] = Auth::user()->id;

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật nhóm công việc thành công');

        return redirect()->route('work-group.edit', $dataArr['id']);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        if(Auth::user()->role > 1){
            return redirect()->route('dashboard.index');
        }
        // delete
        $model = WorkGroup::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa nhóm công việc thành công');
        return redirect()->route('work-group.index');
    }
}
