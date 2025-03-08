<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Laba / Rugi</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">L / R</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open('page=laporan&act=set_lap_lr', '') ?>
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
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>

        <?php if (!empty($penjualan)) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Laba / Rugi</h3>
                        </div>
                        <div class="box-body">
                            <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo site_url('page=laporan&act=lr_pdf&route=' . $this->input->get('act') . '&case=' . $this->input->get('case') . '&query=' . $this->input->get('query') . '&tgl_awal=' . $this->input->get('tgl_awal') . '&tgl_akhir=' . $this->input->get('tgl_akhir') . '&status=' . $this->input->get('status')) ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>
                            <?php echo br(2) ?>
                            <div class="row">
                                <div class="col-lg-8">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Penjualan</th>
                                            <th>:</th>
                                            <th class="text-right"><?php // echo general::format_angka($penjualan->jml_gtotal)   ?></th>
                                            <th class="text-right"><?php echo general::format_angka($penjualan->jml_gtotal) ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4"></th>
                                        </tr>
                                        <tr>
                                            <th>HPP Penjualan</th>
                                            <th>:</th>
                                            <th class="text-right"><?php echo general::format_angka($hpp->harga_beli) ?></th>
                                            <th class="text-right"><?php // echo general::format_angka($hpp->harga_beli)   ?></th>
                                        </tr>
                                        <tr>
                                            <th>Operasional Kas</th>
                                            <th>:</th>
                                            <th class="text-right"><?php echo general::format_angka($op_kas->nominal) ?></th>
                                            <th class="text-right"><?php // echo general::format_angka($op_kas->nominal)   ?></th>
                                        </tr>
                                        <?php foreach ($op_kas_det as $op_kas_det) { ?>
                                            <tr>
                                                <td><?php echo nbs(2).' - '.$op_kas_det->keterangan ?></td>
                                                <td>:</td>
                                                <td class="text-right"><?php echo general::format_angka($op_kas_det->nominal) ?></td>
                                                <td class="text-right"><?php // echo general::format_angka($op_kas->nominal)   ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th>Operasional Bank</th>
                                            <th>:</th>
                                            <th class="text-right"><?php echo general::format_angka($op_bank->nominal) ?></th>
                                            <th class="text-right"><?php // echo general::format_angka($op_bank->nominal)   ?></th>
                                        </tr>
                                        <?php foreach ($op_bank_det as $op_bank_det) { ?>
                                            <tr>
                                                <td><?php echo nbs(2).' - '.$op_bank_det->keterangan ?></td>
                                                <td>:</td>
                                                <td class="text-right"><?php echo general::format_angka($op_bank_det->nominal) ?></td>
                                                <td class="text-right"><?php // echo general::format_angka($op_kas->nominal)   ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th class="text-right text-bold">Total</th>
                                            <th class="text-bold">:</th>
                                            <th class="text-right text-bold"></th>
                                            <th class="text-right">(<?php echo general::format_angka($hpp->harga_beli + $op_bank->nominal + $op_kas->nominal) ?>)</th>
                                        </tr>
                                        <?php $laba_rugi = ($lr < 0 ? '(' . general::format_angka(str_replace('-', '', $lr)) . ')' : general::format_angka($lr)) ?></td>
                                        <tr>
                                            <th class="text-right">L / R</th>
                                            <th>:</th>
                                            <td class="text-right text-bold" colspan="2"><?php echo $laba_rugi ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
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