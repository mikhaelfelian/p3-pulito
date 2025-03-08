
<!--    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-home"></i> Beranda</h1>
        </div>
    </div>-->
    <div class="row">        
        <div class="col-lg-12">
            <div class="panel panel-danger">
                <div class="panel-body">
                    <?php echo form_open('pesan/set_notif.php') ?>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group input-group">
                                <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control input-group', 'placeholder' => 'Masukkan tgl ...')) ?>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default form-horizontal"><i class="fa fa-search"></i></button>
                                </span>
                            </div>  
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group input-group">
                                <select name="sort_payment" class="form-control">
                                    <option value="">- Status Bayar -</option>
                                    <option value="paid">Lunas</option>
                                    <option value="unpaid">Belum</option>
                                </select>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default form-horizontal"><i class="fa fa-search"></i></button>
                                </span>
                            </div>  
                        </div>
                    </div>
                    <br/>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="tabel-order">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Nota</th>
                                    <th>Tgl Nota</th>
                                    <th>Pelanggan</th>
                                    <th style="text-align: center;">Status Bayar</th>
                                    <th style="text-align: center;">Ket</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($order)) {
                                    $no = 1;
                                    foreach ($order as $order) {
//                                        $bayar = ($order->tot_kembali < 0 ? 'Kekurangan '.general::format_number(str_replace(array('-'), '', $order->tot_kembali)) : general::status_byr($order->status_payment));
                                        $kurang = $order->tot_bayar - $order->jml_gtotal;
                                        $bayar = ($kurang < 0 ? 'Kekurangan Rp. ' . general::format_number(str_replace(array('-'), '', $order->tot_kurang)) : general::status_byr($order->status_payment));
                                        ?>
                                        <tr>
                                            <td><strong><?php echo $no ?>. </strong></td>
                                            <td class="text-left"><a href="<?php echo base_url('pesan/kasir.php?no_nota=' . $order->no_nota) ?>"><?php echo $order->no_nota ?></a></td>
                                            <td class="text-left"><?php echo $this->tanggalan->tgl_indo($order->tgl_pesan) ?></td>
                                            <td class="text-left"><?php echo $order->nama ?></td>
                                            <td class="text-left"><?php echo $bayar ?></td>
                                            <td class="text-left"><?php echo $order->ket ?></td>
                                        </tr>
                                    </tbody>
                                    <?php
                                    $no++;
                                }
                                ?>
                            </table>
                        <?php } ?>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>