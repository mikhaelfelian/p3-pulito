<?php if (!empty($menu)) { ?>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">                                
                        <div class="col-xs-9">
                            <h2 class="panel-title"><i class="fa fa-cutlery"></i> Dapur</h2>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <?php foreach ($menu as $item) { ?>
                            <tr>
                                <td><span class="fa fa-check"></span></td>
                                <td><?php echo $item->menu . ' x ' . $item->jml . nbs(6) ?></td>
                                <td><?php echo ' x ' . $item->jml . nbs(6) ?></td>
                            </tr>
                            <tr>
                                <td><?php echo nbs() ?></td>
                                <td colspan="3"><?php echo (!empty($item->keterangan) ? "* " . $item->keterangan : '-'); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <a href="<?php echo base_url('pesan/cetak_dapur.php?module=dapur&id='.$_GET['id'].'&nota='.$_GET['nota'].'&no_meja='.$_GET['no_meja'].'&status='.$_GET['status'].'&no_nota='.$_GET['no_nota']) ?>"><button class="btn btn-primary"><i class="fa fa-print"></i> Cetak ke dapur</button></a> 
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">                                
                        <div class="col-xs-9">
                            <h2 class="panel-title"><i class="fa fa-check"></i> Checker</h2>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <?php foreach ($menu as $item) { ?>
                            <tr>
                                <td><span class="fa fa-check"></span></td>
                                <td><?php echo $item->menu . ' x ' . $item->jml . nbs(6) ?></td>
                                <td><?php echo ' x ' . $item->jml . nbs(6) ?></td>
                            </tr>
                            <tr>
                                <td><?php echo nbs() ?></td>
                                <td colspan="3"><?php echo (!empty($item->keterangan) ? "* " . $item->keterangan : '-'); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <a href="<?php echo base_url('pesan/cetak_checker.php?module=dapur&id='.$_GET['id'].'&nota='.$_GET['nota'].'&no_meja='.$_GET['no_meja'].'&status='.$_GET['status'].'&no_nota='.$_GET['no_nota']) ?>"><button class="btn btn-primary"><i class="fa fa-print"></i> Cetak checker</button></a> 
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">                                
                        <div class="col-xs-9">
                            <h2 class="panel-title"><i class="fa fa-check-circle"></i> Bill</h2>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <?php foreach ($menu as $item) { ?>
                            <tr>
                                <td><span class="fa fa-check"></span></td>
                                <td><?php echo $item->menu . ' x ' . $item->jml . nbs(6) ?></td>
                                <td><?php echo ' = ' . general::format_number($item->harga) . nbs(6) ?></td>
                            </tr>
                            <tr>
                                <td><?php echo nbs() ?></td>
                                <td colspan="3"><?php echo (!empty($item->keterangan) ? "* " . $item->keterangan : '-'); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <a href="<?php echo base_url('pesan/cetak_bill.php?module=dapur&id='.$_GET['id'].'&nota='.$_GET['nota'].'&no_meja='.$_GET['no_meja'].'&status='.$_GET['status'].'&no_nota='.$_GET['no_nota']) ?>"><button class="btn btn-primary"><i class="fa fa-print"></i> Cetak Bill</button></a> 
                </div>
            </div>
        </div>
        
    </div>
<?php } ?>