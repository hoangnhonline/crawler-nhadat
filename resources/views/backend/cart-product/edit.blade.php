@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
       @if($cartDetail->type == 1)
      Căn hộ
      @else
      Nền
      @endif
      của
      <span style="color:red">{{ $cartDetail->name }}</span>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('cart-product.index', ['cart_id' => $cart_id]) }}">
      @if($cartDetail->type == 1)
      Căn hộ
      @else
      Nền
      @endif</a></li>
      <li class="active"><span class="glyphicon glyphicon-pencil"></span></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm " href="{{ route('cart-product.index', ['cart_id' => $cart_id]) }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('cart-product.update') }}">
    <input type="hidden" name="id" value="{{ $detail->id }}" >
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Chỉnh sửa
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

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
                <div class="form-group col-md-6">
                  <label>Tên <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $detail->name) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Diện tích </label>
                  <input type="text" class="form-control" name="area" id="area" value="{{ old('area', $detail->area) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Giá </label>
                  <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $detail->price) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Hướng </label>
                  <input type="text" class="form-control" name="direction" id="direction" value="{{ old('direction', $detail->direction) }}">
                </div>
                <input type="hidden" name="cart_id" value="{{ $cart_id }}" >
                <input type="hidden" name="type" value="{{ $cartDetail->type }}">
                @if($cartDetail->type == 1)
                <div class="form-group col-md-6">
                  <label>Lầu </label>
                  <input type="text" class="form-control" name="floor" id="floor" value="{{ old('floor', $detail->price) }}">
                </div>

                <div class="form-group col-md-6">
                  <label>Số phòng </label>
                  <input type="text" class="form-control" name="no_room" id="no_room" value="{{ old('no_room', $detail->no_room) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Số WC </label>
                  <input type="text" class="form-control" name="no_wc" id="no_wc" value="{{ old('no_wc', $detail->no_wc) }}">
                </div>               
                @endif
                <div class="form-group col-md-6">
                  <label>Hoa hồng </label>
                  <input type="text" class="form-control" name="hoa_hong" id="hoa_hong" value="{{ old('hoa_hong', $detail->hoa_hong) }}">
                </div> 
                <div class="form-group col-md-12">
                  <label for="email">Trạng thái </label>
                  <select class="form-control" name="status" id="status">                                
                    <option value="1" {{ 1 ==  old('status', $detail->status) ? "selected" : "" }}>Chưa bán</option>
                    <option value="2" {{ 2 ==  old('status', $detail->status) ? "selected" : "" }}>Đã bán</option>
                    <option value="3" {{ 3 ==  old('status', $detail->status) ? "selected" : "" }}>Đã cọc</option>
                  </select>
                </div>
                <!-- textarea -->
                <div class="form-group col-md-12">
                  <label>Ghi chú</label>
                  <textarea class="form-control" rows="3" name="notes" id="notes">{{ old('notes', $detail->notes) }}</textarea>
                </div>            
                <div class="clearfix"></div>    
            </div>                        
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('cart-product.index', ['cart_id' => $cart_id])}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">
        <!-- general form elements -->
       
        <!-- /.box -->     

      </div>
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@stop
@section('js')
@stop
