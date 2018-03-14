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
      <li><a href="{{ route('data.index') }}">Khách hàng</a></li>
      <li class="active">Chi tiết </li>
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
            Chi tiết
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" method="POST" action="{{ route('data.update') }}" id="formData">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $detail->id }}">
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
                <input type="text" class="form-control" name="name" id="name" value="{{ $detail->name }}">
              </div>             
              <div class="form-group">
                <label>Số điện thoại<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ $detail->phone }}">
              </div>
              <div class="form-group">
                <label>Địa chỉ<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="address" id="address" value="{{ $detail->address }}">
              </div>
              <div class="form-group col-md-6">
                <label>Loại BĐS</label>
                 <input type="text" class="form-control" name="address" id="address" value="{{ $detail->loai_bds }}">
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
              <label>Ghi chú</label>
              <textarea rows="5" name="notes" id="notes" class="form-control">{{ old('notes', $detail->notes) }}</textarea>
            </div>  
            </div>   
                 
            <!-- /.box-body -->    
          
            
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
<script type="text/javascript">
  $(document).ready(function(){
    
    
        $('form input, form textarea, form select').attr('disabled', 'disabled').removeAttr('name');
    
  });
</script>
@stop
