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
                <!--
                <?php if (isset($_GET['id_kat1'])) { ?>
                                        <div class="col-lg-3">
                                            <div class="box box-success">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Kategori</h3>
                                                </div>
                                                <div class="box-body">
                    <?php // echo nbs(5) . '<b>' . $this->db->where('id', general::dekrip($_GET['id_kat1']))->get('tbl_m_kategori')->row()->kategori . '</b>' ?>
                    <?php // echo br() ?>
                    <?php // echo nbs(8) . '* ' . $this->db->where('id', general::dekrip($_GET['id_kat2']))->get('tbl_m_kategori2')->row()->kategori . '' ?>
                    <?php // echo br() ?>
                    <?php // echo nbs(14) . $this->db->where('id', general::dekrip($_GET['id_kat3']))->get('tbl_m_kategori3')->row()->kategori . '' ?>
                                                </div>
                                            </div>
                                        </div>
                <?php } ?>
                -->
                <div class="col-lg-<?php echo (isset($_GET['id_kat1']) ? '12' : '12') ?>">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Keranjang Transaksi</h3>
                        </div>
                        <div class="box-body">
                            <?php if (isset($_GET['id_kat1'])) { ?>
                                <?php echo form_open(base_url('cart/cart_simpan.php')) ?>
                                <?php echo form_hidden('id_kat1', $this->input->get('id_kat1')) ?>
                                <?php echo form_hidden('id_kat2', $this->input->get('id_kat2')) ?>
                                <?php // echo form_hidden('id_kat3', $this->input->get('id_kat3')) ?>

                                <table id="keranjang" class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>Ukuran</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <!--<th>Charge</th>-->
                                            <th>Diskon</th>
                                            <th colspan="2">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?php echo form_input(array('id' => 'uk', 'name' => 'uk', 'class' => 'form-control', 'style' => 'width: 50px; text-align:center;', 'value' => '1')) ?>
                                            </td>
                                            <td>
                                                <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'style' => 'width: 50px; text-align:center;', 'value' => '1')) ?>
                                            </td>
                                            <td>
                                                <div class="input-group col-xs-12">
                                                    <div class="input-group-addon">
                                                        Rp. 
                                                    </div>
                                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control', 'value' => $kategori2->row()->harga)) ?>
                                                </div>                                        
                                            </td>
                                            <?php echo form_hidden('charge','') ?>
                                            <!--
                                            <td>
                                                <select name="charge" class="form-control">
                                                    <option value="">- Pilih -</option>
                                                    <?php
                                                    $charge = $this->db->where('tipe', '0')->get('tbl_m_charge')->result();
                                                    foreach ($charge as $charge) {
                                                        echo '<option value="' . $charge->id . '"> ' . $charge->keterangan . ' (' . general::format_angka($charge->nominal) . ')</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            -->
                                            <td>
                                                <select name="diskon" class="form-control">
                                                    <option value="">- Pilih -</option>
                                                    <?php
                                                    $diskon = $this->db->where('tipe', '0')->get('tbl_m_promo')->result();
                                                    foreach ($diskon as $diskon) {
                                                        echo '<option value="' . $diskon->id . '"> ' . $diskon->keterangan . ' (' . general::format_angka($diskon->persen) . ' %)</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><?php echo form_textarea(array('id' => 'ket', 'name' => 'keterangan', 'class' => 'form-control', 'placeholder' => 'Keterangan ...')) ?></td>
                                            <td>
                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</button>
                                                <!--<button id="tambah_ket" type="button" class="btn btn-success btn-flat"><i class="fa fa-plus"></i></button>-->
                                            </td>
                                        </tr>
										<!--
                                        <tr>
                                            <td colspan="5"></td>
                                            <td><?php echo form_input(array('id' => 'ket', 'name' => 'ket_tambahan[]', 'class' => 'form-control', 'placeholder' => 'Keterangan Tambahan ...')) ?></td>
                                            <td>
                                                <button id="tambah_ket" type="button" class="btn btn-success btn-flat"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
										-->
                                    </tbody>
                                </table>
                                <?php echo form_close() ?>
                                <hr/>
                            <?php } ?>
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center" style="width: 50px; text-align: center;">#</th>
                                    <th class="text-center" style="width: 50px;">No.</th>
                                    <th class="text-left">Jenis Laundry</th>
                                    <th class="text-center" style="width: 75px;">ukuran</th>
                                    <th class="text-center" style="width: 75px;" colspan="2"> Jml</th>
                                    <th class="text-right" colspan="3">Harga</th>
                                    <!--<th class="text-right">Charge</th>-->
                                    <th class="text-right">Diskon</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($this->cart->contents() as $items) { ?>
                                    <?php $subtot = (($items['qty'] * $items['price']) * $items['options']['uk']); ?>
                                    <?php $subtotal = $subtotal + $items['subtotal']; ?>
                                    <?php echo form_open(base_url('cart/cart_update.php')) ?>
                                    <tr>
                                        <td class="text-center" style="width: 50px; vertical-align: middle;">
                                            <?php echo anchor(base_url('cart/cart_hapus.php?id=' . $items['rowid'] . '&id_kat1=' . $items['options']['id_kat1'] . '&id_kat2=' . $items['options']['id_kat2'] . '&id_kat3=' . $items['options']['id_kat3'] . ''), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?>
                                        </td>
                                        <td class="text-center" style="width: 50px; vertical-align: middle;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="vertical-align: middle;"><?php echo ucwords($items['options']['kat2']) ?></td>
                                        <td class="text-center" style="width: 75px; vertical-align: middle;" colspan="2">
                                            <?php echo $items['options']['uk']; ?>
                                        </td>
                                        <td class="text-center" style="width: 75px; vertical-align: middle;">
                                            <?php echo $items['options']['jml']; ?>
                                        </td>
                                        <?php echo form_hidden('rowid', $items['rowid']) ?>
                                        <?php echo form_hidden('id_kat1', $this->input->get('id_kat1')) ?>
                                        <?php echo form_hidden('id_kat2', $this->input->get('id_kat2')) ?>
                                        <td class="text-right" style="width: 75px;">
                                            <?php if(!isset($_GET['id_kat2'])){ ?>
                                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'style' => 'width: 50px; text-align:center;', 'value' => $items['options']['jml'])) ?>
                                            <?php } ?>
                                        </td>
                                        <td class="text-left">
                                            <?php if(!isset($_GET['id_kat2'])){ ?>
                                            <button class="btn btn-info btn-flat"><i class="fa fa-recycle"></i></button>
                                            <?php } ?>
                                        </td>
                                        <td class="text-right" style="vertical-align: middle;"><?php echo general::format_angka($items['options']['harga']); ?></td>
                                        <!--<td class="text-right" style="vertical-align: middle;"><?php echo general::format_angka($items['options']['charge']); ?></td>-->
                                        <td class="text-right" style="vertical-align: middle;"><?php echo general::format_angka($items['options']['promo']); ?></td>
                                        <td class="text-right" style="vertical-align: middle;"><?php echo general::format_angka($items['subtotal']); ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-right" style="width: 50px; vertical-align: middle;">                                            
                                        </td>
                                        <td class="text-right" style="width: 50px; vertical-align: middle;"></td>
                                        <td class="text-left" colspan="7" style="vertical-align: middle;">
                                            <!--<i><?php echo ucwords($items['options']['keterangan']) ?></i>-->
                                            <?php if(isset($_GET['id_kat2'])){ ?>
                                                <i><?php echo ucwords($items['options']['keterangan']) ?></i>
                                            <?php }else{ ?>
                                                <?php echo form_textarea(array('id' => 'ket', 'name' => 'keterangan', 'class' => 'form-control', 'value' => $items['options']['keterangan'])) ?>                                                 
                                            <?php } ?>
                                        </td>
                                        <!--<td class="text-right" style="vertical-align: middle;"></td>-->
                                        <!--<td class="text-right" style="vertical-align: middle;"></td>-->
                                        <td class="text-right" style="vertical-align: middle;"></td>
                                        <td class="text-right" style="vertical-align: middle;"></td>
                                    </tr>
                                    <?php echo form_close() ?>
                                    <!--
                                    <tr><th colspan="7">Keterangan tambahan :</th></tr>
                                    <?php foreach ($items['options']['ket_tmbh'] as $tambahan){ ?>
                                        <tr><td colspan="7"><?php echo $tambahan ?></td></tr>
                                    <?php } ?>
                                    -->
                                <?php } ?>
                                <tr>
                                    <td class="text-right" colspan="10"><b>Total</b></td>
                                    <td class="text-right"><?php echo general::format_angka($subtotal); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('cart/cart-step-1.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo base_url('cart/set_nota_simpan.php') ?>'">Simpan & Buat Nota &raquo;</button>
                                </div>
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
                                        $('#tambah_ket').click(function () {
                                            $('#keranjang').append('<tr><td colspan="5"></td><td><?php echo form_input(array('id' => 'ket', 'name' => 'ket_tambahan[]', 'class' => 'form-control', 'placeholder' => 'Keterangan Tambahan ...')) ?></td><td></td></tr>');
                                        }
                                        );                                
                                        $(function () {
//      Jquery kanggo format angka
//        $("#gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

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