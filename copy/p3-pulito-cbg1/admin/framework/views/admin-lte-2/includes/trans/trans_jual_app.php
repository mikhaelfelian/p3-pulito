<?php $hasError = $this->session->flashdata('form_error') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Penjualan <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home&act=index') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=transaksi&act=trans_jual_list') ?>">Penjualan</a></li>
            <li class="active">Invoice</li>
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
                        <?php echo $this->session->flashdata('transaksi') ?>

                        <?php if (!empty($customer)) { ?>
                            <?php echo br() ?>
                            <div class="row invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    <strong>Invoice #<?php echo $penj->no_nota ?></strong>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <table class="table table-responsive">
                                                <tr>
                                                    <th class="text-left">Sales</th>
                                                    <th class="text-center">:</th>
                                                    <td class="text-left"><?php echo $this->ion_auth->user($penj->id_user)->row()->first_name ?></td>
                                                    <th class="text-left">Gudang</th>
                                                    <th class="text-center">:</th>
                                                    <td class="text-left"><?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name ?></td>
                                                </tr>
                                                <?php $tgl = explode('-', $penj->tgl_simpan) ?>
                                                <tr>
                                                    <th class="text-left">Tgl</th>
                                                    <th class="text-center">:</th>
                                                    <td class="text-left"><?php echo $tgl[2] . '/' . $tgl[1] . '/' . $tgl[0] ?></td>
                                                    <th class="text-left">Platform</th>
                                                    <th class="text-center">:</th>
                                                    <td class="text-left"><?php echo ucwords($penj_plat->platform) . ' - ' . strtoupper($penj_plat->keterangan) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center"></th>
                                                <th class="text-center">No</th>
                                                <th class="text-left">Kode</th>
                                                <th class="text-left">Produk</th>
                                                <th class="text-left">Harga</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-left">Subtotal</th>
                                                <th class="text-left">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($penj_det)) {
                                                $jml_app = $this->db->where('no_nota',$penj->no_nota)->where('status_app','0')->get('tbl_trans_jual_det')->num_rows();
                                                $no = 1;
                                                $tot = 0;
                                                foreach ($penj_det as $penj_det) {
                                                    $tot = $tot + $penj_det->subtotal;
                                                    ?>
                                                    <tr>
                                                        <?php if ($penj->status_nota == '0') { ?>
                                                            <td class="text-center"><?php echo anchor('page=transaksi&act=cart_hapus&id=' . general::enkrip($penj_det->id) . '&nota=' . $this->input->get('id') . '&route=trans_jual_edit', '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?></td>
                                                        <?php } else { ?>
                                                            <td class="text-center"><i class="fa fa-remove"></i></td>
                                                        <?php } ?>
                                                        <td class="text-center"><?php echo $no++ ?>.</td>
                                                        <td class="text-left"><?php echo $penj_det->kode ?></td>
                                                        <td class="text-left"><?php echo $penj_det->produk ?></td>
                                                        <td class="text-left"><?php echo general::format_angka($penj_det->harga) ?></td>
                                                        <td class="text-center"><?php echo $penj_det->jml ?></td>
                                                        <td class="text-left"><?php echo general::format_angka($penj_det->subtotal) ?></td>
                                                        <td class="text-left">
                                                            <?php echo ($penj_det->status_app == '0' ? anchor('page=transaksi&act=trans_jual_app_list&id=' . $this->input->get('id') . '&order_ref=' . general::enkrip($penj_det->id) . '&prod_ref=' . general::enkrip($penj_det->id_produk), '<i class="fa fa-check"></i> Set Approve','class="text-success"') : '') ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <?php echo form_open('page=transaksi&act=set_nota_approve') ?>
                                                <?php echo form_hidden('id', $this->input->get('id')) ?>
                                                <tr>
                                                    <th colspan="6" class="text-right">Total</th>
                                                    <th colspan="" class="text-right"><?php echo general::format_angka($tot) ?></th>
                                                    <th colspan="" class="text-right"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="text-right" style="padding-top: 15px;">Grand Total</th>
                                                    <th colspan="" class="text-right" style="width: 20%;">
                                                        <div class="form-group <?php echo (!empty($hasError['gtotal']) ? 'has-error' : '') ?>">
                                                            <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    Rp
                                                                </div>
                                                                <?php if ($penj->status_nota == '0') { ?>
                                                                    <?php echo form_input(array('id' => 'gtotal', 'name' => 'gtotal', 'class' => 'form-control')) ?>
                                                                <?php } else { ?>
                                                                    <?php echo form_input(array('id' => 'gtotal', 'name' => 'gtotal', 'class' => 'form-control', 'readonly' => 'TRUE', 'value' => $penj->jml_gtotal)) ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th colspan="" class="text-right"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="text-right" style="padding-top: 15px;">Tgl Bayar</th>
                                                    <th colspan="" class="text-right" style="width: 20%;">
                                                        <div class="form-group <?php echo (!empty($hasError['tgl_bayar']) ? 'has-error' : '') ?>">
                                                            <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <?php $tgl_byr = explode('-', $penj->tgl_bayar) ?>
                                                                <?php if ($penj->status_nota == '0') { ?>
                                                                    <?php echo form_input(array('id' => 'tgl_bayar', 'name' => 'tgl_bayar', 'class' => 'form-control')) ?>
                                                                <?php } else { ?>
                                                                    <?php echo form_input(array('id' => '', 'name' => 'tgl_bayar', 'class' => 'form-control', 'readonly' => 'TRUE', 'value' => ($penj->tgl_bayar != '0000-00-00' ? $tgl_byr[2] . '/' . $tgl_byr[1] . '/' . $tgl_byr[0] : ''))) ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th colspan="" class="text-right"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" class="text-right" style="">
                                                        <!--<input name="status_bayar" value="1" type="radio" <?php echo ($penj->status_bayar == '1' ? 'checked' : '') ?>> Paid-->
                                                        <?php echo nbs(2) ?>
                                                        <!--<input name="status_bayar" value="0" type="radio" <?php echo ($penj->status_bayar == '0' ? 'checked' : '') ?>> Not Paid-->
                                                    </th>
                                                    <th colspan="" class="text-right"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" class="text-right" style="">
                                                        <button type="button" class="btn btn-primary btn-flat pull-left" onclick="window.location.href = '<?php echo site_url('page=transaksi&act=trans_jual_list') ?>'"><i class="fa fa-arrow-left"></i> Kembali</button>
                                                        <?php if ($penj->status_nota < '2') { ?>
                                                        <?php if ($jml_app == 0) { ?>
                                                            <button type="submit" class="btn btn-primary btn-flat">Approve</button>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </th>
                                                    <th colspan="" class="text-right"></th>
                                                </tr>
                                                <?php echo form_close() ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                        <?php } ?>
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
<script src="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.js"></script>
<link href="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">
<!--Datepicker-->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.min.css') ?>">


<script src="<?php echo base_url('assets/admin-lte-2/plugins') ?>/JAutoNumber/autonumeric.js"></script>
<!-- Page script -->
<script type="text/javascript">
                                                    $(function () {
                                                        //        Tanggal bayar
                                                        $('#tgl_bayar').datepicker({
                                                            autoclose: true,
                                                        });
//        Jquery kanggo format angka
                                                        $("#ongkir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                                        $("#gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});

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
                                                                    .append("<a>[" + item.kode + "] " + item.produk + "-" + item.harga_jual + "</a>")
                                                                    .appendTo(ul);
                                                        };

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
                                                                    .append("<a>[" + item.kode + "] " + item.produk + "-" + item.harga_jual + "</a>")
                                                                    .appendTo(ul);
                                                        };
                                                    });
</script>