<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-remove"></i> Tutup Toko</h1>
        </div>        
        <!-- /.col-lg-2 -->
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">DATA PENJUALAN HARI INI</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Tanggal</th>
                            <th>:</th>
                            <td><?php echo $this->tanggalan->tgl_indo(date('Y-m-d')) ?></td>
                        </tr>
                        <tr>
                            <th>Nama Kasir</th>
                            <th>:</th>
                            <td><?php echo $profile->first_name ?></td>
                        </tr>
                        <tr>
                            <th>Total Penjualan per Kasir Hari Ini</th>
                            <th>:</th>
                            <td>Rp. <?php echo general::format_number($tot_hr_ini->total) ?></td>
                        </tr>
                        <tr>
                            <th>Total Semua Penjualan Hari Ini</th>
                            <th>:</th>
                            <td>Rp. <?php echo general::format_number($gtot_hr_ini->total) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">CETAK LAPORAN</h3>
                </div>
                <div class="panel-body">
                    <button type="button" onclick="window.location.href='<?php echo base_url('laporan/print.php') ?>'" class="btn btn-danger"><i class="fa fa-print"></i> CETAK DAN KELUAR</button>
                    <br/>
                    <br/>
                    <iframe src="<?php echo base_url('laporan/lap_'.date('Y-m-d').'.pdf') ?>"  style="width: 760px; height: 1024px;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->
    <!-- /.row -->
</div>
