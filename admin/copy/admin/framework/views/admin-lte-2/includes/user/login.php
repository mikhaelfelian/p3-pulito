<div class="login-box">
    <div class="login-logo">
        <!--<img src="<?php echo base_url('assets/admin-lte-2/logo1.png') ?>" class="img-md img-rounded text-center">-->

        <a href="#" style="font-size: 75%; ">
            <b>Pulito</b> Backend
        </a>
    </div>
    <?php $err_msg = $this->session->flashdata('form_error') ?>
    <?php $msg = $this->session->flashdata('login') ?>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php echo (!empty($msg) ? $msg : '<p class="login-box-msg">Silahkan masuk, untuk melakukan transaksi</p>') ?>

        <!-- iCheck  -->
        <link rel="stylesheet" href="<?php echo base_url('./assets/admin-lte-2/plugins/iCheck/square/blue.css') ?>">
        <script src="<?php echo base_url('./assets/admin-lte-2/plugins/jQuery/jQuery-2.2.0.min.js') ?>"></script>
        <script src="<?php echo base_url('./assets/admin-lte-2/plugins/iCheck/icheck.min.js') ?>"></script>
        <script>
            var s = $.noConflict();
            s(function () {
                s('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });
            });
        </script>
        <?php echo form_open('page=login&act=cek_login') ?>
        <div class="form-group has-feedback <?php echo (!empty($err_msg['user']) ? 'has-error' : '') ?>">
            <?php echo form_input(array('name' => 'user', 'class' => 'form-control', 'placeholder' => 'Username ...', 'value' => $this->session->flashdata('user'))) ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback  <?php echo (!empty($err_msg['pass']) ? 'has-error' : '') ?>">
            <?php echo form_password(array('name' => 'pass', 'class' => 'form-control', 'placeholder' => 'Kata Sandi ...')) ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" value="ya" name="ingat"> Ingat Saya
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
            </div>
            <!-- /.col -->
        </div>
        <?php echo form_close() ?>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
