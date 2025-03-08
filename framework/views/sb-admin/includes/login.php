<div class="container">    
    <?php $has_error = $this->session->flashdata('form_error'); ?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="margin-top: 10%;">            
            <?php echo $this->session->flashdata('login') ?>
        </div>
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default" style="margin-top: 0px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Login POS Aplikasi</h3>
                </div>
                <div class="panel-body">
                    <?php echo form_open('front/cek_login.php') ?>
                    <fieldset>
                        <div class="form-group <?php echo (empty($has_error['user']) ? '' : 'has-error') ?>">
                            <?php echo $has_error['user'] ?>
                            <?php echo form_input(array('name' => 'user', 'class' => 'form-control', 'placeholder' => 'Username ...', 'value' => $this->session->flashdata('user'))) ?>
                        </div>
                        <div class="form-group <?php echo (empty($has_error['pass']) ? '' : 'has-error') ?>">
                            <?php echo $has_error['pass'] ?>
                            <?php echo form_password(array('name' => 'pass', 'class' => 'form-control', 'placeholder' => 'Password ...')) ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_checkbox(array('name' => 'ingat', 'value' => 'TRUE')) ?> Ingat Saya
                        </div>
                        <!--<div class="img-thumbnail">-->
                        <?php // echo $image ?>
                        <!--</div>-->
                        <!--<br/>-->
                        <!--<br/>-->
                        <?php // echo form_input(array('name' => 'capjay', 'class' => 'form-control', 'placeholder' => 'Kode Captcha')) ?>
                        <!-- Change this to a button or input when using this as a form -->

                        <?php echo form_reset(array('value' => 'Batal', 'class' => 'btn btn-success')) ?>
                        <?php echo form_submit(array('value' => 'Masuk', 'class' => 'btn btn-success')) ?>
                    </fieldset>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>