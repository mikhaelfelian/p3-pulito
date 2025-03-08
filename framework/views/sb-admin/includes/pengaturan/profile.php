<?php $user    = $this->ion_auth->user()->row(); ?>
<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-gear"></i> Pengaturan</h1>
        </div>        
        <!-- /.col-lg-2 -->
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Ganti Password</h3>
                </div>
                <div class="panel-body">
                    <?php echo form_open('user/s_setting.php') ?>
                    <label>Nama</label>
                    <?php echo form_input(array('name'=>'nama','class'=>'form-control','value'=>$user->first_name)) ?>
                    <label>Username</label>
                    <?php echo form_input(array('name'=>'username','class'=>'form-control','value'=>$user->username)) ?>
                    <label>Kata Sandi Baru</label>
                    <?php echo form_password(array('name'=>'pass1','class'=>'form-control')) ?>
                    <label>Ulang Kata Sandi</label>
                    <?php echo form_password(array('name'=>'pass2','class'=>'form-control')) ?>
                    <?php echo br() ?>
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Profile Login</h3>
                </div>
                <div class="panel-body">
                    <?php echo form_open('user/prof_save.php') ?>
                    <label>Nama</label>
                    <?php echo form_input(array('name'=>'nama','value'=>$user->nama,'class'=>'form-control')) ?>
                    <label>Username</label>
                    <?php echo form_input(array('name'=>'username','value'=>$user->username,'class'=>'form-control')) ?>
                    <?php echo br() ?>
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->
    <!-- /.row -->
</div>
