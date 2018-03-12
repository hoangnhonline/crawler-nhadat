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
    <li><a href="{{ route( 'cart-product.index' ) }}">
      @if($cartDetail->type == 1)
      Căn hộ
      @else
      Nền
      @endif
    </a></li>
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
      <a href="{{ route('cart-product.create', ['cart_id' => $cart_id] ) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>     
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Danh sách</h3>
           <span style="width:60px; height:25px;background-color:orange;padding:3px;color:#FFF;float:right">Đã cọc</span>&nbsp;&nbsp;&nbsp;&nbsp;
          <span style="width:60px; height:25px;background-color:red;padding:3px;color:#FFF;float:right">Đã bán</span>&nbsp;&nbsp;&nbsp;&nbsp;
          <span style="width:70px; height:25px;background-color:#00c0ef;padding:3px;color:#FFF;float:right">Chưa bán</span>
          
         
          <div class="clearfix"></div>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:right">
            {{ $items->appends( ['cart_id' => $cart_id] )->links() }}
          </div>
            <div class="col-md-12">
                @foreach($items as $item)
                <div class="field-tip col-md-3 
                <?php 
                if($item->status == 1) echo " chua-ban";
                elseif($item->status == 2) echo " da-ban";
                else echo " da-coc";
                ?>
                ">
                  <h4>{{ $item->name }}</h4>                 
                  <p style="margin-top:15px;text-align:left">
                    <a style="color:#FFF;text-transform:uppercase" class="btn-sm btn btn-warning" href="{{ route('cart-product.edit', ['id' => $item->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a onclick="return callDelete('{{ $item->name }}','{{ route( 'cart-product.destroy', [ 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger">
                  <span class="glyphicon glyphicon-trash"></span>
                </a>
                  </p>
                  <span class="tip-content">
                    <table cellpadding="10" cellspacing="0">
                      @if($item->area)
                      <tr>
                        <td width="80">Diện tích</td>
                        <td>{{ $item->area }}</td>
                      </tr>
                      @endif
                      @if($item->price)
                      <tr>
                        <td>Giá</td>
                        <td>{{ $item->price }}</td>
                      </tr>
                      @endif
                      @if($item->direction)
                      <tr>
                        <td>Hướng</td>
                        <td>{{ $item->direction }}</td>
                      </tr>
                      @endif
                      @if($item->type == 1)
                      @if($item->floor)
                      <tr>
                        <td>Lầu</td>
                        <td>{{ $item->floor }}</td>
                      </tr>
                      @endif
                      @if($item->no_room)
                      <tr>
                        <td>Số phòng</td>
                        <td>{{ $item->no_room }}</td>
                      </tr>
                      @endif
                      @if($item->no_wc)
                      <tr>
                        <td>Số WC</td>
                        <td>{{ $item->no_wc }}</td>
                      </tr>
                      @endif
                      @endif
                      @if($item->hoa_hong)
                      <tr>
                        <td>Hoa hồng</td>
                        <td>{{ $item->hoa_hong }}</td>
                      </tr>
                      @endif
                      @if($item->notes)
                      <tr>
                        <td>Ghi chú</td>
                        <td>{{ $item->notes }}</td>
                      </tr>
                      @endif
                    </table>

                  </span>
                </div>    
                @endforeach

            </div>
          <div style="text-align:right">          
            {{ $items->appends( ['cart_id' => $cart_id] )->links() }}
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
<input type="hidden" id="route_cart-product_index" value="{{ route('cart-product.index') }}">
<style type="text/css">
  .field-tip {
    position:relative;
    cursor: pointer;    
    border: 1px solid #CCC;
    text-align: center;
    border-radius: 5px;
}
.chua-ban{
  background-color: #00c0ef;
  color:#FFF;
}
.da-ban{
  background-color: red;
  color:#FFF;
}
.da-coc{
 background-color: orange;
  color:#FFF; 
}
    .field-tip .tip-content {
        z-index: 9999;
        text-align: left;
        position:absolute;
        top:0px; /* - top padding */
        right:9999px;
        width:200px;
        margin-right:0px; /* width + left/right padding */
        padding:10px;
        color:#fff;
        background:#367fa9;
        -webkit-box-shadow:2px 2px 5px #aaa;
           -moz-box-shadow:2px 2px 5px #aaa;
                box-shadow:2px 2px 5px #aaa;
        opacity:0;
        -webkit-transition:opacity 250ms ease-out;
           -moz-transition:opacity 250ms ease-out;
            -ms-transition:opacity 250ms ease-out;
             -o-transition:opacity 250ms ease-out;
                transition:opacity 250ms ease-out;
    }
        /* <http://css-tricks.com/snippets/css/css-triangle/> */
        .field-tip .tip-content:before {
            content:' '; /* Must have content to display */
            position:absolute;
            top:0%;
            left:-16px; /* 2 x border width */
            width:0;
            height:0;
            margin-top:0px; /* - border width */
            border:8px solid transparent;
            border-right-color:#367fa9;
        }
        .field-tip:hover .tip-content {
            right:0px;
            opacity:1;
        }

</style>
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