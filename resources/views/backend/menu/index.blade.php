@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Menu
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('menu.index') }}">Menu</a></li>
      <li class="active">Tạo mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('menu.index') }}" style="margin-bottom:5px">Quay lại</a>    
    <div class="row">
      <!-- left column -->

      <div class="col-md-4">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Tạo mới</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">              
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Danh mục bài viết
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <ul>
                        @foreach($articlesCateList as $value)
                        <li>
                          <label>
                          <input type="checkbox" data-parent="cho-thue" data-cap="1" data-value="{{ $value->id }}" name="cap1[]" value="{{ $value->id }}" data-type="3"> {{ $value->name }}
                          </label>
                          <input type="hidden" name="cap1_type[{{ $value->id }}]" value="1">
                          <input type="hidden" name="cap1_title[{{ $value->id }}]" value="{{ $value->name }}">
                          <input type="hidden" name="slug[{{ $value->id }}]" value="{{ $value->slug }}">
                          <input type="hidden" name="object_id[{{ $value->id }}]" value="{{ $value->id }}">
                        </li>
                        @endforeach
                      </ul>
                      <button type="button" class="btnSelectAll btn btn-sm btn-default" style="float:left" data-parent="collapseTwo">Chọn tất cả</button>
                      <button type="button" class="btnAddToMenu btn btn-sm btn-info" style="float:right" data-parent="collapseTwo">Thêm vào menu</button>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Trang
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                     <ul>
                        @foreach($pageList as $value)
                        <li>
                        <label>
                          <input type="checkbox" data-parent="cho-thue" data-cap="1" name="cap1[]" data-value="{{ $value->id }}" data-type="3" value="{{ $value->id }}"> {{ $value->title }}
                          <input type="hidden" name="cap1_type[]" value="2">
                          <input type="hidden" name="cap1_title[]" value="{{ $value->title }}">
                          <input type="hidden" name="slug[]" value="{{ $value->slug }}">
                          <input type="hidden" name="object_id[]" value="{{ $value->id }}">
                        </label>
                        </li>
                        @endforeach
                      </ul>
                      <button type="button" class="btnSelectAll btn btn-sm btn-default" style="float:left" data-parent="collapseThree">Chọn tất cả</button>
                      <button type="button" class="btnAddToMenu btn btn-sm btn-info" style="float:right" data-parent="collapseThree">Thêm vào menu</button>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" id="">
                    <h4 class="panel-title">
                      <a>
                        Tùy chỉnh
                      </a>
                    </h4>
                  </div>
                  <div>
                    <div class="panel-body" id="collapseFour">
                      <div class="form-group">
                        <label>Text hiển thị <span class="red-star">*</span></label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                      </div>
                      <input type="hidden" name="type" value="3">
                      <input type="hidden" name="custom" value="1">
                       <div class="form-group">
                        <label>URL <span class="red-star">*</span></label>
                        <input type="text" class="form-control" name="url" id="url" value="{{ old('url') }}">
                      </div>
                      <button type="button" class="btnAddToMenuCustom btn btn-sm btn-info" style="float:right" data-parent="collapseFour">Thêm vào menu</button>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>
              </div>         
            </div>                        
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">MENU</h3>
          </div>
          <!-- /.box-header -->
          <form action="{{ route('menu.store')}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="panel-group">
                  <ul class="loadMenu" id="menuDefault">
                      <li class="first">
                        <div class="col-sm-11">Trang chủ</div>
                        <div class="col-sm-1">
                          
                        </div>
                       
                      </li> 
                      <li>
                        <div class="col-sm-11">BĐS bán</div>
                        <div class="col-sm-1">
                          
                        </div>
                        
                      </li>  
                      <li>
                        <div class="col-sm-11">BĐS cho thuê</div>
                        <div class="col-sm-1">
                          
                        </div>                        
                      </li>   
                      <li>
                        <div class="col-sm-11">Dự án</div>
                        <div class="col-sm-1">
                          
                        </div>                        
                      </li>
                      
                  </ul>
                  <ul class="loadMenu" id="loadMenu">
                    @if($menuList->count() > 0)
                    @foreach($menuList as $value)                      
                      <li>
                        <div class="col-sm-11">{{ $value->title }}</div>
                        <div class="col-sm-1">
                          <p><span class="glyphicon glyphicon-remove rm-div" aria-hidden="true"></span></p>
                        </div>
                          <input type="hidden" name="title[]" value="{!! $value->title !!}">
                          <input type="hidden" name="type[]" value="{!! $value->type !!}">
                          <input type="hidden" name="url[]" value="{!! $value->url !!}">
                          <input type="hidden" name="slug[]" value="{!! $value->slug !!}">
                          <input type="hidden" name="object_id[]" value="{!! $value->object_id !!}">
                      </li>
                    @endforeach
                    @endif
                  </ul>

                </div>
                 <button type="submit" class="btn btn-primary btn-sm" style="float:right">Lưu</button>              
            </div>
          </form>
        <!-- /.box -->     

      </div>
      <!--/.col (left) -->      
    </div>

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
<style type="text/css">
  #menuDefault li{
    cursor: no-drop;
  }
  .panel-title {font-weight: bold; text-transform:uppercase;}
  li {list-style: none;}
  li label{  font-weight: normal; }
  .loadMenu li{
    background-color: #CCC;
    display: block;
    clear: both;
    height: 40px;
    padding: 8px 10px 10px 0px;
    border-top:none !important;
    margin-bottom: 3px;
    cursor: move;
  }  
  .rm-div {
    cursor: pointer !important;
  }
  .loadMenu li.highlight{
    background-color: #28AA4A;
    color:#FFF;
  }
</style>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function(){    
       $( "#loadMenu" ).sortable({
          start: function (event, ui) {
                  ui.item.toggleClass("highlight");
                  
          },
          stop: function (event, ui) {
                  ui.item.toggleClass("highlight");
                  
          }
       });
       $(document).on('click', '.rm-div', function(){        
        if(confirm("Bạn có chắc chắn xóa ?")){
          $(this).parents('li').remove();
        }
       });
      $('.btnSelectAll').click(function(){
        $('#' + $(this).data('parent')  + ' input[type=checkbox]').prop('checked', true);
      });
      $('.btnAddToMenu').click(function(){
        var obj = $(this);
        $.ajax({
          url:  "{{ route('render-menu') }}",
          type : 'POST',
          data : $('#' + obj.data('parent') + ' :input').serialize(),
          success : function(data){
            $('#loadMenu').append(data);
            var rows = $('#loadMenu li');
            var liTmp = '';
            for (var i = 1; i< rows.length ; i++) {                
                $('#loadMenu li').eq(i-1).attr('id', 'row-' + i);
            }  
          }
        });
      });
      $('.btnAddToMenuCustom').click(function(){
        if($.trim($('#title').val()) != '' && $.trim($('#url').val()) != ''){
          var obj = $(this);
          $.ajax({
            url:  "{{ route('render-menu') }}",
            type : 'POST',
            data : $('#' + obj.data('parent') + ' :input').serialize(),
            success : function(data){
              $('#loadMenu').append(data);
              $('#title, #url').val('');
              var rows = $('#loadMenu li');
              var liTmp = '';
              for (var i = 1; i< rows.length ; i++) {                
                  $('#loadMenu li').eq(i-1).attr('id', 'row-' + i);
              }  
            }
          });
        }
      });
      
    });
</script>
@stop
