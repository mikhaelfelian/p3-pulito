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
                    <div class="box-body no-padding">
                        <?php echo nbs(3) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pelanggan</th>
                                    <th>Lokasi</th>
                                    <th>Tgl</th>
                                    <th>Total</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Nota</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <?php echo form_open(base_url('cart/set_cari_trans.php'), 'id="form-trans" autocomplete="off"') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <!--<input type="hidden" id="id_sales" name="id_sales">-->
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control', 'placeholder'=>'Pencarian no_nota, no_hp, nama pelanggan ketik disini ...')) ?>
                                    </td>
                                    <td>
                                        <?php $cabang = $this->db->get('tbl_pengaturan_cabang')->result(); ?>
                                        <select id="cabang" name="cabang" class="form-control form-inline">
                                            <option value="">- [Lokasi] -</option>
                                            <?php foreach ($cabang as $cabang) { ?>
                                                <option value="<?php echo $cabang->id ?>"><?php echo $cabang->keterangan ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php // } ?>
                                    </td>
                                    <td><?php // echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td><?php // echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <!--
                                    <td>
                                        <?php echo form_input(array('id' => 'cari_kasir', 'name' => 'nama_kasir', 'class' => 'form-control')) ?>
                                        <input type="hidden" id="kasir" name="kasir">
                                    </td>
                                    -->
                                    <td>
                                        <!--
                                        <?php // if (akses::hakKasir() != TRUE) { ?>
                                        <select name="status_bayar" class="form-control">
                                            <option value="">- [Status Bayar] -</option>
                                            <option value="0">Belum Bayar</option>
                                            <option value="2">Belum Lunas</option>
                                            <option value="1">Lunas</option>
                                        </select>
                                        <?php // } ?>
                                        -->
                                    </td>
                                    <td>
                                    </td>
                                    <td><button class="btn btn-primary">Filter</button></td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $tgl         = $this->tanggalan->tgl_indo($penj->tgl_masuk);
                                        $tgl_ambil   = $this->tanggalan->tgl_indo($penj->tgl_ambil);
                                        $sales       = $this->ion_auth->user($penj->id_user)->row();
                                        $cabang      = $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor(base_url('cart/'.($penj->status_bayar != '1' ? 'trans_bayar' : 'trans_detail').'.php?id='.general::enkrip($penj->id).($penj->status_bayar != '1' ? '&route=pengambilan' : '')), '#' . $penj->no_nota . '@' . $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row()->keterangan.' - '.$penj->nama.' - '.$penj->no_hp, 'class="text-default"'); ?></td>
                                            <td><?php echo $cabang->keterangan ?></td>
                                            <td><?php echo $tgl ?></td>
                                            <td class="text-right"><?php echo general::format_angka($penj->jml_gtotal) ?></td>
                                            <td style="width: 200px;">
                                                <?php echo general::status_bayar($penj->status_bayar) ?>
                                                <?php echo (!empty($penj->pengambilan) ? '['.$penj->pengambilan.(!empty($tgl_ambil) ? ' - '.$tgl_ambil : '').']' : '') ?>
                                            </td>
                                            <td>
                                                <?php // echo anchor(base_url('cart/form_edit.php?nota='.general::enkrip($penj->id)), '<i class="fa fa-edit"></i> Edit &nbsp;', 'class="label label-primary"') ?>
                                                <?php if($ambil != TRUE){ ?>
                                                    <?php echo general::status_nota($penj->status_nota).($penj->status_nota == '3' ? ' [Diambil: '. ucwords($penj->pengambilan).']' : '') ?>
                                                <?php }else{ ?>
                                                    <?php echo anchor(base_url('cart/form_pengambilan.php?id='.general::enkrip($penj->id)), '<i class="fa fa-check-circle text-success"></i> Pengambilan', 'class="text-default"') ?>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php echo anchor(base_url('cart/cetak_nota.php?id=' . general::enkrip($penj->id)), '<i class="fa fa-print"></i> '.($penj->cetak == '1' ? 'Cetak Ulang' : 'Cetak'), 'class="label '.($penj->cetak == '1' ? 'label-danger' : 'label-warning').'"') ?>
                                            </td>
                                        </tr>
                                        <?php if($ambil == TRUE){ ?>
                                        <tr>
                                            <td colspan="6">
                                                Lokasi Rak : 
                                                <?php 
                                                $sql_trans_lok = $this->db->where('id_penjualan', $penj->id)->get('tbl_trans_jual_lokasi')->result();
                                                foreach ($sql_trans_lok as $lokasi){
                                                    echo $lokasi->keterangan.' ';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<script>
    function form_validasi() {
        var plgn = $('#no_nota').val();
        var idpel = $('#cabang').val();
        if(idpel != '' && plgn != ''){
            return true;
        }else{
            alert('Kolom pelanggan dan lokasi tidak boleh kosong');
            return false;
        }
    }

    $(function () {
//         Tanggale Nota
        $('#tgl').datepicker({
            autoclose: true,
        });

//        Autocomplete Nyari Kasir
        $('#cari_kasir').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('page=transaksi&act=json_kasir') ?>",
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
                $itemrow.find('#cari_kasir').val(ui.item.nama);
                $('#cari_kasir').val(ui.item.nama);
                $('#kasir').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#cari_kasir').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nama + "</a>")
                    .appendTo(ul);
        };
    });
</script>