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
                                        <td><?php echo anchor('page=transaksi&act=set_nota_hj&id='.$this->input->get('id').'&order_ref='.$this->input->get('order_ref').'&prod_ref='.$this->input->get('prod_ref').'&hrg_ref='.ceil($prod_brg->harga_jual).'&ref=0', 'Set Harga') ?></td>
                                    </tr>
                                    <?php foreach ($prod_hrg as $prod_hrg) { ?>
                                        <tr>
                                            <td><?php echo ucwords($prod_hrg->keterangan) ?></td>
                                            <td><?php echo general::format_angka($prod_hrg->harga) ?></td>
                                            <td><?php echo anchor('page=transaksi&act=set_nota_hj&id='.$this->input->get('id').'&order_ref='.$this->input->get('order_ref').'&prod_ref='.$this->input->get('prod_ref').'&hrg_ref='.ceil($prod_hrg->harga).'&ref='.$prod_hrg->id, 'Set Harga') ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-4">
                                <?php echo anchor('page=transaksi&act=trans_jual&id='.$this->input->get('id'),'<button class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>') ?>
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
                    .append("<a>[" + item.kode + "] " + item.produk + " - " + item.id_penjahit + "</a>")
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