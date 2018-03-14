<?php $__env->startSection('content'); ?>
<?php 
$role = Auth::user()->role;
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Khách hàng
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo e(route('data.index')); ?>">Khách hàng</a></li>
      <li class="active">Chỉnh sửa </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="<?php echo e(route('data.index')); ?>" style="margin-bottom:5px">Quay lại</a>     
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Chỉnh sửa
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" method="POST" action="<?php echo e(route('data.update')); ?>" id="formData">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="id" value="<?php echo e($detail->id); ?>">
            <input type="hidden" name="type" value="<?php echo e($detail->type); ?>">
            <div class="box-body">
              <?php if(Session::has('message')): ?>
              <p class="alert alert-info" ><?php echo e(Session::get('message')); ?></p>
              <?php endif; ?>
              <?php if(count($errors) > 0): ?>
                  <div class="alert alert-danger">
                      <ul>
                          <?php foreach($errors->all() as $error): ?>
                              <li><?php echo e($error); ?></li>
                          <?php endforeach; ?>
                      </ul>
                  </div>
              <?php endif; ?>                                      
               <!-- text input -->
              <div class="form-group">
                <label>Họ tên khách<span class="red-star">*</span></label>
                <input type="text" class="form-control"  name="name" id="name" value="<?php echo e($detail->name); ?>">
              </div>             
              <div class="form-group">
                <label>Số điện thoại<span class="red-star">*</span></label>
                <input type="text" class="form-control"  name="phone" id="phone" value="<?php echo e($detail->phone); ?>">
              </div>
              <div class="form-group">
                <label>Địa chỉ<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="address" id="address" value="<?php echo e($detail->address); ?>">
              </div>
              <div class="form-group col-md-6">
                <label>Loại BĐS</label>
                 <input type="text" class="form-control" name="loai_bds" id="loai_bds" value="<?php echo e($detail->loai_bds); ?>">
              </div>
              <div class="form-group col-md-6">
                <label>Pháp lý</label>
                 <input type="text" class="form-control" name="loai_so" id="loai_so" value="<?php echo e($detail->loai_so); ?>">
              </div> 
              <div class="form-group col-md-6">
                <label>Diện tích</label>
                 <input type="text" class="form-control" name="dien_tich" id="dien_tich" value="<?php echo e($detail->dien_tich); ?>">
              </div>
              <div class="form-group col-md-6">
                <label>Giá</label>
                 <input type="text" class="form-control" name="gia" id="gia" value="<?php echo e($detail->gia); ?>">
              </div>
              <div class="form-group col-md-6">
                <label>Hướng</label>
                 <input type="text" class="form-control" name="huong" id="huong" value="<?php echo e($detail->huong); ?>">
              </div>
              <div class="form-group col-md-6">
                <label>Số lầu</label>
                 <input type="text" class="form-control" name="so_lau" id="so_lau" value="<?php echo e($detail->so_lau); ?>">
              </div>
              <div class="form-group col-md-6">
                <label>Số phòng</label>
                 <input type="text" class="form-control" name="so_phong" id="so_phong" value="<?php echo e($detail->so_phong); ?>">
              </div>
              <div class="form-group col-md-6">
                <label>Số toilet</label>
                 <input type="text" class="form-control" name="so_toilet" id="so_toilet" value="<?php echo e($detail->so_toilet); ?>">
              </div>
              <div class="form-group">
                <label>Đường trước nhà</label>
                 <input type="text" class="form-control" name="duong_truoc_nha" id="duong_truoc_nha" value="<?php echo e($detail->duong_truoc_nha); ?>">
              </div>
              <div class="form-group">
                <label>Ngày gặp</label>
                 <input type="text" class="form-control" name="ngay_gap" id="ngay_gap" value="<?php echo e($detail->ngay_gap); ?>">
              </div>
              <?php if($role == 2): ?>
              <div class="form-group">
                  <label>Trạng thái</label>              
                  <select class="form-control" name="status_1" id="status_1">                      
                      <option value="1" <?php echo e($detail->status_1 == 1 ? "selected" : ""); ?>>Chưa gọi</option>
                      <option value="2" <?php echo e($detail->status_1 == 2 ? "selected" : ""); ?>>Đang gọi</option>
                      <option value="3" <?php echo e($detail->status_1 == 3 ? "selected" : ""); ?>>Đã gọi</option>
                  </select>
                </div>

              <div class="form-group">
                  <label style="margin: 20px;color:red"><input type="checkbox" name="moigioi" value="1">MÔI GIỚI</label>
                </div>    
              <?php elseif($role == 3): ?>
              <div class="form-group">
                  <label>Trạng thái</label>              
                  <select class="form-control" name="status_2" id="status_2">                      
                      <option value="1" <?php echo e($detail->status_2 == 1 ? "selected" : ""); ?>>Chưa gặp</option>
                      <option value="2" <?php echo e($detail->status_2 == 2 ? "selected" : ""); ?>>Không gặp được</option>
                      <option value="3" <?php echo e($detail->status_2 == 3 ? "selected" : ""); ?>>Không chốt được</option>
                      <option value="4" <?php echo e($detail->status_2 == 4 ? "selected" : ""); ?>>Đã chốt</option>
                  </select>
              </div>
              <?php endif; ?>
            <!-- /.box-body -->    
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="<?php echo e(route('data.index')); ?>">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5"></div>
     
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<style type="text/css">
  .checkbox+.checkbox, .radio+.radio{
    margin-top: 10px !important;
  }
</style>
<input type="hidden" id="route_upload_tmp_image" value="<?php echo e(route('image.tmp-upload')); ?>">
 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="<?php echo e(URL::asset('public/assets/js/datetimepicker.js')); ?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.datetime').datetimepicker({
        format:'d-m-Y H:i',                
      });
    <?php if($role == 3 && $detail->status_2 != 4): ?>
        $('form input[type="text"]').attr('readonly', 'readonly').removeAttr('id');
        <?php endif; ?>
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>