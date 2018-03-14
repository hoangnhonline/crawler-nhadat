<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo e(URL::asset('public/admin/dist/img/user2-160x160.jpg')); ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo e(Auth::user()->full_name); ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      
      <?php if(Auth::user()->role < 6): ?>
      <li <?php echo e(in_array(\Request::route()->getName(), ['data.edit', 'data.detail', 'data.index']) ? "class=active" : ""); ?>>
        <a href="<?php echo e(route('data.index')); ?>">
          <i class="fa fa-pencil-square-o"></i> 
          <span>Dữ liệu</span>         
        </a>       
      </li>
      <?php endif; ?>
      
      <?php if(Auth::user()->role == 1): ?>
      <li class="treeview <?php echo e(in_array(\Request::route()->getName(), ['account.index', 'info-seo.index', 'settings.index', 'settings.noti', 'menu.index', 'video.index', 'video.edit', 'video.create']) || (in_array(\Request::route()->getName(), ['custom-link.edit', 'custom-link.index', 'custom-link.create']) && isset($block_id) && $block_id == 2 ) ? 'active' : ''); ?>">
        <a href="#">
          <i class="fa  fa-gears"></i>
          <span>Cài đặt</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">  
          <li <?php echo e(\Request::route()->getName() == "account.index" ? "class=active" : ""); ?>><a href="<?php echo e(route('account.index')); ?>"><i class="fa fa-circle-o"></i> Users</a></li>          
        </ul>
      </li>
      <?php endif; ?>
      <!--<li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<style type="text/css">
  .skin-blue .sidebar-menu>li>.treeview-menu{
    padding-left: 15px !important;
  }
</style>