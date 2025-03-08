<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Pelanggan <small>Detail</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pelanggan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-5">
                <?php echo form_hidden('id', general::enkrip($member->id)) ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Pelanggan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                            <label class="control-label">NIK</label>
                            <?php echo form_input(array('name' => 'nik', 'class' => 'form-control', 'value' => $member->nik, 'readonly'=>'TRUE')) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nama</label>
                            <?php echo form_input(array('name' => 'nama', 'class' => 'form-control', 'value' => $member->nama, 'readonly'=>'TRUE')) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                            <label class="control-label">No. HP</label>
                            <?php echo form_input(array('name' => 'no_hp', 'class' => 'form-control', 'value' => $member->no_hp, 'readonly'=>'TRUE')) ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Alamat</label>
                            <?php echo form_textarea(array('name' => 'alamat', 'class' => 'form-control', 'value' => $member->alamat, 'readonly'=>'TRUE')) ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tipe Member</label>
                            <?php
                            echo br();
                            foreach ($member_tipe->result() as $tipe) {
                                if ($tipe->id == $member->id_grup) {
                                    echo form_radio(array('name' => 'tipe_member', 'value' => $tipe->id, 'checked' => 'TRUE', 'disabled'=>'TRUE')) . ' ' . $tipe->grup . nbs(3);
                                } else {
                                    echo form_radio(array('name' => 'tipe_member', 'value' => $tipe->id, 'disabled'=>'TRUE')) . ' ' . $tipe->grup . nbs(3);
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6 text-left">                                
                                <button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_pelanggan_list') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
                            </div>
                            <div class="col-lg-6 text-right">                                
                                <!--<button type="reset" class="btn btn-default btn-flat">Batal</button>-->
                                <!--<button type="submit" class="btn btn-info btn-flat">Simpan</button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($_GET['case'] == 'deposit') { ?>
                <div class="col-lg-7">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Deposit</h3>
                        </div>
                        <div class="box-body">
                            <div class="well well-sm">
                                <?php echo form_open('page=produk&act=prod_deposit_simpan', 'class="form-inline"') ?>
                                <?php echo form_hidden('id', $this->input->get('id')) ?>

                                <div class="form-group">
                                    <label class="sr-only" for="amount">Jumlah Deposit</label>
                                    <?php echo form_input(array('id' => 'jml_deposit', 'name' => 'jml_deposit', 'class' => 'form-control', 'placeholder' => 'Masukkan jml deposit ...')) ?>
                                </div>
                                <button class="btn btn-primary" type="submit" name="submit" value="deposit">Deposit</button>
                                <?php echo form_close() ?>
                            </div>
                            <hr/>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Tanggal</th>
                                        <th class="text-left">Keterangan</th>
                                        <th class="text-right">Debet</th>
                                        <th class="text-right">Kredit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($member_hist as $hist) { ?>
                                        <?php $tgl = explode('-', $hist->tgl_simpan); ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <td class="text-left"><?php echo $hist->keterangan ?></td>
                                            <td class="text-right"><?php echo general::format_angka($hist->debet) ?></td>
                                            <td class="text-right"><?php echo general::format_angka($hist->kredit) ?></td>
                                            <td class="text-right"><?php echo general::format_angka($hist->jml_deposit) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
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


<script src="<?php echo base_url('../assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('../assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('../assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('../assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('../assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('../assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('../assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
    $(function () {
//      Jquery kanggo format angka
//        $("#gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#jml_deposit").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        $("#jml").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // kibot: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // kibot: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // Biarin wae, ga ngapa2in return false
                        return;
                    }
                    // Cuman nomor
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
    });
</script>