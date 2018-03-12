@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Danh sách khách hàng tham gia bán
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'product.index' ) }}">Danh sách khách hàng tham gia bán</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

      <div class="box box-solid box-info ">

        <div class="box-header with-border">
          <h3 class="box-title">Thông tin sản phẩm</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">

          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              <th style="width: 1%;white-space:nowrap">Mã tin</th>
              <th width="100px">Hình ảnh</th>
              <th style="text-align:center">Thông tin sản phẩm</th>
              <th width="120px">Trạng thái</th>
            </tr>
            <tbody>
                <tr id="row-{{ $detailProduct->id }}">
                  <td><span class="order">1</span></td>
                  <td style="text-align:center">{{ $detailProduct->id }}</td>
                  <td>
                    <img class="img-thumbnail lazy" width="80" data-original="{{ $detailProduct->image_urls ? Helper::showImage($detailProduct->image_urls) : URL::asset('public/admin/dist/img/no-image.jpg') }}" alt="Nổi bật" title="Nổi bật" />
                  </td>
                  <td>
                    <a style="color:{{ $detailProduct->cart_status == 1 ? "#444" : "red" }};font-weight:bold" href="{{ route( 'product.edit', [ 'id' => $detailProduct->id ]) }}">{{ $detailProduct->title }}</a>
                    @if( $detailProduct->is_hot == 1 )
                      <img class="img-thumbnail" src="{{ URL::asset('public/admin/dist/img/star.png')}}" alt="Nổi bật" title="Nổi bật" />
                    @endif <br />
                    <strong style="color:#337ab7;font-style:italic"> {{ Helper::getName($detailProduct->estate_type_id, 'estate_type') }}</strong>
                    <p>
                      @if($detailProduct->street_id > 0)
                        {{ Helper::getName($detailProduct->street_id, 'street') }},&nbsp;
                      @endif
                      @if($detailProduct->ward_id > 0)
                        {{ Helper::getName($detailProduct->ward_id, 'ward') }},&nbsp;
                      @endif
                      @if($detailProduct->district_id > 0)
                        {{ Helper::getName($detailProduct->district_id, 'district') }},&nbsp;
                      @endif
                      @if($detailProduct->city_id > 0)
                        {{ Helper::getName($detailProduct->city_id, 'city') }}
                      @endif

                    </p>
                    <p style="margin-top:10px">

                      <b style="color:red">
                        {{ ($detailProduct->price) }} {{ Helper::getName($detailProduct->price_unit_id, 'price_unit') }}
                      </b>
                    </p>

                  </td>
                  <td class="center">
                    @if($detailProduct->type == 1)
                      {!!  $detailProduct->cart_status == 1 ? '<span class="label label-info"> Chưa bán</span>' : '<span class="label label-success"> Đã bán</span>'  !!}
                    @else
                      {{ $detailProduct->cart_status == 1 ? '<span class="label label-info"> Còn trống</span>' : '<span class="label label-success"> Đã thuê</span>' }}
                    @endif
                  </td>
                </tr>
            </tbody>
          </table>
        </div>

      </div>
      <!-- /.box product -->

      <div class="box box-solid box-warning ">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( {{ $totalCustomer }} khách hàng )</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">

          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              <th style="width: 1%;white-space:nowrap">Khách hàng</th>
              <th width="100px">Loại bán</th>
              <th style="text-align:center">Object type</th>
              <th width="120px">Status tham gia</th>
              <th width="120px">Status bán</th>
              <th width="120px">Hoa hồng start</th>
              <th width="120px">Hoa hồng end</th>
              <th width="120px">Ngày tham gia</th>
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $customerJoinSaleList->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $customerJoinSaleList as $item )
                <?php $i ++;

                ?>
                <tr id="row-{{ $item->id }}">
                  <td><span class="order">{{ $i }}</span></td>
                  <td style="text-align:center">{{ $item->customer_name }}</td>
                  <td style="text-align:center">
                    @if($item->type_sale == 1)
                      <span class="label label-info"> Bán trực tiếp</span>
                    @else
                      <span class="label label-success"> Để lại số điện thoại khách</span>
                    @endif
                  </td>
                  <td style="text-align:center">{{ $item->object_type }}</td>
                  <td style="text-align:center;    cursor: pointer;" >
                    @if($item->status_join == 0)
                      <span data-toggle="modal" data-target="#updateStatusJoin{{ $item->id }}" data-whatever="@mdo" class="label label-danger"> Từ chối</span>
                    @elseif($item->status_join == 1)
                      <span data-toggle="modal" data-target="#updateStatusJoin{{ $item->id }}" data-whatever="@mdo" class="label label-default"> Chờ duyệt</span>
                    @else
                      <span data-toggle="modal" data-target="#updateStatusJoin{{ $item->id }}" data-whatever="@mdo" class="label label-success"> Đã duyệt</span>
                    @endif
                  </td>
                  <td style="text-align:center">
                    @if($item->status_sale == 0)
                      <span class="label label-info"> Chưa bán</span>
                    @else
                      <span class="label label-success"> Đã bán</span>
                    @endif
                  </td>
                  <td>{{ number_format($item->commission_start) }} </td>
                  <td>{{ number_format($item->commission_end) }} </td>
                  <td>{{ date('d-m-Y h:i',strtotime($item->created_at)) }} </td>

                  <td style="white-space:nowrap; text-align:right">
                    <a class="btn btn-default btn-sm" href="{{ route('customer.join-sale-list', ['id' => $item->customer_id]) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>
                    {{--<a href="{{ route( 'product.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>--}}
                    <a onclick="return callDelete('{{ $item->title }}','{{ route( 'product.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>

                  </td>
                </tr>

                <!-- Start Popup save status_join -->
                <div class="modal fade" id="updateStatusJoin{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                  <div class="modal-dialog" role="document">

                    <div class="modal-content ">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Cập nhật tình trạng tham gia bán</h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <div class="radio">
                            <label>
                              <input type="radio" name="status_join{{ $item->id }}" value="0" {!! $item->status_join == 0 ? 'checked' : '' !!}>
                              Từ chối
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="status_join{{ $item->id }}" value="1" {!! $item->status_join == 1 ? 'checked' : '' !!}>
                              Chờ duyệt
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="status_join{{ $item->id }}" value="2" {!! $item->status_join == 2 ? 'checked' : '' !!}>
                              Chấp nhận
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div id="collapseSuccess{{ $item->id }}" class="hide">
                          <div class="alert alert-success" role="alert">Cập nhật thành công! </div>
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary btnUpdateStatusJoin"  data-id="{{ $item->id }}" >Cập nhật</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Popup save status_join -->
              @endforeach

              <input type="hidden" id="productId" value="{{ $detailProduct->id }}">
              <input type="hidden" id="routeUpdateStatusJoinAjax" value="{{ route('product.ajax-update-customer-join-sale')  }}">
            @else
              <tr>
                <td colspan="9">Không có dữ liệu.</td>
              </tr>
            @endif

            </tbody>
          </table>
        </div>

      </div>
      <!-- /.box list customer join sale-->
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
  $('.btnUpdateStatusJoin').click(function(){
    var error = [];
    var id = $(this).data('id');
    var statusJoin = $('input[name=status_join'+id+']:checked', '#updateStatusJoin'+id).val();

    if(!statusJoin) {
      error.push('typeSale');
    }

    if(error.length) {
      for(i in error) {
        $('#'+error[i]).addClass('error');
      }
      return false;
    }

    if(!error.length)
    {
      $('.btnUpdateStatusJoin').prop('disabled', true);
      $.ajax({
        url: $('#routeUpdateStatusJoinAjax').val(),
        method: "POST",
        data : {
          statusJoin: statusJoin,
          id: id
        },
        success : function(data){
          if (data.error == 0){
            $('#collapseSuccess'+id).removeClass('hide');
            setTimeout(function(){
              window.location.reload(1);
            }, 2000);
          }
        }
      });
    }

  });
});

</script>
@stop