<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Transaksi <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Transaksi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <?php echo $this->session->flashdata('transaksi') ?>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <?php echo nbs(3) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Invoice</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Kasir</th>
                                    <th>Status Pembayaran</th>
                                    <!--<th>Pengambil</th>-->
                                    <th>Pengambilan</th>
                                    <th class="text-left" colspan="2">Tgl Ambil</th>
                                </tr>
                            </thead>
                            <?php echo form_open(base_url('cart/set_cari_byr.php')) ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <!--<input type="hidden" id="id_sales" name="id_sales">-->
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control')) ?>
                                    </td>
                                    <td>
                                        <?php $cabang = $this->db->get('tbl_pengaturan_cabang')->result(); ?>
<!--                                        <select name="cabang" class="form-control form-inline">
                                            <option value="">- [Lokasi] -</option>
                                            <?php foreach ($cabang as $cabang) { ?>
                                                <option value="<?php echo $cabang->id ?>"><?php echo $cabang->keterangan ?></option>
                                            <?php } ?>
                                        </select>-->
                                        <?php // } ?>
                                    </td>
                                    <td><?php // echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td>
                                        <?php // echo form_input(array('id' => 'cari_kasir', 'name' => 'nama_kasir', 'class' => 'form-control')) ?>
                                        <!--<input type="hidden" id="kasir" name="kasir">-->
                                    </td>
                                    <td>
                                        <?php // if (akses::hakKasir() != TRUE) { ?>
<!--                                        <select name="status_bayar" class="form-control">
                                            <option value="-">- [Status Bayar] -</option>
                                            <option value="0">Belum Bayar</option>
                                            <option value="2">Belum Lunas</option>
                                            <option value="1">Lunas</option>
                                        </select>-->
                                        <?php // } ?>
                                    </td>
                                    <td colspan="3"></td>
                                    <td><button class="btn btn-primary">Filter</button></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $tgl	   = explode('-', $penj->tgl);
                                        $tgl_ambil = explode('-', $penj->tgl_ambil);
                                        $sales	   = $this->ion_auth->user($penj->id_user)->row();
                                        $pel	   = $this->db->where('id',$penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
                                        
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor(base_url('cart/'.($penj->status_bayar != '1' ? 'trans_bayar' : 'trans_detail').'.php?id='.general::enkrip($penj->id).'&route=trans_bayar_list.php'), '#' . $penj->no_nota.' - '.ucwords($pel->nama).' - '.$pel->no_hp, 'class="text-default"') ?></td>
                                            <td><?php echo ($penj->tgl != '0000-00-00' ? $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] : '') ?></td>
                                            <td><?php echo $sales->first_name ?></td>
                                            <td><?php echo general::status_bayar($penj->status_bayar) ?></td>
                                            <!--<td><?php echo ucwords($penj->pengambilan) ?></td>-->
                                            <td>
                                                <?php echo ($penj->pengambilan == '' ? anchor(base_url('cart/trans_bayar.php?id='.general::enkrip($penj->id).'&route=pengambilan'), 'Bayar & Pengambilan &raquo;') : ucwords(strtolower($penj->pengambilan))) ?>
                                            </td>
                                            <td><?php echo ($penj->tgl_ambil != '0000-00-00' ? $tgl_ambil[1] . '/' . $tgl_ambil[2] . '/' . $tgl_ambil[0] : '-') ?></td>
                                            <td>
                                                <?php // echo anchor(base_url('cart/form_pengambilan.php?id='.general::enkrip($penj->id).'&route='.$this->uri->segment(2)), 'Pengambilan &raquo;') ?>
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