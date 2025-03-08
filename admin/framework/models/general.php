<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jabatan
 *
 * @author Mike
 */
class general extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function status_bayar($status) {
        switch ($status) {
            case '0':
                $status = '<label class="label label-warning">Belum Bayar</label>';
                break;
            
            case '1':
                $status = '<label class="label label-success">Lunas</label>';
                break;
            
            case '2':
                $status = '<label class="label label-info">Kurang</label>';
                break;
        }
        return $status;
    }
    function status_bayar2($status) {
        switch ($status) {
            case '0':
                $status = 'Belum';
                break;
            
            case '1':
                $status = 'Lunas';
                break;
            
            case '2':
                $status = 'Kurang';
                break;
        }
        return $status;
    }
    
    function status_diskon($status) {
        switch ($status) {
            case '0':
                $status = '<label class="label label-warning">Item</label>';
                break;
            
            case '1':
                $status = '<label class="label label-primary">Global</label>';
                break;
        }
        return $status;
    }
    
    function status_nota($status) {
        switch ($status) {
            case '0':
                $status = '<label class="label label-warning">Waiting</label>';
                break;
            
            case '1':
                $status = '<label class="label label-primary">Pending</label>';
                break;
            
            case '2':
                $status = '<label class="label label-success">Approve</label>';
                break;
        }
        return $status;
    }
    
    function metode_bayar($status) {
        switch ($status) {            
            case '2':
                $status = 'Deposit';
                break;
            
            case '1':
                $status = 'Tunai';
                break;
            
            case '0':
                $status = '-';
                break;
        }
        return $status;
    }
    
    function tipe_lokasi($status) {
        switch ($status) {            
            case '1':
                $status = 'RAK';
                break;
            
            case '2':
                $status = 'GANTUNGAN';
                break;
        }
        return $status;
    }
    
    function tipe_pengeluaran($status) {
        switch ($status) {
            case '0':
                $status = 'Kas';
                break;
            
            case '1':
                $status = 'Kasbon';
                break;
            
            case '2':
                $status = 'Transfer';
                break;
            
            case '3':
                $status = 'Operasional';
                break;
        }
        return $status;
    }
    
    function status_dep($status) {
        switch ($status) {
            case '0':
                $status = 'Non Aktif';
                break;

            case '1':
                $status = 'Aktif';
                break;
        }
        return $status;
    }
    
    function status_byr($status) {
        switch ($status) {
            case 'paid':
                $status = 'Lunas';
                break;

            case 'unpaid':
                $status = 'Belum Bayar';
                break;
        }
        return $status;
    }
    
    function status_byr_met($status) {
        switch ($status) {
            case 'cash':
                $status = 'Kas';
                break;

            case 'credit':
                $status = 'Kartu Kredit';
                break;

            case 'debet':
                $status = 'Kartu Debet';
                break;

            case 'lain':
                $status = 'Lainnya';
                break;
        }
        return $status;
    }
    
    function status_posting_buku($status) {
        switch ($status) {
            case '0':
                $status = 'Nonaktif';
                break;

            case '1':
                $status = 'Aktif';
                break;
        }
        return $status;
    }
        
    function no_nota($string,$tabel_nama, $tabel_kolom, $where) {
        $pengaturan = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
        $kode       = $this->db->query("SELECT MAX(".$tabel_kolom.") as no_nota FROM ".$tabel_nama.(isset($where) ? ' WHERE '.$where : ''))->row();
        $char       = $string; // Total String Nota
        $pjg_char   = strlen($char); // Itung panjang Notanya
        $noUrut     = (int) substr($kode->no_nota, $pjg_char, 5); // Incriment Numbering nota
        $noUrut++;
        
        $IDbaru     = sprintf("%05s", $noUrut);        
        return $IDbaru;
    }
        
    function random_kode($string,$tabel_nama, $tabel_kolom) {
        $kode       = $this->db->query("SELECT MAX(".$tabel_kolom.") as no_nota FROM ".$tabel_nama)->row();
        $char       = $string."."; // Total String Nota
        $pjg_char   = strlen($char); // Itung panjang Notanya
        $noUrut     = (int) substr($kode->no_nota, $pjg_char, 5); // Incriment Numbering nota
        $noUrut++;
        
        $IDbaru     = $char . sprintf("%05s", $noUrut);        
        return $IDbaru;
    }
        
    function jns_klm($jenis) {
        switch ($jenis){
            case 'L':
                $jns_klm = 'Laki-laki';
            break;
            case 'P':
                $jns_klm = 'Perempuan';
            break;
            case 'O':
                $jns_klm = 'Lainnya';
            break;
        }
        return $jns_klm;
    }
    
    function tgl_indo($string) {
        $rumus = $this->tanggalan->tgl_indo($string);        
        return $rumus;
    }
    
    function enkrip($string) {
        $rumus = $this->encrypt->encode_url($string);        
        return $rumus;
    }
    
    function dekrip($string) {
        $rumus = $this->encrypt->decode_url($string);        
        return $rumus;
    }
    
    function waktu_post($data) {
        $original = strtotime($data);
        $chunks = array(
            array(60 * 60 * 24 * 365, 'tahun'),
            array(60 * 60 * 24 * 30, 'bulan'),
            array(60 * 60 * 24 * 7, 'minggu'),
            array(60 * 60 * 24, 'hari'),
            array(60 * 60, 'jam'),
            array(60, 'menit'),
        );

        $today = time();
        $since = $today - $original;

        if ($since > 604800) {
//            $print = date("M jS", $original);
            $print  =  $this->tanggalan->tgl_indo(date('Y-m-d', $original));
            
            if ($since > 31536000) {
                $print .= ", " . date("Y", $original);
            }
            return $print;
        }

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name    = $chunks[$i][1];

            if (($count = floor($since / $seconds)) != 0)
                break;
        }

        $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
        return $print . ' yang lalu';
    }
    
    function format_angka($str){
        $string = number_format($str,0,',','.');
        return $string;
    }
}