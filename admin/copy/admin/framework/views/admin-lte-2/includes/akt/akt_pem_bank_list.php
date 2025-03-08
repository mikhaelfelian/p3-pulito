<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pemasukan Bank<small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pemasukan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Pemasukan</h3>
                        <div class="box-tools">
                            <?php echo form_open('page=akuntability&act=set_cari_pem_bank') ?>
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
                                    <th class="text-center">No.</th>
                                    <th class="text-left">Tgl</th>
                                    <th class="text-left">Keterangan</th>
                                    <th class="text-right">Nominal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($pemasukan)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    $total = 0;
                                    foreach ($pemasukan as $pemasukan) {
                                        $tgl = explode('-', $pemasukan->tgl);
                                        $total = $total + $pemasukan->nominal;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td class="text-left"><?php echo $tgl[1].'/'.$tgl[2].'/'.$tgl[0] ?></td>
                                            <td class="text-left"><?php echo $pemasukan->keterangan ?></td>
                                            <td class="text-right"><?php echo general::format_angka($pemasukan->nominal) ?></td>
                                            <td><?php // echo anchor('page=akuntability&act=akt_pem_hapus&id=' . general::enkrip($pemasukan->id), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $pemasukan->keterangan . '] ? \')" class="text-danger"') ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                        <tr>
                                            <td class="text-right text-bold" colspan="3">Total</td>
                                            <td class="text-right text-bold" colspan=""><?php echo general::format_angka($total) ?></td>
                                            <td class="text-right text-bold" colspan=""></td>
                                        </tr>
                                    <?php
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

<!--Datepicker-->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
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
    
    $("#nominal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
});

</script>