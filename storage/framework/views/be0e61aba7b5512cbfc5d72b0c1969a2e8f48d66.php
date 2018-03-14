<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Hoa hồng
           <?php if(!empty($detailProduct)): ?>
           : <span style="color:blue"><?php echo e($detailProduct->title); ?></span>
           <?php endif; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo e(route( 'hh.index' )); ?>">Hoa hồng</a></li>
            <li class="active">Danh sách</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php if(Session::has('message')): ?>
                <p class="alert alert-info" ><?php echo e(Session::get('message')); ?></p>
                <?php endif; ?>                
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách ( <?php echo e($items->total()); ?> )</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div style="text-align:center">
                       <?php echo e($items->appends( $arrSearch )->links()); ?>

                      </div> 
                        <table class="table table-bordered" id="table-list-data">
                            <tr>
                                <th style="width: 1%">#</th>
                                
                                <th>Sản phẩm</th>
                                <th width="150px">Ngày bán</th>
                                <th width="" class="text-right">Hoa hồng</th>
                                
                            </tr>
                            <tbody>
                                <?php if( $items->count() > 0 ): ?>
                                <?php $i = $total = 0; ?>
                                <?php foreach( $items as $item ): ?>
                                <?php $i ++; ?>
                                <tr id="row-<?php echo e($item->id); ?>">
                                    <td><span class="order"><?php echo e($i); ?></span></td>
                                    
                                    <td> <?php echo e($item->product->title); ?>

                                    </td> 
                                    <td>
                                        <?php echo e(date('d-m-Y', strtotime($item->updated_at))); ?>

                                    </td>                       
                                    <td  class="text-right">                                      
                                        <?php if($role == 3): ?>
                                        <?php 
                                        $hh = $item->hh_pr;
                                        ?>
                                        <?php echo e(number_format($item->hh_pr)); ?>

                                        <?php elseif($role == 5): ?>
                                         <?php 
                                        $hh = $item->hh_ctv;
                                        ?>
                                        <?php echo e(number_format($item->hh_ctv)); ?>

                                        <?php elseif($role == 4): ?>
                                        <?php 
                                        $hh = $item->hh_cs;
                                        ?>
                                        <?php echo e(number_format($item->hh_cs)); ?>

                                        <?php endif; ?>
                                        <?php 
                                        $total+= $hh;
                                        ?>
                                    </td>
                                    
                                    
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                  <th colspan="3" class="text-right">Tổng cộng</th>
                                  <th class="text-right"><?php echo e(number_format($total)); ?></th>
                                </tr>
                                <?php else: ?>
                                <tr>
                                    <td colspan="9">Không có dữ liệu.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                         <div style="text-align:center">
                       <?php echo e($items->appends( $arrSearch )->links()); ?>

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
    .pagination{
        margin:0px !important;
    }
</style>
<div id="lichModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tạo lịch hẹn</h4>
      </div>
      <form action="<?php echo e(route('hen.store')); ?>" method="POST" id="formHen">
      <div class="modal-body">
        
            <input type="hidden" name="join_id" id="join_id" value="">
            <div class="form-group col-md-5">
              <label>Ngày hẹn<span class="red-star">*</span></label>
              <input type="text" class="form-control datepicker" name="ngay_hen" id="ngay_hen" value="">
            </div>           
            <div class="form-group col-md-7" >
              <label>Ghi chú</label>
              <textarea class="form-control" rows="2" name="ghi_chu" id="ghi_chu"></textarea>
            </div>
            <div id="load-lich-hen" style="margin-top:20px">
                
            </div>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-primary btn-sm btnSaveHen" >Save</button>
        <button type="button" class="btn btn-default  btn-sm" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
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
        $('#type_sale, #cskh_status, #pr_status, #ctv_id').change(function(){    
          $('#searchForm').submit();
        });  
        $('.datepicker').datepicker({
    dateFormat : 'dd-mm-yy'
  });
        $('.tao-lich-hen').click(function(){
            var join_id = $(this).data('value');
            $('#join_id').val(join_id);
            $.ajax({
                  url: "<?php echo e(route('hen.ajax-list')); ?>",
                  type: "GET",
                  async: false,
                  data: {          
                      join_id : join_id
                  },
                  success: function(data){
                     $('#load-lich-hen').html(data);                    
                  }
              });
        });
      $('.change-status').change(function(){
            var col = $(this).data('col');
            var table = $(this).data('table');
            var id = $(this).data('id');
            var status = $(this).val();
            $.ajax({
                  url: "<?php echo e(route('update-status')); ?>",
                  type: "POST",
                  async: false,
                  data: {          
                      col : col,
                      table : table,
                      id : id,
                      status : status
                  },
                  success: function(data){
                      window.location.reload();                     
                  }
              });
      });
      $('.btnSuccess').click(function(){
            if(confirm('Bạn có chắc chắn không?')){
                var col = $(this).data('col');
                var table = $(this).data('table');
                var id = $(this).data('id');
                var status = 1;
                $.ajax({
                      url: "<?php echo e(route('update-status')); ?>",
                      type: "POST",
                      async: false,
                      data: {          
                          col : col,
                          table : table,
                          id : id,
                          status : status
                      },
                      success: function(data){
                          //window.location.reload();                     
                      }
                  });
            }
      });
      $('.btnSaveHen').click(function(){
        if($('#ngay_hen').val()== ''){
            alert('Chưa nhập ngày hẹn.');
            return false;
        }
        $.ajax({
          url: "<?php echo e(route('hen.store')); ?>",
          type: "POST",
          async: false,
          data: $('#formHen').serialize(),
          success: function(data){
             window.location.reload();                     
          }
      });
      });
    });
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>