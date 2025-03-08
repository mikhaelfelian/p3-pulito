<?php $hasError = $this->session->flashdata('form_error') ?><?php echo $this->session->flashdata('produk') ?>
<?php
$tgl_msk = explode('-', $penj->tgl_masuk);
$tgl_klr = explode('-', $penj->tgl_keluar);

$pelanggan = $this->db->select('tbl_m_pelanggan.kode, tbl_m_pelanggan.nik, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp, tbl_m_pelanggan.lokasi, tbl_m_pelanggan.alamat, tbl_m_pelanggan_grup.grup, tbl_m_pelanggan_grup.status_deposit')->join('tbl_m_pelanggan_grup', 'tbl_m_pelanggan_grup.id=tbl_m_pelanggan.id_grup')->where('tbl_m_pelanggan.id', $penj->id_pelanggan)->get('tbl_m_pelanggan');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Penjualan <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home&act=index') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=transaksi&act=trans_jual_list') ?>">Penjualan</a></li>
            <li class="active">Detail</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Pemesanan</h3>
                        </div>
                        <div class="box-body">
                            <?php echo $this->session->flashdata('transaksi') ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>:</th>
                                    <td>#<?php echo $penj->no_nota ?></td>

                                    <th>Pelanggan</th>
                                    <th>:</th>
                                    <td><?php echo $pelanggan->row()->nama ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Masuk</th>
                                    <th>:</th>
                                    <td><?php echo $penj->tgl_masuk ?></td>

                                    <th>Tgl Keluar</th>
                                    <th>:</th>
                                    <td><?php echo $penj->tgl_keluar ?></td>
                                </tr>
                            </table>
                            <hr/>
                            <br/>
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-right" style="width: 25px;"></th>
                                    <th class="text-center" style="width: 50px;">No.</th>
                                    <th class="text-left">Keterangan</th>
                                    <th class="text-center" style="width: 75px;">Ukuran</th>
                                    <th class="text-center" style="width: 75px;">Pcs</th>
                                    <th class="text-center" style="width: 75px;">Jml</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Diskon</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>                               

                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($penj_det as $items) { ?>
                                    <?php
                                    $subtotal = $subtotal + $items->subtotal;
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px;"><?php // echo ($items->id_kategori2 == 0 && $penj->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')   ?></td>
                                        <td class="text-right" style="width: 50px;"><?php echo $no++ ?></td>
                                        <td class="text-left">                                            
                                            <?php echo ucwords(strtolower($items->produk)); ?>
                                        </td>
                                        <td class="text-center" style="width: 75px;"><?php echo $items->uk; ?></td>
                                        <td class="text-center" style="width: 75px;"><?php echo $items->pcs; ?></td>
                                        <td class="text-center" style="width: 75px;"><?php echo $items->jml; ?></td>
                                        <td class="text-right">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->harga) : ''); ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->diskon) : ''); ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->subtotal) : ''); ?>
                                        </td>
                                    </tr>
									<!--
                                    <tr>
                                        <td class="text-right" style="width: 25px;"><?php // echo ($items->id_kategori2 == 0 && $penj->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')   ?></td>
                                        <td class="text-right" style="width: 50px;"><?php // echo $no++   ?></td>
                                        <td class="text-left" colspan="7">                                            
                                            <?php echo nbs(2) . '<i>' . $items->keterangan . '</i>' ?>
                                        </td>
                                    </tr>
									-->
                                <?php } ?>
                                <?php echo form_open(base_url('cart/set_nota_bayar.php')) ?>
                                <?php echo form_hidden('jml_total', $penj->jml_total) ?>
                                <?php echo form_hidden('id', general::enkrip($penj->id)) ?>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">Total</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_total', 'name' => 'jml_total', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($penj->jml_total))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">Diskon</th>
                                    <th  class="text-right" style="width: 250px;">
                                        <select id="jml_diskon" name="jml_diskon" class="form-control" <?php echo($penj->status_bayar != '0' ? 'disabled="TRUE"' : '') ?>>
                                            <option value="0">None</option>
                                            <?php foreach ($diskon as $diskon) { ?>
                                                <option value="<?php echo $diskon->id ?>" <?php echo ($penj->id_promo == $diskon->id ? 'selected' : '') ?>><?php echo $diskon->keterangan . ' (' . general::format_angka($diskon->persen) . ' %)' ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                </tr>
                                <?php echo form_hidden('id_biaya', '') ?>
                                <!--
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">Charge</th>
                                    <th  class="text-right" style="width: 250px;">
                                        <select id="jml_diskon" name="id_biaya" class="form-control" <?php echo($penj->status_bayar != '0' ? 'disabled="TRUE"' : '') ?>>
                                            <option value="0">None</option>
                                            <?php foreach ($biaya as $biaya) { ?>
                                                <option value="<?php echo $biaya->id ?>" <?php echo ($penj->id_biaya == $biaya->id ? 'selected' : '') ?>><?php echo $biaya->keterangan . ' (' . general::format_angka($biaya->nominal).')' ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                </tr>
                                -->
                                <?php if ($penj->jml_kurang > 0) { ?>
                                    <tr>
                                        <th colspan="8" class="text-right" style="vertical-align: middle;">Total Harus Bayar</th>
                                        <th  class="text-right" style="width: 250px;">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    Rp.
                                                </div>
                                                <?php if ($penj->status_bayar != 0) { ?>
                                                    <?php echo form_input(array('id' => 'jml_kurang', 'name' => 'jml_kurang', 'class' => 'form-control pull-right text-right', 'value' => general::format_angka($penj->jml_kurang), 'readonly' => ($penj->status_bayar != 0 ? 'TRUE' : 'FALSE'))) ?>
                                                <?php } ?>                                                
                                            </div>
                                        </th>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">Jml Bayar</th>
                                    <th  class="text-right" style="width: 250px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php if ($penj->status_bayar == 1) { ?>                                                
                                                <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right', 'value' => general::format_angka($penj->jml_bayar), 'readonly' => ($penj->status_bayar == '1' ? 'TRUE' : 'FALSE'))) ?>
                                            <?php } else { ?>
                                                <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right')) ?>
                                            <?php } ?>                                                
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        <?php echo ($penj->status_bayar == '1' ? ($penj->metode_bayar == '1' ? 'Kembali' : 'Sisa Saldo') : '') ?>
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php if ($penj->status_bayar == '1') { ?>
                                            <?php if ($penj->jml_kembali > 0) { ?>
                                                <div class="input-group date">                                                
                                                    <div class="input-group-addon">
                                                        Rp.
                                                    </div>
                                                    <?php echo form_input(array('id' => 'jml_kembali', 'name' => 'jml_kembali', 'class' => 'form-control pull-right text-right', 'value' => ($penj->status_bayar == '1' ? general::format_angka($penj->jml_kembali) : ''), 'readonly' => 'TRUE')) ?>
                                                </div>
                                            <?php } else { ?>
                                                <?php echo ($penj->metode_bayar == 1 ? general::format_angka($member_sal->jml_deposit) : '0') ?>
                                                <?php echo nbs(2); ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <!--<div id="saldo"><?php echo general::format_angka($member_sal->jml_deposit) ?></div>-->
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        Metode Pembayaran
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php 
                                        $sql_plat = $this->db->where('id_penjualan', $penj->id)->where('id_platform', $penj->metode_bayar)->get('tbl_trans_jual_plat')->row();
                                        
                                        if($penj->metode_bayar > 2){
                                            $sql_met  = $this->db->where('id', $penj->metode_bayar)->get('tbl_m_platform')->row();
                                            $met_pemb = $sql_met->platform;
                                        }else{
                                            $met_pemb = general::metode_bayar($penj->metode_bayar);
                                        }
                                        
                                        echo $met_pemb;
                                        ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="8"></th>
                                    <th class="text-right"><?php echo $sql_plat->keterangan; ?></th>
                                </tr>
                                <tr>
                                    <th colspan="<?php echo (!empty($penj->no_kartu) ? '7' : '9') ?>" class="text-right" style="vertical-align: middle;">
                                        <div id="thanks" class="alert alert-info" style="display: none;">
                                            File berhasil diunduh, silahkan klik <?php echo anchor(base_url('cart/trans_detail.php?id=' . $this->input->get('id')),'Refresh','onclick="tutup();"') ?>
                                        </div>
                                        <?php echo $this->db->where('id_penjualan', $penj->id)->get('tbl_trans_jual_plat')->row()->keterangan; ?>
                                    </th>
                                    <?php if(!empty($penj->no_kartu)){ ?>
                                        <th  class="text-right" style="width: 250px;">
                                            <?php if ($penj->status_bayar == '0') { ?>
                                                <?php echo form_input(array('id' => 'no_kartu', 'name' => 'no_kartu', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Nomor Kartu ...')) ?>
                                            <?php } else { ?>
                                                <?php echo (!empty($penj->no_kartu) ? '' : '') ?>
                                            <?php } ?>
                                        </th>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo site_url('page=transaksi&act=trans_jual_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
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