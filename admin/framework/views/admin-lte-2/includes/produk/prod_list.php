<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Produk <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Produk</li>
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
                        <?php echo nbs(3) ?>
                        <?php if (akses::hakAdmin() != TRUE) { ?>
                            <button class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_barang_tambah') ?>'"><i class="fa fa-plus"></i> Tambah</button>
                        <?php } ?>

                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Barang</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <?php echo form_open('page=produk&act=set_cari_prod') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <?php echo form_hidden('route', $this->input->get('act')) ?>
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td><?php echo form_input(array('name' => 'kode', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('name' => 'produk', 'class' => 'form-control')) ?></td>
                                    <td><button class="btn btn-primary">Cari</button></td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($produk)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($produk as $produk) {
//                                        $trans = $this->db->select('SUM(jml) as jml')->where('id_produk', $produk->id)->where('tbl_trans_jual.status_nota', '1')->join('tbl_trans_jual', 'tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')->get('tbl_trans_jual_det')->row();
//                                        $tot_jml = $this->db->select('SUM(stok) as jml')->where('id_produk', $produk->id)->get('tbl_m_produk_stok')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $produk->kode ?></td>
                                            <td><?php echo $produk->produk ?></td>
                                            <td>
                                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                    <?php echo anchor('page=produk&act=prod_barang_tambah&id=' . general::enkrip($produk->id), '<i class="fa fa-edit"></i>', 'class="text-default"') ?>
                                                    <?php echo nbs(2) ?>
                                                    <?php echo anchor('page=produk&act=prod_barang_hapus&id=' . general::enkrip($produk->id), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus [' . $produk->produk . '] ? \')" class="text-danger"') ?>
                                                <?php } ?>
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