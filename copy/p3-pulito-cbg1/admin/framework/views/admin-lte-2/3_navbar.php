<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- search form -->

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENU NAVIGASI</li>
            <li class="<?php echo ($_GET['page'] == 'home' ? 'active' : '') ?>"><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></i></a></li>
             <?php akses::menuAkses() ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>