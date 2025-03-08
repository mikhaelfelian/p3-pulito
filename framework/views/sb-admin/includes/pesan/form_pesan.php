
<!-- Tabel User - DATA TABLE Jquery -->
<script src="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-2.1.4.min.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/ui/jquery.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/ui/autonumeric.js"></script>
<link href="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/sb-admin') ?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/sb-admin') ?>/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<!--<link href="<?php echo base_url('assets/sb-admin') ?>/css/dataTables.bootstrap.css" rel="stylesheet">-->

<!-- Script Utama -->
<script type="text/javascript">
    var s = $.noConflict();
    s(function () {
        s('#tgl').datepicker({'dateFormat': 'yy-mm-dd'});
        s('#tabel-pelanggan').DataTable({
            responsive: true
        });


        /* Ambil Data Pelanggan */
        s('#nama').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('pesan/pelanggan.json') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                var $itemrow = s(this).closest('tr');
                // Populate the input fields from the returned values
                $itemrow.find('#nama').val(ui.item.nama);
                s('#nama').val(ui.item.nama);
                s('#kode').val(ui.item.kode);
                s('#no_hp').val(ui.item.no_hp);
                s('#alamat').val(ui.item.alamat);
                s('#status_pesan').val(ui.item.status_pesan);
                s('#status_plgn').val(ui.item.status_plgn);

                // Give focus to the next input field to recieve input from user
                s('#qty').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return s("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nama + "-" + item.no_hp + "</a>")
                    .appendTo(ul);
        };
    });
</script>
<!--JQuery UI-->

<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header"><i class="fa fa-list-alt"></i> Form Pesanan</h1>
        </div>
        <div class="col-lg-6 text-right">
            <h1 class="page-header"><?php echo $_GET['no_meja']; ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <?php // $stat_meja = substr($_GET['no_meja'], 0, -2) ?>
                <tr>
                    <td style="width: 36px; border-top: 0px;"><a href="<?php echo base_url('pesan/meja_batal.php?id=' . $_GET['id']) ?>"><button class="btn btn-primary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</button></a></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title"><i class="fa fa-folder"></i> Form Data Pelanggan</h2>
                </div>
                <div class="panel-body">
                    <?php $has_error = $this->session->flashdata('form_error') ?>
                    <?php echo form_open('pesan/form_simpan.php') ?>
                    <?php echo form_hidden('id_pesanan', $_GET['id']) ?>
                    <?php echo form_hidden('no_meja', $_GET['no_meja']) ?>
                    <?php echo form_hidden('status_resto', $_GET['status']) ?>
                    <?php echo form_hidden('no_nota', $_GET['no_nota']) ?>

                    <div class="form-group <?php echo (empty($has_error['kode']) ? '' : 'has-error') ?>">
                        <label class="control-label" for="<?php echo (empty($has_error['kode']) ? '' : 'InputError') ?>">Kode</label>
                        <?php echo $has_error['kode'] ?>
                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control', 'readonly' => TRUE)) ?>
                    </div>
                    
                    <div class="form-group <?php echo (empty($has_error['tgl']) ? '' : 'has-error') ?>">
                        <label class="control-label" for="<?php echo (empty($has_error['tgl']) ? '' : 'InputError') ?>">Tanggal</label>
                        <?php echo $has_error['tgl'] ?>
                        <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control', 'placeholder' => 'Tgl Pesan ...')) ?>
                    </div>                  

                    <div class="form-group <?php echo (empty($has_error['nama']) ? '' : 'has-error') ?>">
                        <label class="control-label" for="<?php echo (empty($has_error['nama']) ? '' : 'InputError') ?>">Nama Pelanggan</label>
                        <?php echo $has_error['nama'] ?>
                    </div> 
                    <div class="form-group input-group">
                        <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control input-group', 'placeholder' => 'Masukkan nama pelanggan ...')) ?>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default form-horizontal" onclick="window.location.href = '<?php echo base_url('pesan/form_pel_tambah.php?id=' . $_GET['id'] . '&no_meja=' . $_GET['no_meja'] . '&status=' . $_GET['status'] . '&no_nota=' . $_GET['no_nota']) ?>'"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>                    

                    <div class="form-group <?php echo (empty($has_error['no_hp']) ? '' : 'has-error') ?>">
                        <label class="control-label" for="<?php echo (empty($has_error['no_hp']) ? '' : 'InputError') ?>">No. HP</label>
                        <?php echo $has_error['no_hp'] ?>
                        <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'readonly' => 'TRUE')) ?>
                    </div>

                    <div class="form-group <?php echo (empty($has_error['alamat']) ? '' : 'has-error') ?>">
                        <label class="control-label" for="<?php echo (empty($has_error['alamat']) ? '' : 'InputError') ?>">Alamat</label>
                        <?php echo $has_error['alamat'] ?>
                        <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'readonly' => 'TRUE')) ?>
                    </div>
                    <?php echo form_reset(array('value' => 'Batal', 'class' => 'btn btn-success')) ?>
                    <?php echo form_submit(array('value' => 'Pesan', 'class' => 'btn btn-success')) ?>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <?php if (!empty($cust_sesi)) { ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-9">
                                <h2 class="panel-title"><i class="fa fa-shopping-cart"></i> Data Pelanggan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Nama Pelanggan</th>
                                <th>:</th>
                                <td><?php echo ucwords($cust_sesi['nama']) ?></td>
                            </tr>
                            <tr>
                                <th>No. HP</th>
                                <th>:</th>
                                <td><?php echo $cust_sesi['no_hp'] ?></td>
                            </tr>
                            <tr>
                                <th>Status Pesanan</th>
                                <th>:</th>
                                <td><?php echo general::status_resto($cust_sesi['status_resto']) ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <th>:</th>
                                <td><?php echo $cust_sesi['alamat'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php } ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title"><i class="fa fa-users"></i> Data Pelanggan</h2>
                </div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="tabel-pelanggan">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pelanggan)) { ?>
                                    <?php foreach ($pelanggan as $pelanggan) { ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $pelanggan->kode ?></td>
                                            <td><?php echo $pelanggan->nama ?></td>
                                            <td><?php echo $pelanggan->no_hp ?></td>
                                            <td><?php echo $pelanggan->alamat ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        /*
          <div class="row">
          <div class="col-lg-6">
          <div class="panel panel-primary">
          <div class="panel-heading">
          <div class="row">
          <div class="col-xs-9">
          <h2 class="panel-title"><i class="fa fa-shopping-cart"></i> Form Data Pesanan</h2>
          </div>
          </div>
          </div>
          <div class="panel-body">
          <p>Silahkan isi data pelanggan, untuk melakukan pemesanan sebelum memilih menu</p>
          <?php echo form_open('pesan/form_simpan.php') ?>
          <?php echo form_hidden('id_pesanan', $_GET['id']) ?>
          <?php echo form_hidden('no_meja', $_GET['no_meja']) ?>
          <div class="form-group <?php echo (empty($has_error['kode']) ? '' : 'has-error') ?>">
          <label class="control-label" for="<?php echo (empty($has_error['kode']) ? '' : 'InputError') ?>">Kode</label>
          <?php echo $has_error['kode'] ?>
          <?php echo form_input(array('name' => 'kode', 'class' => 'form-control', 'readonly'=>TRUE, 'value' => $no_plgn)) ?>
          </div>

          <div class="form-group <?php echo (empty($has_error['nama']) ? '' : 'has-error') ?>">
          <label class="control-label" for="<?php echo (empty($has_error['nama']) ? '' : 'InputError') ?>">Nama Pelanggan</label>
          <?php echo $has_error['nama'] ?>
          <?php echo form_input(array('name' => 'nama', 'class' => 'form-control', 'value' => $this->session->flashdata('nama'))) ?>
          </div>

          <div class="form-group <?php echo (empty($has_error['no_hp']) ? '' : 'has-error') ?>">
          <label class="control-label" for="<?php echo (empty($has_error['no_hp']) ? '' : 'InputError') ?>">No. HP</label>
          <?php echo $has_error['no_hp'] ?>
          <?php echo form_input(array('name' => 'no_hp', 'class' => 'form-control', 'value' => $this->session->flashdata('no_hp'))) ?>
          </div>

          <div class="form-group <?php echo (empty($has_error['status_resto']) ? '' : 'has-error') ?>">
          <label class="control-label" for="<?php echo (empty($has_error['status_resto']) ? '' : 'InputError') ?>">Status Pesanan</label>
          <?php echo $has_error['status_resto'] ?>
          <select name="status_resto" class="form-control">
          <option value="">- Pilih -</option>
          <option value="1">Delivery</option>
          <option value="2">Makan di Tempat</option>
          <option value="3">Bungkus / Packing</option>
          </select>
          </div>

          <div class="form-group <?php echo (empty($has_error['status_plgn']) ? '' : 'has-error') ?>">
          <label class="control-label" for="<?php echo (empty($has_error['status_plgn']) ? '' : 'InputError') ?>">Status Pelanggan</label>
          <?php echo $has_error['status_plgn'] ?>
          <select name="status_plgn" class="form-control">
          <option value="">- Pilih -</option>
          <option value="umum">Umum</option>
          <option value="pelanggan">Pelanggan</option>
          </select>
          </div>

          <div class="form-group <?php echo (empty($has_error['alamat']) ? '' : 'has-error') ?>">
          <label class="control-label" for="<?php echo (empty($has_error['alamat']) ? '' : 'InputError') ?>">Alamat</label>
          <?php echo $has_error['alamat'] ?>
          <?php echo form_textarea(array('name' => 'alamat', 'class' => 'form-control', 'value' => $this->session->flashdata('alamat'))) ?>
          </div>

          <?php echo form_reset(array('value' => 'Batal', 'class' => 'btn btn-success')) ?>
          <?php echo form_submit(array('value' => 'Pesan', 'class' => 'btn btn-success')) ?>
          <?php echo form_open() ?>
          </div>
          </div>
          </div>
          <div class="col-lg-6">
          <?php if(!empty($cust_sesi)){ ?>
          <div class="panel panel-primary">
          <div class="panel-heading">
          <div class="row">
          <div class="col-xs-9">
          <h2 class="panel-title"><i class="fa fa-shopping-cart"></i> Data Pelanggan</h2>
          </div>
          </div>
          </div>
          <div class="panel-body">
          <table class="table table-striped">
          <tr>
          <th>Nama Pelanggan</th>
          <th>:</th>
          <td><?php echo ucwords($cust_sesi['nama']) ?></td>
          </tr>
          <tr>
          <th>No. HP</th>
          <th>:</th>
          <td><?php echo $cust_sesi['no_hp'] ?></td>
          </tr>
          <tr>
          <th>Status Pesanan</th>
          <th>:</th>
          <td><?php echo $cust_sesi['status_resto'] ?></td>
          </tr>
          <tr>
          <th>Alamat</th>
          <th>:</th>
          <td><?php echo $cust_sesi['alamat'] ?></td>
          </tr>
          </table>
          </div>
          </div>
          <?php } ?>
          </div>
          </div>
         */
        ?>
    </div>
    <!--</div>-->
    <!-- /.row -->
</div>