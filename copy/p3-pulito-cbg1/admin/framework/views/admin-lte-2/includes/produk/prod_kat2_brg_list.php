<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Tambah Data Bahan <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Bahan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open('page=produk&act='.(!empty($bahan) ? 'prod_kategori2_brg_update' : 'prod_kategori2_brg_simpan'), '') ?>
                <?php echo form_hidden('id', $this->input->get('id')) ?>                
                <input type="hidden" id="id_bahan" name="id_bahan" <?php echo (!empty($bahan) ? 'value="'.general::enkrip($bahan->id).'"' : '') ?>>
                
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Kategori</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nama Kategori</label>
                            <select name="kategori" class="form-control" disabled="TRUE">
                                <option value="">- Pilih -</option>
                                <?php
                                $id_kat1 = general::dekrip($this->input->get('id_kat'));
                                $sql_kat = $this->db->get('tbl_m_kategori')->result();

                                foreach ($sql_kat as $kat) {
                                    echo '<option value="' . $kat->id . '" ' . ($kategori->id_kategori == $kat->id ? 'selected' : '') . '>' . $kat->kategori . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['kategori2']) ? 'has-error' : '') ?>">
                            <label class="control-label">Sub Kategori 1</label>
                            <?php echo form_input(array('name' => 'kategori2', 'class' => 'form-control', 'value'=>$kategori->kategori,'readonly'=>'TRUE')) ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Bahan</label>
                            <?php echo form_input(array('id' => 'bahan', 'name' => 'bahan', 'class' => 'form-control', 'value'=>$bahan->produk)) ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Jml</label>
                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'style' => 'width: 50px; text-align:center;', 'value'=>$bahan->jml)) ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">Batal</button>
                        <button type="submit" class="btn btn-info pull-right">Simpan</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="col-lg-8">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Bahan per Kategori</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kategori</th>
                                    <th>Bahan</th>
                                    <th>Stok</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($barang)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($barang as $barang) {
                                        $kat   = $this->db->where('id', $barang->id_kategori2)->get('tbl_m_kategori2')->row();
                                        $bahan = $this->db->where('id', $barang->id_barang)->get('tbl_m_produk')->row();
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $kat->kategori ?></td>
                                            <td><?php echo $bahan->produk ?></td>
                                            <td><?php echo $barang->jml ?></td>
                                            <td>
                                                <?php echo anchor('page=produk&act=prod_kategori2_brg_list&id='.$this->input->get('id').'&id_bahan=' . general::enkrip($barang->id).'&id_kategori='.$this->input->get('id'), '<i class="fa fa-edit"></i> Ubah', 'class="text-primary"').nbs(2)  ?>
                                                <?php echo anchor('page=produk&act=prod_kategori2_brg_hapus&id=' . general::enkrip($barang->id).'&id_kategori='.$this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $barang->kategori . '] ? \')" class="text-danger"')  ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
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
<!-- Page script -->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<script>
    $(function () {
    $("#jml").keydown(function (e) {
    // kibot: backspace, delete, tab, escape, enter .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // kibot: Ctrl+A, Command+A
                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // kibot: home, end, kanan, kiri, atas, bawah
                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                // Biarin wae, ga ngapa2in return false
                return;
            }
            // Cuman nomor
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
//        
//        Autocomplete buat produk
        $('#bahan').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('page=produk&act=json_barang') ?>",
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
                var $itemrow = $(this).closest('tr');
                // Populate the input fields from the returned values
                $itemrow.find('#kode').val(ui.item.kode);
//                $('#kode').val(ui.item.kode);
                $('#bahan').val(ui.item.produk);
                $('#id_bahan').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#qty').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>[" + item.kode + "] " + item.produk + "</a>")
                    .appendTo(ul);
        };
    });
</script>