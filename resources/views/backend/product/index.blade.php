@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Sản phẩm
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'product.index' ) }}">Sản phẩm</a></li>
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
      <a href="{{ route('product.create', ['estate_type_id' => $arrSearch['estate_type_id'], 'type' => $arrSearch['type'], 'city_id' => $arrSearch['city_id']]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('product.index') }}">            
            <div class="form-group">              
              <select class="form-control" name="type" id="type">
                  <option value="">--Loại--</option>
                  <option value="1" {{ $arrSearch['type'] == 1 ? "selected" : "" }}>Bán</option>
                  <option value="2" {{ $arrSearch['type'] == 2 ? "selected" : "" }}>Cho thuê</option>
              </select>
            </div>
            <div class="form-group">                            
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="cart_status[]" value="1" {{ in_array(1, $arrSearch['cart_status'])  ? "checked" : "" }}>
                  {{ $arrSearch['type'] == 1 ? "Chưa bán" : "Còn trống" }}
                </label>
              </div>
          
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="cart_status[]" value="2" {{ in_array(2, $arrSearch['cart_status'])  ? "checked" : "" }}>
                  {{ $arrSearch['type'] == 1 ? "Đã bán" : "Đã thuê" }}
                </label>
              </div>
          
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="cart_status[]" value="3" {{ in_array(3, $arrSearch['cart_status']) ? "checked" : "" }}>
                  Đã cọc
                </label>
              </div>
              
            </div>
              <div class="form-group">
                <div class="checkbox">
                  <label style="color:red; font-weight:bold">
                    <input type="checkbox" name="is_hot" id="is_hot" value="1" {{ $arrSearch['is_hot'] == 1 ? "checked" : "" }}>
                    Tin HOT
                  </label>
                </div>               
              </div>
              <div class="form-group">
              <select class="form-control" name="estate_type_id" id="estate_type_id" style="width:150px;">
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
              <select class="form-control" name="ward_id" id="ward_id" style="width:100px">
                <option value="">--Phường--</option>
                  @foreach( $wardList as $value )
                  <option value="{{ $value->id }}"
                  {{ $arrSearch['ward_id'] == $value->id ? "selected" : "" }}                       

                  >{{ $value->name }}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">              
              <input type="text" placeholder="Tiêu đề" class="form-control" name="name" value="{{ $arrSearch['name'] }}" style="width:140px">
            </div>
            <div class="form-group">              
              <input type="text" placeholder="Mã tin" class="form-control" name="id" value="{{ $arrSearch['id'] }}" style="width:60px">
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
          @if($arrSearch['is_hot'] == 1)
          <form method="post" action={{ route('product.save-order-hot')}} >
            {{ csrf_field() }}
            @if($items->count() > 0)
            <button type="submit" class="btn btn-warning btn-sm">Save thứ tự</button>
            @endif
            <input type="hidden" name="estate_type_id" value="{{ $arrSearch['estate_type_id']}}">
            <input type="hidden" name="type" value="{{ $arrSearch['type']}}">
            <input type="hidden" name="is_hot" value="1">
          @endif

            <table class="table table-bordered" id="table-list-data">
              <tr>
                <th style="width: 1%">#</th>
                <th style="width: 1%;white-space:nowrap">Mã tin</th>
                @if($arrSearch['is_hot'] == 1)
                <td width="120px">
                  Thứ tự
                </td>
                @endif
                <th width="100px">Hình ảnh</th>
                <th style="text-align:center">Thông tin sản phẩm</th>
                <th width="120px">Trạng thái</th>                              
                <th width="120px">Danh sách user bán</th>
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
                  <td style="text-align:center">{{ $item->id }}</td>
                  @if($arrSearch['is_hot'] == 1)
                  <td>
                    <input type="text" value="{{ $item->display_order }}" name="display_order[{{$item->id}}]" style="width:80px" class="form-control" />
                  </td>
                  @endif
                  <td>
                    <img class="img-thumbnail lazy" width="80" data-original="{{ $item->image_urls ? Helper::showImage($item->image_urls) : URL::asset('public/admin/dist/img/no-image.jpg') }}" alt="Nổi bật" title="Nổi bật" />
                  </td>
                  <td>                  
                    <a style="color:{{ $item->cart_status == 1 ? "#444" : "red" }};font-weight:bold" href="{{ route( 'product.edit', [ 'id' => $item->id ]) }}">{{ $item->title }}</a> 
                    @if( $item->is_hot == 1 )
                  <img class="img-thumbnail" src="{{ URL::asset('public/admin/dist/img/star.png')}}" alt="Nổi bật" title="Nổi bật" />
                  @endif <br />
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
                      {{ (number_format($item->price)) }} ({{ $item->price_text }})
                     </b>                    
                    </p>
                    
                  </td>
                  <td>                
                   @if($item->cart_status == 1)
                    <span class="label label-success">Chưa bán</span>
                    @elseif($item->cart_status == 2)
                    <span class="label label-danger">Đã bán</span>
                    @elseif($item->cart_status == 3)
                    <span class="label label-warning">Đã cọc</span>
                    @endif
                  </td>
                  <td class="center">
                    <a class="btn btn-primary btn-sm col-xs-12" href="{{ route('sales.index', ['product_id' => $item->id]) }}" target="_blank"><i class="fa fa-users" aria-hidden="true"></i> </a>
                  </td>
                  <td style="white-space:nowrap; text-align:right">
                    <a class="btn btn-default btn-sm" href="{{ route('chi-tiet', [$item->slug_loai, $item->slug, $item->id] ) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>
                    <a href="{{ route( 'product.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>                    
                    @if($item->sales->count() == 0 || Auth::user()->role == 1 || (Auth::user()->role == 6 && $item->sales->count() == 0))                    
                    <a onclick="return callDelete('{{ $item->title }}','{{ route( 'product.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                    @endif
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
          @if($arrSearch['is_hot'] == 1)
          </form>
          @endif
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
  $('#is_hot').change(function(){
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