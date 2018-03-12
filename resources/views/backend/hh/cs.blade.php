@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Chăm sóc CTV
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('change-csctv') }}">Chăm sóc CTV</a></li>
      <li class="active">Cập nhật</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('sales.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('update-cs') }}" id="formData">
    <div class="row">
      <!-- left column -->

      <div class="col-md-9">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">            
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
               @if(Session::has('message'))
                <p class="alert alert-info" >{{ Session::get('message') }}</p>
                @endif     
              <div class="col-md-12">
                <h4>Thông tin chăm sóc CTV</h4>
                <table class="table table-bordered">
                  <tr>
                    <td width="130px">Mã CSCTV</td>
                    <td>CS{{ $detailCS->id }}</td>
                  </tr>                  
                  <tr>
                    <td>Số điện thoại</td>
                    <td>{{ $detailCS->phone }}</td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td>{{ $detailCS->email }}</td>
                  </tr>
                </table>
              </div>
              <p class="panel-info panel" style="color:red;padding:10px">Nếu bạn không hài lòng với chăm sóc CTV hiện tại bạn có thể chuyển CS CTV khác theo danh dách bên dưới.
              <br><br>
              <span style="text-transform:uppercase">Quý vui lòng liên hệ sđt: 0911.356.178 để thông báo trước khi chuyển, Xin cám ơn.</span></p>             
                <div class="form-group" id="div_cs">
                  <label>Chăm sóc CTV</label>
                  <select class="form-control" name="leader_id" id="leader_id">
                    @foreach($csctvList as $cs)
                    <option value="{{ $cs->id }}" {{ old('leader_id', Auth::user()->leader_id) == $cs->id ? "selected" : "" }}> CS{{ $cs->id }} </option>
                    @endforeach
                    
                  </select>
                </div>     
                
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('account.index')}}">Hủy</a>
            </div>
            
        </div>
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
<script type="text/javascript">
         
    });
    
</script>
@stop
