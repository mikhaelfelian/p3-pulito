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
            <div class="col-lg-4">
                <?php
                switch ($_GET['sub']) {
                    case '1':
                        $sql_kt = $this->db->where('id', general::dekrip($this->input->get('id')))->get('tbl_m_kategori2')->row();
                        ?>
                        <?php echo form_open('page=produk&act='.(isset($_GET['id']) ? 'prod_kategori2_update' : 'prod_kategori2_simpan'), '') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <?php echo form_hidden('id_kat', $this->input->get('id_kat')) ?>
                        <?php echo form_hidden('route', $this->input->get('route')) ?>
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form Kategori</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama Kategori</label>
                                    <select name="kategori" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <?php
                                        $id_kat1 = general::dekrip($this->input->get('id_kat'));
                                        $sql_kat = $this->db->get('tbl_m_kategori')->result();

                                        foreach ($sql_kat as $kat) {
                                            echo '<option value="' . $kat->id . '" ' . ($id_kat1 == $kat->id ? 'selected' : '') . '>' . $kat->kategori . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['kategori2']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Sub Kategori 1</label>
                                    <?php echo form_input(array('name' => 'kategori2', 'class' => 'form-control', 'value'=>$sql_kt->kategori)) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Keterangan</label>
                                    <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control', 'value'=>$sql_kt->keterangan)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Jumlah</label>
                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right', 'value'=>$sql_kt->jml)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['harga']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Harga</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Rp
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'value'=>$sql_kt->harga)) ?>
                                    </div>
                                </div>
                                <!--
                                <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Tipe</label>
                                    <?php // echo br() ?>
                                    <?php // echo form_radio(array('id' => 'tipe', 'name' => 'tipe', 'value'=>'1')).' Karpet' ?>
                                    <?php // echo nbs(2) ?>
                                    <?php // echo form_radio(array('id' => 'tipe', 'name' => 'tipe', 'value'=>'0')).' Non Karpet' ?>
                                </div>
                                -->
                            </div>
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default">Batal</button>
                                <button type="submit" class="btn btn-info pull-right"><?php echo (isset($_GET['id']) ? 'Update' : 'Simpan') ?></button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                        <?php
                        break;

                    case '2':
                        ?>
                        <?php echo form_open('page=produk&act=prod_kategori3_simpan', '') ?>
                        <?php echo form_hidden('id_kat', $this->input->get('id_kat')) ?>
                        <?php echo form_hidden('id_kat2', $this->input->get('id_kat2')) ?>
                        <?php echo form_hidden('route', $this->input->get('route')) ?>
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form Kategori</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama Kategori</label>
                                    <select name="kategori" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <?php
                                        $id_kat1 = general::dekrip($this->input->get('id_kat'));
                                        $sql_kat1 = $this->db->get('tbl_m_kategori')->result();

                                        foreach ($sql_kat1 as $kat1) {
                                            echo '<option value="' . $kat1->id . '" ' . ($id_kat1 == $kat1->id ? 'selected' : '') . '>' . $kat1->kategori . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Sub Kategori 1</label>
                                    <select name="kategori2" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <?php
                                        $sql_kat2 = $this->db->get('tbl_m_kategori2')->result();

                                        foreach ($sql_kat2 as $kat2) {
                                            $id_kat2 = general::dekrip($this->input->get('id_kat2'));
                                            echo '<option value="' . $kat2->id . '" ' . ($id_kat2 == $kat2->id ? 'selected' : '') . '>' . $kat2->kategori . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['kategori2']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Sub Kategori 2</label>
                                    <?php echo form_input(array('name' => 'kategori3', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['harga']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Harga</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Rp
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right')) ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Keterangan</label>
                                    <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control')) ?>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default">Batal</button>
                                <button type="submit" class="btn btn-info pull-right">Simpan</button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                        <?php
                        break;

                    default:
                        ?>
                        <?php echo form_open('page=produk&act=prod_kategori_simpan', '') ?>
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form Kategori</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama Kategori</label>
                                    <?php echo form_input(array('name' => 'kategori', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Keterangan</label>
                                    <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control')) ?>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default">Batal</button>
                                <button type="submit" class="btn btn-info pull-right">Simpan</button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                        <?php
                        break;
                }
                ?>
            </div>
            <div class="col-lg-8">
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
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kategori</th>
                                    <th>Sub Kategori 1</th>
                                    <th class="text-center">Jml</th>
                                    <th>Keterangan</th>
                                    <th colspan="2" class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($kategori)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($kategori as $kategori) {
                                        $kat1 = $this->db->where('id', $kategori->id_kategori)->get('tbl_m_kategori')->row();
//                                        $kat2 = $this->db->where('id', $kategori->id_kategori2)->get('tbl_m_kategori2')->row();
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $kat1->kategori ?></td>
                                            <td><?php echo $kategori->kategori ?></td>
                                            <td class="text-center"><?php echo general::format_angka($kategori->jml) ?></td>
                                            <td><?php echo $kategori->keterangan ?></td>
                                            <td>
                                                <?php if ($kat1->status_temp == '1') { ?>
                                                    <?php echo anchor('page=produk&act=prod_kategori_list&id_kat=' . general::enkrip($kategori->id_kategori) . '&id=' . general::enkrip($kategori->id) . '&sub=1', '<i class="fa fa-edit"></i> Ubah') ?>
                                                    <?php echo nbs(2); ?>
                                                    <?php echo anchor('page=produk&act=set_kategori_perm&id_kat=' . general::enkrip($kategori->id_kategori) . '&id=' . general::enkrip($kategori->id) . '&sub=1', '<i class="fa fa-download"></i> Set Permanent') ?>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php echo anchor('page=produk&act=prod_kategori_hapus&id=' . general::enkrip($kategori->id), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $kategori->kategori . '] ? \')" class="text-danger"') ?>
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