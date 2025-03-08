<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Produk <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=produk&act=prod_list') ?>">Produk</a></li>
            <li class="active">Ubah</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
        <div class="row">
            <div class="col-lg-12">
                <?php echo form_open('page=produk&act=prod_update', '') ?>
                <?php echo form_hidden('id', $this->input->get('id')) ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Produk</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('produk') ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Kode</label>
                                    <?php echo form_input(array('name' => 'kode', 'class' => 'form-control', 'value' => $produk->kode)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['produk']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Jenis</label>
                                    <?php echo form_input(array('name' => 'produk', 'class' => 'form-control', 'value' => $produk->produk)) ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Tgl Barang Jadi</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <?php $tgl = explode('-', $produk->tgl_simpan) ?>
                                                <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value' => $tgl[2] . '/' . $tgl[1] . '/' . $tgl[0])) ?>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                            <!--<label class="control-label">Jml</label>-->
                                            <?php // echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right', 'value' => $produk->jml)) ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <!--<label class="control-label">Berat</label>-->
                                            <?php // echo form_input(array('id' => 'berat', 'name' => 'berat', 'class' => 'form-control pull-right', 'value' => $produk->berat)) ?>
                                        </div>
                                    </div>
                                </div>                     

                                <div class="row">
                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                        <div class="col-xs-6">
                                            <label class="control-label">Ongkos Tas</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <?php echo form_input(array('id' => 'hrg_ongk', 'name' => 'hrg_ongk', 'class' => 'form-control pull-right', 'value' => $produk->harga_ongk)) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                        <div class="col-xs-6">
                                            <div class="form-group <?php echo (!empty($hasError['hrg_beli']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Harga Beli</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php echo form_input(array('id' => 'hrg_beli', 'name' => 'hrg_beli', 'class' => 'form-control pull-right', 'value' => $produk->harga_beli)) ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group <?php echo (!empty($hasError['hrg_jual']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Harga Jual</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <?php echo form_input(array('id' => 'hrg_jual', 'name' => 'hrg_jual', 'class' => 'form-control pull-right', 'value' => $produk->harga_jual)) ?>
                                            </div>                                        
                                        </div>                                        
                                    </div>
                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                        <div class="col-xs-6">
                                            <label class="control-label">Incentive</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <?php echo form_input(array('id' => 'ins', 'name' => 'insentive', 'class' => 'form-control pull-right', 'value' => $produk->insentif)) ?>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>     
                                <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                    <div class="row">
                                        <div class="col-xs-6">                                      
                                        </div>
                                        <div class="col-xs-6">
                                            <!--<label class="control-label">Lama Pengerjaan</label>-->
                                            <?php // echo form_input(array('id' => '', 'name' => 'lama_pengerjaan', 'class' => 'form-control pull-right', 'value' => $produk->lama_pengerjaan)) ?>                                            
                                        </div>
                                    </div>
                                </div>                      
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                            </div>
                            <div class="col-lg-6 text-right">
                                <!--<button type="reset" class="btn btn-default">Batal</button>-->
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
            <div class="col-lg-6">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Stok</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open('page=produk&act=prod_simpan_stok') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group <?php echo (!empty($hasError['penjahit']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Nama Penjahit</label>
                                            <select name="penjahit" class="form-control select2">
                                                <option value="">- [Pilih] -</option>
                                                <?php
                                                if (!empty($penjahit)) {
                                                    foreach ($penjahit as $penjahit) {
                                                        ?>
                                                        <option value="<?php echo $penjahit->id ?>"><?php echo $penjahit->penjahit ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Jml</label>
                                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-plus"></i> Stok</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                        <?php echo br(2) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center text-bold">No.</th>
                                    <th class="text-left">Penjahit</th>
                                    <th class="text-right">Stok</th>
                                    <th class="text-left">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($produk_stok as $produk_stok) { ?>
                                    <tr>
                                        <td class="text-center text-bold"><?php echo $no++; ?></td>
                                        <td class="text-left"><?php echo $produk_stok->penjahit; ?></td>
                                        <td class="text-right"><?php echo $produk_stok->stok; ?></td>
                                        <td class="text-left">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                <?php echo anchor('page=produk&act=prod_hapus_stok&id=' . general::enkrip($produk_stok->id) . '&ref=' . $this->input->get('id'), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <!--<button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>-->
                            </div>
                            <div class="col-lg-6 text-right">
                                <!--<button type="reset" class="btn btn-default">Batal</button>-->
                                <!--<button type="submit" class="btn btn-info btn-flat">Simpan</button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Harga Grosir</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open('page=produk&act=prod_simpan_hrg') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Keterangan</label>
                                    <?php echo form_input(array('id' => '', 'name' => 'keterangan', 'class' => 'form-control pull-right', 'placeholder' => 'Keterangan ...')) ?>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group <?php echo (!empty($hasError['hrg_res']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Harga Grosir</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Rp
                                        </div>
                                        <?php echo form_input(array('id' => 'hrg_res', 'name' => 'harga', 'class' => 'form-control pull-right', 'placeholder' => 'Harga ...')) ?>
                                    </div>
                                </div>                                           
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-plus"></i> Harga</button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                        <?php echo br(2) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center text-bold">No.</th>
                                    <th class="text-left">Keterangan</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-left">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($produk_hrg as $produk_hrg) { ?>
                                    <tr>
                                        <td class="text-center text-bold"><?php echo $no++; ?></td>
                                        <td class="text-left"><?php echo $produk_hrg->keterangan; ?></td>
                                        <td class="text-right"><?php echo general::format_angka($produk_hrg->harga); ?></td>
                                        <td class="text-left">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                <?php echo anchor('page=produk&act=prod_hapus_hrg&id=' . general::enkrip($produk_hrg->id) . '&ref=' . $this->input->get('id'), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <!--<button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>-->
                            </div>
                            <div class="col-lg-6 text-right">
                                <!--<button type="reset" class="btn btn-default">Batal</button>-->
                                <!--<button type="submit" class="btn btn-info btn-flat">Simpan</button>-->
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

                                        $("#hrg_res").autoNumeric({aSep: '.', aDec: ',', aPad: false});
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