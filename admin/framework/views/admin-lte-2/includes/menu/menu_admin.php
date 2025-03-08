<!--STAFF ADMIN-->
<li class="<?php echo ($_GET['page'] == 'produk' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-database"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'produk' ? 'all' : 'none') ?>;">
        <li><a href="<?php echo site_url('page=produk&act=prod_pelanggan_list') ?>"><i class="fa fa-angle-right"></i> Pelanggan</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_kategori_list') ?>"><i class="fa fa-angle-right"></i> Semua Kategori</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_kategori1_list') ?>"><i class="fa fa-angle-right"></i> Kategori</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_kategori2_list') ?>"><i class="fa fa-angle-right"></i> Sub Kategori 1</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_barang_list') ?>"><i class="fa fa-angle-right"></i> Bahan</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_lokasi_list') ?>"><i class="fa fa-angle-right"></i> Lokasi</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_member_list') ?>"><i class="fa fa-angle-right"></i> Member</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_diskon_list') ?>"><i class="fa fa-angle-right"></i> Diskon</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_charge_list') ?>"><i class="fa fa-angle-right"></i> Charge / Biaya</a></li>
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
<li class="<?php echo ($_GET['page'] == 'laporan' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-files-o"></i>
        <span>Pelaporan</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'laporan' ? 'all' : 'none') ?>;">
        <li><a href="<?php echo site_url('page=laporan&act=data_penjualan') ?>"><i class="fa fa-angle-right"></i> Data Transaksi</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_penjualan_det') ?>"><i class="fa fa-angle-right"></i> Data Terjual</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_packing') ?>"><i class="fa fa-angle-right"></i> Data Packing</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_keuangan') ?>"><i class="fa fa-angle-right"></i> Data Keuangan</a></li>
    </ul>
</li>