<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Detail</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=laporan&act=' . $this->input->get('route') . '&case=' . $this->input->get('case') . '&query=' . $this->input->get('query') . '&tgl_awal=' . $this->input->get('tgl_awal') . '&tgl_akhir=' . $this->input->get('tgl_akhir') . '') ?>">Laporan</a></li>
            <li class="active">Cetak</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cetak</h3>
                    </div>
                    <div class="box-body">
                            <?php
                            switch ($_GET['case']) {
                                case 'semua':
                                    
                                    break;

                                case 'cabang':
                                    $button = anchor('page=laporan&act=pdf_packing&case=cabang&cabang='.$this->input->get('cabang').'&tgl_awal='.$this->input->get('tgl_awal').'&tgl_akhir='.$this->input->get('tgl_akhir').'&tipe='.$this->input->get('tipe').'&type=D','<i class="fa fa-download"></i> Unduh'). nbs(2).
                                              anchor('page=laporan&act=pdf_packing&case=cabang&cabang='.$this->input->get('cabang').'&tgl_awal='.$this->input->get('tgl_awal').'&tgl_akhir='.$this->input->get('tgl_akhir').'&tipe='.$this->input->get('tipe'),'<i class="fa fa-external-link-square"></i> Fullscreen','target="_blank"').br(2);
                                    $uri    = site_url('page=laporan&act=pdf_packing&case=cabang&cabang='.$this->input->get('cabang').'&tgl_awal='.$this->input->get('tgl_awal').'&tgl_akhir='.$this->input->get('tgl_akhir').'&tipe='.$this->input->get('tipe'));
                                    break;

                                case 'per_tanggal':
                                    $button = anchor('page=laporan&act=penjualan_pdf&case=per_tanggal&query='.$this->input->get('query').'&cabang='.$this->input->get('cabang').'&tipe='.$this->input->get('tipe'),'<button class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Cetak</button>');
                                    break;

                                case 'per_rentang':
                                    $button = anchor('page=laporan&act=penjualan_pdf&case=per_rentang&tgl_awal='.$this->input->get('tgl_awal').'&tgl_akhir='.$this->input->get('tgl_akhir').'&cabang='.$this->input->get('cabang').'&tipe='.$this->input->get('tipe'),'<button class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Cetak</button>');
                                    break;

                                case 'per_sales':
                                    $button = anchor('page=laporan&act=penjualan_pdf&case=per_sales&sales='.$this->input->get('sales').'&tgl_awal='.$this->input->get('tgl_awal').'&tgl_akhir='.$this->input->get('tgl_akhir').'&cabang='.$this->input->get('cabang').'&tipe='.$this->input->get('tipe'),'<button class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Cetak</button>');
                                    break;

                                default:
                                    $button = '';
                                    break;
                            }
                            
                            echo $button;
                            ?>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="<?php echo $uri ?>">
                            </iframe>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo site_url('page=laporan&act=data_packing') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                            </div>
                        </div>
                    </div>
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
                                        //Initialize Select2 Elements
                                        $(".select2").select2();
                                        //Date picker
                                        $('#tgl').datepicker({
                                            autoclose: true,
                                        });

                                        $("#hrg_beli").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#hrg_jual").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#hrg_grosir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#ins").autoNumeric({aSep: '.', aDec: ',', aPad: false});

                                        $("#jml").keydown(function (e) {
                                            // Allow: backspace, delete, tab, escape, enter and .
                                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                    // Allow: Ctrl+A, Command+A
                                                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                            // Allow: home, end, left, right, down, up
                                                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                        // let it happen, don't do anything
                                                        return;
                                                    }
                                                    // Ensure that it is a number and stop the keypress
                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                        e.preventDefault();
                                                    }
                                                });

                                        $("#berat").keydown(function (e) {
                                            // Allow: backspace, delete, tab, escape, enter and .
                                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                    // Allow: Ctrl+A, Command+A
                                                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                            // Allow: home, end, left, right, down, up
                                                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                        // let it happen, don't do anything
                                                        return;
                                                    }
                                                    // Ensure that it is a number and stop the keypress
                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                        e.preventDefault();
                                                    }
                                                });
                                    });

</script>