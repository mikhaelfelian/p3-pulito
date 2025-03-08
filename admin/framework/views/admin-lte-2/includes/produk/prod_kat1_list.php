<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Kategori <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Kategori</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-9">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Kategori</h3>
                        <div class="box-tools">
                            <?php echo form_open('page=produk&act=set_cari_kat') ?>
                            <?php echo form_hidden('route', $_GET['act']) ?>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="pencarian" class="form-control pull-right" placeholder="Pencarian">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <?php if (isset($_GET['id'])) { ?>
                            <?php echo form_open('page=produk&act=prod_kategori_update', '') ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>

                            <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                <div class="form-group <?php echo (!empty($hasError['kategori2']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Kategori</label>
                                    <?php echo form_input(array('name' => 'kategori', 'class' => 'form-control', 'value' => $kat_edit->kategori)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Kategori</label>
                                    <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control', 'value' => $kat_edit->keterangan)) ?>
                                </div>

                                <button type="submit" class="btn btn-info pull-right">Simpan</button>
                                <?php echo form_close() ?>
                            <?php } else { ?>
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kategori</th>
                                            <th>Keterangan</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($kategori)) {
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($kategori as $kategori) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $kategori->kategori ?></td>
                                                    <td>
                                                        <?php if(akses::hakAdmin() != TRUE){ ?>
                                                            <?php echo anchor('page=produk&act=prod_kategori_list&id_kat=' . general::enkrip($kategori->id) . '&sub=1&route=prod_kategori1_list/' . general::enkrip($kategori->id) . '/1', '<i class="fa fa-plus"></i> Tambah', 'class="text-primary"') ?>
                                                            <?php echo nbs(3) ?>
                                                            <?php echo anchor('page=produk&act=prod_kategori1_list&id=' . general::enkrip($kategori->id), '<i class="fa fa-edit"></i> Ubah', ' class=""') ?>
                                                            <?php echo nbs(2) ?>
                                                            <?php echo anchor('page=produk&act=prod_kategori1_hapus&id=' . general::enkrip($kategori->id), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $kategori->kategori . '] ? \')" class="text-danger"') ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php } ?>
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