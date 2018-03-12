@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Tin ký gửi
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'product.index' ) }}">Tin ký gửi</a></li>
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
      <a href="{{ route('product.create', ['estate_type_id' => $arrSearch['estate_type_id'], 'type' => $arrSearch['type']]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('product.kygui') }}">            
            <input type="hidden" name="type" value="1">
            <div class="form-group">              
              <select class="form-control" name="cart_status" id="cart_status">
                  <option value="">--Trạng thái--</option>
                  <option value="1" {{ $arrSearch['cart_status'] == 1 ? "selected" : "" }}>
                    {{ $arrSearch['type'] == 1 ? "Chưa bán" : "Còn trống" }}
                  </option>
                  <option value="2" {{ $arrSearch['cart_status'] == 2 ? "selected" : "" }}>
                    {{ $arrSearch['type'] == 1 ? "Đã bán" : "Đã thuê" }}
                  </option>
              </select>
            </div>
              <div class="form-group">
              <select class="form-control" name="estate_type_id" id="estate_type_id">
                <option value="">--Danh mục--</option>
                @foreach( $estateTypeArr as $value )
                  <option value="{{ $value->id }}"
                  {{ $arrSearch['estate_type_id'] == $value->id ? "selected" : "" }}                          

                  >{{ $value->name }}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">              
              <select class="form-control" name="city_id" id="city_id">
                <option value="">--Tỉnh/TP--</option>
                  @foreach( $cityList as $value )
                    <option value="{{ $value->id }}"
                    {{ $arrSearch['city_id'] == $value->id ? "selected" : "" }}                        

                    >{{ $value->name }}</option>
                    @endforeach
              </select>
            </div>
            <div class="form-group">              
              <select class="form-control" name="district_id" id="district_id">
                <option value="">--Quận--</option>
                <?php 
                  $districtList = App\Models\District::where('city_id', $arrSearch['city_id'])->get();
                  ?>
                  @foreach( $districtList as $value )
                    <option value="{{ $value->id }}"
                    {{ $arrSearch['district_id'] == $value->id ? "selected" : "" }}                        

                    >{{ $value->name }}</option>
                    @endforeach
              </select>
            </div>
            <div class="form-group">              
              <select class="form-control" name="ward_id" id="ward_id">
                <option value="">--Phường--</option>
                  @foreach( $wardList as $value )
                  <option value="{{ $value->id }}"
                  {{ $arrSearch['ward_id'] == $value->id ? "selected" : "" }}                       

                  >{{ $value->name }}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">              
              <input type="text" placeholder="Tiêu đề" class="form-control" name="name" value="{{ $arrSearch['name'] }}">
            </div>           
            
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
          </form>         
        </div>
      </div>
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( {{ $items->total() }} sản phẩm )</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}
          </div>  
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              <th width="100px">Hình ảnh</th>
              <th style="text-align:center">Thông tin sản phẩm</th>
              <th width="120px">Trạng thái</th>                              
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; 

                ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>
                
                <td>
                  <img class="img-thumbnail lazy" width="80" data-original="{{ $item->image_urls ? Helper::showImage($item->image_urls) : URL::asset('public/admin/dist/img/no-image.jpg') }}" alt="Nổi bật" title="Nổi bật" />
                </td>
                <td>                  
                  <a style="color:{{ $item->cart_status == 1 ? "#444" : "red" }};font-weight:bold" href="{{ route( 'product.edit', [ 'id' => $item->id ]) }}">{{ $item->title }}</a> <br />
                  <strong style="color:#337ab7;font-style:italic"> {{ Helper::getName($item->estate_type_id, 'estate_type') }}</strong>
                  <p>
                    @if($item->street_id > 0)
                    {{ Helper::getName($item->street_id, 'street') }},&nbsp;
                    @endif
                    @if($item->ward_id > 0)
                    {{ Helper::getName($item->ward_id, 'ward') }},&nbsp;
                    @endif
                    @if($item->district_id > 0)
                    {{ Helper::getName($item->district_id, 'district') }},&nbsp;
                    @endif
                    @if($item->city_id > 0)
                    {{ Helper::getName($item->city_id, 'city') }}
                    @endif

                  </p>
                 <p style="margin-top:10px">
                    
                    <b style="color:red">                  
                    {{ ($item->price) }} {{ Helper::getName($item->price_unit_id, 'price_unit') }}
                   </b>                    
                  </p>
                  
                </td>
                <td>                
                  @if($item->type == 1)
                    {{ $item->cart_status == 1 ? "Chưa bán" : "Đã bán" }}                  
                  @else
                    {{ $item->cart_status == 1 ? "Còn trống" : "Đã thuê" }}
                  @endif
                </td>
                <td style="white-space:nowrap; text-align:right">
                  <a class="btn btn-default btn-sm" href="{{ route('chi-tiet', [$item->slug_loai, $item->slug, $item->id] ) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>
                  
                  
                  <a href="{{ route( 'product.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>                 

                  <a onclick="return callDelete('{{ $item->name }}','{{ route( 'product.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>

                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}
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
<style type="text/css">
#searchForm div{
  margin-right: 7px;
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
  $('input.submitForm').click(function(){
    var obj = $(this);
    if(obj.prop('checked') == true){
      obj.val(1);      
    }else{
      obj.val(0);
    } 
    obj.parent().parent().parent().submit(); 
  });
  
  $('#estate_type_id, #city_id, #type, #district_id, #ward_id, #cart_status').change(function(){    
    $('#searchForm').submit();
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
            updateOrder("san_pham", strOrder);
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