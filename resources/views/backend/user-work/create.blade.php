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
      <li><a href="{{ route('user-work.index') }}">Công việc</a></li>
      <li class="active">Tạo mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('user-work.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('user-work.store') }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
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
                <div class="form-group" >
                  
                  <label>Ngày<span class="red-star">*</span></label>
                  <input type="text" class="form-control datepicker" name="work_date" id="work_date" value="{{ old('work_date', $date_current) }}">
                </div>                
                <div class="form-group">
                  <label for="email">Nhóm công việc<span class="red-star">*</span></label>
                  <select class="form-control" name="group_id" id="group_id">
                    <option value="">--Chọn--</option>
                    @foreach( $groupList as $value )
                    <option value="{{ $value->id }}"
                    {{ old('group_id') == $value->id ? "selected" : "" }}                           

                    >{{ $value->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="is_hot" value="1" {{ old('is_hot') == 1 ? "checked" : "" }}>
                      Ưu tiên
                    </label>
                  </div>               
                </div>
                <div class="form-group">
                  <label>Mô tả</label>
                  <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                  <label>Chi tiết</label>
                  <textarea class="form-control" rows="4" name="work_content" id="work_content">{{ old('work_content') }}</textarea>
                </div>
                  <input type="hidden" id="editor" value="work_content">
            </div>          
          
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('user-work.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-4">
       
         

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
<script type="text/javascript">
    $(document).ready(function(){
      $('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
      $(".select2").select2();
      var editor = CKEDITOR.replace( 'work_content',{
          language : 'vi',    
          height : 300
      });
      var editor2 = CKEDITOR.replace( 'description',{
          language : 'vi',    
          height : 300
      });
      @if(Auth::user()->role > 1)
      var editor = CKEDITOR.replace( 'leader_comment',{
          language : 'vi',    
          height : 300
      });
      @endif
    });
    
</script>
@stop
