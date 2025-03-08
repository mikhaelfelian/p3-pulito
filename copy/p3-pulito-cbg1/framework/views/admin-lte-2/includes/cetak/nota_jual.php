<?php echo $this->session->flashdata('produk') ?>
<html>
    <head>
        <title>INVOICE</title>
        <style>
            @media  print {
                html, body {
                    width: 4.5in;
                    /*was 8.5in*/ 
                    /*height: 13cm; */
                    /*was 5.5in*/ 
                    display: block;
                    font-family: "Calibri";
                    /*font-size: 10pt; NOT A VALID PROPERTY */
                }

                @page  {
					width: 21cm;
                    height: 13cm;
                    padding: 1cm;
                    margin: 0cm 1.20cm;
					size:auto;
					/*size: 21cm 13cm;*/
					/*size: 11inch 4.5inch;
                    margin: 10;*/
                }

                #printPageButton {
                    display: none;
                }

                header, footer, aside, nav, form, iframe, .menu, .hero, .adslot {
                    display: none;
                }
                
                table.myFormat tr td { font-size: 5px; }
            }
        </style>
    </head>
    <body>
        <table border="0" style="width: 510px;" cellspacing="0">
            <tr>
                <th style="width: 255px; text-align: left; font-size: 11px;"><?php echo $penj->nama ?></th>
                <th style="font-size: 11px;"></th>
                <th style="width: 255px; text-align: left; font-size: 11px;"><?php echo $penj->alamat ?></th>
            </tr>
            <tr>
                <th style="width: 500px; text-align: center; font-size: 11px;" colspan="3">NOTA PEMESANAN</th>
            </tr>
            <tr>
                <th style="width: 255px; text-align: left; font-size: 11px;"><?php echo 'No.#'.$penj->no_nota.' '.$this->tanggalan->tgl_indo($penj->tgl_simpan) ?></th>
                <th style="font-size: 11px;"></th>
                <th style="width: 255px; text-align: left; font-size: 11px;"><?php echo 'Masuk: '.$this->tanggalan->tgl_indo($penj->tgl_masuk).' - Jadi: '.$this->tanggalan->tgl_indo($penj->tgl_keluar)?></th>
            </tr>
        </table>
        <!--=======================================================================================================-->
        <table border="0" style="width: 510px;" cellspacing="0">
            <tr>
                <!--<th style="text-align: left; width: 100px; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 14px;">Tanggal</th>-->
                <!--<th style="text-align: left; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 11px;">Item</th>-->
                <!--<th style="text-align: left; border-top: 1px dashed #000; border-bottom: 1px dashed #000;">Tgl</th>-->
                <th style="text-align: left; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 11px;">No</th>
                <th style="text-align: left; border-top: 1px dashed #000; border-bottom: 1px dashed #000; width: 250px;font-size: 11px;">Jenis</th>
                <th style="text-align: center; border-top: 1px dashed #000; border-bottom: 1px dashed #000; width: 450px; font-size: 11px;">Keterangan</th>
                <th style="text-align: right; border-top: 1px dashed #000; border-bottom: 1px dashed #000; width: 100px; font-size: 11px; width: 50px;">Disc</th>
                <th style="text-align: center; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 11px; width: 5px;">Jml</th>
                <th style="text-align: right; border-top: 1px dashed #000; border-bottom: 1px dashed #000; width: 100px; font-size: 11px; width: 50px;">Harga</th>
            </tr>
            <?php $no = 1; ?>
            <?php foreach ($penj_det as $sql_det){ ?>
                <tr>
                    <td style="text-align: left; font-size: 11px;"><?php echo $no; ?></td>
                    <td style="text-align: left; font-size: 11px;"><?php echo strtoupper($sql_det->produk)?></td>
                    <td style="text-align: center; font-size: 11px;"><?php echo str_replace(';',"\n",$sql_det->keterangan); ?></td>
                    <td style="text-align: right; font-size: 11px;"><?php echo ($sql_det->diskon != 0 ? number_format($sql_det->diskon,'0','.',',') : ''); ?></td>
                    <td style="text-align: center; font-size: 11px;"><?php echo ($sql_det->jml != 0 ? $sql_det->jml : ''); ?></td>
                    <td style="text-align: right; font-size: 11px;"><?php echo ($sql_det->harga != 0 ? number_format($sql_det->harga,'0','.',',') : ''); ?></td>
                </tr>
            <?php $no++; ?>
            <?php } ?>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold; font-size: 11px; border-top: 1px dashed #000;">PCS</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px; border-top: 1px dashed #000;">0</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px; border-top: 1px dashed #000;">TOTAL</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px; border-top: 1px dashed #000;"><?php echo number_format($penj->jml_total,'0','.',','); ?></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold; font-size: 11px;">DISKON</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo number_format($penj->jml_diskon,'0','.',','); ?></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold; font-size: 11px;">GRAND TOTAL</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo number_format($penj->jml_gtotal,'0','.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left; font-weight: normal; font-size: 11px;"><?php echo ($penj->cetak == '1' ? 'STORE COPY' : ''); ?></td>
                <td colspan="3" style="text-align: right; font-weight: bold; font-size: 11px;">JML BAYAR</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo number_format($penj->jml_bayar,'0','.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left; font-weight: normal; font-size: 11px;"><?php echo $this->ion_auth->user($penj->id_user)->row()->username.'@'.$pengaturan->keterangan; ?></td>
                <td colspan="3" style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo ($penj->jml_kurang > 0 ? 'KEKURANGAN' : ($penj->metode_bayar == 1 ? 'KEMBALIAN' : 'SALDO'))?></td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo ($penj->jml_kurang > 0 ? number_format($penj->jml_kurang,'0','.',',') : ($penj->metode_bayar == 1 ?  ($penj->jml_kembali == 0 ? '0,0' : number_format($penj->jml_kembali,'0','.',',')) : number_format($member_sal->jml_deposit,'0','.',','))); ?></td>
            </tr>
        </table>
        <br/>
        <button id="printPageButton" onclick="javascript:window.print()">Cetak</button>
    </body>
</html>