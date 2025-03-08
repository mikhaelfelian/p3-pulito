<?php echo $this->session->flashdata('produk') ?>
<?php
$tgl_msk = explode('-', $penj->tgl_masuk);
$tgl_klr = explode('-', $penj->tgl_keluar);

$pelanggan = $this->db->select('tbl_m_pelanggan.kode, tbl_m_pelanggan.nik, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp, tbl_m_pelanggan.lokasi, tbl_m_pelanggan.alamat, tbl_m_pelanggan_grup.grup, tbl_m_pelanggan_grup.status_deposit')->join('tbl_m_pelanggan_grup', 'tbl_m_pelanggan_grup.id=tbl_m_pelanggan.id_grup')->where('tbl_m_pelanggan.id', $penj->id_pelanggan)->get('tbl_m_pelanggan');
?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data
                <small>Transaksi</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Keranjang Transaksi</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
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
                                    <th class="text-center" style="width: 75px;">Jml</th>
                                    <th class="text-right">Harga</th>
                                    <!--<th class="text-right">Charge</th>-->
                                    <th class="text-left">Diskon</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($penj_det as $items) { ?>
                                    <?php
                                    $subtotal = $subtotal + $items->subtotal;
//                                    $sql_ket  = $this->db->where('id', $items->id);
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px; vertical-align: middle;"><?php // echo ($items->id_kategori2 == 0 && $penj->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')  ?></td>
                                        <td class="text-center" style="width: 50px; vertical-align: middle;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 450px; vertical-align: middle;">                                            
                                            <?php echo ucwords(strtolower($items->produk)); ?>
                                        </td>
                                        <td class="text-center" style="width: 75px; vertical-align: middle;"><?php echo $items->uk; ?></td>
                                        <td class="text-center" style="width: 75px; vertical-align: middle;"><?php echo $items->jml; ?></td>
                                        <td class="text-right" style="width: 100px; vertical-align: middle;">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->harga) : ''); ?>
                                        </td>
                                        <!--
                                        <td class="text-left" style="vertical-align: middle;">
                                            <?php // echo ($items->harga != 0 ? general::format_angka($items->charge) : ''); ?>
                                        </td>
                                        -->
                                        <td class="text-left" style="vertical-align: middle;">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->diskon) : ''); ?>
                                        </td>
                                        <td class="text-right" style="vertical-align: middle;">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->subtotal) : ''); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php echo form_open(base_url('cart/set_nota_bayar.php'.(isset($_GET['route']) ? '?route='.$_GET['route'] : ''))) ?>
                                <?php echo (isset($_GET['route']) ? form_hidden('route', $this->input->get('route')) : '') ?>
                                <?php echo form_hidden('jml_total', $penj->jml_total) ?>
                                <?php echo form_hidden('no_nota', $penj->no_nota) ?>
                                <?php echo form_hidden('id', general::enkrip($penj->id)) ?>
                                <!--
                                <tr>
                                    <th colspan="" class="text-right" style="vertical-align: middle;">

                                    </th>
                                    <th class="text-right" style="vertical-align: middle;"></th>
                                    <th colspan="8" class="text-right" style="width: 200px;">
                                        <input type="radio" name="ck_jasa_lipat" value="1" <?php echo ($penj->ck_jasa_lipat == 1 ? 'checked="TRUE"' : '') ?>> Lipat
                                        <?php echo nbs(4) ?>
                                        <input type="radio" name="ck_jasa_lipat" value="0" <?php echo ($penj->ck_jasa_gantung == 1 ? 'checked="TRUE"' : '') ?>> Gantung
                                        <?php // echo form_checkbox(array('name' => 'ck_jasa_lipat', 'value' => '1')) . ' Lipat' ?>
                                        <?php // echo nbs(4) ?>
                                        <?php // echo form_checkbox(array('name' => 'ck_jasa_gantung', 'value' => '1')) . ' Gantung' ?>
                                    </th>
                                </tr>
                                -->
                                <tr>
                                    <th class="text-right" colspan="7" style="vertical-align: middle;">Total</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_total', 'name' => 'jml_total', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => $penj->jml_total)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">Diskon</th>
                                    <th  class="text-right" style="width: 250px;">
                                        <select id="jml_diskon" name="jml_diskon" class="form-control" <?php echo($penj->status_bayar != '0' ? 'disabled="TRUE"' : '') ?>>
                                            <option value="0">None</option>
                                            <?php foreach ($diskon as $diskon) { ?>
                                                <option value="<?php echo $diskon->id ?>" <?php echo ($penj->id_promo == $diskon->id ? 'selected' : '') ?>><?php echo $diskon->keterangan . ' (' . general::format_angka($diskon->persen) . ' %)' ?></option>
                                            <?php } ?>
                                        </select>
                                        <!--
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                        <?php if ($penj->status_bayar == '0') { ?>
                                            <?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right')) ?>
                                        <?php } else { ?>
                                            <?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right', 'value' => $penj->diskon, 'readonly' => 'TRUE')) ?>
                                        <?php } ?>
                                        </div>
                                        -->
                                    </th>
                                </tr>
                                <!--
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">Charge</th>
                                    <th  class="text-right" style="width: 250px;">                                        
                                        <select id="jml_diskon" name="id_biaya" class="form-control" <?php echo($penj->status_bayar != '0' ? 'disabled="TRUE"' : '') ?>>
                                            <option value="0">None</option>
                                            <?php foreach ($biaya as $biaya) { ?>
                                                <option value="<?php echo $biaya->id ?>" <?php echo ($penj->id_biaya == $biaya->id ? 'selected' : '') ?>><?php echo $biaya->keterangan . ' (' . general::format_angka($biaya->persen) . ' %)' ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                </tr>
                                -->
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                        Metode Pembayaran
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php // if ($penj->status_bayar == '0') { ?>
                                        <?php // echo form_radio(array('id' => 'tunai', 'name' => 'metode_bayar', 'value' => '1', 'checked' => 'TRUE')) . nbs(2) ?> 
                                        <select id="metode_bayar" name="metode_bayar" class="form-control" <?php echo($penj->status_bayar == '1' ? 'disabled="TRUE"' : '') ?>>
                                            <?php $sql_metode = $this->db->where('id_penjualan', $penj->id)->get('tbl_trans_jual_plat')->row(); ?>
											<option value="1" <?php echo ($sql_metode->id_platform == 1 ? 'selected' : ''); ?>>Tunai</option>
                                            <?php
                                            $sql_dep  = $this->db->select('tbl_m_pelanggan_grup.status_deposit')->join('tbl_m_pelanggan_grup','tbl_m_pelanggan_grup.id=tbl_m_pelanggan.id_grup')->where('tbl_m_pelanggan.id', $penj->id_user)->get('tbl_m_pelanggan')->row();
                                                                                        
                                            if($sql_dep->status_deposit == '1'){
                                                echo '<option value="2">Deposit</option>';
                                            }
                                            ?>                                            
                                            <?php foreach ($platform as $platform) { ?>
                                                <?php if($platform->id > 2) { ?>
                                                    <option value="<?php echo $platform->id ?>" <?php echo ($sql_metode->id_platform == $platform->id ? 'selected' : '') ?>><?php echo $platform->platform ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <?php // } else { ?>
                                        <?php // echo general::metode_bayar($penj->metode_bayar) ?>
                                        <?php // } ?>
                                    </th>
                                </tr>
								<?php if ($penj->status_bayar > 0) { ?>
                                    <tr>
                                        <th colspan="7" class="text-right" style="vertical-align: middle;">Jml Grand Total</th>
                                        <th  class="text-right" style="width: 250px;">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    Rp.
                                                </div>
                                                <?php if ($penj->status_bayar != 0) { ?>
                                                    <?php echo form_input(array('id' => 'jml_gtotal', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right text-right', 'value' => $penj->jml_gtotal, 'readonly' => ($penj->status_bayar != 0 ? 'TRUE' : 'FALSE'))) ?>
                                                <?php } ?>                                                
                                            </div>
                                        </th>
                                    </tr>
				<?php } ?>
                                <?php if ($penj->jml_kurang > 0) { ?>
                                    <tr>
                                        <th colspan="7" class="text-right" style="vertical-align: middle;">Jml Hrs Bayar</th>
                                        <th  class="text-right" style="width: 250px;">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    Rp.
                                                </div>
                                                <?php // if ($penj->status_bayar != 0) { ?>
                                                    <?php echo form_input(array('id' => 'jml_kurang', 'name' => 'jml_kurang', 'class' => 'form-control pull-right text-right', 'value' => $penj->jml_kurang, 'readonly' => ($penj->status_bayar != 0 ? 'TRUE' : 'FALSE'))) ?>
                                                <?php // } ?>                                                
                                            </div>
                                        </th>
                                    </tr>
                                <?php } ?>
				<?php if($penj->jml_kurang > 0){ ?>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">Jml Bayar</th>
                                    <th  class="text-right" style="width: 250px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php if ($penj->status_bayar == 1) { ?>                                                
                                                <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right', 'value' => $penj->jml_bayar, 'readonly' => ($penj->status_bayar == '1' ? 'TRUE' : 'FALSE'))) ?>
                                            <?php } else { ?>
                                                <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right')) ?>
                                            <?php } ?>                                                
                                        </div>
                                    </th>
                                </tr>
                                <?php } else { ?>
                                    <?php echo form_hidden('jml_bayar', '0') ?>
                                <?php } ?>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                        <?php echo ($penj->status_bayar == '1' ? ($penj->metode_bayar != 1 ? 'Sisa Saldo' : 'Kembali') : '') ?>
                                        <div id="saldo_label">Sisa Saldo</div>
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php if ($penj->status_bayar == '1') { ?>
                                            <?php if ($penj->jml_kembali > 0) { ?>
                                                <div class="input-group date">                                                
                                                    <div class="input-group-addon">
                                                        Rp.
                                                    </div>
                                                    <?php echo form_input(array('id' => 'jml_kembali', 'name' => 'jml_kembali', 'class' => 'form-control pull-right text-right', 'value' => ($penj->status_bayar == '1' ? $penj->jml_kembali : ''), 'readonly' => ($penj->status_bayar == '1' ? 'TRUE' : 'FALSE'))) ?>
                                                </div>
                                            <?php } else { ?>
                                                <?php echo ($penj->metode_bayar == 1 ? general::format_angka($member_sal->jml_deposit) : '0') ?>
                                                <?php echo nbs(2); ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <div id="saldo"><?php echo general::format_angka($member_sal->jml_deposit) ?></div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php // if ($penj->status_bayar == '0') { ?>
                                        <?php echo form_input(array('id' => 'no_kartu', 'name' => 'no_kartu', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Nomor Kartu / Kode Voucher ...')) ?>
                                        <?php // } else { ?>
                                        <?php // echo (!empty($penj->no_kartu) ? '' : '') ?>
                                        <?php // } ?>
                                    </th>
                                </tr>
				<?php if($penj->status_bayar == 1 && $_GET['route'] == 'pengambilan'){ ?>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">Nama Pengambil</th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php if (!empty($penj->pengambilan)) { ?>                                                
                                            <?php echo form_input(array('id' => 'pengambil', 'name' => 'pengambil', 'class' => 'form-control pull-right text-right', 'value' => $penj->pengambilan, 'readonly' => ($penj->status_bayar == '1' ? 'TRUE' : 'FALSE'))) ?>
                                        <?php } else { ?>
                                            <?php echo form_input(array('id' => 'pengambil', 'name' => 'pengambil', 'class' => 'form-control pull-right text-right')) ?>
                                        <?php } ?>
                                    </th>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('cart/trans_bayar_list.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Lihat Daftar Nota</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if ($penj->status_bayar == '0') { ?>
                                        <!--//<?php // echo form_checkbox(array('name' => 'cetak', 'value' => '1')) . nbs(2)    ?> Cetak Nota-->
                                    <?php } ?>
                                    <?php echo nbs(5) ?>
                                    <!--<button type="button" class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo base_url('cart/form_edit.php?nota=' . $this->input->get('id')) ?>'"><i class="fa fa-edit"></i> Ubah</button>-->
                                    <?php if ($penj->jml_gtotal == 0) { ?>
					<button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('cart/cetak_nota_ket.php?id=' . $this->input->get('id') . '&status_ctk=' . $penj->cetak) ?>'"><i class="fa fa-print"></i> Cetak Keterangan</button>
                                    <?php } ?>
                                    <button type="button" class="btn <?php echo ($penj->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('cart/cetak_nota.php?id=' . $this->input->get('id') . '&status_ctk=' . $penj->cetak) ?>'"><i class="fa fa-print"></i> <?php echo ($penj->cetak == '1' ? 'Cetak Ulang Nota' : 'Cetak Nota') ?></button>
                                    <button type="button" class="btn <?php echo ($penj->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('cart/cetak_nota_jual.php?id=' . $this->input->get('id') . '&status_ctk=' . $penj->cetak) ?>'"><i class="fa fa-print"></i> <?php echo ($penj->cetak == '1' ? 'Cetak Nota HTML' : 'Cetak Nota HTML') ?></button>
                                    <?php if ($penj->status_bayar != '1') { ?>
                                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa <?php echo ($penj->jml_gtotal == '0' ? 'fa-check' : 'fa-shopping-cart') ?>"></i> <?php echo ($penj->jml_gtotal == 0 ? 'Konfirm' : 'Bayar') ?> &raquo;</button>
                                    <?php } else { ?>										<!--<button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('cart/cetak_nota_ket.php?id=' . $this->input->get('id') . '&status_ctk=' . $penj->cetak) ?>'"><i class="fa fa-print"></i> Cetak Keterangan</button>-->
                                        <?php if($penj->pengambilan == '' && $_GET['route'] == 'pengambilan'){ ?>
                                            <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Ambil &raquo;</button>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
                                        $(function () {
                                            $('#saldo_label').hide();
                                            $('#saldo').hide();
                                            $('#no_kartu').hide();

                                            $('#tunai').click(function () {
                                                $('#no_kartu').hide()
                                            });
                                            
                                            var metode_byr = $('#metode_bayar option:selected').val();
                                            $("#metode_bayar").on('change',function () {
                                                if($('#metode_bayar option:selected').val() > 2){
                                                   $('#no_kartu').show(); 
                                                }else{
                                                   $('#no_kartu').hide()
                                                }
                                            });

                                            //      Tanggale Masuk
                                            $('#tgl_masuk').datepicker({
                                                autoclose: true,
                                            });
//      Tanggale Jadi
                                            $('#tgl_keluar').datepicker({
                                                autoclose: true,
                                            });
//      Jquery kanggo format angka
//                                            $("input[type=text]").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_kurang").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_total").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_biaya").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_kembali").autoNumeric({aSep: '.', aDec: ',', aPad: false});

//                                            $("#jml_diskon").children("option").filter(":selected").value()

                                            $("#deposit").click(function () {
//                                                var jml_diskon = $('#jml_diskon :selected').val();
                                                var biaya = $("#jml_biaya").val();
                                                var total = $("#jml_total").val();

//                                                e.preventDefault();
                                                $.ajax({
                                                    type: "GET",
                                                    url: "<?php echo base_url('cart/get_diskon.php') ?>",
                                                    data: {id: $('#jml_diskon :selected').val()},
                                                    success: function (data) {
                                                        $.get("<?php echo base_url('cart/get_diskon.php?id=') ?>" + $('#jml_diskon :selected').val(), function (data) {
                                                            var jml_total = total.replace('.', '');
                                                            var jml_biaya = biaya.replace('.', '');
                                                            var jml_diskon = (parseInt(data) / 100) * parseInt(jml_total);
                                                            var jml_gtotal = ((parseInt(jml_total) + parseInt(jml_biaya)) - parseInt(jml_diskon));

                                                            console.log(jml_diskon);
                                                            console.log(jml_gtotal);
//                                                            $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                                            $("#jml_bayar").prop('readonly', true);
                                                            $("#jml_bayar").val(jml_gtotal);
                                                        })
                                                    },
                                                    error: function () {
                                                        alert('Error');
                                                    }
                                                });

//                                                $("#jml_bayar").prop('readonly', true);
//                                                $("#jml_bayar").val(jml_gtotal);
                                                $("#saldo").show();
                                                $("#saldo_label").show();
                                            });

                                            $("#tunai").click(function () {
//            var jml_total = $("#jml_total").val();
                                                $("#jml_bayar").prop('readonly', false);
                                                $("#jml_bayar").val('');
                                                $("#saldo").hide();
                                                $("#saldo_label").hide();
                                            });

                                            $("#jml").keydown(function (e) {
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
                                        });
</script>