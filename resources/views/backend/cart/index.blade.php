@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Giỏ hàng
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'cart.index' ) }}">Giỏ hàng</a></li>
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
      @if(Auth::user()->role > 1)
      <a href="{{ route('cart.create', ['type' => $type]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      @endif
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('cart.index') }}">
            <div class="form-group">
              <label for="email">Loại :</label>
              <select class="form-control" name="type" id="type">                     
              <option value="">--All--</option>           
                <option value="1" {{ 1 == $type ? "selected" : "" }}>Chưng cư</option>
                <option value="2" {{ 2 == $type ? "selected" : "" }}>Đất nền</option>                
              </select>
            </div>           
            <div class="form-group">
              <label for="email">&nbsp;&nbsp;&nbsp;Tên :</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ $name }}">
            </div>       
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
          </form>         
        </div>
      </div>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Danh sách</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:right">
            {{ $items->appends( ['name' => $name, 'type' => $type] )->links() }}
          </div>
          @if( $items->count() > 0 )
          <div class="col-md-12">
            @foreach( $items as $item )
            <div class="col-md-4" style="border:1px solid #CCC;padding:10px;text-align:center; border-radius:5px">
              <h3><a href="{{ route('cart-product.index', ['cart_id' => $item->id]) }}">{{ $item->name }}</a></h3>
              <a class="btn-sm btn btn-primary" href="{{ route('cart-product.index', ['cart_id' => $item->id]) }}" ><span class="badge">{{ $item->cartProduct->count() }}</span> 
                {{ ($type == 1) ? "Căn hộ" :  "Nền" }}
                 </a>
                @if(Auth::user()->role > 1)
                <a href="{{ route( 'cart.edit', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-warning">
                  <span class="glyphicon glyphicon-pencil"></span>
                </a>                  
                
                <a onclick="return callDelete('{{ $item->name }}','{{ route( 'cart.destroy', [ 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger">
                  <span class="glyphicon glyphicon-trash"></span>
                </a>                  
                @endif
                
            </div>
            @endforeach
          </div>
          @else
            <p>Chưa có dữ liệu.</p>
          @endif             
          <div style="text-align:right">          
            {{ $items->appends( ['name' => $name, 'type' => $type] )->links() }}
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
<input type="hidden" id="route_tag_index" value="{{ route('cart.index') }}">
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
  $('#type, #district_id').change(function(){
    $(this).parents('form').submit();
  });
  $('#table-list-data tbody').sortable({
        placeholder: 'placeholder',
        handle: ".move",
        start: function (event, ui) {
                ui.item.toggleClass("highlight");
        },
        stop: function (event, ui) {
                ui.item.toggleClass("highlight");
        },          
        axis: "y",
        update: function() {
            var rows = $('#table-list-data tbody tr');
            var strOrder = '';
            var strTemp = '';
            for (var i=0; i<rows.length; i++) {
                strTemp = rows[i].id;
                strOrder += strTemp.replace('row-','') + ";";
            }     
            updateOrder("loai_sp", strOrder);
        }
    });
});
function updateOrder(table, strOrder){
  $.ajax({
      url: $('#route_update_order').val(),
      type: "POST",
      async: false,
      data: {          
          str_order : strOrder,
          table : table
      },
      success: function(data){
          var countRow = $('#table-list-data tbody tr span.order').length;
          for(var i = 0 ; i < countRow ; i ++ ){
              $('span.order').eq(i).html(i+1);
          }                        
      }
  });
}
</script>
@stop