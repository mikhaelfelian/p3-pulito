
<!-- Tabel User - DATA TABLE Jquery -->
<script src="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-2.1.4.min.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<!--<link href="<?php echo base_url('assets/sb-admin') ?>/css/dataTables.bootstrap.css" rel="stylesheet">-->

<!-- Script Utama -->
<script type="text/javascript">
    var s = $.noConflict();
    s(function () {
        s('#tabel-pelanggan').DataTable({
            responsive: true
        });
    });
</script>
<!--JQuery UI-->

<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header"><i class="fa fa-list-alt"></i> Form Pesanan</h1>
        </div>
        <div class="col-lg-6 text-right">
            <h1 class="page-header"><?php echo $_GET['no_meja']; ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <?php // $stat_meja = substr($_GET['no_meja'], 0, -2) ?>
                <tr>
                    <td style="width: 36px; border-top: 0px;"><a href="<?php echo base_url('pesan/form.php?id='.$_GET['id'].'&no_meja='.$_GET['no_meja'].'&status='.$_GET['status'].'&no_nota='.$_GET['no_nota']) ?>"><button class="btn btn-primary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</button></a></td>
                    <td class="text-right" style="border-top: 0px;">
                        <?php if (!empty($cust_sesi)) { ?>
                            <!--<a href="<?php echo base_url('pesan/menu.php?id=' . $_GET['id'] . '&no_meja=' . $_GET['no_meja']) ?>"><button class="btn btn-primary">Lanjut <i class="fa fa-fw fa-arrow-right"></i></button></a><br/><br/>-->
                        <?php } else { ?>
                            <!--<a href="javascript:;" onclick="alert('Silahkan mengisi data customer dahulu !!')"><button class="btn btn-default">Lanjut <i class="fa fa-fw fa-arrow-right"></i></button></a><br/><br/>-->
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title"><i class="fa fa-folder"></i> Form Data Pelanggan</h2>
                </div>
                <div class="panel-body">
                    <?php $has_error = $this->session->flashdata('form_error') ?>
                    <?php echo form_open('pesan/form_pel_simpan.php') ?>
                    <?php echo form_hidden('id_pesanan', $_GET['id']) ?>
                    <?php echo form_hidden('no_meja', $_GET['no_meja']) ?>
                    <?php echo form_hidden('status', $_GET['status']) ?>
                    <?php echo form_hidden('no_nota', $_GET['no_nota']) ?>
                    <?php echo form_hidden('status_plgn', 'pelanggan') ?>
                    <div class="form-group <?php echo (empty($has_error['kode']) ? '' : 'has-error') ?>">
                        <label class="control-label" for="<?php echo (empty($has_error['kode']) ? '' : 'InputError') ?>">Kode</label>
                        <?php echo $has_error['kode'] ?>
                        <?php echo form_input(array('name' => 'kode', 'class' => 'form-control', 'readonly' => TRUE, 'value' => $no_plgn)) ?>
                    </div>

                    <div class="form-group <?php echo (empty($has_error['nama']) ? '' : 'has-error') ?>">
                        <label class="control-label" for="<?php echo (empty($has_error['nama']) ? '' : 'InputError') ?>">Nama Pelanggan</label>
                        <?php echo $has_error['nama'] ?>
                        <?php echo form_input(array('name' => 'nama', 'class' => 'form-control', 'value' => $this->session->flashdata('nama'))) ?>
                    </div>

                    <div class="form-group <?php echo (empty($has_error['no_hp']) ? '' : 'has-error') ?>">
                        <label class="control-label" for="<?php echo (empty($has_error['no_hp']) ? '' : 'InputError') ?>">No. HP</label>
                        <?php echo $has_error['no_hp'] ?>
                        <?php echo form_input(array('name' => 'no_hp', 'class' => 'form-control', 'value' => $this->session->flashdata('no_hp'))) ?>
                    </div>

                    <div class="form-group <?php echo (empty($has_error['alamat']) ? '' : 'has-error') ?>">
                        <label class="control-label" for="<?php echo (empty($has_error['alamat']) ? '' : 'InputError') ?>">Alamat</label>
                        <?php echo $has_error['alamat'] ?>
                        <?php echo form_textarea(array('name' => 'alamat', 'class' => 'form-control', 'value' => $this->session->flashdata('alamat'))) ?>
                    </div>

                    <?php echo form_reset(array('value' => 'Batal', 'class' => 'btn btn-success')) ?>
                    <?php echo form_submit(array('value' => 'Simpan', 'class' => 'btn btn-success')) ?>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title"><i class="fa fa-users"></i> Data Pelanggan</h2>
                </div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="tabel-pelanggan">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pelanggan)) { ?>
                                    <?php foreach ($pelanggan as $pelanggan) { ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $pelanggan->kode ?></td>
                                            <td><?php echo $pelanggan->nama ?></td>
                                            <td><?php echo $pelanggan->no_hp ?></td>
                                            <td><?php echo $pelanggan->alamat ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->
    <!-- /.row -->
</div>