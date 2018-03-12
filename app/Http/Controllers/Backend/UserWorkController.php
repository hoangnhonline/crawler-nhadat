<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserWork;
use App\Models\WorkGroup;
use App\Models\Account;

use Helper, File, Session, Auth;

class UserWorkController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $s['status'] = $status = isset($request->status) ? $request->status : null;
        $s['group_id'] = $group_id = isset($request->group_id) ? $request->group_id : null;
        $s['created_user'] = $created_user = isset($request->created_user) ? $request->created_user : null;
        $s['date_from'] = $date_from = isset($request->date_from) && $request->date_from !='' ? $request->date_from : '';
        $s['date_to'] = $date_to = isset($request->date_to) && $request->date_to !='' ? $request->date_to : date('d-m-Y');               

        $query = UserWork::whereRaw('1');
        if( $status ){
            $query->where('user_work.status', $status);
        }        
        if( $group_id ){
            $query->where('group_id', $group_id);
        }
        if( $date_from ){
            $dateFromFormat = date('Y-m-d', strtotime($date_from));
            $query->whereRaw("work_date >= '".$dateFromFormat."'");
        }
        if( $date_to ){
            $dateToFormat = date('Y-m-d', strtotime($date_to));
            $query->whereRaw("work_date <= '".$dateToFormat."'");
        }
        $userList = (object) [];
        if(Auth::user()->role > 1 ){
            $query->where('user_work.created_user', Auth::user()->id);
        }elseif(Auth::user()->role == 2){
            $userIdArr = [];
            $userList = Account::where('role', 1)->join('user_mod', 'user_mod.user_id', '=', 'users.id')
                    ->where('user_mod.mod_id', Auth::user()->id)->get();
            if($userList){
                foreach($userList as $tmp)
                {
                    $userIdArr[] = $tmp->user_id;
                }
            }
            $query->whereIn('user_work.created_user', $userIdArr);            

            if( $created_user > -1){
                $query->where('user_work.created_user', $created_user);
            }

        }else{         
            $userList = Account::where('role', 1)->get();            
            if( $created_user){
                $query->where('user_work.created_user', $created_user);
            }
        }
        $query->join('users', 'users.id', '=', 'user_work.created_user');
        $query->select('user_work.*', 'users.full_name', 'users.role', 'users.email');
        $groupList = WorkGroup::all();
        $query->orderBy('user_work.status', 'asc')->orderBy('is_hot','desc')->orderBy('user_work.id', 'desc');
        $items = $query->orderBy('user_work.work_date', 'DESC')->paginate(20);

        return view('backend.user-work.index', compact( 'items', 's', 'userList', 'groupList'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {        
        $groupList = WorkGroup::all();
        $date_current = date('d-m-Y');
        return view('backend.user-work.create', compact('date_current', 'groupList'));
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
        $user_id = Auth::user()->id;
        $detailUser = Account::find($user_id);
        $this->validate($request,[       
            'group_id' => 'required',     
            'work_content' => 'required',
            'work_date' => 'required',
        ],
        [   
            'group_id.required' => 'Bạn chưa chọn nhóm công việc',             
            'work_content.required' => 'Bạn chưa nhập nội dung',            
            'work_date.required' => 'Bạn chưa nhập ngày làm việc'
        ]);               
        $dataArr['work_date'] = date('Y-m-d', strtotime($dataArr['work_date']));
        
        $dataArr['created_user'] = $dataArr['updated_user'] = $user_id;

        $dataArr['leader_id'] = $detailUser->leader_id;        
        
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;

        $rs = UserWork::create($dataArr);      

        Session::flash('message', 'Tạo mới công việc thành công');

        return redirect()->route('user-work.index');
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
        $groupList = WorkGroup::all();
        $detail = UserWork::find($id);  
        if(!$detail){
            return redirect()->route('dashboard.index');
        }    
        $user_id = $detail->created_user;
        $detailUser = Account::find($user_id);
        return view('backend.user-work.edit', compact('detail', 'detailUser', 'groupList'));
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
        if(Auth::user()->role > 1){
            $this->validate($request,[     
                'group_id' => 'required',       
                'work_content' => 'required',
                'work_date' => 'required',
            ],
            [            
                'group_id.required' => 'Bạn chưa chọn nhóm công việc',
                'work_content.required' => 'Bạn chưa nhập nội dung',            
                'work_date.required' => 'Bạn chưa nhập ngày làm việc'
            ]);               
        }else{
            $this->validate($request,[            
                'leader_comment' => 'required'                
            ],
            [            
                'leader_comment.required' => 'Bạn chưa nhập nhận xét'
            ]);               
        }   

        $dataArr['updated_user'] = Auth::user()->id;
        
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;

        $model = UserWork::find($dataArr['id']);

        $model->update($dataArr);
        
        Session::flash('message', 'Cập nhật công việc thành công');        

        return redirect()->route('user-work.edit', $dataArr['id']);
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
        $model = UserWork::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa công việc thành công');
        return redirect()->route('user-work.index');
    }
}
