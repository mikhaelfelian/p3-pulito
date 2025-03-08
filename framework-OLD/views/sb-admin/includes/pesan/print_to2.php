<?php
/*
 * Session untuk ambil data cust dan meja
 * - Variabel $sesi_cust['nama']   => Memuat data nama cust;
 * - Variabel $sesi_cust['status'] => Memuat data status makan ditempan ato bungkus;
 */

$sesi_cust = $this->session->userdata('cust');


/*
 * Generate No. Nota
 */
$IDbaru = general::no_nota('tbl_orderlist', 'no_nota');

/* Selesai */
?>
<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header"><i class="fa fa-print"></i> Cetak Pesanan <?php echo $_GET['nota'] ?></h1>
        </div>
        <div class="col-lg-6 text-right">
            <h1 class="page-header"><?php echo $_GET['no_meja']; ?></h1>
        </div>
    </div>
    <div class="row">
        <!-- /.col-lg-12 -->
        <div class="col-lg-12">
            <a href="<?php echo base_url('pesan/detail.php?id=' . $_GET['id']) ?>"><button class="btn btn-primary"><i class="fa fa-fw fa-arrow-left"></i> Detail Pesanan</button></a><br/><br/>
        </div>

        <?php if (!empty($keranjang)) { ?>
            <?php foreach ($keranjang as $keranjang) { ?>
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">                                
                                <div class="col-xs-9">
                                    <h2 class="panel-title"><i class="fa fa-cutlery"></i> Dapur <?php // echo $keranjang->no_meja    ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <?php
                                $nota_det = crud::bacaDr('tbl_orderlist_det', 'no_nota', $keranjang->no_nota);
                                if (!empty($nota_det)) {
                                    foreach ($nota_det as $nota_det) {
                                        $this->db->where('id', $nota_det->id);
                                        $mode = $this->db->get('tbl_m_produk')->row();
                                        ?>
                                        <tr>
                                            <td><span class="fa fa-check"></span></td>
                                            <td><?php echo $nota_det->menu . ' x ' . $nota_det->jml . nbs(6) ?></td>
                                            <td><?php echo ' x ' . $nota_det->jml . nbs(6) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo nbs() ?></td>
                                            <td colspan="3"><?php echo (!empty($nota_det->keterangan) ? "* " . $nota_det->keterangan : '-'); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                            <?php echo br(1) ?>
                            <a href="<?php echo base_url('pesan/cetak.php?module=print_termal_dapur&id=' . $_GET['id'] . '&nota=' . $_GET['nota'] . '&totalamount=' . $_GET['totalamount']) ?>"><button class="btn btn-primary"><i class="fa fa-print"></i> Cetak ke dapur</button></a> 
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">                                
                                <div class="col-xs-9">
                                    <h2 class="panel-title"><i class="fa fa-check-circle"></i> Checker</h2>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <?php
                                $nota_det = crud::bacaDr('tbl_orderlist_det', 'no_nota', $keranjang->no_nota);
                                if (!empty($nota_det)) {
                                    foreach ($nota_det as $nota_det) {
                                        $this->db->where('id', $nota_det->id);
                                        $mode = $this->db->get('tbl_m_produk')->row();
                                        ?>
                                        <tr>
                                            <td><span class="fa fa-check"></span></td>
                                            <td><?php echo $nota_det->menu . ' x ' . $nota_det->jml . nbs(6) ?></td>
                                            <td><?php echo ' x ' . $nota_det->jml . nbs(6) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo nbs() ?></td>
                                            <td colspan="3"><?php echo (!empty($nota_det->keterangan) ? "* " . $nota_det->keterangan : '-'); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                            <?php echo br(1) ?>
                            <a href="<?php echo base_url('pesan/cetak.php?module=print_termal_checker&id=' . $_GET['id'] . '&nota=' . $_GET['nota'] . '&totalamount=' . $_GET['totalamount']) ?>"><button class="btn btn-primary"><i class="fa fa-print"></i> Cetak checker</button></a> 
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php echo form_open('pesan/set_bill.php') ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">                                
                                <div class="col-xs-9">
                                    <h2 class="panel-title"><i class="fa fa-check-circle"></i> Bill</h2>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <?php
                                $nota_det = crud::bacaDr('tbl_orderlist_det', 'no_nota', $keranjang->no_nota);
                                if (!empty($nota_det)) {
                                    $total = 0;
                                    foreach ($nota_det as $nota_det) {
                                        $jml_tot = $nota_det->harga * $nota_det->jml;
                                        $total   = $total + $jml_tot;
                                        $this->db->where('id', $nota_det->id);
                                        $mode = $this->db->get('tbl_m_produk')->row();
                                        ?>
                                        <tr>
                                            <td><span class="fa fa-check"></span></td>
                                            <td><?php echo $nota_det->menu.nbs(6) ?></td>
                                            <td><?php echo ' x ' . $nota_det->jml . nbs(6) ?></td>
                                            <td><?php echo number_format($jml_tot, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo nbs() ?></td>
                                            <td colspan="4"><?php echo (!empty($nota_det->keterangan) ? "* " . $nota_det->keterangan : '-'); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>								
                                    <tr style="font-weight: bold;">
                                        <td><?php echo nbs() ?></td>
                                        <td colspan="2" class="text-right">Total</td>
                                        <td colspan="2"><?php echo (!empty($total) ? "" . number_format($total, 0, ',', '.') : '-'); ?></td>
                                    </tr>
                                    <tr style="font-weight: bold;">
                                        <td><?php echo nbs() ?></td>
                                        <td colspan="2" class="text-right">Diskon <?php echo $keranjang->diskon ?> %</td>
                                        <td colspan="2"><?php echo (!empty($total) ? "" . number_format(general::diskon($keranjang->diskon,$keranjang->jml_gtotal), 0, ',', '.') : '-'); ?></td>
                                    </tr>
                                    <tr style="font-weight: bold;">
                                        <td><?php echo nbs() ?></td>
                                        <td colspan="2" class="text-right">Grand Total</td>
                                        <td colspan="2"><?php echo (!empty($total) ? "" . number_format(general::tot_diskon($keranjang->diskon,$keranjang->jml_gtotal), 0, ',', '.') : '-'); ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <table class="table table-responsive">
                                <tr style="font-weight: bold;">
                                    <td><?php echo nbs() ?></td>
                                    <td colspan="2" class="text-right">Disc %</td>
                                    <td colspan="2"><?php echo form_input(array('name' => 'disc', 'class' => 'form-control','value'=>0)) ?></td>
                                </tr>
                            </table>
                            <?php echo br(1) ?>
                            <?php echo form_hidden('module','print_termal_bill') ?>
                            <?php echo form_hidden('id',$_GET['id']) ?>
                            <?php echo form_hidden('nota',$_GET['nota']) ?>
                            <?php echo form_hidden('totalamount',$_GET['totalamount']) ?>
                            <button class="btn btn-primary"><i class="fa fa-print"></i> Cetak bill</button>
                            <!--<a href="<?php // echo base_url('pesan/cetak.php?module=print_termal_bill&id=' . $_GET['id'] . '&nota=' . $_GET['nota'] . '&totalamount=' . $_GET['totalamount']) ?>"><button class="btn btn-primary"><i class="fa fa-print"></i> Cetak bill</button></a>--> 
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <!--</div>-->
    <!-- /.row -->
</div>