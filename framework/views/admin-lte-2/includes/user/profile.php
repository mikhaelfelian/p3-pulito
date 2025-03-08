<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Pengguna <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Pengaturan</a></li>
            <li class="active">User</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profile</h3>
                    </div>
                    <div class="box-body">
                        <?php if (!empty($user)) { ?>
                            <div class="row">
                                <div class="col-lg-8">
                                    <?php echo form_open('page=pengaturan&act=profile_update', 'id="FormSimpan"') ?>
                                    <?php echo form_hidden('id', $user->id) ?>
                                    <div class="form-group">
                                        <label>E-MAIL</label>
                                        <?php echo form_input(array('name' => 'email', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $user->email)) ?>
                                        <br/>
                                        <label>Username</label>
                                        <?php echo form_input(array('name' => 'username', 'placeholder' => 'Username ..', 'class' => 'form-control', 'value' => $user->username)) ?>
                                        <br/>
                                        <label>Nama</label>
                                        <?php echo form_input(array('name' => 'nama', 'placeholder' => 'Username ..', 'class' => 'form-control', 'value' => $user->first_name)) ?>
                                        <br/>
                                        <label>Kata Sandi</label>
                                        <?php echo form_password(array('name' => 'pass1', 'placeholder' => 'Kata Sandi ..', 'class' => 'form-control', 'value' => $user->nm_akun)) ?>
                                        <br/>
                                        <button type="submit" class="btn btn-flat btn-primary"><i class="fa fa-save"></i> UBAH DATA</button>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                                <div class="col-lg-4">
                                    <label>USERNAME</label>
                                    <?php echo br() . $user->username ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-lg-8">
                                    <?php echo form_open('page=anggota&act=anggota_simpan', 'id="FormSimpan"') ?>
                                    <div class="form-group">
                                        <?php echo form_input(array('name' => 'email', 'placeholder' => 'Email Siswa ..', 'class' => 'form-control')) ?>
                                        <br/>
                                        <?php echo form_input(array('name' => 'nis', 'placeholder' => 'NIS ..', 'class' => 'form-control')) ?>
                                        <br/>
                                        <?php echo form_input(array('name' => 'nm_akun', 'placeholder' => 'Nama Siswa ..', 'class' => 'form-control')) ?>
                                        <br/>
                                        <?php echo form_radio(array('name' => 'jns_klm', 'value' => 'L')) ?> L &nbsp; 
                                        <?php echo form_radio(array('name' => 'jns_klm', 'value' => 'P')) ?> P
                                        <br/>
                                        <br/>
                                        <?php echo form_input(array('name' => 'tmp_lahir', 'placeholder' => 'Tmp Lahir ..', 'class' => 'form-control')) ?>
                                        <br/>
                                        <?php echo form_input(array('name' => 'tgl_lahir', 'placeholder' => 'Tgl Lahir.. cth :  1992-02-15 / (yyyy-mm-dd) ..', 'class' => 'form-control')) ?>
                                        <br/>
                                        <?php echo form_input(array('name' => 'alamat', 'placeholder' => 'Alamat ..', 'class' => 'form-control')) ?>
                                        <br/>
                                        <?php echo form_input(array('name' => 'kota', 'placeholder' => 'Kota ..', 'class' => 'form-control')) ?>
                                        <br/>
                                        <button type="submit" class="btn btn-flat btn-primary"><i class="fa fa-save"></i> SIMPAN</button>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>
                        <?php } ?>
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
<script>
    $(function () {
        $('#cekAbeh').click(function () {
            $('input:checkbox').prop('checked', true);
            $(".itemnya").css("background", "yellow");
            $('#apusPilih').show();
        });

        $('#cekAbehIlang').click(function () {
            $('input:checkbox').prop('checked', false);
            $(".itemnya").css("background", "#f4f4f4");
            $('#apusPilih').hide();
        });

        $('#apusPilih').hide();
        $('#apusPilih').click(function () {
            $('#HapusBanyak').submit();
        });

        /* The todo list plugin */
        $(".todo-list").todolist({
            onCheck: function (ele) {
                $(this).css("background", "yellow");
                $('#apusPilih').show();
                return ele;
            },
            onUncheck: function (ele) {
                $(this).css("background", "#f4f4f4");
                $('#apusPilih').hide();
                return ele;
            }
        });
    });
</script>