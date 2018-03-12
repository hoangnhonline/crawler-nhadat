@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Công việc
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'user-work.index' ) }}">Công việc</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('user-work.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('user-work.index') }}">  <div class="form-group">
            @if($userList && Auth::user()->role > 1)
              <div class="form-group">
                <label>Editor</label>                
                <?php $i = 0; ?>
                <select class="form-control" name="created_user" id="created_user">
                  <option value="">Tất cả</option>
                  @foreach($userList as $us)
                  <option value="{{ $us->id }}" {{ $s['created_user'] == $us->id ? "selected" : "" }}>{{ $us->full_name }}</option> 
                  <?php $i++; ?>
                  @endforeach
                </select>
                <div class="clearfix"></div>
            </div>     
            @endif
            <div class="form-group">
              <select class="form-control" name="status" id="status">
                <option value="">--Trạng thái--</option>
                 <option value="1" {{ $s['status'] == 1 ? "selected" : "" }}>Chưa duyệt</option>
                 <option value="2" {{ $s['status'] == 2 ? "selected" : "" }}>Đã duyệt</option>
              </select>
            </div>          
            <div class="form-group">
              <select class="form-control" name="group_id" id="group_id">
                <option value="" >--Nhóm công việc--</option>
                   @foreach( $groupList as $value )
                    <option value="{{ $value->id }}"
                    {{ $s['group_id'] == $value->id ? "selected" : "" }}                           

                    >{{ $value->name }}</option>
                    @endforeach                
              </select>
            </div>  
            <div class="form-group">              
              <input type="text" class="form-control datepicker" placeholder="Từ ngày" name="date_from" value="{{ $s['date_from'] }}">
            </div> 
            <div class="form-group">              
              <input type="text" class="form-control datepicker" placeholder="Đến ngày" name="date_to" value="{{ $s['date_to'] }}">
            </div>                         
            <button type="submit" class="btn btn-default btn-sm">Lọc</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value">{{ $items->total() }} công việc )</span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
            {{ $items->appends( $s )->links() }}
          </div>  
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>              
              <th width="120px">Ngày</th>
              <th width="120px">Nhân viên</th>
              <th>Mô tả</th>
              <th>Nhận xét</th>
              <th>Trạng thái</th>
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )

              <?php $i = 0; ?>
              @foreach( $items as $item )           
                <?php $i ++; ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>       
                <td style="white-space:nowrap">
                   @if( $item->is_hot == 1 )
                  <img class="img-thumbnail" src="{{ URL::asset('public/admin/dist/img/star.png')}}" alt="Ưu tiên" title="Ưu tiên" />
                  @endif 
                  <br>
                  {{ date('d-m-Y', strtotime($item->work_date)) }}

                  
                </td>    
                <td style="white-space:nowrap"><h4>{{ $item->full_name }}</h4></td>    
                <td>                                    
                  <p><?php echo $item->description; ?></p>
                </td>
                <td><?php echo $item->leader_comment; ?></td>
                <td>                  
                {{ $item->status == 1 ? "Mới" : ( $item->status == 2  ? "Đã duyệt" : "Không duyệt")  }}
                </td>
                <td style="white-space:nowrap">                          
                  @if(Auth::user()->role == 1)
                    @if($item->status == 1)
                    <a href="{{ route( 'user-work.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>                 
                    
                    <a onclick="return callDelete('{{ $item->title }}','{{ route( 'user-work.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                    @endif
                  @else
                  <a href="{{ route( 'user-work.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>                 
                  
                  <a onclick="return callDelete('{{ $item->title }}','{{ route( 'user-work.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                  @endif                  
                  
                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
          <div style="text-align:center">
            {{ $items->appends( $s )->links() }}
          </div>  
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
@stop
@section('js')

<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: 'Bạn muốn xóa "' + name +'"?',
    text: "Dữ liệu sẽ không thể phục hồi.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then(function() {
    location.href= url;
  })
  return flag;
}
$(document).ready(function(){
 $('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
  $('.select2').select2();
  $('#status, #created_user, #group_id').change(function(){
    $(this).parents('form').submit();
  });
  
});
</script>
@stop