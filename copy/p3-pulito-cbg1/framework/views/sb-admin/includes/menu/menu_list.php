<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-responsive" style="border: 0px;">
                <tr>
                    <td style="border: 0px;"><h1 class="page-header"><i class="fa fa-list"></i> Daftar Menu</h1></td>
                    <td style="border: 0px;" class="text-right"><h1 class="page-header"><?php echo $_GET['no_meja'] . ' (' . $this->cart->total_items() . ' Pesanan)'; ?></h1></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <?php $cart = $this->cart->contents(); ?>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-responsive" style="border: 0px;">
                <tr>
                    <td style="width: 36px; border: 0px;"><a href="<?php echo base_url('pesan/meja_batal.php?id='.$_GET['id'].'&no_meja=' . $_GET['no_meja'].'&status='.$_GET) ?>"><button class="btn btn-primary"><i class="fa fa-fw fa-close"></i> Batal</button></a></td>
                    <?php echo form_open('pesan/cari.php'); ?>
                    <?php echo form_hidden('no_meja', $_GET['no_meja']) ?>
                    <?php echo form_hidden('id', $_GET['id']) ?>
                    <?php echo (isset($_GET['halaman']) ? form_hidden('hal', $_GET['halaman']) : '') ?>
                    <td style=" border: 0px;" class="text-left"><input type="text" name="cari" class="form-control" placeholder="Masukkan kata kunci ..."/></td>
                    <td style=" border: 0px;" class="text-left">
                        <?php echo form_radio(array('name' => 'kategori', 'value' => 'kode', 'checked' => 'TRUE')) ?> Kode Menu
                        <?php echo nbs(2) ?>
                        <?php echo form_radio(array('name' => 'kategori', 'value' => 'menu')) ?> Menu
                        <?php echo nbs(4) ?>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                    </td>
                    <?php echo form_close(); ?>
                    <td style="border: 0px;" class="text-right">                        
                        <?php if (!empty($cart)) { ?>
                            <a href="<?php echo base_url('pesan/checkout.php?id=' . $_GET['id'] . '&no_meja=' . $_GET['no_meja']) ?>"><button class="btn btn-primary">Lanjut <i class="fa fa-fw fa-arrow-right"></i></button></a><br/><br/>
                        <?php } else { ?>
                            <button class="btn btn-default" onclick="alert('Silahkan pesan minimal 1 menu.')">Lanjut <i class="fa fa-fw fa-arrow-right"></i></button><br/><br/>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php if (!empty($menu_list)) { ?>
        <div class="row">
            <div class="col-lg-6">
                <table class="table table-responsive" style="border: 0px;">
                    <tr>
                        <td style="border: 0px;">
                            <ul class="pagination">                        
                                <?php
                                if (!empty($pagination)) {
                                    if ($total_rows > $PerPage) {
                                        echo '<li>' . $pagination . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <?php
            $no = (isset($_GET['halaman']) ? 1 + $_GET['halaman'] : 1);
            foreach ($menu_list as $menu) {
                ?>
                <!-- JQueri UI Form <?php echo $no; ?>-->
                <script src="<?php echo base_url() ?>assets/ui/jquery-2.1.4.min.js"></script>
                <!--<script src="<?php echo base_url() ?>assets/ui/jquery.js"></script>-->
                <script src="<?php echo base_url() ?>assets/ui/jquery-ui.js"></script>
                <script src="<?php echo base_url() ?>assets/ui/autonumeric.js"></script>
                <link href="<?php echo base_url() ?>assets/ui/jquery-ui.min.css" rel="stylesheet">
                <script type="text/javascript">
                                    var s = $.noConflict();
                                    s(function () {
                                        //                s('#tgl').datepicker({'dateFormat': 'yy-mm-dd'});

                                        s("#price<?php echo $no; ?>").autoNumeric({aSep: '.', aDec: ',', aPad: false});

                                        s("#qty<?php echo $no; ?>").keydown(function (e) {
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
                <!--JQuery UI-->

                <?php
                echo form_open('pesan/temp_pesan_menu.php');
                echo form_hidden('id_meja', $_GET['id']);
                echo form_hidden('no_meja', $_GET['no_meja']);
                echo form_hidden('id_menu', $menu->id);
                echo form_hidden('kode', $menu->kode);
                echo form_hidden('nama', $menu->menu);
                echo form_hidden('harga', $menu->harga);
                ?>

                <div class="col-lg-4 col-md-4">
                    <table class="table table-responsive" style="border: 0px;">
                        <tr>
                            <td style="border: 0px;">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">                                
                                            <div class="col-xs-12">
                                                <h2 class="panel-title"><?php echo $no . '. ' . ucwords($menu->menu) ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-12 text-right">
                                                <h2 class="panel-title"><?php echo '[' . $menu->kode . ']' ?></h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <?php if (!empty($menu->file)) { ?>
                                                    <img src="<?php echo base_url('assets/gbr/' . $menu->file) ?>" class="img-circle" style="width: 100px; height: 100px;">
                                                <?php } else { ?>
                                                    <img src="<?php echo base_url('assets/gbr/default.png') ?>" class="img-circle" style="width: 100px; height: 100px;">
                                                <?php } ?>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <strong><?php echo ($menu->harga / 1000) ?>K</strong>
                                                <p class="text-muted"><?php echo $menu->ket ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <p class="text-gray"><strong>Keterangan :</strong></p>
                                        <p class="text-gray">
                                            <?php echo form_textarea(array('name' => 'ket', 'rows' => '5', 'placeholder' => 'Misal : ' . $menu->menu . ' tidak pakai ...', 'class' => 'form-control')) ?>
                                        </p>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">                                
                                            <div class="col-xs-3">
                                                <?php echo form_input(array('id' => 'qty' . $no, 'name' => 'qty', 'value' => '1', 'class' => 'form-control')) ?>
                                            </div>
                                            <div class="col-xs-9 text-left">
                                                <button class="btn btn-default"><i class="fa fa-shopping-cart"></i> Pesan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php echo form_close() ?>
                <?php
                $no++;
            }
            ?>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <ul class="pagination">                        
                    <?php
                    if (!empty($pagination)) {
                        if ($total_rows > $PerPage) {
                            echo '<li>' . $pagination . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">        
            <div class="col-lg-12">
                <div class="alert alert-warning"><i class="fa fa-remove"></i> Data tidak ditemukan !!</div>
            </div>
        </div>
    <?php } ?>
    <!--</div>-->
    <!-- /.row -->
</div>