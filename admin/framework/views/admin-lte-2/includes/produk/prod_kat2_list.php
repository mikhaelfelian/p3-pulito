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
                            <?php echo form_open('page=produk&act=set_cari_kat', 'autocomplete="off"') ?>
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
                            <?php echo form_open('page=produk&act=prod_kategori2_update', '') ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>

                            <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                <label class="control-label">Nama Kategori</label>
                                <select name="kategori" class="form-control" disabled="TRUE">
                                    <option value="">- Pilih -</option>
                                    <?php
                                    $id_kat1 = general::dekrip($this->input->get('id'));
                                    $sql_kat = $this->db->get('tbl_m_kategori')->result();

                                    foreach ($sql_kat as $kat) {
                                        echo '<option value="' . $kat->id . '" ' . ($kategori->id_kategori == $kat->id ? 'selected' : '') . '>' . $kat->kategori . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['kategori2']) ? 'has-error' : '') ?>">
                                <label class="control-label">Sub Kategori 1</label>
                                <?php echo form_input(array('name' => 'kategori2', 'class' => 'form-control', 'value' => $kategori->kategori)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Harga</label>
                                <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control', 'value' => $kategori->harga)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Jml</label>
                                <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => $kategori->jml)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Keterangan</label>
                                <?php echo form_input(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control', 'value' => $kategori->keterangan)) ?>
                            </div>

                            <button type="submit" class="btn btn-info pull-right">Simpan</button>
                            <?php echo form_close() ?>
                        <?php } else { ?>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Keterangan</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($kategori)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($kategori as $kategori) {
//                                        $kat1 = $this->db->where('id', $kategori->id_kategori)->get('tbl_m_kategori')->row();
//                                        $kat2 = $this->db->where('id', $kategori->id_kategori2)->get('tbl_m_kategori2')->row();
                                            ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $kategori->kategori ?></td>
                                                <td><?php echo general::format_angka($kategori->harga) ?></td>
                                                <td><?php echo $kategori->keterangan ?></td>
                                                <td>
                                                    <?php if(akses::hakAdmin() != TRUE){ ?>
                                                        <?php echo anchor('page=produk&act=prod_kategori2_list&id=' . general::enkrip($kategori->id) . '&route=ubah', '<i class="fa fa-edit"></i> Ubah', 'class="text-primary"') ?>
                                                        <?php echo nbs(3) ?>
                                                        <?php echo anchor('page=produk&act=prod_kategori2_brg_list&id=' . general::enkrip($kategori->id), '<i class="fa fa-plus"></i> Bahan', 'class="text-primary"') ?>
                                                        <?php echo nbs(3) ?>
                                                        <?php echo anchor('page=produk&act=prod_kategori2_hapus&id=' . general::enkrip($kategori->id), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $kategori->kategori . '] ? \')" class="text-danger"') ?>
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
					<?php if (!isset($_GET['id'])) { ?>
                    <?php if (!empty($pagination)) { ?>
                        <div class="box-footer">                        
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php echo $pagination ?>
                            </ul>
                        </div>
                    <?php } ?>
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
<script src="<?php echo base_url('assets/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
    $(function () {
        /* Jquery kanggo format angka */
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

    });
</script>