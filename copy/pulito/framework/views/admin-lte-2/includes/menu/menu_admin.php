<li class="<?php echo ($_GET['page'] == 'akuntability' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-balance-scale"></i>
        <span>Akuntabilitas</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'akuntability' ? 'all' : 'none') ?>;">
        <li>
            <a href="#"><i class="fa fa-angle-right"></i> Kas <i class="fa fa-angle-left pull-right"></i></a>
            
            <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'akuntability' ? 'all' : 'none') ?>;">
                <li><a href="<?php echo site_url('page=akuntability&act=akt_peng_kas_list') ?>"><i class="fa fa-chevron-circle-right"></i> Pengeluaran</a></li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-angle-right"></i> Bank <i class="fa fa-angle-left pull-right"></i></a>
            
            <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'akuntability' ? 'all' : 'none') ?>;">
                <li><a href="<?php echo site_url('page=akuntability&act=akt_peng_bank_list') ?>"><i class="fa fa-chevron-circle-right"></i> Pengeluaran</a></li>
            </ul>
        </li>
    </ul>
</li>