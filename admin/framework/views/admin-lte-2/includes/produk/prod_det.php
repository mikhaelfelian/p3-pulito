<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Produk <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=produk&act=prod_list') ?>">Produk</a></li>
            <li class="active">Detail</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail Produk</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group <?php echo (!empty($hasError['penjahit']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama Penjahit</label>
                                    <br/>
                                    <?php echo ucwords($this->db->where('id', $produk->id_penjahit)->get('tbl_m_penjahit')->row()->penjahit) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Kode</label>
                                    <br/>
                                    <?php echo $produk->kode ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['produk']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Jenis</label>
                                    <br/>
                                    <?php echo ucwords($produk->produk) ?>
                                </div>                                
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Tgl Barang Jadi</label>
                                            <br/>
                                            <?php $tgl = explode('-', $produk->tgl_simpan) ?>
                                            <?php echo $tgl[2] . '/' . $tgl[1] . '/' . $tgl[0] ?>
                                        </div> 
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Jml</label>
                                            <br/>
                                            <?php echo (!empty($produk_tot_stok->jml) ? $produk_tot_stok->jml : '0') ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                            <!--                                            <label class="control-label">Berat</label>
                                                                                        <br/>-->
                                            <?php // echo $produk->berat ?>
                                        </div>
                                    </div>
                                </div>                     
                                <div class="form-group <?php echo (!empty($hasError['Jml']) ? 'has-error' : '') ?>">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                <label class="control-label">Ongkos Tas</label>
                                                <br/>
                                                <?php echo general::format_angka($produk->harga_ongk) ?>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xs-6">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                <label class="control-label">Harga Beli</label>
                                                <br/>
                                                <?php echo general::format_angka($produk->harga_beli) ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>                           
                                <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label class="control-label">Harga Jual</label>
                                            <br/>
                                            <?php echo general::format_angka($produk->harga_jual) ?>
                                        </div>
                                        <div class="col-xs-6">

                                        </div>
                                    </div>
                                </div>       
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                <label class="control-label">Incentive</label>
                                                <br/>
                                                <?php echo general::format_angka($produk->insentif) ?>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xs-6">
                                            <!--<label class="control-label">Lama Pengerjaan</label>-->
                                            <!--<br/>-->
                                            <?php // echo $produk->lama_pengerjaan ?>
                                        </div>
                                    </div>
                                </div>                      
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="box-title">Data Stok</h4>
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-left">Penjahit</th>
                                        <th class="text-left">Stok</th>
                                    </tr>
                                    <?php $no = 1 ?>
                                    <?php foreach ($produk_stok as $produk_stok) { ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?></td>
                                            <td class="text-left"><?php echo $produk_stok->penjahit ?></td>
                                            <td class="text-left"><?php echo $produk_stok->stok ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="box-title">Harga Grosir</h4>
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-left">Keterangan</th>
                                        <th class="text-left">Harga</th>
                                    </tr>
                                    <?php $no = 1 ?>
                                    <?php foreach ($produk_hrg as $produk_hrg) { ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?></td>
                                            <td class="text-left"><?php echo $produk_hrg->keterangan ?></td>
                                            <td class="text-left"><?php echo general::format_angka($produk_hrg->harga) ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="box-title">History Barang</h4>
                                <table class="table table-striped">
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    <?php $no = 1; ?>
                                    <?php foreach ($produk_hist as $produk_hist) { ?>
                                        <?php $tgl_app = explode('-', $produk_hist->tgl_simpan) ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $tgl_app[2].'/'.$tgl_app[1].'/'.$tgl_app[0]. ' - '. $produk_hist->wkt_simpan ?></td>
                                            <td><?php echo $produk_hist->keterangan ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=' . (isset($_GET['route']) ? $this->input->get('route') : 'prod_list')) ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>

<!--Datepicker-->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.min.css') ?>">


<script src="<?php echo base_url('assets/admin-lte-2/plugins') ?>/JAutoNumber/autonumeric.js"></script>
<!-- Page script -->
<script>
                                    $(function () {
                                        //Initialize Select2 Elements
                                        $(".select2").select2();
                                        //Date picker
                                        $('#tgl').datepicker({
                                            autoclose: true,
                                        });

                                        $("#hrg_beli").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#hrg_jual").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#hrg_grosir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#ins").autoNumeric({aSep: '.', aDec: ',', aPad: false});

                                        $("#jml").keydown(function (e) {
                                            // Allow: backspace, delete, tab, escape, enter and .
                                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                    // Allow: Ctrl+A, Command+A
                                                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                            // Allow: home, end, left, right, down, up
                                                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                        // let it happen, don't do anything
                                                        return;
                                                    }
                                                    // Ensure that it is a number and stop the keypress
                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                        e.preventDefault();
                                                    }
                                                });

                                        $("#berat").keydown(function (e) {
                                            // Allow: backspace, delete, tab, escape, enter and .
                                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                    // Allow: Ctrl+A, Command+A
                                                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                            // Allow: home, end, left, right, down, up
                                                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                        // let it happen, don't do anything
                                                        return;
                                                    }
                                                    // Ensure that it is a number and stop the keypress
                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                        e.preventDefault();
                                                    }
                                                });
                                    });

</script>