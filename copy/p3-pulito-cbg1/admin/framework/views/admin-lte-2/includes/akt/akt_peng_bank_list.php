<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pengeluaran Bank<small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pengeluaran</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-3">
                <?php echo form_open('page=akuntability&act=akt_peng_bank_simpan', '') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Pengeluaran</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Tgl</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value' => date('m/d/Y'))) ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                            <label class="control-label">Keterangan</label>
                            <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control')) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                            <label class="control-label">Jenis</label><br/>
                            <div class="row">
                                <div class="col-lg-4">
                                    <?php echo form_radio(array('name' => 'status', 'value' => '0', 'checked' => 'TRUE', 'onclick' => 'document.getElementById(\'id_jenis\').disabled  = true')) ?> Kas
                                </div>
                                <div class="col-lg-8">
                                    <?php echo form_radio(array('name' => 'status', 'value' => '1', 'onclick' => 'document.getElementById(\'id_jenis\').disabled  = false')) ?> Operasional
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-lg-4">

                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                        <select id="id_jenis" name="jenis" class="form-control" disabled="TRUE">
                                            <option value="">- Pilih -</option>
                                            <?php
                                            $jenis = $this->db->get('tbl_akt_kas_jns')->result();
                                            foreach ($jenis as $jenis) {
                                                echo '<option value="' . $jenis->id . '">' . $jenis->jenis . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['nominal']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nominal</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    Rp
                                </div>
                                <?php echo form_input(array('id' => 'nominal', 'name' => 'nominal', 'class' => 'form-control pull-right')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">Batal</button>
                        <button type="submit" class="btn btn-info pull-right">Simpan</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="col-lg-9">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Pengeluaran</h3>
                        <div class="box-tools">
                            <?php echo form_open('page=akuntability&act=set_cari_peng_bank') ?>
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
                                    <th>User</th>
                                    <th>Tgl</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <!--<th>Jenis</th>-->
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($pemasukan)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    $tot_peng = 0;
                                    foreach ($pemasukan as $pemasukan) {
                                        $tot_peng = $tot_peng + $pemasukan->nominal;
                                        $tgl = explode('-', $pemasukan->tgl);
                                        $usr = $this->ion_auth->user($pemasukan->id_user)->row()->first_name;
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo ucwords($usr) ?></td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <td><?php echo $pemasukan->keterangan ?></td>
                                            <td class="text-right"><?php echo general::format_angka($pemasukan->nominal) ?></td>
                                            <!--<td><?php // echo $pemasukan->id_jenis  ?></td>-->
                                            <td><?php echo anchor('page=akuntability&act=akt_peng_hapus&id=' . general::enkrip($pemasukan->id).'&route='.$this->input->get('act').'&kode='.$pemasukan->kode, '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $pemasukan->keterangan . '] ? \')" class="text-danger"') ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-right text-bold" colspan="4">Total</td>
                                        <td class="text-right text-bold"><?php echo general::format_angka($tot_peng) ?></td>
                                        <!--<td><?php // echo $pemasukan->id_jenis  ?></td>-->
                                        <td></td>
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