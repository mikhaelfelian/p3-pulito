<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
        <!-- JQueri UI -->
        <script src="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-2.1.4.min.js"></script>
        <script src="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.js"></script>
        <script src="<?php echo base_url('assets/sb-admin') ?>/ui/autonumeric.js"></script>
        <link href="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">
        <script type="text/javascript">
            var s = $.noConflict();
            s(function () {
                s('#kode').focus();
                /* Menu Tambahan */

                s('#kode').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "<?php echo base_url('json/json_menu_tambahan.json') ?>",
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
                        var $itemrow = s(this).closest('tr');
                        // Populate the input fields from the returned values
                        $itemrow.find('#menu').val(ui.item.menu);
                        s('#kode').val(ui.item.kode);
                        s('#produk').val(ui.item.produk);
                        s('#id_produk').val(ui.item.id);
                        s('#kode').val(ui.item.kode);
                        s('#harga').val(ui.item.harga);
                        s('#ket_menu').val(ui.item.ket);

                        // Give focus to the next input field to recieve input from user
                        s('#qty').focus();
                        return false;
                    }
                    // Format the list menu output of the autocomplete
                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                    return s("<li></li>")
                            .data("item.autocomplete", item)
                            .append("<a>[" + item.kode + "] " + item.produk + "-" + item.harga + "</a>")
                            .appendTo(ul);
                };

                s('#produk').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "<?php echo base_url('json/json_menu_tambahan.json') ?>",
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
                        var $itemrow = s(this).closest('tr');
                        // Populate the input fields from the returned values
                        $itemrow.find('#menu').val(ui.item.menu);
                        s('#kode').val(ui.item.kode);
                        s('#produk').val(ui.item.produk);
                        s('#id_produk').val(ui.item.id);
                        s('#kode').val(ui.item.kode);
                        s('#harga').val(ui.item.harga);
                        s('#ket_menu').val(ui.item.ket);

                        // Give focus to the next input field to recieve input from user
                        s('#qty').focus();
                        return false;
                    }
                    // Format the list menu output of the autocomplete
                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                    return s("<li></li>")
                            .data("item.autocomplete", item)
                            .append("<a>[" + item.kode + "] " + item.produk + "-" + item.harga + "</a>")
                            .appendTo(ul);
                };

                s("#harga").keydown(function (e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A, Command+A
                                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                    // Allow: home, end, left, right, down, up
                                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                                // let it happen, don't do anything
                                return;
                            }
                            // Ensure that it is a number and stop the keypress
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });

                s("#qty").keydown(function (e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A, Command+A
                                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                    // Allow: home, end, left, right, down, up
                                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                                // let it happen, don't do anything
                                return;
                            }
                            // Ensure that it is a number and stop the keypress
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });


                /* Untuk Kasir */
                s("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                s("#jml_disk").keydown(function (e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A, Command+A
                                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                    // Allow: home, end, left, right, down, up
                                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                                // let it happen, don't do anything
                                return;
                            }
                            // Ensure that it is a number and stop the keypress
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });

                s("#id_card").prop('disabled', true);
                s("#m_kas").click(function () {
                    s("#id_card").prop('disabled', true);
                    s("#id_card").val('');
                });

                s("#m_deb").click(function () {
                    s("#id_card").prop('disabled', false);
                });

                s("#m_kred").click(function () {
                    s("#id_card").prop('disabled', false);
                });

                s("#m_lain").click(function () {
                    s("#id_card").prop('disabled', false);
                });

            });

        </script>
        <!--JQuery UI-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php echo $this->session->flashdata('pesan') ?>
        </div>
    </div>
    <!-- /.row -->
    <?php echo br(2) ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Kasir</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php if ($pesanan->status_payment == 'unpaid' AND $pesanan->jml_bayar > 0) { ?>
                                <a href="<?php echo base_url('front/index.php') ?>"><button class="btn btn-primary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</button></a><br/><br/>
                            <?php } elseif ($pesanan->status_order == 'pend') { ?>
                                <a href="<?php echo base_url('pesan/batal.php?no_nota=' . $_GET['no_nota'] . '&status=' . $pesanan->status_order . (isset($_GET['route']) ? '&route=' . $_GET['route'] : '')) ?>"><button class="btn btn-danger"><i class="fa fa-fw fa-remove"></i> Batal</button></a><br/><br/>
                            <?php } else { ?>
                                <a href="<?php echo base_url('front/index.php') ?>"><button class="btn btn-primary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</button></a><br/><br/>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">        
                        <div class="col-lg-12">
                            <?php echo $this->session->flashdata('transaksi') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">           
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="panel-title"><i class="fa fa-check"></i> Data Transaksi</h2>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="3">User : <?php echo $this->ion_auth->user()->row()->first_name ?></th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No. Nota</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($trans)) {
                                                $no = 1;
                                                foreach ($trans as $trans) {
                                                    $stat_order = $trans->status_order;
                                                    $stat_byr = $trans->status_payment;

                                                    switch ($stat_order) {
                                                        case 'pend':
                                                            $status = general::status_order($stat_order);
                                                            break;

                                                        case 'batal':
                                                            $status = general::status_order($stat_order);
                                                            break;

                                                        case 'confirm':
                                                            $status = general::status_order($stat_order);
                                                            break;

                                                        case 'complete':
                                                            $status = general::status_byr($stat_byr);
//                                            $status = $stat_byr;
                                                            break;
                                                    }
                                                    ?>                            
                                                    <tr>
                                                        <td><?php echo $no ?></td>
                                                        <td><a href="<?php echo base_url('pesan/kasir.php?id=' . general::enkrip($trans->id_meja) . '&no_meja=' . $trans->no_meja . '&status=' . $trans->status_resto . '&no_nota=' . $trans->no_nota) ?>"><?php echo $trans->no_nota ?></a></td>
                                                        <td><?php echo ($trans->status_order == 'complete' && $trans->status_payment == 'paid' ? 'Lunas' : 'Menunggu'); ?></td>
                                                    </tr>
                                                    <?php
                                                    $no++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">            
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="panel-title"><i class="fa fa-shopping-cart"></i> Penjualan</h2>
                                </div>
                                <div class="panel-body">
                                    <?php echo form_open('pesan/u_status_order.php') ?>
                                    <?php // echo form_hidden('id_meja', $_GET['id']) ?>
                                    <?php // echo form_hidden('no_meja', $_GET['no_meja']) ?>
                                    <?php // echo form_hidden('no_nota', $_GET['no_nota']) ?>
                                    <table class="table table-striped">
                                        <?php if ($pesanan->status_resto == 2 OR $pesanan->status_resto == 3) { ?>                        
                                            <tr>
                                                <th colspan="6">Tanggal : <?php echo $this->tanggalan->tgl_indo($pesanan->tgl_simpan) ?></th>
                                            </tr>
                                        <?php } else { ?>                        
                                            <tr>
                                                <th colspan="3">Tanggal : <?php echo $this->tanggalan->tgl_indo($pesanan->tgl_simpan) ?></th>
                                                <th colspan="3"></th>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td style="vertical-align: middle"><label>No. Nota</label></td>
                                            <td style="vertical-align: middle"><label>:</label></td>
                                            <td style="vertical-align: middle"><?php echo $pesanan->no_nota ?></td>

                                            <td style="vertical-align: middle"><label>Nama</label></td>
                                            <td style="vertical-align: middle"><label>:</label></td>
                                            <td style="vertical-align: middle"><?php echo $pesanan->nama ?></td>
                                        </tr>
                                    </table>
                                    <?php echo form_close() ?>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Produk</th>
                                                <th>Jml</th>
                                                <th>Harga</th>
                                                <th>Keterangan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <?php echo form_open('pesan/temp_pesan_menu.php') ?>
                                        <?php echo form_hidden('no_nota', $_GET['no_nota']) ?>
                                        <input type="hidden" id="id_produk" name="id_produk">
                                        <tbody>
                                            <tr>
                                                <td><?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control')) ?></td>
                                                <td><?php echo form_input(array('id' => 'produk', 'name' => 'produk', 'class' => 'form-control')) ?></td>
                                                <td><?php echo form_input(array('id' => 'qty', 'name' => 'qty', 'value' => '', 'class' => 'form-control', 'style' => 'width:40px; text-align:center;')) ?></td>
                                                <td><?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control', 'readonly' => 'TRUE')) ?></td>
                                                <td><?php echo form_input(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control')) ?></td>
                                                <td><button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Beli</button></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <?php echo form_input(array('id' => 'ket_menu', 'class' => 'form-control', 'readonly' => 'TRUE')) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php echo form_close() ?>
                                    </table>
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center" style="width: 7px;"><label>No.</label></th>
                                            <th class="text-left"><label>Produk</label></th>
                                            <th class="text-center"><label>Jml</label></th>
                                            <th class="text-left"><label>Harga</label></th>
                                            <th class="text-left"><label>Subtotal</label></th>
                                        </tr>
                                        <?php
                                        if (!empty($menu)) {
                                            $no = 1;
                                            $total = 0;
                                            foreach ($menu as $menu_pesanan) {
                                                $total = $total + $menu_pesanan->subtotal;
                                                ?>
                                                <tr>
                                                    <?php if ($pesanan->status_payment == 'paid' AND $pesanan->status_order == 'complete') { ?>
                                                        <td class="text-center"><i class="fa fa-remove danger"></i></td>
                                                    <?php } else { ?>
                                                        <td class="text-center"><a href="<?php echo base_url('pesan/hapus.php?module=pesan&no_nota=' . $_GET['no_nota'] . '&id_produk=' . $menu_pesanan->id_produk) ?>" onclick="return confirm('Hapus ?')"><i class="fa fa-remove danger"></i> </a></td>
                                                    <?php } ?>
                                                    <td class="text-center"><?php echo $no ?></td>
                                                    <td class="text-left"><?php echo $menu_pesanan->produk ?></td>
                                                    <td class="text-center"><?php echo $menu_pesanan->jml ?></td>
                                                    <td class="text-left"><?php echo $this->config->item('mata_uang') ?><?php echo number_format($menu_pesanan->harga, 0, ',', '.') ?></td>
                                                    <td class="text-left"><?php echo $this->config->item('mata_uang') ?><?php echo number_format($menu_pesanan->subtotal, 0, ',', '.') ?></td>
                                                </tr>
                                                <?php
                                                $no++;
                                            }
                                        }
                                        ?>
                                        <?php $tax = general::tax($total); ?>
                                        <?php $tot = general::totalamount($total); ?>
                                        <?php echo form_open('pesan/bayar.php'); ?>
                                        <?php echo form_hidden('id_meja', $_GET['id']); ?>
                                        <?php echo form_hidden('no_meja', $_GET['no_meja']); ?>
                                        <?php echo form_hidden('status', $_GET['status']); ?>
                                        <?php echo form_hidden('no_nota', $_GET['no_nota']); ?>
                                        <?php echo form_hidden('ppn', $tax); ?>
                                        <?php echo form_hidden('gtotal', $tot); ?>
                                        <?php $diskon = general::diskon($pesanan->diskon, $total); ?>
                                        <?php $tot_diskon = general::tot_diskon($pesanan->diskon, $total); ?>
                                        <?php if ($setting->ppn != '0') { ?>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Total</label></td>
                                                <td class="text-left"><label><?php echo $this->config->item('mata_uang') ?><?php echo number_format($total, 0, ',', '.') ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>PPN <?php echo $setting->ppn ?>%</label></td>
                                                <td class="text-left"><label><?php echo $this->config->item('mata_uang') ?><?php echo number_format($tax, 0, ',', '.') ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Grand Total</label></td>
                                                <td class="text-left"><label><?php echo $this->config->item('mata_uang') ?><?php echo number_format($tot, 0, ',', '.') ?></label></td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Total</label></td>
                                                <td class="text-left" colspan="2"><label><?php echo $this->config->item('mata_uang') ?><?php echo number_format($total, 0, ',', '.') ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Diskon <?php echo (!empty($pesanan->diskon) ? $pesanan->diskon . '%' : '') ?></label></td>
                                                <td class="text-left" colspan="2"><label><?php echo $this->config->item('mata_uang') ?><?php echo number_format($diskon, 0, ',', '.') ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Grand Total</label></td>
                                                <td class="text-left" colspan="2"><label><?php echo $this->config->item('mata_uang') ?><?php echo number_format($tot_diskon, 0, ',', '.') ?></label></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="4" class="text-right"><label>Jml Bayar</label></td>
                                            <td class="text-left" colspan="2"><label><?php echo $this->config->item('mata_uang') ?><?php echo number_format($pesanan->tot_bayar, 0, ',', '.') ?></label></td>
                                        </tr>
                                        <?php $kembalian = $pesanan->tot_bayar - $pesanan->jml_gtotal; ?>
                                        <?php $str_kembali = ($kembalian < 0 ? $pesanan->tot_kurang : $kembalian) ?>
                                        <?php $jml_kmbl = str_replace('-', '', $str_kembali) ?>
                                        <?php echo form_hidden('kmbli', $pesanan->tot_kembali) ?>
                                        <?php echo form_hidden('krg', $pesanan->tot_kurang) ?>
                                        <tr>
                                            <td colspan="4" class="text-right"><label><?php echo ($kembalian < 0 ? 'Sisa Kekurangan' : 'Jumlah Kembali') ?></label></td>
                                            <td class="text-left" colspan="2"><label><?php echo $this->config->item('mata_uang') ?><?php echo number_format($jml_kmbl, 0, ',', '.') ?></label></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Metode</b></td>
                                            <?php $met = $met_pemb->metode ?>
                                            <td class="text-left" colspan="2" style="vertical-align: middle;">
                                                <input id="m_kas"  type="radio" name="metode" value="cash" <?php echo (!empty($met) ? ($met == 'cash' ? 'checked="TRUE"' : '') : 'checked="TRUE"') ?>> Kas <?php echo nbs(2) ?>
                                                <input id="m_deb"  type="radio" name="metode" value="debet" <?php echo ($met == 'debet' ? 'checked="TRUE"' : '') ?>> Kartu Debet <?php echo nbs(2) ?>
                                                <input id="m_kred" type="radio" name="metode" value="kredit" <?php echo ($met == 'kredit' ? 'checked="TRUE"' : '') ?>> Kartu Kredit <?php echo nbs(2) ?>
                                                <input id="m_lain" type="radio" name="metode" value="lain" <?php echo ($met == 'lain' ? 'checked="TRUE"' : '') ?>> Lainnya <?php echo nbs(2) ?>
                                            </td>
                                            <td class="text-right">Diskon %</td>
                                            <td class="text-left"><?php echo form_input(array('id' => 'jml_disk', 'name' => 'disc', 'class' => 'form-control text-center', 'style' => 'width: 50px;', 'value' => $pesanan->diskon)) ?></td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"></td>
                                            <td colspan="2" class="text-right"><?php echo form_input(array('id' => 'id_card', 'name' => 'id_card', 'value' => $met_pemb->no_card, 'class' => 'form-control')) ?></td>
                                            <td class="text-right" style="vertical-align: middle;"><label>Jml Bayar</label></td>
                                            <td class="text-left" colspan="2">
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><?php echo $this->config->item('mata_uang') ?> </span>
                                                    <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'cash', 'class' => 'form-control')) ?>
                                                </div>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="" class="text-right"><label>Ket</label></td>
                                            <td class="text-left" colspan="3"><input type="text" name="ket" value="<?php echo $pesanan->ket ?>" class="form-control"></td>
                                            <td class="text-left"><input type="checkbox" name="cetak" value="1" checked="TRUE"> Cetak</td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right"><label>&nbsp;</label></td>
                                            <td class="text-left"><button class="btn btn-primary"><i class="fa fa-print"></i> Bayar Sekarang</button></td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <?php echo form_close(); ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
