<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pulito
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Transaksi</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-body">
                            <?php echo form_open_multipart(base_url('cart/set_nota_update.php')) ?>
                            <?php echo form_hidden('id', general::enkrip($sess_jual->id)) ?>
                            <div class="row">
                                <div class="col-lg-6">                                
                                    <div class="form-group">
                                        <label class="control-label">No. Invoice</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                #
                                            </div>
                                            <?php echo form_input(array('id' => '', 'name' => 'no_nota', 'class' => 'form-control pull-right', 'value' => $sess_jual->no_nota, 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-lg-3">                                
                                    <div class="form-group <?php echo (!empty($hasError['tgl_masuk']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Tanggal Masuk</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right', 'value' => date('m/d/Y'))) ?>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-lg-3">                                
                                    <div class="form-group <?php echo (!empty($hasError['tgl_keluar']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Tanggal Jadi</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_keluar', 'name' => 'tgl_keluar', 'class' => 'form-control pull-right', 'value' => date('m/d/Y'))) ?>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="bag-pelanggan" class="form-group <?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Pelanggan</label>
                                                <div class="input-group date">
                                                    <select id="pelanggan" name="pelanggan" class="form-control select2">
                                                        <option value="">- [Pilih] -</option>
                                                        <?php
                                                        $plgn = $this->db->get('tbl_m_pelanggan')->result();
                                                        if (!empty($plgn)) {
                                                            foreach ($plgn as $plgn) {
                                                                $sql_tipe = $this->db->where('id', $plgn->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                                                ?>
                                                                <option value="<?php echo $plgn->id ?>" <?php echo ($plgn->id == $sess_jual->id_pelanggan ? 'selected' : '') ?>><?php echo '[' . $plgn->kode . '] ' . $plgn->nama . ' - ' . $sql_tipe->grup ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="input-group-addon">
                                                        <a href="#" data-toggle="modal" data-target="#modal-primary">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <!--Nampilin message box success-->
<!--                                            <div id="msg-success" class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h5><i class="glyphicon glyphicon-ok"></i><?php echo nbs(4) ?>Pelanggan berhasil ditambahkan !!</h5>
                                            </div>-->
                                            
                                            <!--
                                            <div class="form-group <?php echo (!empty($hasError['status_reseller']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Tipe Pelanggan</label>
                                            <?php echo br() ?>
                                            <?php echo form_radio(array('name' => 'status_pel', 'value' => '0', 'checked' => 'TRUE')) ?> Umum
                                            <?php echo nbs(4) ?>
                                            <?php echo form_radio(array('name' => 'status_pel', 'value' => '1')) ?> Member
                                            </div>
                                            -->
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-lg-6">-->
                                    <!--<div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">-->
                                        <!--<label class="control-label">Keterangan</label>-->
                                        <?php // echo form_textarea(array('id' => '', 'name' => 'keterangan', 'class' => 'form-control pull-right', 'style' => 'height: 226px;')) ?>
                                    <!--</div>-->
                                <!--</div>-->
                            </div>
                            <div class="row">
                                <div id="keranjang" class="col-lg-4">
                                    <?php echo br() ?>
                                    <button type="reset" class="btn btn-warning btn-flat">Batal</button>
                                    <button type="submit" class="btn btn-primary btn-flat">Set Order</button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sess_jual)) { ?>
                <?php $tglm = explode('-', $sess_jual->tgl_masuk);
                $tglj = explode('-', $sess_jual->tgl_masuk); ?>
                <div class="row">                
                    <div class="col-lg-8">
                        <div class="box box-warning" id="data_pelanggan">
                            <div class="box-body">
                                <table class="table table-striped">
                                    <tr>
                                        <th>No. Invoice</th>
                                        <th>:</th>
                                        <td>#<?php echo $sess_jual->no_nota ?></td>

                                        <th>Tgl Masuk</th>
                                        <th>:</th>
                                        <td><?php echo $tglm[1] . '/' . $tglm[2] . '/' . $tglm[0] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pelanggan</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($pelanggan->nama) ?></td>

                                        <th>Tgl Jadi</th>
                                        <th>:</th>
                                        <td><?php echo $tglj[1] . '/' . $tglj[2] . '/' . $tglj[0] ?></td>
                                    </tr>
                                    <!--
                                    <tr>
                                        <th>Keterangan</th>
                                        <th>:</th>
                                        <td colspan="4"><?php // echo $sess_jual['keterangan'] ?></td>
                                    </tr>
                                    -->
                                </table>
                            </div>
                            <div class="box-footer">
                                <button class="btn btn-primary btn-flat pull-right" onclick="window.location.href = '<?php echo base_url('cart/cart-step-1-edit.php?nota='.$this->input->get('nota')) ?>'">Lanjut &raquo;</button>
                            </div>
                        </div>
                    </div>
                </div>
<?php } ?>


            <!--Modal form-->
            <div class="modal modal-default fade" id="modal-primary">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Form Pelanggan</h4>
                        </div>                
                        <form class="tagForm" id="form-pelanggan">
                            <div class="modal-body">
                                <!--Nampilin message box success-->
                                                               <div id="msg-success" class="alert alert-success alert-dismissible">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                                    <h5><i class="glyphicon glyphicon-ok"></i><?php echo nbs(4) ?>Pelanggan berhasil ditambahkan !!</h5>
                                                                </div>

                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">NIK</label>
                                    <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control')) ?>
                                </div>

                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama</label>
                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                                    <label class="control-label">No. HP</label>
                                    <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alamat</label>
                                    <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Tipe Member</label>
                                    <?php
                                    echo br();
                                    foreach ($sql_member_tipe->result() as $tipe) {
                                        echo form_radio(array('name' => 'tipe_member', 'value' => $tipe->id)) . ' ' . $tipe->grup . nbs(3);
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-flat pull-left" data-dismiss="modal">Close</button>
                                <button type="button" id="submit-pelanggan" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
                                $(function () {
                               $('#msg-success').hide(); 

//      Platform
                                    $(".select2").select2();

//      Tanggale Masuk
                                    $('#tgl_masuk').datepicker({
                                        autoclose: true,
                                    });
//      Tanggale Jadi
                                    $('#tgl_keluar').datepicker({
                                        autoclose: true,
                                    });

//      Tanggal bayar
                                    $('#tgl_bayar').datepicker({
                                        autoclose: true,
                                    });

//        $('#modal-primary').modal('show.bs.modal');

                                    $('#submit-pelanggan').on('click', function (e) {
                                        var nama = $('#nama').val();
                                        var no_hp = $('#no_hp').val();
                                        var alamat = $('#alamat').val();

                                        e.preventDefault();
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url('member/member_simpan2.php') ?>",
                                            data: $("#form-pelanggan").serialize(),
                                            success: function (data) {
                                                $('#nama').val('');
                                                $('#no_hp').val('');
                                                $('#alamat').val('');

                                                $("#bag-pelanggan").load("<?php echo base_url('dashboard.php') ?> #bag-pelanggan", function () {
                                                    $(".select2").select2();
                                                });
                                                $('#msg-success').show();
                                                $("#modal-primary").modal('hide');
                                                setTimeout(function () {
                                                    $('#msg-success').hide('blind', {}, 500)
                                                }, 3000);
                                            },
                                            error: function () {
                                                alert('Error');
                                            }
                                        });
                                        return false;
                                    });
                                });
</script>