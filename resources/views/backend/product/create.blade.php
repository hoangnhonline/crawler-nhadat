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
      <li><a href="{{ route('product.index') }}">Sản phẩm</a></li>
      <li class="active">Thêm mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('product.index', ['estate_type_id' => $estate_type_id, 'type' => $type]) }}" style="margin-bottom:5px">Quay lại</a>    
    <form role="form" method="POST" action="{{ route('product.store') }}" id="dataForm">
    <div class="row">
      <!-- left column -->      
      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Chỉnh sửa
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}          
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
                <div>

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Thông tin chi tiết</a></li>
                    <li role="presentation"><a href="#lien-he" aria-controls="tien-ich" role="tab" data-toggle="tab">Thông tin liên hệ</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Hình ảnh</a></li>                    
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                      
                        <input type="hidden" name="type" value="1">
                        <div class="form-group pleft-5">
                          <label for="email">Danh mục<span class="red-star">*</span></label>
                          <select class="form-control" name="estate_type_id" id="estate_type_id">
                            <option value="">--Chọn--</option>
                            @foreach( $estateTypeArr as $value )
                            <option value="{{ $value->id }}"
                            {{ old('estate_type_id', $estate_type_id) == $value->id ? "selected" : "" }}
                            >{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>                       
                        <div class="form-group col-md-4  pleft-5">
                          <label for="email">Tỉnh/TP <span class="red-star">*</span></label>
                            <select class="form-control" name="city_id" id="city_id">
                                @foreach( $cityList as $value )
                                <option value="{{ $value->id }}"
                                {{ old('city_id', $city_id) == $value->id ? "selected" : "" }}                           

                                >{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4  pleft-5">
                          <label for="email">Quận <span class="red-star">*</span></label>
                            <select class="form-control" name="district_id" id="district_id">
                              <option value="">-- chọn --</option>
                            <?php 
                            if($city_id){
                              $districtList = App\Models\District::where('city_id', $city_id)->get();
                            }
                            ?>
                            <?php $district_id = old('district_id', $district_id); ?>
                                @foreach( $districtList as $value )
                                <option value="{{ $value->id }}"
                                {{ $district_id == $value->id ? "selected" : "" }}                           

                                >{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4 none-padding">
                          <label for="email">Phường <span class="red-star">*</span></label>
                          <select class="form-control" name="ward_id" id="ward_id">
                            <option value="">--Chọn--</option>
                            <?php 
                            $wardList = App\Models\Ward::where('district_id', $district_id)->get();
                            ?>
                            @foreach( $wardList as $value )
                            <option value="{{ $value->id }}"
                            {{ old('ward_id') == $value->id ? "selected" : "" }}                           

                            >{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-6  pleft-5">
                          <label for="email">Đường</label>
                            <select class="form-control" name="street_id" id="street_id">
                            <option value="">--Chọn--</option>
                            <?php 
                            $streetList = App\Models\Street::where('district_id', $district_id)->get();
                            ?>
                                @foreach( $streetList as $value )
                                <option value="{{ $value->id }}"
                                {{ old('street_id') == $value->id ? "selected" : "" }}                           

                                >{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 none-padding">
                          <label for="email">Dự án</label>
                          <select class="form-control" name="project_id" id="project_id">
                            <option value="">--Chọn--</option>
                            @foreach( $projectList as $value )
                            <option value="{{ $value->id }}"
                            {{ old('project_id') == $value->id ? "selected" : "" }}
                            >{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group" >                  
                          <label>Tên <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">                  
                          <label>Slug <span class="red-star">*</span></label>                  
                          <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}">
                        </div>
                        <div class="form-group col-md-6 none-padding" >                  
                            <label>Giá bằng số<span class="red-star">*</span></label>
                            <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}">
                        </div>                       
                        <div class="form-group col-md-6" >                  
                            <label>Giá bằng chữ<span class="red-star">*</span></label>
                            <input type="text" class="form-control" name="price_text" id="price_text" value="{{ old('price_text') }}">
                        </div>
                        <div class="form-group col-md-6  pleft-5">
                          <label for="email">Khoảng giá<span class="red-star">*</span></label>
                            <select class="form-control" name="price_id" id="price_id">
                              <option value="">--Chọn--</option>
                                @foreach( $priceList as $value )
                                <option value="{{ $value->id }}"
                                {{ old('price_id') == $value->id ? "selected" : "" }}
                                >{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 none-padding">
                          <label for="email">Khoảng diện tích<span class="red-star">*</span></label>
                          <select class="form-control" name="area_id" id="area_id">
                            <option value="">--Chọn--</option>
                            @foreach( $areaList as $value )
                            <option value="{{ $value->id }}"
                            {{ old('area_id') == $value->id ? "selected" : "" }}
                            >{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <hr>
                        <u style="font-size:20px; font-weight:bold">HOA HỒNG</u>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-3" >                  
                            <label>Tổng hoa hồng<span class="red-star">*</span></label>
                            <input type="text" class="form-control" name="hoa_hong" id="hoa_hong" value="{{ old('hoa_hong') }}" placeholder="VND"> 
                        </div>
                        <div class="form-group col-md-3" >                  
                            <label>PR<span class="red-star">*</span></label>
                            <input type="text" class="form-control" name="hoa_hong_pr" id="hoa_hong_pr" value="{{ old('hoa_hong_pr') }}" placeholder="%"> 
                        </div>
                        <div class="form-group col-md-3" >                  
                            <label>Chăm sóc CTV<span class="red-star">*</span></label>
                            <input type="text" class="form-control" name="hoa_hong_cs" id="hoa_hong_cs" value="{{ old('hoa_hong_cs') }}" placeholder="%"> 
                        </div>
                        <div class="form-group col-md-3" >                  
                            <label>CTV<span class="red-star">*</span></label>
                            <input type="text" class="form-control" name="hoa_hong_ctv" id="hoa_hong_ctv" value="{{ old('hoa_hong_ctv') }}" placeholder="%"> 
                        </div>
                        <hr>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12 none-padding">
                            <label>Địa chỉ</label>
                             <input type="text" class="form-control" name="full_address" id="full_address" value="{{ old('full_address') }}">  
                        </div>
                        <div class="form-group col-md-4 none-padding">
                          <label>Diện tích <span class="red-star">*</span></label>                  
                          <input type="text" class="form-control" name="area" id="area" value="{{ old('area') }}">                        
                        </div>                        
                        <div class=" form-group col-md-4 none-padding pleft-5">
                          <label>Mặt tiền</label>                  
                          <input type="text" class="form-control" name="front_face" id="front_face" value="{{ old('front_face') }}">                        
                        </div>
                        <div class="form-group col-md-4 none-padding pleft-5">
                          <label>Đường trước nhà</label>                  
                          <input type="text" class="form-control" name="street_wide" id="street_wide" value="{{ old('street_wide') }}">                        
                        </div>
                        <div class="form-group col-md-3 none-padding">
                          <label>Số tầng</label>                  
                          <input type="text" class="form-control" name="no_floor" id="no_floor" value="{{ old('no_floor') }}">                        
                        </div>
                        <div class="form-group col-md-3 none-padding pleft-5">
                          <label>Số phòng</label>                  
                          <input type="text" class="form-control" name="no_room" id="no_room" value="{{ old('no_room') }}">                        
                        </div>
                        <div class="form-group col-md-3 none-padding pleft-5">
                          <label>Số WC</label>                  
                          <input type="text" class="form-control" name="no_wc" id="no_wc" value="{{ old('no_wc') }}">                        
                        </div>
                        <div class="form-group col-md-3 none-padding pleft-5">
                          <label>Hướng</label>                  
                          <select class="form-control" name="direction_id" id="direction_id">
                            @if( $directionArr->count() > 0)
                              @foreach( $directionArr as $value )
                              <option value="{{ $value->id }}" {{ old('direction_id') == $value->id  ? "selected" : "" }}>{{ $value->name }}</option>
                              @endforeach
                            @endif
                          </select>                       
                        </div>
                        <div class="form-group col-md-12">
                          <div class="checkbox">
                            <label style="font-weight:bold;color:red">
                              <input type="checkbox" name="is_hot" value="1" {{ old('is_hot') == 1 ? "checked" : "" }}>
                              Tin HOT
                            </label>
                          </div>               
                        </div>
                        <div class="form-group col-md-4 none-padding" >
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="cart_status" value="1" {{ old('cart_status') == 1 || old('cart_status') == NULL ? "checked" : "" }}>
                                {{ $type == 1 ? "Chưa bán" : "Còn trống" }}
                              </label>
                            </div>
                        </div>
                        <div class="form-group col-md-4 none-padding" >
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="cart_status" value="2" {{ old('cart_status') == 2 ? "checked" : "" }}>
                                {{ $type == 1 ? "Đã bán" : "Đã thuê" }}
                              </label>
                            </div>
                        </div>
                        <div class="form-group col-md-4 none-padding" >
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="cart_status" value="3" {{ old('cart_status') == 3 ? "checked" : "" }}>
                                Đã cọc
                              </label>
                            </div>
                        </div>                        
                        <div class="form-group form-group col-md-12 none-padding" style="margin-top:10px">
                            <label>Mô tả</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                          </div>
                          <input type="hidden" id="editor" value="description">
                          <div class="clearfix"></div>
                        <div class="form-group" style="margin-top:10px;margin-bottom:10px"> 
                          <input id="pac-input" class="controls" type="text" placeholder="Nhập địa chỉ để tìm kiếm">
                          <div id="map-abc"></div>
                      </div>
                        <div class="clearfix"></div>
                    </div><!--end thong tin co ban-->   
                    <div role="tabpanel" class="tab-pane" id="lien-he">
                        <div class="form-group col-md-6 " >                  
                            <label>Họ tên <span class="red-star">*</span></label>
                            <input type="text" class="form-control" name="contact_name" id="contact_name" value="{{ old('contact_name', 'Thanh Phú Thịnh Land') }}">
                        </div>
                        <div class="form-group col-md-6 none-padding pleft-5" >                  
                            <label>Địa chỉ</label>
                            <input type="text" class="form-control" name="contact_address" id="contact_address" value="{{ old('contact_address', '34 Trần Hưng Đạo, P.Tân Sơn Nhì, Q.Tân Phú') }}">
                        </div>                        
                        <div class="form-group col-md-6 " >                  
                            <label>Điện thoại</label>
                            <input type="text" class="form-control" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', '0919.356.178') }}">
                        </div>
                 
                            <input type="hidden" class="form-control" name="contact_mobile" id="contact_mobile" value="{{ old('contact_mobile') }}">
                        
                       
                            <input type="hidden" class="form-control" name="contact_email" id="contact_email" value="{{ old('contact_email') }}">
                       
                        <div class="clearfix"></div>
                     </div><!--end lien he -->                                      
                     <div role="tabpanel" class="tab-pane" id="settings">
                        <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                         
                          <div class="col-md-12" style="text-align:center">
                         
                            <button class="btn btn-primary btnMultiUpload" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                            <div class="clearfix"></div>
                            <div id="div-image" style="margin-top:10px"></div>
                          </div>
                          <div style="clear:both"></div>
                        </div>

                     </div><!--end hinh anh-->
                     
                  </div>

                </div>
                  
            </div>

            <div class="box-footer">
              <input type="hidden" name="longt" id="longt" value="" />
              <input type="hidden" name="latt" id="latt" value="" />
              <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('product.index', ['estate_type_id' => $estate_type_id, 'type' => $type])}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-4">      
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thông tin SEO</h3>
          </div>

          <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <label>Meta title </label>
                <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{ old('meta_title') }}">
              </div>
              <!-- textarea -->
              <div class="form-group">
                <label>Meta desciption</label>
                <textarea class="form-control" rows="6" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
              </div>  

              <div class="form-group">
                <label>Meta keywords</label>
                <textarea class="form-control" rows="4" name="meta_keywords" id="meta_keywords">{{ old('meta_keywords') }}</textarea>
              </div>  
              <div class="form-group">
                <label>Custom text</label>
                <textarea class="form-control" rows="6" name="custom_text" id="custom_text">{{ old('custom_text') }}</textarea>
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

<input type="hidden" id="route_upload_tmp_image_multiple" value="{{ route('image.tmp-upload-multiple') }}">
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
<input type="hidden" id="route_get_tien_ich" value="{{ route('product.ajax-get-tien-ich') }}">
<style type="text/css">
  .nav-tabs>li.active>a{
    color:#FFF !important;
    background-color: #3C8DBC !important;
  }

</style>

    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map-abc {
        height: 400px;
      }
    

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map-abc #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }     
      
    </style>
@stop
@section('js')
<script>
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map-abc'), {
          center: {lat: 10.7860332, lng: 106.6950147},
          zoom: 17,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
           var marker = new google.maps.Marker({
              position: new google.maps.LatLng(10.7860332, 106.6950147),
              draggable:true,
              map: map            
            });
           google.maps.event.addListener(marker,'dragend',function(event) {
                document.getElementById('latt').value = this.position.lat();
                document.getElementById('longt').value = this.position.lng();                
            });
        });

        var markers = [];       
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            document.getElementById('latt').value = place.geometry.location.lat();
            document.getElementById('longt').value = place.geometry.location.lng();
            var icon = {              
              size: new google.maps.Size(128, 128),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              draggable:true,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }

             // Clear out the old markers.
          markers.forEach(function(marker) {
            google.maps.event.addListener(marker,'dragend',function(event) {
                document.getElementById('latt').value = this.position.lat();
                document.getElementById('longt').value = this.position.lng();                
            });
          });
            
          });
          map.fitBounds(bounds);
        });
      }
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhxs7FQ3DcyDm8Mt7nCGD05BjUskp_k7w&libraries=places&callback=initAutocomplete"
         async defer></script>
<script type="text/javascript">

$(document).ready(function(){

$('#pac-input').on('keypress', function(e) {
    return e.which !== 13;
});
$(document).on('click', '.remove-image', function(){
  if( confirm ("Bạn có chắc chắn không ?")){
    $(this).parents('.col-md-3').remove();
  }
});   
     
     
      $(".select2").select2();
      $('#dataForm').submit(function(){
        
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
      
      var editor3 = CKEDITOR.replace( 'description',{
          language : 'vi',
          height : 300,
          toolbarGroups : [
            
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'links', groups: [ 'links' ] },           
            '/',
            
          ]
      });
      $('#btnUploadImage').click(function(){        
        $('#file-image').click();
      }); 
     
      var files = "";
      $('#file-image').change(function(e){
         files = e.target.files;
         
         if(files != ''){
           var dataForm = new FormData();        
          $.each(files, function(key, value) {
             dataForm.append('file[]', value);
          });   
          
          dataForm.append('date_dir', 0);
          dataForm.append('folder', 'tmp');

          $.ajax({
            url: $('#route_upload_tmp_image_multiple').val(),
            type: "POST",
            async: false,      
            data: dataForm,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#div-image').append(response);
                if( $('input.thumb:checked').length == 0){
                  $('input.thumb').eq(0).prop('checked', true);
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
     

      $('#title').change(function(){
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
      
      $('#district_id').change(function(){

            var district_id = $(this).val();
          $.ajax({
            url : '{{ route('get-child') }}',
            data : {
              mod : 'ward',
              col : 'district_id',
              id : district_id
            },
            type : 'POST',
            dataType : 'html',
            success : function(data){
              $('#ward_id').html(data);
            }
          });

          $.ajax({
            url : '{{ route('get-child') }}',
            data : {
              mod : 'street',
              col : 'district_id',
              id : district_id
            },
            type : 'POST',
            dataType : 'html',
            success : function(data){
              $('#street_id').html(data);
            }
          });

          $.ajax({
            url : '{{ route('get-child') }}',
            data : {
              mod : 'project',
              col : 'district_id',
              id : district_id
            },
            type : 'POST',
            dataType : 'html',
            success : function(data){
              $('#project_id').html(data);
            }
          })
        
      });
      $('#city_id').change(function(){                 
          $.ajax({
            url : '{{ route('get-child') }}',
            data : {
              mod : 'district',
              col : 'city_id',
              id : $('#city_id').val()
            },
            type : 'POST',
            dataType : 'html',
            success : function(data){
              $('#district_id').html(data);
              $('#ward_id, #project_id, #street_id').html('');
            }
          })
        
      });

    });
    
</script>
@stop
