<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data <small>User</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=pengaturan&act=user_list') ?>">Data User</a></li>
            <?php echo (isset($_GET['id']) ? '<li>User</li><li class="active">Update</li>' : '<li class="active">User</li>') ?>            
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                <div class="col-lg-4">                    <?php echo form_open('page=pengaturan&act=user_'.(!empty($_GET['id']) ? 'update' : 'simpan')) ?>
                    <?php echo form_hidden('id', $_GET['id']) ?>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Form User</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                <label class="control-label">Nama</label>
                                <?php echo form_input(array('name' => 'nama', 'class' => 'form-control', 'value'=>$user->first_name)) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['user']) ? 'has-error' : '') ?>">
                                <label class="control-label">Username</label>
                                <?php echo form_input(array('name' => 'user', 'class' => 'form-control', 'value'=>$user->username)) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['pass1']) ? 'has-error' : '') ?>">
                                <label class="control-label">Kata Sandi</label>
                                <?php echo form_password(array('name' => 'pass1', 'class' => 'form-control')) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                                <label class="control-label">Ulang Kata Sandi</label>
                                <?php echo form_password(array('name' => 'pass2', 'class' => 'form-control')) ?>
                            </div>
                            <!--
                            <div class="form-group <?php echo (!empty($hasError['cabang']) ? 'has-error' : '') ?>">
                                <label class="control-label">Cabang</label>
                                <select name="cabang" class="form-control">
                                    <option value="">- Pilih -</option>
                                    <?php
                                    $cabang = $this->db->get('tbl_pengaturan_cabang')->result();
                                    foreach ($cabang as $cabang) {
                                        echo '<option value="' . $cabang->id . '" '.($cabang->id == $user->id_app ? 'selected' : '').'>' . strtoupper($cabang->keterangan) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            -->
                            <div class="form-group <?php echo (!empty($hasError['grup']) ? 'has-error' : '') ?>">
                                <label class="control-label">Grup</label>
                                <select name="grup" class="form-control">
                                    <option value="">- Pilih -</option>
                                    <?php
                                    $grup = $this->ion_auth->groups()->result();
                                    foreach ($grup as $grup) {
                                        if ($grup->name != 'superadmin') {
                                            echo '<option value="' . $grup->id . '" '.($grup->name == $this->ion_auth->get_users_groups($user->id)->row()->name ? 'selected' : '').'>' . ucfirst($grup->description) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default">Batal</button>
                            <button type="submit" class="btn btn-info pull-right">Simpan</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            <?php } else { ?>
                <?php if (isset($_GET['id'])) { ?>
                    <div class="col-lg-4">
                        <?php echo form_open('page=pengaturan&act=user_update') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form User</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama</label>
                                    <?php echo form_input(array('name' => 'nama', 'class' => 'form-control', 'value'=>$user->first_name)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['user']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Username</label>
                                    <?php echo form_input(array('name' => 'user', 'class' => 'form-control', 'value'=>$user->username)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['pass1']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Kata Sandi</label>
                                    <?php echo form_password(array('name' => 'pass1', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Ulang Kata Sandi</label>
                                    <?php echo form_password(array('name' => 'pass2', 'class' => 'form-control')) ?>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info btn-flat pull-right">Update</button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="col-lg-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Pengguna</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('pengaturan') ?>
                        <table class="table table-striped todo-list ui-sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($users as $user) { ?>
                                    <?php if ($this->ion_auth->get_users_groups($user->id)->row()->name != 'superadmin') { ?>
                                        <tr>
                                            <td style="width: 15px; text-align: center;"><?php echo $no++ ?></td>
                                            <td><?php echo ucwords($user->first_name) ?></td>
                                            <td><?php echo $user->username ?></td>
                                            <td><?php echo ucwords($this->ion_auth->get_users_groups($user->id)->row()->name) ?></td>
                                            <td style="width: 15px; text-align: center;">
                                                <?php if (akses::hakSA() == TRUE) { ?>
                                                    <?php echo anchor('page=pengaturan&act=user_list&id=' . general::enkrip($user->id), '<i class="fa fa-edit"></i>', '') ?>
                                                    <?php echo anchor('page=pengaturan&act=user_hapus&id=' . general::enkrip($user->id), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') ?>
                                                <?php } else { ?>
                                                    <?php echo anchor('page=pengaturan&act=user_list&id=' . general::enkrip($user->id), '<i class="fa fa-edit"></i>', '') ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
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