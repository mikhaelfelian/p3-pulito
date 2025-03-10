<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Penjualan <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Produk</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <?php echo nbs(3) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Invoice</th>
                                    <th>Tgl</th>
                                    <th>Platform</th>
                                    <th>Sales</th>
                                    <th>Status Nota</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <?php echo form_open('page=transaksi&act=set_cari_penj') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <input type="hidden" id="id_sales" name="id_sales">
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td><?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td><?php // echo form_input(array('name' => 'produk', 'class' => 'form-control'))       ?></td>
                                    <td><?php echo form_input(array('id' => 'sales', 'name' => 'sales', 'class' => 'form-control')) ?></td>
                                    <td>
                                        <?php if (akses::hakGudang() != TRUE) { ?>
                                            <select name="status_nota" class="form-control">
                                                <option value="">- [Status Nota] -</option>
                                                <option value="0">Waiting</option>
                                                <option value="1">Pending</option>
                                                <option value="2">Approve</option>
                                            </select>
                                        <?php } ?>
                                    </td>
                                    <td><button class="btn btn-primary">Cari</button></td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $tgl = explode('-', $penj->tgl);
                                        $sales = $this->ion_auth->user($penj->id_user)->row();
                                        $gudang = $this->ion_auth->user($penj->id_gudang)->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor('page=transaksi&act=trans_jual_detail&id=' . general::enkrip($penj->no_nota), '#' . $penj->no_nota, 'class="text-default"') ?></td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <td><?php echo $penj->platform ?></td>
                                            <!--<td><?php echo general::format_angka($penj->jml_gtotal) ?></td>-->
                                            <td><?php echo $sales->first_name ?></td>
                                            <td><?php echo general::status_nota($penj->status_nota) ?></td>
                                            <td>
                                                <?php if (akses::hakSales() == TRUE OR akses::hakOwner() == TRUE OR akses::hakSA() == TRUE) { ?>
                                                    <?php if ($penj->id_user == $this->ion_auth->user()->row()->id) { ?>
                                                        <?php echo anchor('page=transaksi&act=trans_jual_edit&id=' . general::enkrip($penj->no_nota), '<i class="fa fa-edit"></i> ', 'class="text-default"') ?>
                                                        <?php echo nbs(2) ?>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($penj->status_nota == '1') { ?>
                                                    <?php if (akses::hakSales() != TRUE) { ?>
                                                        <?php // echo anchor('page=transaksi&act=set_nota_approve&id=' . general::enkrip($penj->no_nota), '<i class="fa fa-check-circle text-success"></i> ', 'class="text-default"') ?>
                                                        <?php echo anchor('page=transaksi&act=trans_jual_app&id=' . general::enkrip($penj->no_nota), '<i class="fa fa-check-circle text-success"></i> ', 'class="text-default"') ?>
                                                        <?php echo nbs(2) ?>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if (akses::hakOwner() == TRUE OR akses::hakSA() == TRUE) { ?>
                                                    <?php // if ($penj->status_nota == '0') { ?>
                                                        <?php echo anchor('page=transaksi&act=trans_jual_hps&id=' . general::enkrip($penj->no_nota), '<i class="fa fa-remove text-danger"></i> ', 'class="text-danger" onclick="return confirm(\'Yakin menghapus ?\')"') ?>
                                                        <?php echo nbs(2) ?>
                                                    <?php // } ?>
                                                <?php } ?>
                                                <?php if (akses::hakGudang() == TRUE) { ?>
                                                    <?php if ($penj->status_nota == '2') { ?>
                                                        <?php echo anchor('page=transaksi&act=trans_jual_print&id=' . general::enkrip($penj->no_nota), '<i class="fa fa-print text-default"></i> ', 'class="text-primary" target="_blank"') ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($pagination)) { ?>
                        <div class="box-footer">                        
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php echo $pagination ?>
                            </ul>
                        </div>
                    <?php } ?>
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

<!-- Page script -->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!--Datepicker-->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<script>
    $(function () {
//         Tanggale Nota
        $('#tgl').datepicker({
            autoclose: true,
        });

//        Autocomplete kanggo nyari no_notanya
        $('#no_nota').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('page=transaksi&act=json_transaksi') ?>",
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
                $itemrow.find('#no_nota').val(ui.item.no_nota);
                $('#no_nota').val(ui.item.no_nota);

                // Give focus to the next input field to recieve input from user
                $('#no_nota').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.no_nota + "</a>")
                    .appendTo(ul);
        };

//        Autocomplete kanggo nyari salesnya
        $('#sales').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('page=transaksi&act=json_sales') ?>",
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
                $itemrow.find('#sales').val(ui.item.sales);
                $('#sales').val(ui.item.sales);
                $('#id_sales').val(ui.item.id_sales);

                // Give focus to the next input field to recieve input from user
                $('#qty').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.sales + "</a>")
                    .appendTo(ul);
        };
    });
</script>