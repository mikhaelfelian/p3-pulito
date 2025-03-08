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
                                <div class="col-xs-6 table-responsive">
                                    <h3>Data penjahit dan stok</h3>
                                    <table class="table table-striped">
                                        <tr>
                                            <td class="text-left">Jenis</td>
                                            <td class="text-center">:</td>
                                            <td class="text-left"><?php echo $penj_det->produk ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Jumlah</td>
                                            <td class="text-center">:</td>
                                            <td class="text-left"><?php echo $penj_det->jml ?></td>
                                        </tr>
                                    </table>
                                    <?php echo form_open('page=transaksi&act=set_nota_brg_approve') ?>
                                    <?php echo form_hidden('id', $this->input->get('id')) ?>
                                    <?php echo form_hidden('order_ref', $this->input->get('order_ref')) ?>
                                    <?php echo form_hidden('prod_ref', $this->input->get('prod_ref')) ?>
                                    <?php echo form_hidden('jml', $penj_det->jml) ?>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-left">Nama Penjahit</th>
                                            <th class="text-center">Stok</th>
                                            <th>#</th>
                                        </tr>
                                        <?php $n = 1; ?>
                                        <?php $tot_qty = 0; ?>
                                        <?php foreach ($prod_stok as $prod_stok) { ?>
                                            <?php $tot_qty = $tot_qty + $prod_stok->stok ?>
                                            <?php echo form_hidden('id_stok[]', $prod_stok->id) ?>
                                            <?php $msg = $this->session->flashdata('transaksi' . $prod_stok->id) ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td class="text-left"><?php echo $prod_stok->penjahit ?></td>
                                                <td class="text-center"><?php echo $prod_stok->stok ?></td>
                                                <td>
                                                    <div class="form-group <?php echo (!empty($msg) ? 'has-error' : '') ?>">
                                                        <?php echo form_input(array('id' => 'qty' . $no++, 'name' => 'qty[]', 'class' => 'form-control')) ?>
                                                        <?=$msg?>
                                                    </div>                                                    
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th></th>
                                            <th class="text-right">Total</th>
                                            <th class="text-center"><?php echo $tot_qty ?></th>
                                            <th><button type="submit" class="btn btn-primary btn-flat">Approve</button></th>
                                        </tr>
                                    </table>
                                    <?php echo form_close() ?>
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

        $("[type=text]").keydown(function (e) {
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