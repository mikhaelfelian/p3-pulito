<li class="<?php echo ($_GET['page'] == 'produk' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-database"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'produk' ? 'all' : 'none') ?>;">
        <li><a href="<?php echo site_url('page=produk&act=prod_penj_list') ?>"><i class="fa fa-angle-right"></i> Penjahit</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_list') ?>"><i class="fa fa-angle-right"></i> Produk</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_plat_list') ?>"><i class="fa fa-angle-right"></i> Platform</a></li>
    </ul>
</li>

<li class="<?php echo ($_GET['page'] == 'transaksi' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-shopping-cart"></i>
        <span>Transaksi</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'transaksi' ? 'all' : 'none') ?>;">
        <li><a href="<?php echo site_url('page=transaksi&act=trans_jual_list') ?>"><i class="fa fa-angle-right"></i> Data Penjualan</a></li>
    </ul>
</li>