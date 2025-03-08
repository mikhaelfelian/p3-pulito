<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Penjualan <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Penjualan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Order</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo $this->session->flashdata('transaksi') ?>
                            </div>
                        </div>
                        <?php echo form_open('page=transaksi&act=set_nota') ?>
                        <?php echo form_hidden('id', $customer['no_nota']) ?>
                        <div class="row">
                            <div class="col-lg-6">                                
                                <div class="form-group">
                                    <label class="control-label">No. Invoice</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            #
                                        </div>
                                        <?php echo form_input(array('id' => '', 'name' => 'no_nota', 'class' => 'form-control pull-right', 'value' => $no_nota, 'readonly' => 'TRUE')) ?>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-lg-4">                                
                                <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Tanggal</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value'=>date('m/d/Y'))) ?>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group <?php echo (!empty($hasError['platform']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Platform</label>
                                            <select name="platform" class="form-control select2">
                                                <option value="">- [Pilih] -</option>
                                                <?php
                                                if (!empty($platform)) {
                                                    foreach ($platform as $platform) {
                                                        ?>
                                                        <option value="<?php echo $platform->id ?>"><?php echo $platform->platform ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. Platform</label>
                                            <?php echo form_input(array('id' => '', 'name' => 'keterangan', 'class' => 'form-control pull-right')) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">                                
                                <div class="form-group <?php echo (!empty($hasError['ongkir']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Ongkos Kirim</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Rp
                                        </div>
                                        <?php echo form_input(array('id' => 'ongkir', 'name' => 'ongkir', 'class' => 'form-control pull-right')) ?>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <?php echo br() ?>
                                <button type="reset" class="btn btn-warning btn-flat">Batal</button>
                                <button type="submit" class="btn btn-primary btn-flat">Set Penjualan</button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                        <?php echo br() ?>

                        <?php if (!empty($customer)) { ?>
                            <hr/>
                            <?php echo form_open('page=transaksi&act=cart_simpan') ?>
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $customer['no_nota'] ?>">

                            <div class="row">
                                <div class="col-sm-2">
                                    <label>Kode</label>
                                    <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control')) ?>
                                </div>
                                <div class="col-sm-4">
                                    <label>Produk</label>
                                    <?php echo form_input(array('id' => 'produk', 'name' => 'produk', 'class' => 'form-control')) ?>
                                </div>
                                <div class="col-sm-1">
                                    <label>Qty</label>
                                    <?php echo form_input(array('id' => 'qty', 'name' => 'qty', 'class' => 'form-control')) ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>Harga</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Rp
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'readonly' => 'TRUE')) ?>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <label><?php echo nbs(3) ?></label>
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-shopping-cart"></i> Beli</button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                            <hr/>
                            <?php echo br() ?>
                            <div class="row invoice-info">
                                <div class="col-sm-8 invoice-col">
                                    <strong>Invoice #<?php echo $customer['no_nota'] ?></strong>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-responsive">
                                                <tr>
                                                    <th class="text-left">Sales</th>
                                                    <th class="text-center">:</th>
                                                    <td class="text-left"><?php echo $this->ion_auth->user()->row()->first_name ?></td>
                                                    <th class="text-left">Platform</th>
                                                    <th class="text-center">:</th>
                                                    <td class="text-left"><?php echo ucwords($penj_plat->platform) . ' - ' . strtoupper($penj_plat->keterangan) ?></td>
                                                </tr>
                                                <?php $tgl = explode('-', $customer['tgl_simpan']) ?>
                                                <tr>
                                                    <th class="text-left">Tgl</th>
                                                    <th class="text-center">:</th>
                                                    <td class="text-left"><?php echo $tgl[2] . '/' . $tgl[1] . '/' . $tgl[0] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                                
                                <?php if (isset($_GET['prod_ref'])) { ?>
                                    <div class="col-xs-4 table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Keterangan</th>
                                                <th>Harga</th>
                                                <th>#</th>
                                            </tr>
                                            <tr>
                                                <td>Harga Normal</td>
                                                <td><?php echo general::format_angka($prod_brg->harga_jual) ?></td>
                                                <td><?php echo anchor('page=transaksi&act=set_nota_hj&id=' . $this->input->get('id') . '&order_ref=' . $this->input->get('order_ref') . '&prod_ref=' . $this->input->get('prod_ref') . '&hrg_ref=' . ceil($prod_brg->harga_jual), 'Set Harga') ?></td>
                                            </tr>
                                            <?php foreach ($prod_hrg as $prod_hrg) { ?>
                                                <tr>
                                                    <td><?php echo ucwords($prod_hrg->keterangan) ?></td>
                                                    <td><?php echo general::format_angka($prod_hrg->harga) ?></td>
                                                    <td><?php echo anchor('page=transaksi&act=set_nota_hj&id=' . $this->input->get('id') . '&order_ref=' . $this->input->get('order_ref') . '&prod_ref=' . $this->input->get('prod_ref') . '&hrg_ref=' . ceil($prod_hrg->harga), 'Set Harga') ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"></th>
                                                    <th class="text-center">No</th>
                                                    <th class="text-left">Kode</th>
                                                    <th class="text-left">Produk</th>
                                                    <th class="text-right">Harga</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-right">Subtotal</th>
                                                    <th class="text-right">#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($penj_det)) {
                                                    $no = 1;
                                                    $tot = 0;
                                                    foreach ($penj_det as $penj_det) {
                                                        $tot = $tot + $penj_det->subtotal;
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo anchor('page=transaksi&act=cart_hapus&id=' . general::enkrip($penj_det->id) . '&nota=' . $this->input->get('id'), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?></td>
                                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                                            <td class="text-left"><?php echo $penj_det->kode ?></td>
                                                            <td class="text-left"><?php echo $penj_det->produk ?></td>
                                                            <td class="text-right"><?php echo general::format_angka($penj_det->harga) ?></td>
                                                            <td class="text-center"><?php echo $penj_det->jml ?></td>
                                                            <td class="text-right"><?php echo general::format_angka($penj_det->subtotal) ?></td>
                                                            <td class="text-right"><?php echo anchor('page=transaksi&act=trans_jual&id=' . $this->input->get('id') . '&order_ref=' . general::enkrip($penj_det->id) . '&prod_ref=' . general::enkrip($penj_det->id_produk), '<i class="fa fa-arrow-right"></i> Set Harga') ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php echo form_open('page=transaksi&act=set_nota_proses') ?>
                                                    <?php echo form_hidden('id', $this->input->get('id')) ?>
                                                    <tr>
                                                        <th colspan="6" class="text-right">Total</th>
                                                        <th colspan="" class="text-right"><?php echo general::format_angka($tot) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" class="text-right" style="padding-top: 15px;">
                                                            <div class="form-group <?php echo (!empty($hasError['gtotal']) ? 'has-error' : '') ?>">
                                                                <label>Grand Total</label>
                                                            </div>
                                                        </th>
                                                        <th colspan="" class="text-right" style="width: 20%;">
                                                            <div class="form-group <?php echo (!empty($hasError['gtotal']) ? 'has-error' : '') ?>">
                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        Rp
                                                                    </div>
                                                                    <?php echo form_input(array('id' => 'gtotal', 'name' => 'gtotal', 'class' => 'form-control', 'readonly' => 'TRUE', 'value' => $tot)) ?>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" class="text-right" style="padding-top: 15px;">
                                                            <div class="form-group <?php echo (!empty($hasError['tgl_bayar']) ? 'has-error' : '') ?>">
                                                                <label>Tgl Bayar</label>
                                                            </div>
                                                        </th>
                                                        <th colspan="" class="text-right" style="width: 20%;">
                                                            <div class="form-group <?php echo (!empty($hasError['tgl_bayar']) ? 'has-error' : '') ?>">
                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                    <?php echo form_input(array('id' => 'tgl_bayar', 'name' => 'tgl_bayar', 'class' => 'form-control', 'value' => $this->session->flashdata('tgl_bayar'))) ?>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="7" class="text-right" style="">
                                                            <input name="metode_bayar" value="1" type="radio" <?php echo ($penj->metode_bayar == '1' ? 'checked' : '') ?>> Cash
                                                            <?php echo nbs(2) ?>
                                                            <input name="metode_bayar" value="0" type="radio" <?php echo ($penj->metode_bayar == '0' ? 'checked' : '') ?>> Transfer
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="7" class="text-right" style="">
                                                            <input name="status_bayar" value="1" type="radio" <?php echo ($penj->status_bayar == '1' ? 'checked' : '') ?>> Paid
                                                            <?php echo nbs(2) ?>
                                                            <input name="status_bayar" value="0" type="radio" <?php echo ($penj->status_bayar == '0' ? 'checked' : '') ?>> Not Paid
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="7" class="text-right" style="">
                                                            <?php if ($tot > 0) { ?>
                                                                <button type="button" class="btn btn-danger btn-flat" onclick="window.location.href='<?php echo site_url('page=transaksi&act=trans_jual_hps&id='.general::enkrip($penj->no_nota).'&route=trans_jual') ?>'">Batal</button>
                                                                <button type="submit" class="btn btn-primary btn-flat">Simpan Nota</button>
                                                            <?php } ?>
                                                        </th>
                                                    </tr>
                                                    <?php echo form_close() ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>                                
                                <!-- /.col -->
                            </div>
                        <?php } ?>
                        <?php // echo br() ?>
                        <!--                        <div class="row">
                                                    <div class="col-lg-12">
                                                        <pre>
                        <?php // print_r($this->session->all_userdata()) ?>
                                                        </pre>
                                                    </div>
                                                </div>-->
                    </div>
                    <div class="box-footer">

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
<script src="<?php echo base_url('assets/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
    $(function () {
//      Platform
        $(".select2").select2();

//      Tanggale Nota
        $('#tgl').datepicker({
            autoclose: true,
        });

//      Tanggal bayar
        $('#tgl_bayar').datepicker({
            autoclose: true,
        });

//        Jquery kanggo format angka
        $("#ongkir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        $("#qty").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // kibot: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // kibot: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // Biarin wae, ga ngapa2in return false
                        return;
                    }
                    // Cuman nomor
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });


//        Autocomplete buat kode
        $('#kode').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('page=transaksi&act=json_produk') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                var $itemrow = $(this).closest('tr');
                // Populate the input fields from the returned values
                $itemrow.find('#kode').val(ui.item.kode);
                $('#kode').val(ui.item.kode);
                $('#produk').val(ui.item.produk);
                $('#harga').val(ui.item.harga_jual);
                $('#id').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#qty').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>[" + item.kode + "] " + item.produk + "</a>")
                    .appendTo(ul);
        };

//        Autocomplete buat produk
        $('#produk').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('page=transaksi&act=json_produk') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                var $itemrow = $(this).closest('tr');
                // Populate the input fields from the returned values
                $itemrow.find('#kode').val(ui.item.kode);
                $('#kode').val(ui.item.kode);
                $('#produk').val(ui.item.produk);
                $('#harga').val(ui.item.harga_jual);
                $('#id').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#qty').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>[" + item.kode + "] " + item.produk + "</a>")
                    .appendTo(ul);
        };
    });
</script>