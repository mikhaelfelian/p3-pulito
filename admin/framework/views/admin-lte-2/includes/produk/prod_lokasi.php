<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Lokasi <small>Tempat</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=produk&act=prod_list') ?>">Produk</a></li>
            <li class="active">Tambah</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <?php if(akses::hakAdmin() != TRUE){ ?>
        <div class="row">
            <div class="col-lg-5">
                <?php echo form_open('page=produk&act=prod_lokasi_simpan', '') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Tambah Lokasi</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('produk') ?>
                        <div class="form-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                            <label class="control-label">Kode Lokasi</label>
                            <?php echo form_input(array('name' => 'kode', 'class' => 'form-control')) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                            <label class="control-label">Keterangan</label>
                            <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control')) ?>
                        </div>  
                        <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                            <label class="control-label">Jumlah</label>
                            <?php echo form_input(array('name' => 'jml', 'class' => 'form-control', 'style'=>'width: 120px;')) ?>
                        </div>  
                        <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'has-error' : '') ?>">
                            <label class="control-label">Tipe</label>
                            <br/>
                            <?php echo form_radio(array('name' => 'tipe_lokasi', 'value' => '1')) ?> Rak
                            <?php echo nbs(2) ?>
                            <?php echo form_radio(array('name' => 'tipe_lokasi', 'value' => '2')) ?> Gantungan
                        </div>  
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <!--<button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_barang_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>-->
                            </div>
                            <div class="col-lg-6 text-right">
                                <button type="reset" class="btn btn-default btn-flat">Batal</button>
                                <button type="submit" class="btn btn-info btn-flat">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Lokasi</h3>
                    </div>
                    <div class="box-body">
                        
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Keterangan</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <?php echo form_open('page=produk&act=set_cari_lokasi') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <?php echo form_hidden('route', $this->input->get('act')) ?>
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td><?php echo form_input(array('name' => 'kode', 'class' => 'form-control')) ?></td>
                                    <td><?php //echo form_input(array('name' => 'produk', 'class' => 'form-control')) ?></td>
                                    <td><?php // echo form_input(array('name' => 'hj', 'class' => 'form-control')) ?></td>
                                    <td><button class="btn btn-primary">Cari</button></td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($lokasi)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($lokasi as $lokasi) {
//                                        $trans = $this->db->select('SUM(jml) as jml')->where('id_produk', $produk->id)->where('tbl_trans_jual.status_nota', '1')->join('tbl_trans_jual', 'tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')->get('tbl_trans_jual_det')->row();
//                                        $tot_jml = $this->db->select('SUM(stok) as jml')->where('id_produk', $produk->id)->get('tbl_m_produk_stok')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $lokasi->kode ?></td>
                                            <td><?php echo $lokasi->keterangan ?></td>
                                            <td><?php echo general::tipe_lokasi($lokasi->tipe) ?></td>
                                            <td></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <!--<button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_barang_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>-->
                            </div>
                            <div class="col-lg-6 text-right">
                                <!--<button type="reset" class="btn btn-default btn-flat">Batal</button>-->
                                <!--<button type="submit" class="btn btn-info btn-flat">Simpan</button>-->
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
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
                                        $("#hrg_ongk").autoNumeric({aSep: '.', aDec: ',', aPad: false});
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