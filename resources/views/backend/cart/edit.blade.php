@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Giỏ hàng</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
      <li class="active"><span class="glyphicon glyphicon-pencil"></span></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm " href="{{ route('cart.index') }}" style="margin-bottom:5px">Quay lại</a>
    <div class="row">
      <!-- left column -->

      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Chỉnh sửa
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" method="POST" action="{{ route('cart.update') }}">
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
              <div class="form-group">
                <label for="email">Loại </label>
                <select class="form-control" name="type" id="type">                                
                  <option value="1" {{ 1 ==  old('type', $detail->type) ? "selected" : "" }}>Chung cư</option>
                  <option value="2" {{ 2 ==  old('type', $detail->type) ? "selected" : "" }}>Đất nền</option>
                </select>
              </div>
              
               <!-- text input -->
              <div class="form-group">
                <label>Tên <span class="red-star">*</span></label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $detail->name }}">
              </div>
           
               @if($editorList && Auth::user()->role > 2)
                <div class="form-group">
                    <label>Nhân viên<span class="red-star">*</span></label>
                    <div class="clearfix"></div>
                    <?php $i = 0; ?>
                    @foreach($editorList as $edi)
                    <div class="col-md-3">
                      <input type="checkbox" name="user_id[]" value="{{ $edi->id }}" id="user_id_{{ $i }}"
                      {{ in_array($edi->id, $cartUser) ? "checked" : "" }}
                      ><label for="user_id_{{ $i }}">{{ $edi->full_name }}</label>
                    </div>
                    <?php $i++; ?>
                    @endforeach
                    <div class="clearfix"></div>
                </div>               
                @endif  
                <div class="clearfix"></div>
                @if($modList && Auth::user()->role > 2)
                <div class="form-group">
                    <label>MOD<span class="red-star">*</span></label>
                    <div class="clearfix"></div>
                    <?php $i = 0; ?>
                    @foreach($modList as $edi)
                    <div class="col-md-3">
                      <input type="checkbox" name="user_id[]" value="{{ $edi->id }}" id="user_id_{{ $edi->id }}"
                      {{ in_array($edi->id, $cartUser) ? "checked" : "" }}
                      ><label for="user_id_{{ $edi->id }}">{{ $edi->full_name }}</label>
                    </div>
                    <?php $i++; ?>
                    @endforeach
                    <div class="clearfix"></div>
                </div>               
                @endif           
            </div>                    
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('cart.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

@stop
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    $('#type').change(function(){
      var type = $(this).val();
      if(type != 3){
        $('#div_tien_ich').hide();
      }else{
        $('#div_tien_ich').show();
      }
    });
    $('#name').change(function(){
         var name = $.trim( $(this).val() );
         if( name != '' && $('#slug').val() == ''){
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug').val( response.str );
                }                
              },
              error: function(response){                             
                  var errors = response.responseJSON;
                  for (var key in errors) {
                    
                  }
                  //$('#btnLoading').hide();
                  //$('#btnSave').show();
              }
            });
         }
      });
  });
</script>>
@stop
