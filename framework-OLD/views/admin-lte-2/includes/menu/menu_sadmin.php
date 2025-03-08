<li class="<?php echo ($_GET['page'] == 'produk' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-database"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'produk' ? 'all' : 'none') ?>;">
        <li><a href="<?php echo site_url('page=produk&act=prod_pelanggan_list') ?>"><i class="fa fa-angle-right"></i> Pelanggan</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_kategori_list') ?>"><i class="fa fa-angle-right"></i> Kategori</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_barang_list') ?>"><i class="fa fa-angle-right"></i> Barang</a></li>
        <li><a href="<?php echo site_url('page=produk&act=prod_lokasi_list') ?>"><i class="fa fa-angle-right"></i> Barang</a></li>
    </ul>
</li>
<!--
<li class="<?php echo ($_GET['page'] == 'transaksi' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-shopping-cart"></i>
        <span>Transaksi</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'transaksi' ? 'all' : 'none') ?>;">
        <li><a href="<?php echo site_url('page=transaksi&act=trans_jual') ?>"><i class="fa fa-angle-right"></i> Penjualan</a></li>
        <li><a href="<?php echo site_url('page=transaksi&act=trans_jual_list') ?>"><i class="fa fa-angle-right"></i> Data Penjualan</a></li>
    </ul>
</li>

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
                <li><a href="<?php echo site_url('page=akuntability&act=akt_pem_kas_list') ?>"><i class="fa fa-chevron-circle-right"></i> Pemasukan</a></li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-angle-right"></i> Bank <i class="fa fa-angle-left pull-right"></i></a>
            
            <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'akuntability' ? 'all' : 'none') ?>;">
                <li><a href="<?php echo site_url('page=akuntability&act=akt_peng_bank_list') ?>"><i class="fa fa-chevron-circle-right"></i> Pengeluaran</a></li>
                <li><a href="<?php echo site_url('page=akuntability&act=akt_pem_bank_list') ?>"><i class="fa fa-chevron-circle-right"></i> Pemasukan</a></li>
            </ul>
        </li>
        <li><a href="<?php echo site_url('page=akuntability&act=akt_modal_list') ?>"><i class="fa fa-angle-right"></i> Modal</a></li>
    </ul>
</li>

<li class="<?php echo ($_GET['page'] == 'laporan' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-files-o"></i>
        <span>Pelaporan</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'laporan' ? 'all' : 'none') ?>;">
        <li><a href="<?php echo site_url('page=laporan&act=data_penjahit&case=semua') ?>"><i class="fa fa-angle-right"></i> Data Penjahit</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_produk&case=semua') ?>"><i class="fa fa-angle-right"></i> Data Persediaan</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_penjualan&case=semua') ?>"><i class="fa fa-angle-right"></i> Data Penjualan</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_insentif&case=semua') ?>"><i class="fa fa-angle-right"></i> Data Incentive</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_pemasukan&case=semua&status=semua') ?>"><i class="fa fa-angle-right"></i> Data Pemasukan</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_pengeluaran&case=semua&status=semua') ?>"><i class="fa fa-angle-right"></i> Data Pengeluaran</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_kas&case=semua&status=semua') ?>"><i class="fa fa-angle-right"></i> Kas</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_piutang&case=semua') ?>"><i class="fa fa-angle-right"></i> Piutang</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_lr&case=semua&status=') ?>"><i class="fa fa-angle-right"></i> Laba / Rugi</a></li>
        <li><a href="<?php echo site_url('page=laporan&act=data_modal&case=semua&status=') ?>"><i class="fa fa-angle-right"></i> Modal</a></li>
    </ul>
</li>
-->

<li class="<?php echo ($_GET['page'] == 'pengaturan' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-gear"></i>
        <span>Pengaturan</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'pengaturan' ? 'all' : 'none') ?>;">
        <!--<li><a href="<?php echo site_url('page=pengaturan&act=mail_notif') ?>"><i class="fa fa-angle-right"></i> Pengaturan</a></li>-->
        <li><a href="<?php echo site_url('page=pengaturan&act=user_list') ?>"><i class="fa fa-angle-right"></i> Pengguna</a></li>
        <li><a href="<?php // echo site_url('page=pengaturan&act=backup_db') ?>"><i class="fa fa-angle-right"></i> Backup / Restore</a></li>
    </ul>
</li>