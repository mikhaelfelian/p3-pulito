<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Pemasukan</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Pemasukan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open('page=laporan&act=set_lap_pemasukan', '') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Semua</label>
                            <br/>
                            <input type="checkbox" name="semua" value="1"> Semua
                        </div>
                        <div class="form-group">
                            <label class="control-label">Per Hari</label>
                            <br/>
                            <input type="checkbox" name="hari_ini" value="<?php echo date('m/d/Y') ?>"> Hari Ini
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Tgl</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value' => '')) ?>
                                    </div>
                                </div>                            
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Rentang</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control pull-right', 'value' => '')) ?>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Jenis</label>
                            <div class="input-group date">
                                <?php echo form_radio(array('id' => '', 'name' => 'jenis', 'value' => 'semua', 'checked' => 'TRUE')) ?> Semua
                                <?php echo nbs(4) ?>
                                <?php echo form_radio(array('id' => '', 'name' => 'jenis', 'value' => 'kas')) ?> Kas
                                <?php echo nbs(4) ?>
                                <?php echo form_radio(array('id' => '', 'name' => 'jenis', 'value' => 'bank')) ?> Bank
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>

        <?php if (!empty($pemasukan)) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Pemasukan</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo site_url('page=laporan&act=pemasukan_pdf&route=' . $this->input->get('act') . '&case=' . $this->input->get('case') . '&query=' . $this->input->get('query') . '&tgl_awal=' . $this->input->get('tgl_awal') . '&tgl_akhir=' . $this->input->get('tgl_akhir') . '&status=' . $this->input->get('status')) ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>
                            <?php echo br(2) ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tgl</th>
                                        <th>Keterangan</th>
                                        <!--<th>Jenis</th>-->
                                        <th class="text-right">Pemasukan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php $tot = 0; ?>
                                    <?php foreach ($pemasukan as $pemasukan) { ?>
                                        <?php $tgl = explode('-', $pemasukan->tgl_simpan) ?>
                                        <?php $tot = $tot + $pemasukan->nominal ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?></td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <td><?php echo ucfirst($pemasukan->keterangan) ?></td>
                                            <td class="text-right"><?php echo general::format_angka($pemasukan->nominal) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="text-right text-bold" colspan="3">Total Pemasukan</td>
                                        <td class="text-right text-bold"><?php echo general::format_angka($tot) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>

<!--Datepicker-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.min.css') ?>">


<script src="<?php echo base_url('assets/admin-lte-2/plugins') ?>/JAutoNumber/autonumeric.js"></script>
<!-- Page script -->
<script>
                            $(function () {
                                //Date picker
                                $('#tgl').datepicker({
                                    autoclose: true,
                                });
                                $('#tgl_rentang').daterangepicker();
                            });

</script>