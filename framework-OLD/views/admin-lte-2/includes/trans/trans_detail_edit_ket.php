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
                                    <?php echo form_open(base_url('cart/trans_edit_ket_upd.php')) ?>
                                    <?php echo form_hidden('id', $_GET['id']) ?>
                                    <?php echo form_hidden('itemid', $items->id) ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px;"><?php // echo ($items->id_kategori2 == 0 && $penj->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')   ?></td>
                                        <td class="text-right" style="width: 50px;">
                                            <?php // echo anchor(base_url('cart/trans_edit_ket.php?id='.$_GET['id'].'&itemid='.general::enkrip($items->id)), ucwords(strtolower($items->produk)), 'class="label label-info"')   ?>                                            
                                            <?php if(isset($_GET['itemid'])){ ?>
                                            <button class="btn btn-info btn-flat"><i class="fa fa-recycle"></i></button>
                                            <?php } ?>
                                        </td>
                                        <td class="text-left" colspan="7">
                                            <?php if(isset($_GET['itemid'])){ ?>
                                                <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control', 'style' => 'text-align:left;', 'value' => $items->keterangan)) ?>
                                            <?php }else{ ?>
                                                <?php echo nbs(2) . '<i>' . $items->keterangan . '</i>' ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php echo form_close() ?>
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
                                            <?php echo form_input(array('id' => 'jml_total', 'name' => 'jml_total', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => $penj->jml_total)) ?>
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
                                                <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right', 'value' => $penj->jml_bayar, 'readonly' => ($penj->status_bayar == '1' ? 'TRUE' : 'FALSE'))) ?>
                                            <?php } else { ?>
                                                <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right')) ?>
                                            <?php } ?>                                                
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        <?php echo ($penj->status_bayar == '1' ? ($penj->metode_bayar == '1' ? 'Kembali' : 'Sisa Saldo') : '') ?>
                                        <div id="saldo_label">Sisa Saldo</div>
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php if ($penj->status_bayar == '1') { ?>
                                            <?php if ($penj->jml_kembali > 0) { ?>
                                                <div class="input-group date">                                                
                                                    <div class="input-group-addon">
                                                        Rp.
                                                    </div>
                                                    <?php echo form_input(array('id' => 'jml_kembali', 'name' => 'jml_kembali', 'class' => 'form-control pull-right text-right', 'value' => ($penj->status_bayar == '1' ? $penj->jml_kembali : ''), 'readonly' => 'TRUE')) ?>
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
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        Metode Pembayaran
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php 
                                        if($penj->metode_bayar > 2){
                                            $sql_met = $this->db->where('id', $penj->metode_bayar)->get('tbl_m_platform')->row();
                                            echo $sql_met->keterangan;
                                        }else{
                                            $met_pemb = general::metode_bayar($penj->metode_bayar);
                                        }
                                        
                                        echo $met_pemb;
                                        ?>
                                    </th>
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
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('cart/'.(isset($_GET['route']) ? $this->input->get('route') : 'trans_order_list.php')) ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('cart/cetak_nota_ket.php?id=' . $this->input->get('id') . '&status_ctk=' . $penj->cetak) ?>'"><i class="fa fa-print"></i> Cetak Keterangan</button>
                                    <?php if ($penj->status_bayar != '1') { ?>
                                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-cart-arrow-down"></i> Bayar &raquo;</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn <?php echo ($penj->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('cart/cetak_nota.php?id=' . $this->input->get('id') . '&status_ctk=' . $penj->cetak) ?>'"><i class="fa fa-print"></i> <?php echo ($penj->cetak == '1' ? 'Cetak Ulang Nota' : 'Cetak Nota') ?></button>
                                    <?php } ?>
									
                                    <?php //if ($penj->status_bayar != '1') { ?>
                                                        <!--//<?php // echo form_checkbox(array('name' => 'cetak', 'value' => '1')) . nbs(2)     ?> Cetak Nota-->
                                    <?php //} ?>
                                    <?php echo nbs(5) ?>
                                    <!--<button type="button" class="btn <?php echo ($penj->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="<?php echo ($penj->cetak == '1' ? "window.location.href='".base_url('cart/cetak_nota.php?id=' . $this->input->get('id'))."'" : 'download(); thanks();') ?>"><i class="fa fa-print"></i> <?php echo ($penj->cetak == '1' ? 'Cetak Ulang Nota' : 'Cetak Nota') ?></button>-->
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

       //      Tanggale Masuk
       $('#tgl_masuk').datepicker({
           autoclose: true,
       });
//      Tanggale Jadi
       $('#tgl_keluar').datepicker({
           autoclose: true,
       });
//      Jquery kanggo format angka
       $("#jml_total").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_biaya").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_kembali").autoNumeric({aSep: '.', aDec: ',', aPad: false});
//
//       $("#jml_diskon").children("option").filter(":selected").value()
//
       $("#deposit").click(function () {
//           var jml_diskon = $('#jml_diskon :selected').val();
           var biaya = $("#jml_biaya").val();
           var total = $("#jml_total").val();
//
//           e.preventDefault();
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
//
                       console.log(jml_diskon);
                       console.log(jml_gtotal);
//                       $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                       $("#jml_bayar").prop('readonly', true);
                       $("#jml_bayar").val(jml_gtotal);
                   })
               },
               error: function () {
                   alert('Error');
               }
           });
//
//           $("#jml_bayar").prop('readonly', true);
//           $("#jml_bayar").val(jml_gtotal);
           $("#saldo").show();
           $("#saldo_label").show();
       });
//
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
 var myWindow;

 function download() {
     myWindow = window.open("<?php echo base_url('cart/cetak_nota.php?id=' . $this->input->get('id')) ?>", "", "width=200,height=100,scrollbars=no,toolbar=no,menubar=no,location=no" );
//     myWindow.document.write('<p>This is \'MsgWindow\'. <?php // echo anchor(base_url('cart/cetak_nota.php?id='.$this->input->get('id')),'Refresh','onclick="tutup();"') ?></p>');
     this.window.focus();
 }

 function thanks() {
     document.getElementById('thanks').style.display = 'block';
 }
 
 function tutup(){
     myWindow.close();
 }
</script>