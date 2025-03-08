<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
                <!--<script src="<?php echo base_url('./assets/sb-admin') ?>/ui/jquery-2.1.4.min.js"></script>-->
        <script src="<?php echo base_url('./assets/sb-admin') ?>/ui/jquery.js"></script>
        <script src="<?php echo base_url('./assets/sb-admin') ?>/ui/jquery-ui.js"></script>
        <script src="<?php echo base_url('./assets/sb-admin') ?>/ui/autonumeric.js"></script>
        <link href="<?php echo base_url('./assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">
        <script src="<?php echo base_url('./assets/sb-admin') ?>/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>assets/raphael/raphael-min.js"></script>
        <script src="<?php echo base_url('./assets/sb-admin') ?>/morrisjs/morris.min.js"></script>

        <script type="text/javascript">
            var s = $.noConflict();
            s(function () {
                s('#tgl').datepicker({'dateFormat': 'yy-mm-dd'});

                Morris.Bar({
                    element: 'grap-penj-tahun',
                    data: <?php echo (!empty($graph_penj_thn) ? json_encode($graph_penj_thn) : '') ?>,
                    xkey: 'bulan',
                    ykeys: ['total'],
                    labels: ['Total'],
                    barRatio: 0.4,
                    xLabelAngle: 35,
                    hideHover: 'auto'
                });
            });
        </script>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php echo $this->session->flashdata('pesan') ?>
        </div>
    </div>
    <!-- /.row -->
    <?php echo br(2) ?>
    <div class="row">
        <?php foreach ($kategori1 as $kategori1) { ?>
            <div class="col-lg-3 col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <?php echo br(2) ?>                                   
                                <i class="fa fa-suitcase fa-5x"></i>
                                <?php echo br(2) ?>                              
                            </div>
                            <div class="col-xs-9 text-center">
                                <?php echo br(2) ?>                          
                                <div class="medium"><strong><?php echo strtoupper($kategori1->kategori) ?></strong></div>
                                <?php echo br(2) ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-xs-3">
                                <a href="<?php echo base_url('set_cart_temp.php?id_kat1='.general::enkrip($kategori1->id)) ?>">
                                    <div><button class="btn btn-primary">Pesan <i class="fa fa-arrow-right"></i></button></div>
                                </a>
                            </div>
                            <div class="col-xs-9 text-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
