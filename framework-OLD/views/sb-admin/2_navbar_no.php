<?php $user = $this->session->userdata('login') ?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?php $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row() ?>
        <?php $session = $this->session->userdata('login') ?>
        <?php // $user    = $this->ion_auth->user()->row() ?>
        <!--<img src="<?php echo base_url('assets/theme/4-col-portofolio/logo.jpg') ?>" style="width: 5%;">-->
        <a class="navbar-brand" href="<?php echo base_url('dashboard.php') ?>" target=""><?php echo strtoupper($setting->judul) ?></a>
        <a class="navbar-brand" href="#" style="color: #666666"><small><?php echo 'Selamat Datang, '.ucwords($this->ion_auth->user()->row()->first_name).' - Login terakhir : '.unix_to_human($this->ion_auth->user()->row()->last_login) ?></small></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-shopping-cart fa-fw"></i> [Penjualan] <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="<?php echo site_url('front/data_penjualan.php') ?>"><i class="fa fa-arrow-right fa-fw"></i> Data Penjualan</a>
                </li>
                <li>
                    <a href="<?php echo site_url('front/data_pelanggan.php') ?>"><i class="fa fa-arrow-right fa-fw"></i> Data Pelanggan</a>
                </li>
                <li>
                    <a href="<?php echo base_url('front/data_barang.php') ?>"><i class="fa fa-arrow-right fa-fw"></i> Data Barang</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?php echo ucwords($this->ion_auth->user()->row()->username) ?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="<?php echo site_url('pengaturan.php') ?>"><i class="fa fa-gear fa-fw"></i> Pengaturan</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo base_url('logout.php') ?>" onclick="return confirm('Keluar ?')"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->    
    <!-- /.navbar-static-side -->
</nav>
