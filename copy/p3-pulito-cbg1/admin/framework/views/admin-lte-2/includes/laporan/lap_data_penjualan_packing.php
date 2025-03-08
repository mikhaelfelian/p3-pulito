<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Transaksi</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Transaksi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open('page=laporan&act=set_lap_packing', '') ?>
                <?php echo form_hidden('route', 'data_packing') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Cabang</label>
                            <select id="lokasi" name="cabang" class="form-control select2">
                                <option value="">[SEMUA CABANG]</option>
                                <?php
                                $cabang = $this->db->order_by('keterangan', 'DESC')->get('tbl_pengaturan_cabang')->result();
                                if (!empty($cabang)) {
                                    foreach ($cabang as $cabang) {
//                                      
                                        ?>
                                        <option value="<?php echo $cabang->id ?>"><?php echo $cabang->keterangan ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
						<!--
                        <div class="form-group">
                            <label class="control-label">Per Hari</label>
                            <br/>
                            <input type="checkbox" name="hari_ini" value="<?php echo date('m/d/Y') ?>"> Hari Ini
                        </div>
						-->
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
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
<!--            <div class="col-lg-4">
                <?php echo form_open('page=laporan&act=set_lap_penjualan2', '') ?>
                <?php echo form_hidden('route', 'data_packing') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Cabang</label>
                            <select id="lokasi" name="cabang" class="form-control select2">
                                <option value="">[SEMUA CABANG]</option>
                                <?php
                                $cabang = $this->db->order_by('keterangan', 'DESC')->get('tbl_pengaturan_cabang')->result();
                                if (!empty($cabang)) {
                                    foreach ($cabang as $cabang) {
//                                      
                                        ?>
                                        <option value="<?php echo $cabang->id ?>"><?php echo $cabang->keterangan ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tgl</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value' => '')) ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Rentang</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control pull-right', 'value' => '')) ?>
                            </div>
                        </div>                                
                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Metode Pembayaran</label>
                            <?php echo br() ?>
                            <?php echo form_radio(array('id' => '', 'name' => 'tipe', 'value' => '0', 'checked' => 'TRUE')) ?> Semua
                            <?php echo nbs(2) ?>
                            <?php echo form_radio(array('id' => '', 'name' => 'tipe', 'value' => '1')) ?> Tunai
                            <?php echo nbs(2) ?>
                            <?php echo form_radio(array('id' => '', 'name' => 'tipe', 'value' => '2')) ?> Deposit
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="col-lg-4">
                <?php echo form_open('page=laporan&act=set_lap_penjualan3', '') ?>
                <?php echo form_hidden('route', 'data_packing') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan per Kasir</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Cabang</label>
                            <select id="lokasi" name="cabang" class="form-control select2">
                                <option value="">[SEMUA CABANG]</option>
                                <?php
                                $cabang = $this->db->order_by('keterangan', 'DESC')->get('tbl_pengaturan_cabang')->result();
                                if (!empty($cabang)) {
                                    foreach ($cabang as $cabang) {
//                                      
                                        ?>
                                        <option value="<?php echo $cabang->id ?>"><?php echo $cabang->keterangan ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Kasir</label>
                            <select id="lokasi" name="sales" class="form-control select2">
                                <option value="">- Pilih -</option>
                                <?php
                                $kasir = $this->db->select('tbl_ion_users.id, tbl_ion_users.username, tbl_ion_users.first_name, tbl_pengaturan_cabang.keterangan as cabang')->join('tbl_pengaturan_cabang', 'tbl_pengaturan_cabang.id=tbl_ion_users.id_app')->get('tbl_ion_users')->result();
                                if (!empty($kasir)) {
                                    foreach ($kasir as $kasir) {
//                                      
                                        ?>
                                        <option value="<?php echo $kasir->id ?>"><?php echo $kasir->username . '@' . $kasir->cabang ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tgl</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <?php echo form_input(array('id' => 'tgl_sales', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value' => '')) ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Rentang</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <?php echo form_input(array('id' => 'tgl_rentang_sales', 'name' => 'tgl_rentang', 'class' => 'form-control pull-right', 'value' => '')) ?>
                            </div>
                        </div>                                
                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Metode Pembayaran</label>
                            <?php echo br() ?>
                            <?php echo form_radio(array('id' => '', 'name' => 'tipe', 'value' => '0', 'checked' => 'TRUE')) ?> Semua
                            <?php echo nbs(2) ?>
                            <?php echo form_radio(array('id' => '', 'name' => 'tipe', 'value' => '1')) ?> Tunai
                            <?php echo nbs(2) ?>
                            <?php echo form_radio(array('id' => '', 'name' => 'tipe', 'value' => '2')) ?> Deposit
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            -->
        </div>

        <?php if (!empty($penjualan)) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Transaksi</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo site_url('page=laporan&act=penjualan_pdf&route=' . $this->input->get('act') . '&case=' . $this->input->get('case') . '&query=' . $this->input->get('query') . '&tgl_awal=' . $this->input->get('tgl_awal') . '&tgl_akhir=' . $this->input->get('tgl_akhir') . '&tipe=' . $this->input->get('tipe') . '&sales=' . $this->input->get('sales')) ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>-->
                            <?php
                            $rute        = ($_GET['act'] == 'data_packing' ? 'packing_pdf' : '');
                            switch ($_GET['case']) {
                                case 'semua':
                                    
                                    break;

                                case 'cabang':
                                    $button = anchor('page=laporan&act='.(!empty($rute) ? $rute : 'penjualan_pdf').'&case=cabang&cabang='.$this->input->get('cabang').'&tgl_awal='.$this->input->get('tgl_awal').'&tgl_akhir='.$this->input->get('tgl_akhir').'&tipe='.$this->input->get('tipe'),'<button class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Cetak</button>');
                                    break;

                                case 'per_tanggal':
                                    $button = anchor('page=laporan&act='.(!empty($rute) ? $rute : 'penjualan_pdf').'&case=per_tanggal&query='.$this->input->get('query').'&cabang='.$this->input->get('cabang').'&tipe='.$this->input->get('tipe'),'<button class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Cetak</button>');
                                    break;

                                case 'per_rentang':
                                    $button = anchor('page=laporan&act='.(!empty($rute) ? $rute : 'penjualan_pdf').'&case=per_rentang&tgl_awal='.$this->input->get('tgl_awal').'&tgl_akhir='.$this->input->get('tgl_akhir').'&cabang='.$this->input->get('cabang').'&tipe='.$this->input->get('tipe'),'<button class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Cetak</button>');
                                    break;

                                case 'per_sales':
                                    $button = anchor('page=laporan&act='.(!empty($rute) ? $rute : 'penjualan_pdf').'&case=per_sales&sales='.$this->input->get('sales').'&tgl_awal='.$this->input->get('tgl_awal').'&tgl_akhir='.$this->input->get('tgl_akhir').'&cabang='.$this->input->get('cabang').'&tipe='.$this->input->get('tipe'),'<button class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Cetak</button>');
                                    break;

                                default:
                                    $button = '';
                                    break;
                            }
                            
                            echo $button;
                            ?>
                            <?php echo br(2) ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <!--<th>Tgl</th>-->
                                        <th>Bahan Packing</th>
                                        <th class="text-center">Jml</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php if (!empty($penjualan)) { ?>
                                            <?php $no = 1; ?>
                                            <?php $total = 0; ?>
                                            <?php foreach ($penjualan as $penjualan) { ?>
                                            <?php $tgl = explode('-', $penjualan->tgl_simpan) ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++ ?></td>
                                                    <!--<td class="text-left"><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>-->
                                                    <td><?php echo ucwords($penjualan->produk) ?></td>
                                                    <td class="text-center"><?php echo $penjualan->jml ?></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
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
        $('#tgl_sales').datepicker({
            autoclose: true,
        });
        
        $('#tgl_rentang').daterangepicker();
        $('#tgl_rentang_sales').daterangepicker();
        $(".select2").select2();
    });

</script>