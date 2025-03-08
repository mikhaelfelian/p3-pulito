<!DOCTYPE html>
<html>
    <head>
        <title>NGSPECIALIST</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body onload="window.print()">
        <?php $tgl = explode('-', $penj->tgl_simpan) ?>
        <?php echo $penj_plat->platform.' - '.$penj_plat->keterangan.'<br/>'; ?>
        <?php echo (akses::hakGudang() == TRUE ? '<b>[GUDANG]</b>' : '<b>[SALES]</b>') ?>  
        <?php echo $this->ion_auth->user($penj->id_user)->row()->first_name ?> | 
        #<?php echo $penj->no_nota.' - '.$tgl[2].'/'.$tgl[1].'/'.$tgl[0] ?>
        <table border="1" width="400px" cellpadding="2" cellspacing="0">
            <thead>
                <tr>
                    <th width="250px">Kode</th>
                    <th width="150px">Subtotal</th>
                    <th width="150px">Sales</th>
                    <th width="150px">Gudang</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($penj_det)) {
                    $no = 1;
                    foreach ($penj_det as $penj) {
                        ?>                
                        <tr>
                            <td style="height: 50px;"><?php echo $penj->kode ?></td>
                            <td style="text-align: right;"><?php echo general::format_angka($penj->subtotal) ?> </td>
                            <td style="height: 50px;"><?php echo $penj->id_user ?></td>
                            <td style="height: 50px;"><?php echo $penj->id_gudang ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </body>
</html>
