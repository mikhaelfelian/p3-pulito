<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Kategori
                <small>
                    <a href="#" data-toggle="modal" data-target="#modal-form-kategori">
                        <button class="btn btn-warning"><i class="fa fa-plus"></i> Tambah</button>
                    </a>
                </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Kategori</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row" id="bag-kategori">
                <?php $no = 1; ?>
                <?php foreach ($kategori1 as $kategori1) { ?>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner text-center">
                                <a href="<?php echo base_url('cart/cart-step-2.php?id_kat1=' . general::enkrip($kategori1->id)) ?>" style="color: #fff;">
                                    <h4><?php echo ucwords(character_limiter($kategori1->kategori, 20)) ?></h4>
                                    <p><?php echo ($kategori1->status_temp == 1 ? anchor(base_url('cart/cart-step-1-hapus.php?id=' . general::enkrip($kategori1->id)), '<i class="fa fa-remove"></i><b>Hapus</b>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"') : nbs()) ?></p>
                                </a>
                            </div>
                            <div class="icon">
                                <a href="<?php echo base_url('cart/cart-step-2.php?id_kat1=' . general::enkrip($kategori1->id)) ?>" style="color: #e0d7d7 transparent;">
                                    <!--<i class="ion ion-bag"></i>-->
                                </a>
                            </div>

                            <a href="<?php echo base_url('cart/cart-step-2.php?id_kat1=' . general::enkrip($kategori1->id)) ?>" class="small-box-footer"><?php echo nbs(2) ?></a>
                        </div>
                    </div>
                <?php $no++; ?>
                <?php } ?>
            </div>
        </section>
        <!-- /.content -->

        <!--Modal Form Kategori-->
        <div class="modal modal-default fade" id="modal-form-kategori">
            <div class="modal-dialog">
                <div class="modal-content">            
                    <!--Nampilin message box success-->
                    <div id="msg-success" class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="glyphicon glyphicon-ok"></i><?php echo nbs(4) ?>Kategori berhasil ditambahkan !!</h5>
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Form Kategori</h4>
                    </div>
                    <form class="tagForm" id="form-kategori">
                        <div class="modal-body">
                            <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                <label class="control-label">Nama Kategori</label>
                                <?php echo form_input(array('id' => 'kategori', 'name' => 'kategori', 'class' => 'form-control')) ?>
                            </div>

                            <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                <label class="control-label">Keterangan</label>
                                <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control')) ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-flat pull-left" data-dismiss="modal">Close</button>
                            <button type="button" id="submit-form-kategori" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
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

        $('#submit-form-kategori').on('click', function (e) {
            var kategori = $('#kategori').val();
            var keterangan = $('#keterangan').val();

            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('cart/cart-step-1-simpan.php') ?>",
                data: $("#form-kategori").serialize(),
                success: function (data) {
//                    $('#kategori').val('');
//                    $('#keterangan').val('');
                    console.log(kategori);
                    $("#bag-kategori").load("<?php echo base_url('cart/cart-step-1.php') ?> #bag-kategori", function () {
                        //$(".select2").select2();
                    });
                    $('#msg-success').show();
                    $("#modal-form-kategori").modal('hide');
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