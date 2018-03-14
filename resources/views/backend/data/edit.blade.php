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
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('data.index') }}">Khách hàng</a></li>
      <li class="active">Chỉnh sửa </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('data.index') }}" style="margin-bottom:5px">Quay lại</a>     
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Chỉnh sửa
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" method="POST" action="{{ route('data.update') }}" id="formData">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $detail->id }}">
            <input type="hidden" name="type" value="{{ $detail->type }}">
            <div class="box-body">
              @if(Session::has('message'))
              <p class="alert alert-info" >{{ Session::get('message') }}</p>
              @endif
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif                                      
               <!-- text input -->
              <div class="form-group">
                <label>Họ tên khách<span class="red-star">*</span></label>
                <input type="text" class="form-control"  name="name" id="name" value="{{ $detail->name }}">
              </div>             
              <div class="form-group">
                <label>Số điện thoại<span class="red-star">*</span></label>
                <input type="text" class="form-control"  name="phone" id="phone" value="{{ $detail->phone }}">
              </div>
              <div class="form-group">
                <label>Địa chỉ<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="address" id="address" value="{{ $detail->address }}">
              </div>
              <div class="form-group col-md-6">
                <label>Loại BĐS</label>
                 <input type="text" class="form-control" name="loai_bds" id="loai_bds" value="{{ $detail->loai_bds }}">
              </div>
              <div class="form-group col-md-6">
                <label>Pháp lý</label>
                 <input type="text" class="form-control" name="loai_so" id="loai_so" value="{{ $detail->loai_so }}">
              </div> 
              <div class="form-group col-md-6">
                <label>Diện tích</label>
                 <input type="text" class="form-control" name="dien_tich" id="dien_tich" value="{{ $detail->dien_tich }}">
              </div>
              <div class="form-group col-md-6">
                <label>Giá</label>
                 <input type="text" class="form-control" name="gia" id="gia" value="{{ $detail->gia }}">
              </div>
              <div class="form-group col-md-6">
                <label>Hướng</label>
                 <input type="text" class="form-control" name="huong" id="huong" value="{{ $detail->huong }}">
              </div>
              <div class="form-group col-md-6">
                <label>Số lầu</label>
                 <input type="text" class="form-control" name="so_lau" id="so_lau" value="{{ $detail->so_lau }}">
              </div>
              <div class="form-group col-md-6">
                <label>Số phòng</label>
                 <input type="text" class="form-control" name="so_phong" id="so_phong" value="{{ $detail->so_phong }}">
              </div>
              <div class="form-group col-md-6">
                <label>Số toilet</label>
                 <input type="text" class="form-control" name="so_toilet" id="so_toilet" value="{{ $detail->so_toilet }}">
              </div>
              <div class="form-group">
                <label>Đường trước nhà</label>
                 <input type="text" class="form-control" name="duong_truoc_nha" id="duong_truoc_nha" value="{{ $detail->duong_truoc_nha }}">
              </div>
              <div class="form-group">
                <label>Ngày gặp</label>
                 <input type="text" class="form-control" name="ngay_gap" id="ngay_gap" value="{{ $detail->ngay_gap }}">
              </div>
              @if($role <= 2)
              <div class="form-group">
                  <label>Trạng thái</label>              
                  <select class="form-control" name="status_1" id="status_1">                      
                      <option value="1" {{ $detail->status_1 == 1 ? "selected" : "" }}>Chưa gọi</option>
                      <option value="2" {{ $detail->status_1 == 2 ? "selected" : "" }}>Đang gọi</option>
                      <option value="3" {{ $detail->status_1 == 3 ? "selected" : "" }}>Đã gọi</option>
                  </select>
                </div>

              <div class="form-group">
                  <label style="margin: 20px;color:red"><input type="checkbox" name="moigioi" value="1">MÔI GIỚI</label>
                </div>    
              @elseif($role == 3)
              <div class="form-group">
                  <label>Trạng thái</label>              
                  <select class="form-control" name="status_2" id="status_2">                      
                      <option value="1" {{ $detail->status_2 == 1 ? "selected" : "" }}>Chưa gặp</option>
                      <option value="2" {{ $detail->status_2 == 2 ? "selected" : "" }}>Không gặp được</option>
                      <option value="3" {{ $detail->status_2 == 3 ? "selected" : "" }}>Không chốt được</option>
                      <option value="4" {{ $detail->status_2 == 4 ? "selected" : "" }}>Đã chốt</option>
                  </select>
              </div>
              @endif
            <!-- /.box-body -->    
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('data.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5"></div>
     
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<style type="text/css">
  .checkbox+.checkbox, .radio+.radio{
    margin-top: 10px !important;
  }
</style>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
 
@stop

@section('js')
<script type="text/javascript" src="{{ URL::asset('public/assets/js/datetimepicker.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.datetime').datetimepicker({
        format:'d-m-Y H:i',                
      });
    @if($role == 3 && $detail->status_2 != 4)
        $('form input[type="text"]').attr('readonly', 'readonly').removeAttr('id');
        @endif
  });
</script>
@stop
