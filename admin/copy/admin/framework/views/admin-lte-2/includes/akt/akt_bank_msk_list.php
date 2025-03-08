<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Bank Masuk <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Bank Masuk</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Bank Masuk</h3>
                        <div class="box-tools">
                            <?php echo form_open('page=akuntability&act=set_cari_bank_msk') ?>
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
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tgl</th>
                                    <th>Sales</th>
                                    <th>No. Invoice</th>
                                    <th class="text-right">Nominal</th>
                                    <th class="text-left">Approved By</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($bank_msk)) {
                                    
                                    $no     = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    $gtotal = 0;
                                    foreach ($bank_msk as $bank_msk) {
                                        $tgl    = explode('-', $bank_msk->tgl);
                                        $gtotal = $gtotal + $bank_msk->jml_gtotal;
                                        $sales  = $this->ion_auth->user($bank_msk->id_user)->row();
                                        $gudang = $this->ion_auth->user($bank_msk->id_gudang)->row();
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <td><?php echo $sales->first_name ?></td>
                                            <td><?php echo '#' . $bank_msk->no_nota ?></td>
                                            <td class="text-right"><?php echo general::format_angka($bank_msk->jml_gtotal) ?></td>
                                            <td class="text-left"><?php echo $gudang->first_name.' '.$gudang->last_name ?></td>
                                            <td><?php // echo anchor('page=akuntability&act=akt_peng_hapus&id=' . general::enkrip($bank_msk->id), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $bank_msk->keterangan . '] ? \')" class="text-danger"')    ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td><?php // echo $no++ ?></td>
                                        <td><?php // echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                        <td><?php // echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                        <td class="text-right text-bold">Total</td>
                                        <td class="text-right text-bold"><?php echo general::format_angka($gtotal) ?></td>
                                        <td><?php // echo anchor('page=akuntability&act=akt_peng_hapus&id=' . general::enkrip($bank_msk->id), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $bank_msk->keterangan . '] ? \')" class="text-danger"')    ?></td>
                                    </tr>
                                <?php } ?>
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