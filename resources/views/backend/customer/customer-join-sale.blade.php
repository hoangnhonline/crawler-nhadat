@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Danh sách giao dịch cộng tác viên tham gia bán
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
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{ $customerInfo->image_url }}" alt="User profile picture">

          <h3 class="profile-username text-center">{{ $customerInfo->fullname }}</h3>

          <p class="text-muted text-center">{{ $customerInfo->username }}</p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <strong><i class="fa fa-map-marker margin-r-5"></i>Địa chỉ </strong>
              <a class="pull-right">{{ $customerInfo->address }}</a>
            </li>
            <li class="list-group-item">
              <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
              <a class="pull-right">{{ $customerInfo->email }}</a>
            </li>
            <li class="list-group-item">
              <strong><i class="fa fa-phone margin-r-5"></i> Điện thoại</strong>
              <a class="pull-right">{{ $customerInfo->phone }}</a>
            </li>
            <li class="list-group-item">
              <strong><i class="fa fa-phone margin-r-5"></i> Điểm</strong>
              <a class="pull-right">{{ $customerInfo->score }}</a>
            </li>
          </ul>
          @if($customerInfo->type == 1)
            <span class="btn btn-success btn-block"> Đã duyệt</span>
          @else
            <span class="btn btn-default btn-block"> Chưa duyệt</span>
          @endif
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- About Me Box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Tổng quát giao dịch</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <strong><i class="fa fa-book margin-r-5"></i> Tổng số giao dịch</strong>

          <p class="text-muted">
            10
          </p>

          <hr>

          <strong><i class="fa fa-map-marker margin-r-5"></i> Giao dịch thành công</strong>

          <p class="text-muted">3</p>

          <hr>

          <strong><i class="fa fa-pencil margin-r-5"></i> Hoa hồng đã nhận</strong>

          <p class="text-muted">12,000</p>

          <hr>


        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#activity" data-toggle="tab">Danh sách giao dịch</a></li>
          {{--<li><a href="#timeline" data-toggle="tab">Timeline</a></li>--}}
          <li><a href="#settings" data-toggle="tab">Cập nhật thông tin</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="activity">
            <table class="table table-bordered" id="table-list-data">
              <tr>
                <th style="width: 1%">#</th>
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
                @endforeach

              @else
                <tr>
                  <td colspan="9">Không có dữ liệu.</td>
                </tr>
              @endif

              </tbody>
            </table>

          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="timeline">
            {{--<!-- The timeline -->
            <ul class="timeline timeline-inverse">
              <!-- timeline time label -->
              <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
              </li>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-envelope bg-blue"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                  <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                  <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-primary btn-xs">Read more</a>
                    <a class="btn btn-danger btn-xs">Delete</a>
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-user bg-aqua"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                  <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                  </h3>
                </div>
              </li>
              <!-- END timeline item -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-comments bg-yellow"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                  <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                  <div class="timeline-body">
                    Take me to your leader!
                    Switzerland is small and neutral!
                    We are more like Germany, ambitious and misunderstood!
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <!-- timeline time label -->
              <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
              </li>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-camera bg-purple"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                  <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                  <div class="timeline-body">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <li>
                <i class="fa fa-clock-o bg-gray"></i>
              </li>
            </ul>--}}
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="settings">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Name</label>

                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputName" placeholder="Name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Name</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputName" placeholder="Name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                <div class="col-sm-10">
                  <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-danger">Submit</button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
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