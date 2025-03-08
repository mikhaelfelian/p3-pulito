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
            <h1 class="page-header"><i class="fa fa-users"></i> Set Nama Customer</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table" style="border-top: 0px;">
                <?php if (!empty($sesi_cust['nama'])) { ?>
                    <?php echo form_open('pesan/proses.php') ?>
                    <?php echo form_hidden('id', $_GET['id']) ?>
                    <?php echo form_hidden('no_meja', $_GET['no_meja']) ?>
                    <?php echo form_hidden('total', $this->cart->total()) ?>
                    <tr>
                        <td style="width: 36px;"><a href="<?php echo base_url('pesan/meja.php?id=' . $_GET['id'] . '&no_meja=' . $_GET['no_meja']) ?>"><button class="btn btn-primary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</button></a></td>
                        <td class="text-right">
                            <a href="<?php echo base_url('pesan/checkout.php?id=' . $_GET['id'] . '&no_meja=' . $_GET['no_meja']) ?>"><button class="btn btn-primary">Lanjut <i class="fa fa-fw fa-arrow-right"></i></button></a><br/><br/>
                        </td>
                    </tr>
                    <?php echo form_close() ?>
                <?php } else { ?>
                    <tr>
                        <td style="width: 36px;"><a href="<?php echo base_url('pesan/meja.php?id=' . $_GET['id'] . '&no_meja=' . $_GET['no_meja']) ?>"><button class="btn btn-primary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</button></a></td>
                        <td class="text-right">
                            <a href="javascript:;" onclick="alert('Setel nama pelanggan dahulu !!')"><button class="btn btn-default">Lanjut <i class="fa fa-fw fa-arrow-right"></i></button></a><br/><br/>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">                                
                        <div class="col-xs-9">
                            <h2 class="panel-title"><i class="fa fa-shopping-cart"></i> Data Pesanan</h2>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo form_open('pesan/set_cust.php') ?>
                    <?php echo form_hidden('id', $_GET['id']) ?>
                    <?php echo form_hidden('no_meja', $_GET['no_meja']) ?>
                    <?php // echo form_hidden('total', $total_harga) ?>
                    <table class="table table-striped" style="border: 0px solid;">
                        <tr>
                            <td>Nama Cust</td>
                            <td><?php echo form_input(array('name' => 'nama', 'placeholder' => '[Umum]', 'class' => 'form-control')) ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <select name="status" class="form-control">
                                    <option value="1">Makan ditempat</option>
                                    <option value="2">Bungkus</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <td><button class="btn btn-primary">Setel Pelanggan <i class="fa fa-arrow-right"></i></button></td>
                        </tr>
                    </table>
                    <?php echo form_open() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--</div>-->
<!-- /.row -->
</div>