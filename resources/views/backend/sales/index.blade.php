@extends('backend.layout')
@section('content')
<?php 
$role = Auth::user()->role;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Khách hàng 
           @if(!empty($detailProduct))
           : <span style="color:blue">{{ $detailProduct->title }}</span>
           @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route( 'sales.index' ) }}">Khách hàng</a></li>
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
                <!--<a href="{{ route('sales.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>-->
                @if($role <= 5)
                <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">Bộ lọc</h3>
                      </div>
                      <div class="panel-body">
                        <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('sales.index') }}">   
                            @if($role != 2 && $role != 3)
                            <div class="form-group">              
                              <select class="form-control" name="type_sale" id="type_sale">
                                  <option value="">--Hình thức bán--</option>
                                  <option value="1" {{ $type_sale == 1 ? "selected" : "" }}>Bán trực tiếp</option>
                                  <option value="2" {{ $type_sale == 2 ? "selected" : "" }}>Để lại số điện thoại</option>
                              </select>
                            </div>  
                            @else
                            <input type="hidden" name="type_sale" value="2">
                            @endif
                            @if($role == 2)
                            <div class="form-group">              
                              <select class="form-control" name="cskh_status" id="cskh_status">
                                  <option value="">--Trạng thái--</option>
                                  <option value="1" {{ $cskh_status == 1 ? "selected" : "" }}>Chưa gọi</option>
                                  <option value="2" {{ $cskh_status == 2 ? "selected" : "" }}>Đang gọi</option>
                                  <option value="3" {{ $cskh_status == 3 ? "selected" : "" }}>Đã lọc</option>
                                  <option value="4" {{ $cskh_status == 4 ? "selected" : "" }}>Đã khóa</option>
                              </select>
                            </div>  
                            @endif
                            @if($role == 3)
                            <div class="form-group">              
                              <select class="form-control" name="pr_status" id="pr_status">
                                  <option value="">--Trạng thái--</option>
                                  <option value="1" {{ $pr_status == 1 ? "selected" : "" }}>Chưa chăm sóc</option>
                                  <option value="2" {{ $pr_status == 2 ? "selected" : "" }}>Đang chăm sóc</option>
                                  <option value="4" {{ $pr_status == 4 ? "selected" : "" }}>Không thành công</option>
                              </select>
                            </div>  
                            @endif <!--$role == 3-->
                            @if(in_array($role, [1,6]))
                            @if($prList->count() > 0)
                            <div class="form-group">              
                              <select class="form-control" name="pr_id" id="pr_id">
                                  <option value="">--CTV--</option>
                                  @foreach($prList as $ctv)
                                  <option value="{{ $ctv->id }}" {{ $ctv->id == $pr_id ? "selected" : "" }}>{{ $ctv->full_name }}</option>
                                  @endforeach
                              </select>
                            </div> 
                            @endif   <!--$ctvList->count() > 0-->
                            @endif
                            @if(in_array($role, [1,2,4]))
                            @if($ctvList->count() > 0)
                            <div class="form-group">              
                              <select class="form-control" name="ctv_id" id="ctv_id">
                                  <option value="">--CTV--</option>
                                  @foreach($ctvList as $ctv)
                                  <option value="{{ $ctv->id }}" {{ $ctv->id == $ctv_id ? "selected" : "" }}>{{ $ctv->full_name }}</option>
                                  @endforeach
                              </select>
                            </div> 
                            @endif   <!--$ctvList->count() > 0-->
                              @endif
                            <div class="form-group">              
                              <input type="text" name="keyword" value="{{ $arrSearch['keyword'] }}" class="form-control" placeholder="Số ĐT hoặc CMND">
                            </div> 
                             <!-- check lon hon CTV-->                          
                            <button style="margin-top:-5px;" type="submit" class="btn btn-primary btn-sm">Lọc</button>
                        </form>
                        </div></div>

                        @endif
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
                      <td>{{ $hen->info->full_name }}</td>
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
                                @if($role == 4)
                                <th>Hình thức bán</th>
                                <th>CTV</th>
                                @else
                                <th>Khách hàng</th>
                                <th>Số điện thoại</th>
                                @endif
                                <th>Sản phẩm</th>                                
                                @if($type_sale == 2 && $role < 3)
                                <th>PR</th>
                                @endif
                                <th width="180px" class="text-center">Trạng thái</th>
                                <th width="">Trạng thái GD</th>
                                <th width="120px">Ngày tham gia</th>
                                @if(in_array($role, [3,4,5]))
                                <th class="text-right">Hoa hồng                                
                                </th>
                                @endif
                                <th width="1%;white-space:nowrap">Thao tác</th>
                                
                            </tr>
                            <tbody>
                                @if( $items->count() > 0 )
                                <?php $i = 0; ?>
                                @foreach( $items as $item )
                                <?php $i ++; ?>
                                <tr id="row-{{ $item->id }}">
                                    <td><span class="order">{{ $i }}</span>
                                    </td>
                                    @if($role != 4)
                                    <td>
                                      @if($item->type_sale == 2)
                                      {{ $item->full_name }}
                                      @else
                                      BÁN TRỰC TIẾP
                                      @endif
                                      
                                    </td>
                                    <td>{{ $item->phone }}
                                      @if( ($role == 2 || $role == 3 ) && $item->type_sale == 2)
                                      
                                        @if($item->cskh_status < 3)                                        
                                        <button type="button" class="btn btn-info tao-lich-hen btn-sm"  title="Tạo lịch hẹn" data-value="{{ $item->id }}" data-toggle="modal" data-target="#lichModal">Lịch hẹn <span class="badge">({{ $item->hen($item->id)->count() }})</span></button>
                                        @endif <!--item->cskh_status < 3-->
                                        @if($item->cskh_status == 3 && $item->pr_status < 3 && $role == 3)
                                        <button type="button" class="btn btn-info tao-lich-hen btn-sm"  title="Tạo lịch hẹn" data-value="{{ $item->id }}" data-toggle="modal" data-target="#lichModal">Lịch hẹn <span class="badge">({{ $item->hen($item->id)->count() }})</span></button>
                                        @endif
                                      @endif
                              
                                    <!--if pr status != 3-->
                                    </td>
                                    @else
                                    <td style="white-space:nowrap;">
                                      @if($item->type_sale == 1)
                                      Bán trực tiếp
                                      @else
                                      Để lại số điện thoại
                                      @endif
                                    </td>
                                    <td style="white-space:nowrap;">
                                      <a href="{{ route('sales.index', ['ctv_id' => $item->ctv_id])}}" target="_blank">{{ $item->ctv->full_name }}
                                    </td>
                                    @endif
                                
                                      
                                
                                    <td>{{ $item->product->title }}
                                    @if($item->status_sales == 1)
                                    <span class="label label-info">Chưa bán</span>
                                    @elseif($item->status_sales == 2)
                                    <span class="label label-danger">Đã bán</span>
                                    @elseif($item->status_sales == 3)
                                    <span class="label label-warning">Đã cọc</span>
                                    @endif
                                    @if($item->notes)
                                    <br/><u>Ghi chú :</u> 
                                    <span style="font-style:italic">{{ $item->notes }}</span>
                                    @endif

                                    </td>                                   
                                  
                                    
                                    @if($type_sale == 2 && $role < 3)
                                    <td style="white-space:nowrap">
                                        @if($item->pr)
                                        {{ $item->pr->full_name }}
                                        @endif
                                    </td>
                                    @endif
                                    <td class="text-center">
                                    @if($role == 2 && $item->type_sale == 2)
                                      @if( $item->cskh_status == 1)
                                      Chưa gọi
                                      @elseif( $item->cskh_status == 2)
                                      Đang gọi
                                      @elseif($item->cskh_status == 3)
                                      Đã lọc
                                      @elseif($item->cskh_status == 4)
                                      Đã khóa
                                      @endif                                    
                                    @endif
                                    @if($role == 3)
                                      @if( $item->pr_status == 1)
                                        Chưa chăm sóc
                                        @elseif( $item->pr_status == 2)
                                        Đang chăm sóc
                                        @elseif($item->pr_status == 4)
                                        Không thành công
                                      @endif                                      
                                    @endif

                                    @if($role == 4 && $item->type_sale == 1)
                                    @if( $item->status_join == 1)
                                        Chưa duyệt
                                        @elseif( $item->status_join == 2)
                                        Đã duyệt
                                      @endif                                       
                                    @endif
                                    @if($role == 5 && $item->type_sale == 1)
                                    @if($item->status_join == 1)
                                    <span class="label label-danger">Chưa duyệt</span>
                                    @else
                                    <span class="label label-success">Đã duyệt</span>
                                    @endif
                                    @endif
                                    </td>                                   
                                    <td>
                                        @if($item->is_close == 0)
                                            <span class="label label-info">Đang mở</span>
                                            <br>
                                        @else
                                            @if($item->is_success == 0)
                                            <span class="label label-danger">Đã đóng</span>
                                            <br>
                                            @endif
                                        @endif
                                        
                                        @if($item->is_success == 1)
                                            <span class="label label-success">GD thành công</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($item->created_at)) }}
                                    </td>
                                    @if(in_array($role, [3, 4, 5]))
                                    <td class="text-right" style="font-weight:bold;">

                                      @if($item->is_success == 0)
                                        <?php
                                        if($role == 5){
                                          $phantram = $item->product->hoa_hong_ctv;
                                        }elseif( $role == 4 ){
                                          $phantram = $item->product->hoa_hong_cs;
                                        }elseif( $role == 3 ){
                                          $phantram = $item->product->hoa_hong_pr;
                                        }
                                        ?>
                                        @if($item->type_sale == 1 || $role == 4 || $role == 3)
                                        {{ number_format($phantram*$item->product->hoa_hong*$item->product->price/100/100) }}
                                        @else
                                        {{ number_format(($item->product->hoa_hong*$phantram*$item->product->price/100/100)) }}
                                        @endif
                                      @else
                                        @if($role == 5)
                                        {{ number_format($item->hh_ctv) }}
                                        @elseif($role == 4)
                                        {{ number_format($item->hh_cs) }}
                                        @elseif($role == 3)
                                        {{ number_format($item->hh_pr) }}
                                        @endif                                      
                                      @endif <!--GD da dong va thanh cong-->
                                    </td>
                                    @endif
                                    <td style="white-space:nowrap; text-align:right">
                                        @if($type_sale == 2)
                                        <a href="{{ route( 'sales.detail', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-info">Chi tiết</a>
                                        @endif
                                        @if($role == 1 || $role == 6)
                                            @if($item->is_close == 1 && $item->is_success == 0)
                                            <button data-table="ctv_join_sale" data-col="is_success" data-id="{{ $item->id }}" class="btn-sm btn btn-success btnSuccess">GD thành công</button>
                                            @endif
                                        @endif
                                        
                                        @if($item->type_sale == 2 && $role != 4 && $item->is_close == 0 && $role !=5|| ($item->status_join == 1 && $item->type_sale == 1))
                                        <a href="{{ route( 'sales.edit', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
                                        @endif
                                        @if($role ==1)
                                        <a onclick="return callDelete('{{ $item->full_name }}','{{ route( 'sales.destroy', [ 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
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
        $('#type_sale, #cskh_status, #pr_status, #ctv_id').change(function(){    
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