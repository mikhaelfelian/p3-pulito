<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini" style="color: #FFFF00;"><b>PULITO</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" style="color: #FFFF00;"><b>PULITO</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!--<img src="<?php // echo base_url('./assets/admin-lte-2') . '/'; ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                            <i class="fa fa-user-circle"></i>
                            <span class="hidden-xs"><?php echo ucwords($this->ion_auth->user()->row()->username) ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <!--<img src="<?php // echo base_url('./assets/admin-lte-2') . '/'; ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->
                                <i class="fa fa-user-circle fa-5x"></i>
                                <p>
                                    <a href="<?php echo site_url('page=pengaturan&act=profile') ?>" style="color: #ffffff">
                                        <?php echo ucwords($this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name) ?>
                                    </a>  
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo site_url('page=login&act=logout') ?>" onclick="return confirm('Logout ?')" class="btn btn-default btn-flat">Keluar</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>