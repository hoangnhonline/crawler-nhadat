@extends('backend.layout')
@section('content')
<?php 
$role = Auth::user()->role;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Dữ liệu          
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route( 'data.index' ) }}">Dữ liệu</a></li>
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
                @if(Auth::user()->role == 2)
                <a href="{{ route('data.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Thêm chính chủ</a>
                @endif
                <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">Bộ lọc</h3>
                      </div>
                      <div class="panel-body">
                        <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('data.index') }}">   
                             <div class="form-group">              
                              <select class="form-control" name="type" id="type">
                                  <option value="">--Hình thức--</option>
                                  <option value="1" {{ $type == 1 ? "selected" : "" }}>Bán</option>
                                  <option value="2" {{ $type == 2 ? "selected" : "" }}>Cho thuê</option>
                              </select>
                            </div>  
                            @if($role < 3)
                             <div class="form-group">              
                              <select class="form-control" name="moigioi" id="moigioi">
                                  <option value="">--Phân loại--</option>
                                  <option value="1" {{ $moigioi == 1 ? "selected" : "" }}>Môi giới</option>
                                  <option value="2" {{ $moigioi == 2 ? "selected" : "" }}>Chính chủ</option>
                              </select>
                            </div>  
                            
                            
                            
                            <div class="form-group">              
                              <select class="form-control" name="site_id" id="site_id">
                                  <option value="">--Site nguồn--</option>
                                  <option value="1" {{ $site_id == 1 ? "selected" : "" }}>muaban.net</option>
                                  <option value="2" {{ $site_id == 2 ? "selected" : "" }}>batdongsan.com.vn</option>
                                  <option value="3" {{ $site_id == 3 ? "selected" : "" }}>muabannhadat.vn</option>
                                  <option value="4" {{ $site_id == 4 ? "selected" : "" }}>nhadatnhanh.vn</option>
                              </select>
                            </div>  
                            @endif
                            @if($role == 2)
                            <div class="form-group">              
                              <select class="form-control" name="status_1" id="status_1">
                                  <option value="">--Trạng thái--</option>
                                  <option value="1" {{ $status_1 == 1 ? "selected" : "" }}>Chưa gọi</option>
                                  <option value="2" {{ $status_1 == 2 ? "selected" : "" }}>Đang gọi</option>
                                  <option value="3" {{ $status_1 == 3 ? "selected" : "" }}>Đã gọi</option>
                              </select>
                            </div>  
                            @endif <!--$role == 3-->
                            @if($role == 3)
                            <div class="form-group">                                     
                              <select class="form-control" name="status_2" id="status_2">  
                                  <option value="">--Trạng thái--</option>                    
                                  <option value="1" {{ $status_2 == 1 ? "selected" : "" }}>Chưa gặp</option>
                                  <option value="2" {{ $status_2 == 2 ? "selected" : "" }}>Không gặp được</option>
                                  <option value="3" {{ $status_2 == 3 ? "selected" : "" }}>Không chốt được</option>
                                  <option value="4" {{ $status_2 == 4 ? "selected" : "" }}>Đã chốt</option>
                                  <option value="5" {{ $status_2 == 5 ? "selected" : "" }}>Đã hoàn thành</option>
                              </select>
                          </div>
                            @endif
                             @if($role == 4)
                            <div class="form-group">              
                              <select class="form-control" name="status_3" id="status_3">
                                  <option value="">--Trạng thái--</option>
                                  <option value="1" {{ $status_3 == 1 ? "selected" : "" }}>Đã hoàn thành</option>
                                  <option value="2" {{ $status_3 == 2 ? "selected" : "" }}>Chưa hoàn thành</option>
                              </select>
                            </div>  
                            @endif <!--$role == 3-->
                            <div class="form-group">              
                              <input type="text" name="keyword" value="{{ $arrSearch['keyword'] }}" class="form-control" placeholder="Số điện thoại">
                            </div> 
                             <!-- check lon hon CTV-->                          
                            <button style="margin-top:-5px;" type="submit" class="btn btn-primary btn-sm">Lọc</button>
                        </form>
                        </div></div>
                        
                @if($henList->count() > 0)
                <div class="panel panel-warning" style="padding: 10px">
                  <h4>Các cuộc hẹn hôm nay:</h4>
                  <table class="table table-bordered">
                    <tr>
                      <th>Khách hàng</th>
                      <th>Điện thoại</th>
                      <th>Ghi chú</th>
                    </tr>
                    @foreach($henList as $hen)
                    <tr>
                      <td>{{ $hen->info->name }}</td>
                      <td>{{ $hen->info->phone }}</td>
                      <td>{{ $hen->ghi_chu }}</td>
                    </tr>
                    @endforeach
                    
                  </table>
                </div>
                @endif
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách ( {{ $items->total() }} )</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div style="text-align:center">
                       {{ $items->appends( $arrSearch )->links() }}
                      </div> 
                        <table class="table table-bordered" id="table-list-data">
                            <tr>
                                <th style="width: 1%">#</th>                                
                                <th style="white-space:nowrap">Hình thức</th>
                                <th style="white-space:nowrap">Phân loại</th>
                                <th>Số điện thoại</th>
                                @if($role == 4)  
                                <th>Hình ảnh</th>                       
                                @endif
                                <th>Tin rao</th>
                                <th width="180px" class="text-center">Trạng thái</th>                                
                                <th width="120px">Ngày crawler</th>
                               
                                <th width="1%;" style="white-space:nowrap">Thao tác</th>
                                
                            </tr>
                            <tbody>
                                @if( $items->count() > 0 )
                                <?php $i = 0; ?>
                                @foreach( $items as $item )
                                <?php $i ++; ?>
                                <tr id="row-{{ $item->id }}">
                                    <td><span class="order">{{ $i }}</span>
                                    </td>
                                   
                                    <td style="white-space:nowrap">
                                      @if($item->type == 2)
                                      CHO THUÊ
                                      @else
                                      BÁN
                                      @endif
                                      
                                    </td>
                                    <td style="white-space:nowrap">
                                      @if($item->moigioi == 2)
                                      <span style="color:blue">CHÍNH CHỦ</span>
                                      @else
                                      MÔI GIỚI
                                      @endif
                                    </td>
                                    <td>
                                      {!! $item->name."<br>" !!}
                                      {{ $item->phone }}                                      
                                        @if($item->status_1 != 1 && $item->status_2 < 4 ) 
                                        <button type="button" class="btn btn-info tao-lich-hen btn-sm"  title="Tạo lịch hẹn" data-value="{{ $item->id }}" data-toggle="modal" data-target="#lichModal">Lịch hẹn <span class="badge">({{ $item->hen($item->id)->count() }})</span></button>
                                        @endif        
                              
                                    <!--if pr status != 3-->
                                    </td>
                                    @if($role == 4)
                                    <td>
                                       <img class="img-thumbnail lazy" width="80" data-original="{{ $item->image_url ? Helper::showImage($item->image_url) : URL::asset('public/admin/dist/img/no-image.jpg') }}" alt="Nổi bật" title="Nổi bật" />
                                    </td>
                                    @endif
                                
                                    <td>
                                      <a href="{{ $item->url }}" target="_blank">{{ $item->tieu_de }}</a>
                                      <br>
                                      <p>{{ $item->gia }} - {{ $item->dien_tich }}             </p>
                                    @if($item->notes)
                                    <br/><u>Ghi chú :</u> 
                                    <span style="font-style:italic">{{ $item->notes }}</span>
                                    @endif

                                    </td>
                                    
                                    <td class="text-center">
                                      @if($role == 2)
                                        @if($item->status_1 == 1)
                                          Chưa gọi
                                        @elseif($item->status_1 == 2)
                                          Đang gọi
                                        @else
                                          Đã gọi
                                        @endif
                                      @endif

                                      @if($role == 3)
                                        @if($item->status_2 == 1)
                                          Chưa gặp
                                        @elseif($item->status_2 == 2)
                                          Không gặp được
                                        @elseif($item->status_2 == 3)
                                          Không chốt được
                                        @elseif($item->status_2 == 4)
                                          Đã chốt
                                        @else
                                          Đã hoàn thành
                                        @endif
                                      @endif

                                      @if($role == 4)
                                        @if($item->status_3 == 0)
                                         
                                        @else
                                          Đã hoàn thành
                                        @endif
                                      @endif
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($item->created_at)) }}
                                    </td>                             
                                    <td style="white-space:nowrap; text-align:right">
                                       
                                        <a href="{{ route( 'data.detail', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-info">Chi tiết</a>
                                        @if($item->status_2 == 5 && $role == 4)
                                        <a href="{{ route( 'data.upload', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-warning">Hình ảnh + video</a>                                       
                                        @endif
                                          @if($role != 2 && $item->status_2 == 4)                                    
                                            <button data-table="crawl_data" data-col="status_2" data-id="{{ $item->id }}" class="btn-sm btn btn-success btnSuccess">Hoàn thành</button>@endif                                
                                         @if($role == 4 && $item->status_3 == 2)                                    
                                            <button data-table="crawl_data" data-col="status_3" data-id="{{ $item->id }}" class="btn-sm btn btn-success btnDone">Hoàn thành</button>@endif 
                                        @if($item->moigioi == 2 && $item->status_2 != 5 && $item->status_3 != 1)
                                        <a href="{{ route( 'data.edit', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>                                       
                                        @endif
                                        
                                        @if($item->status_2 != 5  && $item->status_3 != 1)
                                        <a onclick="return callDelete('{{ $item->name }}','{{ route( 'data.destroy', [ 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
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
                       {{ $items->appends( $arrSearch )->links() }}
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
<style type="text/css">
    .pagination{
        margin:0px !important;
    }
</style>
<div id="lichModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tạo lịch hẹn</h4>
      </div>
      <form action="{{ route('hen.store') }}" method="POST" id="formHen">
      <div class="modal-body">
        
            <input type="hidden" name="join_id" id="join_id" value="">
            <div class="form-group col-md-5">
              <label>Ngày hẹn<span class="red-star">*</span></label>
              <input type="text" class="form-control datepicker" name="ngay_hen" id="ngay_hen" value="">
            </div>           
            <div class="form-group col-md-7" >
              <label>Ghi chú</label>
              <textarea class="form-control" rows="2" name="ghi_chu" id="ghi_chu"></textarea>
            </div>
            <div id="load-lich-hen" style="margin-top:20px">
                
            </div>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-primary btn-sm btnSaveHen" >Save</button>
        <button type="button" class="btn btn-default  btn-sm" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
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
        $('#type, #moigioi, #status_1, #status_3, #site_id, #status_2').change(function(){    
          $('#searchForm').submit();
        });  

        $('.datepicker').datepicker({
        dateFormat : 'dd-mm-yy'
      });
        $('.tao-lich-hen').click(function(){
            var join_id = $(this).data('value');
            $('#join_id').val(join_id);
            $.ajax({
                  url: "{{ route('hen.ajax-list') }}",
                  type: "GET",
                  async: false,
                  data: {
                      join_id : join_id
                  },
                  success: function(data){
                     $('#load-lich-hen').html(data);                    
                  }
              });
        });
      $('.change-status').change(function(){
          if(confirm('Bạn chắc chắn chuyển trạng thái của thông tin này ?')){
            var col = $(this).data('col');
            var table = $(this).data('table');
            var id = $(this).data('id');
            var status = $(this).val();
            $.ajax({
                  url: "{{ route('update-status') }}",
                  type: "POST",
                  async: false,
                  data: {          
                      col : col,
                      table : table,
                      id : id,
                      status : status
                  },
                  success: function(data){
                      window.location.reload();                     
                  }
              });
          }else{
            $(this).val($(this).data('old'));
          }

      });
      $('.btnSuccess').click(function(){
            if(confirm('Bạn có chắc chắn không?')){
                var col = $(this).data('col');
                var table = $(this).data('table');
                var id = $(this).data('id');
                var status = 5;
                $.ajax({
                      url: "{{ route('update-status') }}",
                      type: "POST",
                      async: false,
                      data: {          
                          col : col,
                          table : table,
                          id : id,
                          status : status
                      },
                      success: function(data){                        
                          window.location.reload();                     
                      }
                  });
            }
      });
      $('.btnDone').click(function(){
            if(confirm('Bạn có chắc chắn không?')){
                var col = $(this).data('col');
                var table = $(this).data('table');
                var id = $(this).data('id');
                var status = 1;
                $.ajax({
                      url: "{{ route('update-status') }}",
                      type: "POST",
                      async: false,
                      data: {          
                          col : col,
                          table : table,
                          id : id,
                          status : status
                      },
                      success: function(data){                        
                          window.location.reload();                     
                      }
                  });
            }
      });
      $('.btnSaveHen').click(function(){
        if($('#ngay_hen').val()== ''){
            alert('Chưa nhập ngày hẹn.');
            return false;
        }
        $.ajax({
          url: "{{ route('hen.store') }}",
          type: "POST",
          async: false,
          data: $('#formHen').serialize(),
          success: function(data){
             window.location.reload();                     
          }
      });
      });
    });
    
</script>
@stop