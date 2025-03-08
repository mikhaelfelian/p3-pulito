<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
                <!--<script src="<?php echo base_url('./assets/sb-admin') ?>/ui/jquery-2.1.4.min.js"></script>-->
        <script src="<?php echo base_url('./assets/sb-admin') ?>/ui/jquery.js"></script>
        <script src="<?php echo base_url('./assets/sb-admin') ?>/ui/jquery-ui.js"></script>
        <script src="<?php echo base_url('./assets/sb-admin') ?>/ui/autonumeric.js"></script>
        <link href="<?php echo base_url('./assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">
        <script src="<?php echo base_url('./assets/sb-admin') ?>/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url('./assets/sb-admin') ?>/js/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo base_url('./assets/sb-admin') ?>/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url('./assets/sb-admin') ?>/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
        <!--<link href="<?php echo base_url('./assets/sb-admin') ?>/css/dataTables.bootstrap.css" rel="stylesheet">-->
        <script type="text/javascript">
            var s = $.noConflict();
            s(function () {
                s('#tgl').datepicker({'dateFormat': 'yy-mm-dd'});
                s('#tabel-order').DataTable({
                    responsive: true
                });
            });
        </script>
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
                                <a href="<?php echo base_url('front/'.(isset($_GET['route']) ? $_GET['route'] : 'index.php')) ?>"><button class="btn btn-primary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</button></a><br/><br/>
                            <?php // } ?>
                        </div>
                    </div>
                    <div class="row">        
                        <div class="col-lg-12">
                            <?php echo $this->session->flashdata('transaksi') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">           
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="panel-title"><i class="fa fa-check"></i> Data Transaksi</h2>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="3">User : <?php echo $user->username ?></th>
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
                                                        <td><?php echo general::status_byr($trans->status_payment) ?></td>
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
                        <div class="col-lg-8">            
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
                                                <th colspan="3">Tanggal Nota : <?php echo $this->tanggalan->tgl_indo($pesanan->tgl_simpan) ?></th>
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
                                                <th>Produk</th>
                                                <th>Jml</th>
                                                <th>Harga</th>
                                                <th>Keterangan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <?php // echo form_open('pesan/temp_pesan_menu.php') ?>
                                        <?php echo form_hidden('no_nota', $_GET['no_nota']) ?>
                                        <input type="hidden" id="id_produk" name="id_produk">
                                        <tbody>
                                            <tr>
                                                <td><?php echo form_input(array('id' => 'produk', 'name' => 'produk', 'class' => 'form-control', 'readonly' => 'TRUE')) ?></td>
                                                <td><?php echo form_input(array('id' => 'qty', 'name' => 'qty', 'value' => '', 'class' => 'form-control', 'style' => 'width:40px; text-align:center;', 'readonly' => 'TRUE')) ?></td>
                                                <td><?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control', 'readonly' => 'TRUE')) ?></td>
                                                <td><?php echo form_input(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control', 'readonly' => 'TRUE')) ?></td>
                                                <td><button type="button" class="btn btn-default"><i class="fa fa-plus"></i> Beli</button></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">
                                                    <?php echo form_input(array('id' => 'ket_menu', 'class' => 'form-control', 'readonly' => 'TRUE')) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php // echo form_close() ?>
                                    </table>
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center" style="width: 7px;"><label>No.</label></th>
                                            <th class="text-center"><label>Menu</label></th>
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
                                                    <td class="text-center"><i class="fa fa-remove danger"></i></td>
                                                    <td class="text-center"><?php echo $no ?></td>
                                                    <td class="text-left"><?php echo $menu_pesanan->produk ?></td>
                                                    <td class="text-center"><?php echo $menu_pesanan->jml ?></td>
                                                    <td class="text-left">Rp. <?php echo number_format($menu_pesanan->harga, 0, ',', '.') ?></td>
                                                    <td class="text-left">Rp. <?php echo number_format($menu_pesanan->subtotal, 0, ',', '.') ?></td>
                                                </tr>
                                                <?php
                                                $no++;
                                            }
                                        }
                                        ?>
                                        <?php $tax = general::tax($total); ?>
                                        <?php $tot = general::totalamount($total); ?>
                                        <?php // echo form_open('pesan/set_cetak.php'); ?>
                                        <?php // echo form_hidden('id_meja', $_GET['id']); ?>
                                        <?php // echo form_hidden('no_meja', $_GET['no_meja']); ?>
                                        <?php // echo form_hidden('status', $_GET['status']); ?>
                                        <?php // echo form_hidden('no_nota', $_GET['no_nota']); ?>
                                        <?php // echo form_hidden('ppn', $tax); ?>
                                        <?php // echo form_hidden('gtotal', $tot); ?>
                                        <?php $diskon = general::diskon($pesanan->diskon, $total); ?>
                                        <?php $tot_diskon = general::tot_diskon($pesanan->diskon, $total); ?>
                                        <?php if ($setting->ppn != '0') { ?>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Total</label></td>
                                                <td class="text-left"><label>Rp. <?php echo number_format($total, 0, ',', '.') ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>PPN <?php echo $setting->ppn ?>%</label></td>
                                                <td class="text-left"><label>Rp. <?php echo number_format($tax, 0, ',', '.') ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Grand Total</label></td>
                                                <td class="text-left"><label>Rp. <?php echo number_format($tot, 0, ',', '.') ?></label></td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Total</label></td>
                                                <td class="text-left" colspan="2"><label>Rp. <?php echo number_format($total, 0, ',', '.') ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Diskon <?php echo (!empty($pesanan->diskon) ? $pesanan->diskon . '%' : '') ?></label></td>
                                                <td class="text-left" colspan="2"><label>Rp. <?php echo number_format($diskon, 0, ',', '.') ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Grand Total</label></td>
                                                <td class="text-left" colspan="2"><label>Rp. <?php echo number_format($tot_diskon, 0, ',', '.') ?></label></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="4" class="text-right"><label>Jml Bayar</label></td>
                                            <td class="text-left" colspan="2"><label>Rp. <?php echo number_format($pesanan->tot_bayar, 0, ',', '.') ?></label></td>
                                        </tr>
                                        <?php $kembalian = $pesanan->tot_bayar - $pesanan->jml_gtotal; ?>
                                        <?php $str_kembali = ($kembalian < 0 ? $pesanan->tot_kurang : $kembalian) ?>
                                        <?php $jml_kmbl = str_replace('-', '', $str_kembali) ?>
                                        <?php echo form_hidden('kmbli', $pesanan->tot_kembali) ?>
                                        <?php echo form_hidden('krg', $pesanan->tot_kurang) ?>
                                        <tr>
                                            <td colspan="4" class="text-right"><label><?php echo ($kembalian < 0 ? 'Sisa Kekurangan' : 'Jumlah Kembali') ?></label></td>
                                            <td class="text-left" colspan="2"><label>Rp. <?php echo number_format($jml_kmbl, 0, ',', '.') ?></label></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Metode</b></td>
                                            <?php $met = $met_pemb->metode ?>
                                            <td class="text-left" colspan="2" style="vertical-align: middle;">
                                                <input id="m_kas"  type="radio" name="metode" readonly="TRUE" value="cash" <?php echo (!empty($met) ? ($met == 'cash' ? 'checked="TRUE"' : '') : 'checked="TRUE"') ?>> Kas <?php echo nbs(2) ?>
                                                <input id="m_deb"  type="radio" name="metode" readonly="TRUE" value="debet" <?php echo ($met == 'debet' ? 'checked="TRUE"' : '') ?>> Kartu Debet <?php echo nbs(2) ?>
                                                <input id="m_kred" type="radio" name="metode" readonly="TRUE" value="kredit" <?php echo ($met == 'kredit' ? 'checked="TRUE"' : '') ?>> Kartu Kredit <?php echo nbs(2) ?>
                                                <input id="m_lain" type="radio" name="metode" readonly="TRUE" value="lain" <?php echo ($met == 'lain' ? 'checked="TRUE"' : '') ?>> Lainnya <?php echo nbs(2) ?>
                                            </td>
                                            <td class="text-right">Diskon %</td>
                                            <td class="text-left"><?php echo form_input(array('id' => 'jml_disk', 'name' => 'disc', 'class' => 'form-control text-center', 'style' => 'width: 50px;', 'readonly'=>'TRUE', 'value' => $pesanan->diskon)) ?></td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"></td>
                                            <td colspan="2" class="text-right"><?php echo form_input(array('id' => 'id_card', 'name' => 'id_card', 'readonly'=>'TRUE', 'value' => $met_pemb->no_card, 'class' => 'form-control')) ?></td>
                                            <td class="text-right"><label>Jml Bayar</label></td>
                                            <td class="text-left" colspan="2"><?php echo form_input(array('id' => 'jml_bayar', 'name' => 'cash', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => general::format_angka($pesanan->jml_bayar))) ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="" class="text-right"><label>Ket</label></td>
                                            <td class="text-left" colspan="3"><input type="text" name="ket" readonly="TRUE" value="<?php echo $pesanan->ket ?>" class="form-control"></td>
                                            <td class="text-left"><input type="checkbox" name="cetak" value="1" checked="TRUE"> Cetak</td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right"><label>&nbsp;</label></td>
                                            <td class="text-left"><button class="btn btn-primary" onclick="window.location.href='<?php echo base_url('pesan/cetak_nota.php?no_nota='.$this->input->get('no_nota').'&from=detail&route='.$this->input->get('route')) ?>'"><i class="fa fa-print"></i> Cetak Ulang Nota</button></td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <?php // echo form_close(); ?>
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
