<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Thêm chính chủ
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo e(route('data.index')); ?>">Chính chủ</a></li>
      <li class="active">Thêm mới </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="<?php echo e(route('data.index', ['moigioi' => 2])); ?>" style="margin-bottom:5px">Quay lại</a>     
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Thêm mới
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" method="POST" action="<?php echo e(route('data.store')); ?>" id="formData">
            <?php echo csrf_field(); ?>

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
              <div class="form-group">
                <label>Hình thức<span class="red-star">*</span></label>
                <select name="type" id="type" class="form-control">
                    <option value="">--Chọn--</option>
                    <option value="1" <?php echo e(old('type') == 1 ? "selected" : ""); ?>>Bán</option>
                    <option value="2" <?php echo e(old('type') == 2 ? "selected" : ""); ?>>Cho thuê</option>
                  </select>
              </div>                            
               <!-- text input -->
              <div class="form-group">
                <label>Họ tên khách</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo e(old('name')); ?>">
              </div>              
              <div class="form-group">
                <label>Số điện thoại<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e(old('phone')); ?>">
              </div>
              <div class="form-group">
                <label>Địa chỉ<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="address" id="address" value="<?php echo e(old('address')); ?>">
              </div>
              <div class="form-group">
                <label>Giá</label>
                <input type="text" class="form-control" name="gia" id="gia" value="<?php echo e(old('gia')); ?>">
              </div> 
              <div class="form-group">
                <label>Diện tích</label>
                <input type="text" class="form-control" name="dien_tich" id="dien_tich" value="<?php echo e(old('dien_tich')); ?>">
              </div>            
              <div class="form-group">
                <label>Ghi chú</label>
                <textarea rows="5" name="notes" id="notes" class="form-control"><?php echo e(old('notes')); ?></textarea>
              </div> 
              
              <div class="form-group">
                    <label for="email">Trạng thái <span class="red-star">*</span></label>
                    <select class="form-control" name="status_1" id="status_1">
                        <option value="1" <?php echo e(old('status_1') == 1 ? "selected" : ""); ?>>Chưa gọi</option>
                        <option value="2" <?php echo e(old('status_1') == 2 ? "selected" : ""); ?>>Đang gọi</option>
                        <option value="3" <?php echo e(old('status_1') == 3 ? "selected" : ""); ?>>Đã gọi</option>
                    </select>
                  </div>
              </div>                          
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>