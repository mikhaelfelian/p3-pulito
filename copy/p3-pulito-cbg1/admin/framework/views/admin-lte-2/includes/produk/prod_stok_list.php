<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Produk <small>Menurut penjahit</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Stok</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Penjahit</th>
                                    <th>Kode</th>
                                    <th>Jenis</th>
                                    <th>Qty</th>
                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                        <th>HPP</th>
                                    <?php } ?>
                                    <th>Harga Jual</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <?php echo form_open('page=produk&act=set_cari_prod_stok') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td><?php echo form_input(array('name' => 'pj', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('name' => 'kode', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('name' => 'produk', 'class' => 'form-control')) ?></td>
                                    <td><?php // echo form_input(array('name' => 'qty', 'class' => 'form-control')) ?></td>
                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                        <td><?php echo form_input(array('name' => 'hb', 'class' => 'form-control')) ?></td>
                                    <?php } ?>
                                    <td><?php echo form_input(array('name' => 'hj', 'class' => 'form-control')) ?></td>
                                    <td><button class="btn btn-primary btn-flat">Cari</button></td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($produk)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($produk as $produk) {
                                        
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo ucwords($produk->penjahit) ?></td>
                                            <td><?php echo anchor('page=produk&act=prod_det&id=' . general::enkrip($produk->id).'&route='.$this->input->get('act'), $produk->kode) ?></td>
                                            <td><?php echo $produk->produk ?></td>
                                            <td style="width: 70px; text-align: center;"><?php echo $produk->stok; ?></td>
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                <td><?php echo general::format_angka($produk->harga_beli) ?></td>
                                            <?php } ?>
                                            <td><?php echo general::format_angka($produk->harga_jual) ?></td>
                                            <td>
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