<table class="table table-bordered" id="table-list-data">
    <tr>
        <th style="width: 1%">#</th>        
        <th>Ngày hẹn</th>
        <th>Ghi chú</th>        
    </tr>
    <tbody>
        <?php if( $items->count() > 0 ): ?>
        <?php $i = 0; ?>
        <?php foreach( $items as $item ): ?>
        <?php $i ++; ?>
        <tr id="row-<?php echo e($item->id); ?>">
            <td><span class="order"><?php echo e($i); ?></span></td>
           
            <td>
                <?php echo e(date('d-m-Y', strtotime($item->ngay_hen))); ?>

            </td>                                   
            <td>
                <?php echo e($item->ghi_chu); ?>

            </td>            
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="9">Không có dữ liệu.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>