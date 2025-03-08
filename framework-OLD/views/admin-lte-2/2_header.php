<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="<?php echo base_url('dashboard.php') ?>" class="navbar-brand"><b>PULITO</b></a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?php echo base_url('dashboard.php') ?>">Dashboard</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaksi <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url('cart/trans_order_list.php') ?>">Data Transaksi</a></li>
                                <li><a href="<?php echo base_url('cart/trans_rak_list.php') ?>">Data Lokasi Rak</a></li>
                                <li><a href="<?php echo base_url('cart/trans_antrian_list.php') ?>">Set Lokasi Rak</a></li>
                                <li><a href="<?php echo base_url('cart/trans_bayar_list.php') ?>">Set Pembayaran & Ambil</a></li>
                                <!--<li><a href="<?php echo base_url('cart/trans_ambil_list.php') ?>">Pengambilan</a></li>-->
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Member <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url('member.php') ?>">Data Pelanggan</a></li>
                                <!--<li><a href="<?php echo base_url('member_deposit.php') ?>">Deposit</a></li>-->
                            </ul>
                        </li>
						<!--
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sinkron Data <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url('pengaturan/eksport.php') ?>">Ekspor [Kirim Data]</a></li>
                                <li><a href="<?php echo base_url('pengaturan/import.php') ?>">Impor [Ambil Data]</a></li>
                            </ul>
                        </li>
						-->
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="<?php echo base_url('assets/theme/admin-lte-2/dist/img/user2-160x160.jpg') ?>" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs"><?php echo ucwords($this->ion_auth->user()->row()->first_name) ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="<?php echo base_url('assets/theme/admin-lte-2/dist/img/user2-160x160.jpg') ?>" class="img-circle" alt="User Image">
                                    <p>
                                        <?php $user_id = $this->ion_auth->user()->row()->id ?>
                                        <?php echo ucwords($this->ion_auth->user()->row()->first_name) ?>
                                        <?php $level = $this->ion_auth->get_users_groups($user_id->id)->row(); ?>
                                        <small><?php echo $level->description; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('logout.php') ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-custom-menu -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>