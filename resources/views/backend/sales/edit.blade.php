@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Khách hàng
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('sales.index') }}">Khách hàng</a></li>
      <li class="active">Chỉnh sửa </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('sales.index') }}" style="margin-bottom:5px">Quay lại</a>     
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
          <form role="form" method="POST" action="{{ route('sales.update') }}" id="formData">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $detail->id }}">
            <input type="hidden" name="type_sale" value="{{ $detail->type_sale }}">
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
              @if($detail->type_sale == 2)            
               <!-- text input -->
              <div class="form-group">
                <label>Họ tên khách<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="full_name" id="full_name" value="{{ $detail->full_name }}">
              </div>
              <div class="form-group">
                <label>CMND<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="cmnd" id="cmnd" value="{{ $detail->cmnd }}">
              </div>
              <div class="form-group">
                <label>Số điện thoại<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ $detail->phone }}">
              </div>
              <div class="form-group">
                <label>Địa chỉ<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="address" id="address" value="{{ $detail->address }}">
              </div>
              <div class="form-group">
                <label>Vùng quan tâm<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="vung_quan_tam" id="vung_quan_tam" value="{{ $detail->vung_quan_tam }}">
              </div>
              <div class="form-group">
                <label>Nhu cầu<span class="red-star">*</span></label>
                <select name="nhu_cau" id="nhu_cau" class="form-control">
                    <option value="">--Chọn--</option>
                    <option value="1" {{ $detail->nhu_cau == 1 ? "selected" : "" }}>Ở</option>
                    <option value="2" {{ $detail->nhu_cau == 2 ? "selected" : "" }}>Đầu tư ngắn hạn</option>
                    <option value="3" {{ $detail->nhu_cau == 3 ? "selected" : "" }}>Đầu tư trung hạn</option>
                    <option value="4" {{ $detail->nhu_cau == 4 ? "selected" : "" }}>Đầu tư dài hạn</option>
                  </select>
              </div>
              <div class="form-group">
                <label>Loại BĐS<span class="red-star">*</span></label>
                <select name="loai_bds" id="loai_bds" class="form-control">
                  <option value="">--Chọn--</option>
                  <option value="1" {{ $detail->loai_bds == 1 ? "selected" : "" }}>Căn hộ</option>
                  <option value="2" {{ $detail->loai_bds == 2 ? "selected" : "" }}>Đất nền</option>
                  <option value="3" {{ $detail->loai_bds == 3 ? "selected" : "" }}>Biệt thự</option>
                  <option value="4" {{ $detail->loai_bds == 4 ? "selected" : "" }}>Nhà lẻ</option>
                  <option value="5" {{ $detail->loai_bds == 5 ? "selected" : "" }}>Khác</option>
                </select>
              </div>
              @endif
              <div class="form-group">
              <label>Ghi chú</label>
              <textarea rows="5" name="notes" id="notes" class="form-control">{{ old('notes', $detail->notes) }}</textarea>
            </div> 
            @if(Auth::user()->role == 2)
            <div class="form-group">
                  <label for="email">Trạng thái <span class="red-star">*</span></label>
                  <select class="form-control" name="cskh_status" id="cskh_status">
                      <option value="1" {{ $detail->cskh_status == 1 ? "selected" : "" }}>Chưa gọi</option>
                      <option value="2" {{ $detail->cskh_status == 2 ? "selected" : "" }}>Đang gọi</option>
                      <option value="3" {{ $detail->cskh_status == 3 ? "selected" : "" }}>Đã lọc</option>
                      <option value="4" {{ $detail->cskh_status == 4 ? "selected" : "" }}>Đã khóa</option>
                  </select>
                </div>
            </div>  
            @endif
            @if(Auth::user()->role == 3)
            <div class="form-group">
                  <label for="email">Trạng thái <span class="red-star">*</span></label>
                  <select class="form-control" name="pr_status" id="pr_status">
                      <option value="1" {{ $detail->pr_status == 1 ? "selected" : "" }}>Chưa chăm sóc</option>
                      <option value="2" {{ $detail->pr_status == 2 ? "selected" : "" }}>Đang chăm sóc</option>
                      <option value="4" {{ $detail->pr_status == 4 ? "selected" : "" }}>Không thành công</option>
                  </select>
                </div>
            </div> 
            <input type="hidden" name="cskh_status" value="{{ $detail->cskh_status }}">
            @endif
            @if(Auth::user()->role == 4)
            <div class="form-group">
                  <label for="email">Trạng thái <span class="red-star">*</span></label>
                  <label>
                    <input type="radio" name="status_join" value="1" {{ $detail->status_join == 1 ? "checked" : "" }}> Chưa duyệt  
                  </label>
                  <label>
                    <input type="radio" name="status_join" value="2" {{ $detail->status_join == 2 ? "checked" : "" }}> Đã duyệt  
                  </label>                
            </div> 
            @endif
            <!-- /.box-body -->    
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('sales.index')}}">Hủy</a>
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
@stop
