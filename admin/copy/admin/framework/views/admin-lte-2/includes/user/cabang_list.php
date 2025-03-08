<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Cabang <small>Pulito</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=pengaturan&act=cabang_list') ?>">Data Cabang</a></li>      
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <?php if (isset($_GET['id'])) { ?>
                <div class="col-lg-4">
                    <?php echo form_open('page=pengaturan&act=cabang_update') ?>
                    <?php echo form_hidden('id', $this->input->get('id')) ?>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Form Data Cabang</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                <label class="control-label">Cabang</label>
                                <?php echo form_input(array('name' => 'nama', 'class' => 'form-control', 'value' => $user->keterangan)) ?>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info btn-flat pull-right">Update</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            <?php } ?>
            <div class="col-lg-<?php echo (isset($_GET['id']) ? '8' : '12') ?>">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Cabang</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('pengaturan') ?>
                        <table class="table table-striped todo-list ui-sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pulito</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($users as $user) { ?>
                                    <?php if ($user->id != '1') { ?>
                                        <tr>
                                            <td style="width: 15px; text-align: center;"><?php echo $no++ ?></td>
                                            <td><?php echo $user->keterangan ?></td>
                                            <td style="width: 15px; text-align: center;">
                                                <?php echo anchor('page=pengaturan&act=cabang_list&id=' . general::enkrip($user->id), '<i class="fa fa-edit"></i>', '') ?>
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