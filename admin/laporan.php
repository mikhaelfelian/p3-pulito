<?php
/**
 * Description of laporan
 *
 * @author User
 */

class laporan extends CI_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
        $this->load->library('fpdf');
        $this->load->library('excel/PHPExcel');
    }
    
    public function data_penjahit(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['penjahit'] = $this->db->order_by('id','desc')->get('tbl_m_penjahit')->result();
                    break;
                
                case 'nama':
                    $data['penjahit'] = $this->db->where('id',$_GET['query'])->order_by('id','desc')->get('tbl_m_penjahit')->result();
                    break;
                
                case 'per_tanggal':
                    $data['penjahit'] = $this->db->where('tgl_simpan',$_GET['tgl'])->order_by('id','desc')->get('tbl_m_penjahit')->result();
                    break;
                
                case 'per_rentang':
                    $data['penjahit'] = $this->db->query("SELECT * FROM tbl_m_penjahit WHERE tgl_simpan BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    break;
            }
            
            $data['nm_penjahit'] = $this->db->get('tbl_m_penjahit')->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_penjahit', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_produk(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['produk'] = $this->db->select('id, id_penjahit, DATE(tgl_simpan) as tgl_simpan, kode, produk, jml_awal, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, status_stok, lama_pengerjaan, insentif')->order_by('id','desc')->get('tbl_m_produk')->result();
                    break;
                
                case 'per_tanggal':
                    $data['produk'] = $this->db->select('id, id_penjahit, DATE(tgl_simpan) as tgl_simpan, kode, produk, jml_awal, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, status_stok, lama_pengerjaan, insentif')->where('DATE(tgl_simpan)',$_GET['tgl'])->order_by('id','desc')->get('tbl_m_produk')->result();
                    break;
                
                case 'per_rentang':
                    $data['produk'] = $this->db->query("SELECT id, id_penjahit, DATE(tgl_simpan) as tgl_simpan, kode, produk, jml_awal, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, status_stok, lama_pengerjaan, insentif FROM tbl_m_produk WHERE DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_produk', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_penjualan(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe  = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            
            $case      = $this->input->get('case');
//            $where     = ($_GET['sb'] == 'x' ? "(tbl_trans_jual.status_bayar LIKE '%%')" : "(tbl_trans_jual.status_bayar ".($_GET['sb'] == 0 ? "NOT LIKE '1'" : "LIKE '".$_GET['sb']."'").")");
//            switch ($case){
//                case 'semua':
//                    if (!empty($sales)) {
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                        ->like('metode_bayar', $tipe)
//                                        ->where('id_user', $sales)
//                                        ->where($where)
//                                        ->order_by('no_nota', 'desc')
//                                        ->get('tbl_trans_jual')->result();
//                    } else {
//                        if($_GET['tipe'] == '0'){
//                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                        ->where($where)                                        
//                                        ->order_by('no_nota', 'desc')
//                                        ->get('tbl_trans_jual')->result();
//                        }else{
//                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                        ->where($where)
//                                        ->like('metode_bayar', $tipe)
//                                        ->order_by('no_nota', 'desc')
//                                        ->get('tbl_trans_jual')->result();
//                            
//                        }
//                    }
//                    break;
//                
//                case 'cabang':
//                    if($tipe == '0'){
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where($where)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
//                        
//                    }else{
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where($where)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
//                    }
//                    break;
//                
//                case 'per_tanggal':
//                    if($tipe == '0'){
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
//                                             ->where($where)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
//                        
//                    }else{
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
//                                             ->where($where)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
//                    }
//                    break;
//                
//                case 'per_rentang':
//                    if($tipe == '0'){
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
//                                             ->where($where)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
//                        
//                    }else{
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
//                                             ->where($where)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
//                    }
//                    break;
//                
//                case 'per_sales':
//                    if($tipe == '0'){
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('tbl_trans_jual.id_user', $sales)
//                                             ->where($where)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
//                        
//                    }else{
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('tbl_trans_jual.id_user', $sales)
//                                             ->where($where)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
//                    }
//                    break;
//            }
            
            $where     = ($_GET['sb'] == 'x' ? "(tbl_trans_jual.status_bayar LIKE '%%')" : "(tbl_trans_jual.status_bayar ".($_GET['sb'] == 0 ? "NOT LIKE '1'" : "LIKE '".$_GET['sb']."'").")");
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->where($where)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->where($where)                                        
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->where($where)
                                        ->like('metode_bayar', $tipe)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where($where)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }

            $data['sales'] = $this->ion_auth->users()->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_penjualan', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_penjualan_det(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe  = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            
            $case      = $this->input->get('case');
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->group_by('tbl_trans_jual_det.produk')
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->group_by('tbl_trans_jual_det.produk')
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->group_by('tbl_trans_jual_det.produk')
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, , SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
                        $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, , SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->where('DATE(tbl_trans_jual_det.tgl_simpan)', $kueri)
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
                        $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, , SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, , SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }

            $data['sales'] = $this->ion_auth->users()->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_penjualan_det', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_penjualan_det2(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe  = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            
            $case      = $this->input->get('case');
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, tbl_trans_jual_det.jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, tbl_trans_jual_det.jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
                        $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, , SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }

            $data['sales'] = $this->ion_auth->users()->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_penjualan_det', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_keuangan(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe  = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            
            $case      = $this->input->get('case');
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
                        $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->where('status_bayar !=', '0')
                                             ->where('jml_bayar >', '0')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->where('status_bayar !=', '0')
                                             ->where('jml_bayar >', '0')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
                        $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar !=', '0')
                                             ->where('jml_bayar >', '0')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar !=', '0')
                                             ->where('jml_bayar >', '0')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }                    
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar !=', '0')
                                             ->where('jml_bayar >', '0')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['keuangan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar !=', '0')
                                             ->where('jml_bayar >', '0')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }

            $data['sales'] = $this->ion_auth->users()->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_keuangan', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_packing(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe  = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            
            $case      = $this->input->get('case');
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        if(!empty($tgl_awal) && !empty($tgl_akhir)){
                            $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, tbl_trans_jual_det.produk, SUM(tbl_trans_jual_det.jml) as jml')
                                            ->join('tbl_trans_jual', 'tbl_trans_jual.id=tbl_trans_jual_det.id_penjualan')
                                            ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                            ->where('tbl_trans_jual_det.id_kategori2', '0')
                                            ->where('tbl_trans_jual_det.harga', '0')
                                            ->where('tbl_trans_jual_det.status_brg', '1')
                                            ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                            ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                            ->like('tbl_trans_jual.id_app', $cabang)
                                            ->like('tbl_trans_jual.id_user', $sales)
                                            ->group_by('tbl_trans_jual_det.produk', 'desc')
                                            ->get('tbl_trans_jual_det')->result();
                        }else{
                            $data['penjualan'] = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, tbl_trans_jual_det.produk, SUM(tbl_trans_jual_det.jml) as jml')
                                            ->join('tbl_trans_jual', 'tbl_trans_jual.id=tbl_trans_jual_det.id_penjualan')
                                            ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                            ->where('tbl_trans_jual_det.id_kategori2', '0')
                                            ->where('tbl_trans_jual_det.harga', '0')
                                            ->where('tbl_trans_jual_det.status_brg', '1')
                                            ->like('tbl_trans_jual.id_app', $cabang)
                                            ->like('tbl_trans_jual.id_user', $sales)
                                            ->group_by('tbl_trans_jual_det.produk', 'desc')
                                            ->get('tbl_trans_jual_det')->result();
                        }
                        
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
//                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
					/*
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_keluar)', $kueri)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_keluar)', $kueri)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
					*/
					
                    $data['penjualan'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, produk, jml')
												  ->where('status_brg', '1')
												  ->where('DATE(tbl_trans_jual_det.tgl_simpan)', $kueri)
												  ->get('tbl_trans_jual_det')->result(); 
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_keluar) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_keluar) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_keluar) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_keluar) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $data['penjualan'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_keluar) as tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }

            $data['sales'] = $this->ion_auth->users()->result();
			
			//echo '<pre>';
			//print_r($data['penjualan']);
            //echo '</pre>';
			
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_penjualan_packing', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_member(){
        if (akses::aksesLogin() == TRUE) {
            $nik  = $this->input->get('nik');
            $nama = $this->input->get('nama');

            $data['member'] = $this->db->select('id, DATE(tgl_simpan) as tgl_simpan, kode, nik, nama, alamat, no_hp, id_app')->like('nik', $nik)->like('nama', $nama)->get('tbl_m_pelanggan')->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_member', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_deposit(){
        if (akses::aksesLogin() == TRUE) {
            $nik  = $this->input->get('nik');
            $nama = $this->input->get('nama');

            $data['member'] = $this->db
                                   ->select('tbl_m_pelanggan.id, DATE(tbl_m_pelanggan.tgl_simpan) as tgl_simpan, tbl_m_pelanggan.kode, tbl_m_pelanggan.nik, tbl_m_pelanggan.nama, tbl_m_pelanggan.alamat, tbl_m_pelanggan_deposit.jml_deposit')
                                   ->join('tbl_m_pelanggan_deposit', 'tbl_m_pelanggan_deposit.id_pelanggan=tbl_m_pelanggan.id')
                                   ->like('tbl_m_pelanggan.nik', $nik)
                                   ->like('tbl_m_pelanggan.nama', $nama)
                                   ->get('tbl_m_pelanggan')->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_member_dep', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_insentif(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['insentif'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user')
                        ->where('status_nota >=','1')
                        ->order_by('no_nota','desc')
                        ->get('tbl_trans_jual')->result();
                    break;
                
                case 'sales':
                    $data['insentif'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user')
                        ->where('status_nota >=','1')
                        ->where('id_user',$_GET['query'])
                        ->order_by('no_nota','desc')
                        ->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_tanggal':
                    $data['insentif'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user')
                        ->where('status_nota >=','1')
                        ->where('DATE(tgl_simpan)',$_GET['query'])
                        ->order_by('no_nota','desc')
                        ->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_rentang':
                    $data['insentif'] = $this->db->query("SELECT no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user FROM tbl_trans_jual WHERE status_nota >='2' AND DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    break;
            }

            $data['sales'] = $this->ion_auth->users()->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_insentif', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_pemasukan(){
        if (akses::aksesLogin() == TRUE) {
            $case   = $this->input->get('case');
            $status = $this->input->get('status');
            
            switch ($case){
                case 'semua':
                    if($status == 'semua'){
                       $data['pemasukan'] = $this->db
                           ->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $data['pemasukan'] = $this->db
                           ->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('status_kas',$status)
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_tanggal':
                    if($status == 'semua'){
                       $data['pemasukan'] = $this->db
                           ->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('DATE(tgl)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $data['pemasukan'] = $this->db
                           ->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_rentang':
//                    $data['pemasukan'] = $this->db->query("SELECT kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis FROM tbl_akt_kas WHERE tipe='masuk' AND DATE(tgl) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."' ORDER BY id DESC")->result();
                    if($status == 'semua'){
                       $data['pemasukan'] = $this->db
                           ->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('DATE(tgl) >',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) <',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $data['pemasukan'] = $this->db
                           ->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) =<',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_pemasukan', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_pengeluaran(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');            
            $status = $this->input->get('status');
            
            switch ($case){
                case 'semua':
                    if($status == 'semua'){
                       $data['pengeluaran'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $data['pengeluaran'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('status_kas',$status)
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_tanggal':
                    if($status == 'semua'){
                       $data['pengeluaran'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('DATE(tgl)',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $data['pengeluaran'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_rentang':
                    if($status == 'semua'){
                       $data['pengeluaran'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('DATE(tgl) >',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) <',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $data['pengeluaran'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) =<',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_pengeluaran', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_kas(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');            
            $status = $this->input->get('status');
            
            switch ($case){
                case 'semua':
                    if($status == 'semua'){
                       $data['sql'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }else{
                       $data['sql'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('status_kas',$status)
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_tanggal':
                    if($status == 'semua'){
                       $data['sql'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('DATE(tgl)',$this->input->get('tgl_akhir'))
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }else{
                       $data['sql'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl)',$this->input->get('query'))
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_rentang':
                    if($status == 'semua'){
                       $data['sql'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('DATE(tgl) >',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) <',$this->input->get('tgl_akhir'))
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }else{
                       $data['sql'] = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) =<',$this->input->get('tgl_akhir'))
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_kas', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_piutang(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['penjualan'] = $this->db
                        ->select('tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual_plat.id_platform, tbl_trans_jual_plat.keterangan as platform, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.jml_ongkir, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user')
                        ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.no_nota=tbl_trans_jual.no_nota')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->where('tbl_trans_jual.status_bayar','0')
                        ->order_by('tbl_trans_jual.no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'sales':
                    $data['penjualan'] = $this->db
                        ->select('tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual_plat.id_platform, tbl_trans_jual_plat.keterangan as platform, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.jml_ongkir, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user')
                        ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.no_nota=tbl_trans_jual.no_nota')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->where('tbl_trans_jual.status_bayar','0')
                        ->where('tbl_trans_jual.id_user',$this->input->get('query'))
                        ->order_by('tbl_trans_jual.no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_tanggal':
                    $data['penjualan'] = $this->db
                        ->select('tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual_plat.id_platform, tbl_trans_jual_plat.keterangan as platform, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.jml_ongkir, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user')
                        ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.no_nota=tbl_trans_jual.no_nota')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->where('tbl_trans_jual.status_bayar','0')
                        ->where('DATE(tbl_trans_jual.tgl_simpan)',$this->input->get('query'))
                        ->order_by('tbl_trans_jual.no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_rentang':
//                    $data['penjualan'] = $this->db->query("SELECT no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar FROM tbl_trans_jual WHERE DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    
                    $data['penjualan'] = $this->db
                        ->select('tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual_plat.id_platform, tbl_trans_jual_plat.keterangan as platform, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.jml_ongkir, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user')
                        ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.no_nota=tbl_trans_jual.no_nota')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->where('tbl_trans_jual.status_bayar','0')
                        ->where('DATE(tbl_trans_jual.tgl_simpan) >',$this->input->get('tgl_awal'))
                        ->where('DATE(tbl_trans_jual.tgl_simpan) <',$this->input->get('tgl_akhir'))
                        ->order_by('tbl_trans_jual.no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
            }

            $data['sales'] = $this->ion_auth->users()->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_piutang', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_lr(){
        if (akses::aksesLogin() == TRUE) {
            /*
             * Laporan data LR
             * Update 170520170931
             */
            
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    /* ----- Penjualan ----- */
                    $data['penjualan'] = $this->db
                        ->select('SUM(jml_gtotal) as jml_gtotal')
                        ->where('status_nota >','0')
                        ->get('tbl_trans_jual')->row();
                    /* ----- End of Penjualan ----- */
                    
                    /* ----- Operasional Kas ----- */
                    $data['op_kas'] = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->get('tbl_akt_kas')->row();
                    
                    $data['op_kas_det'] = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->get('tbl_akt_kas')->result();
                    /* ----- End Operasional Kas ----- */
                    
                    /* ----- Operasional Bank ----- */
                    $data['op_bank'] = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->get('tbl_akt_kas')->row();
                    
                    $data['op_bank_det'] = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->get('tbl_akt_kas')->result();
                    /* ----- Operasional of Bank ----- */
                    
                    /* ----- HPP ----- */
                    $data['hpp'] = $this->db
                        ->select('SUM(tbl_m_produk.harga_beli) as harga_beli, SUM(tbl_trans_jual_det.jml) as jml')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->join('tbl_trans_jual_det','tbl_trans_jual_det.no_nota=tbl_trans_jual.no_nota')
                        ->join('tbl_m_produk','tbl_m_produk.id=tbl_trans_jual_det.id_produk')
                        ->get('tbl_trans_jual')->row();
                    /* ----- End of HPP ----- */
                    
                    /* ----- LR ----- */
                    $data['lr'] = $data['penjualan']->jml_gtotal - ($data['hpp']->harga_beli + $data['op_kas']->nominal + $data['op_bank']->nominal);
                    /* ----- End of LR ----- */
                    break;
                
                case 'per_tanggal':
                    $data['penjualan'] = $this->db
                        ->select('SUM(jml_gtotal) as jml_gtotal')
                        ->where('status_nota >','0')
                        ->where('DATE(tgl_simpan)',$this->input->get('query'))
                        ->get('tbl_trans_jual')->row();
                    
                    
                    $data['op_kas'] = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->where('DATE(tgl)',$this->input->get('query'))
                        ->get('tbl_akt_kas')->row();
                    
                    $data['op_kas_det'] = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->where('DATE(tgl)',$this->input->get('query'))
                        ->get('tbl_akt_kas')->result();
                    
                    
                    $data['op_bank'] = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->where('DATE(tgl)',$this->input->get('query'))
                        ->get('tbl_akt_kas')->row();
                    
                    $data['op_bank_det'] = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->where('DATE(tgl)',$this->input->get('query'))
                        ->get('tbl_akt_kas')->result();
                    
                    
                    $data['hpp'] = $this->db
                        ->select('SUM(tbl_m_produk.harga_beli) as harga_beli, SUM(tbl_trans_jual_det.jml) as jml')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->where('DATE(tbl_trans_jual.tgl_simpan)',$this->input->get('query'))
                        ->join('tbl_trans_jual_det','tbl_trans_jual_det.no_nota=tbl_trans_jual.no_nota')
                        ->join('tbl_m_produk','tbl_m_produk.id=tbl_trans_jual_det.id_produk')
                        ->get('tbl_trans_jual')->row();
                    
                    $data['lr'] = $data['penjualan']->jml_gtotal - ($data['hpp']->harga_beli + $data['op_kas']->nominal + $data['op_bank']->nominal);
                    break;
                
                case 'per_rentang':
                    $data['penjualan'] = $this->db
                        ->select('SUM(jml_gtotal) as jml_gtotal')
                        ->where('status_nota >','0')
                        ->where('DATE(tgl_simpan) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl_simpan) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_trans_jual')->row();
                    
                    
                    $data['op_kas'] = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_akt_kas')->row();
                    
                    $data['op_kas_det'] = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_akt_kas')->result();
                    
                    
                    $data['op_bank'] = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_akt_kas')->row();
                    
                    $data['op_bank_det'] = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_akt_kas')->result();
                    
                    
                    $data['hpp'] = $this->db
                        ->select('SUM(tbl_m_produk.harga_beli) as harga_beli, SUM(tbl_trans_jual_det.jml) as jml')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->where('DATE(tbl_trans_jual.tgl_simpan) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tbl_trans_jual.tgl_simpan) <=',$this->input->get('tgl_akhir'))
                        ->join('tbl_trans_jual_det','tbl_trans_jual_det.no_nota=tbl_trans_jual.no_nota')
                        ->join('tbl_m_produk','tbl_m_produk.id=tbl_trans_jual_det.id_produk')
                        ->get('tbl_trans_jual')->row();
                    
                    $data['lr'] = $data['penjualan']->jml_gtotal - ($data['hpp']->harga_beli + $data['op_kas']->nominal + $data['op_bank']->nominal);
                    break;
            }

            $data['sales'] = $this->ion_auth->users()->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_lr', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function data_modal(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');            
            $status = $this->input->get('status');
            
            switch ($case){
                case 'semua':
                    if($status == 'semua'){
                       $data['modal'] = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }else{
                       $data['modal'] = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }
                    break;
                
                case 'per_tanggal':
                    if($status == 'semua'){
                       $data['modal'] = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           ->where('DATE(tgl_simpan)',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }else{
                       $data['modal'] = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           ->where('DATE(tgl_simpan)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }
                    break;
                
                case 'per_rentang':
                    if($status == 'semua'){
                       $data['modal'] = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           ->where('DATE(tgl_simpan) >',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl_simpan) <',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }else{
                       $data['modal'] = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           ->where('DATE(tgl_simpan) >=',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl_simpan) =<',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_data_modal', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    
    
    public function penjahit_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['penjahit'] = $this->db->order_by('id','desc')->get('tbl_m_penjahit')->result();
                    break;
                
                case 'per_tanggal':
                    $data['penjahit'] = $this->db->where('tgl_simpan',$_GET['tgl'])->order_by('id','desc')->get('tbl_m_penjahit')->result();
                    break;
                
                case 'per_rentang':
                    $data['penjahit'] = $this->db->query("SELECT * FROM tbl_m_penjahit WHERE tgl_simpan BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function produk_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['produk'] = $this->db->select('id, id_penjahit, DATE(tgl_simpan) as tgl_simpan, kode, produk, jml_awal, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, status_stok, lama_pengerjaan, insentif')->order_by('id','desc')->get('tbl_m_produk')->result();
                    break;
                
                case 'per_tanggal':
                    $data['produk'] = $this->db->select('id, id_penjahit, DATE(tgl_simpan) as tgl_simpan, kode, produk, jml_awal, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, status_stok, lama_pengerjaan, insentif')->where('DATE(tgl_simpan)',$_GET['tgl'])->order_by('id','desc')->get('tbl_m_produk')->result();
                    break;
                
                case 'per_rentang':
                    $data['produk'] = $this->db->query("SELECT id, id_penjahit, DATE(tgl_simpan) as tgl_simpan, kode, produk, jml_awal, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, status_stok, lama_pengerjaan, insentif FROM tbl_m_produk WHERE DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function penjualan_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['penjualan'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function penjualan_det_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['penjualan'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_det_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function keuangan_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['penjualan'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf_keuangan', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function packing_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['penjualan'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf_packing', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function member_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['penjualan'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf_member', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function deposit_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['penjualan'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf_member_dep', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function insentif_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['insentif'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user')->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_tanggal':
                    $data['insentif'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user')->where('DATE(tgl_simpan)',$_GET['query'])->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_rentang':
                    $data['insentif'] = $this->db->query("SELECT no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user FROM tbl_trans_jual WHERE DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pemasukan_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['pemasukan'] = $this->db->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis')->where('tipe','masuk')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    break;
                
                case 'per_tanggal':
                    $data['pemasukan'] = $this->db->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis')->where('tipe','masuk')->where('DATE(tgl)',$_GET['query'])->order_by('id','desc')->get('tbl_akt_kas')->result();
                    break;
                
                case 'per_rentang':
                    $data['pemasukan'] = $this->db->query("SELECT kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis FROM tbl_akt_kas WHERE tipe='masuk' AND DATE(tgl) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."' ORDER BY id DESC")->result();
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pengeluaran_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['pengeluaran'] = $this->db->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis')->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    break;
                
                case 'per_tanggal':
                    $data['pengeluaran'] = $this->db->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis')->where('tipe','keluar')->where('DATE(tgl)',$_GET['query'])->order_by('id','desc')->get('tbl_akt_kas')->result();
                    break;
                
                case 'per_rentang':
                    $data['pengeluaran'] = $this->db->query("SELECT kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis FROM tbl_akt_kas WHERE tipe='keluar' AND DATE(tgl) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."' ORDER BY id DESC")->result();
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function kas_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['kas'] = $this->db->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis')->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    break;
                
                case 'per_tanggal':
                    $data['kas'] = $this->db->select('kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis')->where('tipe','keluar')->where('DATE(tgl)',$_GET['query'])->order_by('id','desc')->get('tbl_akt_kas')->result();
                    break;
                
                case 'per_rentang':
                    $data['kas'] = $this->db->query("SELECT kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis FROM tbl_akt_kas WHERE tipe='keluar' AND DATE(tgl) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."' ORDER BY id DESC")->result();
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }

    public function piutang_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $data['penjualan'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar')->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_tanggal':
                    $data['penjualan'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar')->where('DATE(tgl_simpan)',$_GET['query'])->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_rentang':
                    $data['penjualan'] = $this->db->query("SELECT no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar FROM tbl_trans_jual WHERE DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    break;
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }

    public function lr_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['penjualan'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }

    public function modal_pdf(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['penjualan'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/laporan/lap_v_pdf', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_penjahit(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $sql = $this->db->order_by('id','desc')->get('tbl_m_penjahit')->result();
                    break;
                
                case 'nama':
                    $sql = $this->db->where('id',$_GET['query'])->order_by('id','desc')->get('tbl_m_penjahit')->result();
                    break;
                
                case 'per_tanggal':
                    $sql = $this->db->where('tgl_simpan',$_GET['tgl'])->order_by('id','desc')->get('tbl_m_penjahit')->result();
                    break;
                
                case 'per_rentang':
                    $sql = $this->db->query("SELECT * FROM tbl_m_penjahit WHERE tgl_simpan BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    break;
            }
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul   = "LAPORAN DATA PENJAHIT";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


//          Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(6, .5, 'Nama Penjahit', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Jml Produksi', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(9, .5, 'Keterangan', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                foreach ($sql as $penjahit) {
                    $jml_prod = $this->db->select_sum('stok_awal')->where('id_penjahit',$penjahit->id)->get('tbl_m_produk_stok')->row();

                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(6, .5, $penjahit->penjahit, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(3, .5, (!empty($jml_prod->stok_awal) ? $jml_prod->stok_awal : '0'), 1, 0, 'C', $fill);
                    $this->fpdf->Cell(9, .5, $penjahit->keterangan, 1, 0, 'L', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }



//            if (!empty($sql)) {
//                $fill = FALSE;
//                $no = 1;
//                $tot = 0;
//                $jml_brg = 0;
//                foreach ($sql as $penj) {
//                    $tot = $tot + $penj->subtotal;
//                    $jml_brg = $jml_brg + $penj->jumlah;
//
//                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
//                    $this->fpdf->Cell(4, .5, $this->tanggalan->tgl_indo($penj->tgl), 1, 0, 'C', $fill);
//                    $this->fpdf->Cell(5, .5, $penj->produk, 1, 0, 'L', $fill);
//                    $this->fpdf->Cell(2, .5, $penj->jumlah, 1, 0, 'C', $fill);
//                    $this->fpdf->Cell(3.5, .5, 'Rp. ' . general::format_angka($penj->harga), 1, 0, 'L', $fill);
//                    $this->fpdf->Cell(3.5, .5, 'Rp. ' . general::format_angka($penj->subtotal), 1, 0, 'L', $fill);
//                    $this->fpdf->Ln();
//
//                    $fill = !$fill;
//                    $no++;
//                }
//
//                $this->fpdf->SetFont('Arial', 'B', '10');
//                $this->fpdf->Cell(15.5, .5, 'Jml Barang', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(3.5, .5, $jml_brg . ' Item', 1, 0, 'L', $fill);
//                $this->fpdf->Ln();
//                $this->fpdf->SetFont('Arial', 'B', '10');
//                $this->fpdf->Cell(15.5, .5, 'Total Pendapatan', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(3.5, .5, 'Rp. ' . general::format_angka($tot), 1, 0, 'L', $fill);
//                $this->fpdf->Ln();
//            } else {
//
//                $this->fpdf->SetFont('Arial', 'B', '11');
//                $this->fpdf->SetFillColor(235, 232, 228);
//                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
//                $this->fpdf->Ln(10);
//            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_penjahit_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_produk(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $sql = $this->db->select('id, id_penjahit, DATE(tgl_simpan) as tgl_simpan, kode, produk, jml_awal, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, status_stok, lama_pengerjaan, insentif')->order_by('id','desc')->get('tbl_m_produk')->result();
                    break;
                
                case 'per_tanggal':
                    $sql = $this->db->select('id, id_penjahit, DATE(tgl_simpan) as tgl_simpan, kode, produk, jml_awal, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, status_stok, lama_pengerjaan, insentif')->where('DATE(tgl_simpan)',$_GET['tgl'])->order_by('id','desc')->get('tbl_m_produk')->result();
                    break;
                
                case 'per_rentang':
                    $sql = $this->db->query("SELECT id, id_penjahit, DATE(tgl_simpan) as tgl_simpan, kode, produk, jml_awal, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, status_stok, lama_pengerjaan, insentif FROM tbl_m_produk WHERE DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    break;
            }
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();

            $judul = "LAPORAN DATA PRODUK";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Kode', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(9, .5, 'Produk', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(1, .5, 'Jml', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Harga Jual', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $jml_brg = 0;
                foreach ($sql as $produk) {
                    $tot     = $tot + $produk->harga_jual;
                    $tgl     = explode('-', $produk->tgl_simpan);
                    $jml     = $this->db->select('SUM(stok) as jml')->where('id_produk', $produk->id)->get('tbl_m_produk_stok')->row();
                    $jml_brg = $jml_brg + $jml->jml;

                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(3, .5, $produk->kode, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(9, .5, $produk->produk, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(1, .5, (!empty($jml->jml) ? $jml->jml : '0'), 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($produk->harga_jual), 1, 0, 'R', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Cell(15.5, .5, 'Total', 1, 0, 'R', $fill);
                $this->fpdf->Cell(1, .5, $jml_brg, 1, 0, 'C', $fill);
                $this->fpdf->Cell(2.5, .5, general::format_angka($tot), 1, 0, 'R', $fill);
                $this->fpdf->Ln();
//                $this->fpdf->Cell(15.5, .5, 'Grand Total', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(3.5, .5, general::format_angka($jml_brg * $tot), 1, 0, 'C', $fill);
//                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_barang_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_penjualan(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe      = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            $case      = $this->input->get('case');
            $where     = ($_GET['sb'] == 'x' ? "(tbl_trans_jual.status_bayar LIKE '%%')" : "(tbl_trans_jual.status_bayar ".($_GET['sb'] == 0 ? "NOT LIKE '1'" : "LIKE '".$_GET['sb']."'").")");
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->where($where)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->where($where)                                        
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->where($where)
                                        ->like('metode_bayar', $tipe)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where($where)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }
            
            $sql_plat = $this->db->get('tbl_m_platform');
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA TOTAL TRANSAKSI";

            $this->fpdf->FPDF('L', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('margin');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(27, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(27, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(27, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();

            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//          $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');
            
//          Header tabel
            $this->fpdf->Cell(1, .5, 'NO', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.25, .5, 'TANGGAL', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(5.5, .5, 'OPERATOR', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(1.5, .5, 'BYR', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(5, .5, 'NAMA CUSTOMER', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(1.75, .5, 'NO. INV', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'TRANSAKSI', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2, .5, 'CARA BYR', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'NO KARTU', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'UANG MUKA', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();

            if (!empty($sql)) {
                $this->fpdf->SetFont('Arial', '', '10');
                
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $ong = 0;
                $jml_brg = 0;
                foreach ($sql as $penj) {
                    $tot      = $tot + $penj->jml_gtotal;
                    $ong      = $ong + $penj->jml_ongkir;
                    $jml_brg  = $jml_brg + $penj->jml;
                    $tgl      = explode('-', $penj->tgl_simpan);
                    $tgl_byr  = explode('-', $penj->tgl_bayar);
                    $metode   = $this->db->select('*')->where('id', $penj->metode_bayar)->get('tbl_m_platform')->row();
                    $platform = $this->db->select('*')->where('id_penjualan', $penj->id)->get('tbl_trans_jual_plat')->row();
                    $cabang   = $this->db->select('*')->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                    $nota_det = $this->db->select('tbl_trans_jual_det.id_app, tbl_trans_jual_det.produk, tbl_trans_jual_det.harga as harga_jual, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->where('tbl_trans_jual_det.id_app', $penj->id_app)->where('tbl_trans_jual_det.no_nota', $penj->no_nota)->where('tbl_trans_jual_det.id_kategori2 !=', 0)->get('tbl_trans_jual_det')->result();

                    $this->fpdf->Cell(1, .5, $no++, 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(2.25, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(5.5, .5, $cabang->keterangan.'@'.$this->ion_auth->users($penj->id_user)->row()->username, 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(1.5, .5, general::status_bayar2($penj->status_bayar), 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(5, .5, ucwords($penj->nama), 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(1.75, .5, '#'.$penj->no_nota, 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($penj->jml_gtotal), 'L', 0, 'R', FALSE);
                    $this->fpdf->Cell(2, .5, $metode->platform, 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(3, .5, $platform->keterangan, 'L', 0, 'R', FALSE);
                    $this->fpdf->Cell(2.5, .5, ($penj->jml_kurang == 0 ? '-' : general::format_angka($penj->jml_bayar)), 'LR', 0, 'R', FALSE);
                    $this->fpdf->Ln();

//                    $this->fpdf->Cell(1, .5, $no . '. ', 'L', 0, 'C', FALSE);
//                    $this->fpdf->Cell(2.25, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 'L', 0, 'C', FALSE);
//                    $this->fpdf->Cell(4.5, .5, '#'.$penj->no_nota.'@'.$cabang->keterangan, 'L', 0, 'L', FALSE);
//                    $this->fpdf->Cell(6.5, .5, ucwords($penj->nama), 1, 0, 'L', FALSE);
//                    $this->fpdf->Cell(2.25, .5, ($penj->tgl_bayar == '0000-00-00' ? '-' : $tgl_byr[1] . '/' . $tgl_byr[2] . '/' . $tgl_byr[0]), 1, 0, 'R', FALSE);
//                    $this->fpdf->Cell(2.5, .5, general::format_angka($penj->jml_gtotal), 1, 0, 'R', FALSE);
//                    $this->fpdf->Ln();
                }
                
                $this->fpdf->SetFont('Arial', 'B', '10');
                $i = 1;
                $jml_gtot_tr = 0;
                foreach ($sql_plat->result() as $plat) {                    
                    switch ($case) {
                        case 'semua':
                            if (!empty($sales)) {
                                $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                                ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                                ->like('metode_bayar', $tipe)
                                                ->where('id_user', $sales)
                                                ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                ->order_by('no_nota', 'desc')
                                                ->get('tbl_trans_jual')->result();
                            } else {
                                if ($_GET['tipe'] == '0') {
                                    $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                                    ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                    ->order_by('no_nota', 'desc')
                                                    ->get('tbl_trans_jual')->result();
                                } else {
                                    $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                                    ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                    ->like('metode_bayar', $tipe)
                                                    ->order_by('no_nota', 'desc')
                                                    ->get('tbl_trans_jual')->result();
                                }
                            }
                            break;

                        case 'cabang':
                                $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                     ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                     ->where('tbl_trans_jual.status_bayar', '1')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                     ->like('tbl_trans_jual.id_app', $cabang)
                                                     ->like('tbl_trans_jual.id_user', $sales)
                                                     ->get('tbl_trans_jual')->row();
                            break;

                        case 'per_tanggal':
                                $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                     ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                     ->where('tbl_trans_jual.status_bayar', '1')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                     ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                                     ->get('tbl_trans_jual')->row();
                            break;

                        case 'per_rentang':
                                $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                     ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                     ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                                     ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                                     ->where('tbl_trans_jual.status_bayar', '1')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                     ->get('tbl_trans_jual')->row();
                            break;

                        case 'per_sales':
                                $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                     ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                     ->where('tbl_trans_jual.id_user', $sales)
                                                     ->where('tbl_trans_jual.status_bayar', '1')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                     ->like('tbl_trans_jual.id_app', $cabang)
                                                     ->get('tbl_trans_jual')->row();
                            break;
                    }
                    
                    $jml_gtot_tr = $jml_gtot_tr + $nota->jml_gtotal;

                    $this->fpdf->Cell(17, .5, strtoupper($plat->platform), ($i == 1 ? 'T' : ''), 0, 'R', FALSE);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($nota->jml_gtotal), ($i == 1 ? 'T' : ''), 0, 'R', FALSE);
                    $this->fpdf->Cell(7.5, .5, '', ($i == 1 ? 'T' : ''), 0, 'R', FALSE);
                    $this->fpdf->Ln();
                    
                    $i++;
                }
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(27, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->Cell(17, .5, 'TOTAL', '', 0, 'R', FALSE);
            $this->fpdf->Cell(2.5, .5, general::format_angka($jml_gtot_tr), 'T', 0, 'R', FALSE);
            $this->fpdf->Cell(7.5, .5, '', '', 0, 'R', FALSE);
            $this->fpdf->Ln();

			/*
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(13, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(13, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');
			*/
			
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_penjualan_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function xls_penjualan(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe      = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            $case      = $this->input->get('case');
            $where     = ($_GET['sb'] == 'x' ? "(tbl_trans_jual.status_bayar LIKE '%%')" : "(tbl_trans_jual.status_bayar ".($_GET['sb'] == 0 ? "NOT LIKE '1'" : "LIKE '".$_GET['sb']."'").")");
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->where($where)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->where($where)                                        
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->where($where)
                                        ->like('metode_bayar', $tipe)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where($where)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_user, tbl_trans_jual.tgl_masuk, tbl_trans_jual.id_pengambilan, tbl_trans_jual.id_app, tbl_trans_jual.tgl_ambil, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.status_bayar')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->where($where)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }
            
            $sql_plat = $this->db->get('tbl_m_platform');
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA TOTAL TRANSAKSI";
            
            $setting = $this->db->get('tbl_pengaturan')->row();
            
            $objPHPExcel = new PHPExcel();
            
            // Header Tabel Nota
            $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(TRUE);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'NO.')
                    ->setCellValue('B1', 'TGL')
                    ->setCellValue('C1', 'OPERATOR')
                    ->setCellValue('D1', 'BYR')
                    ->setCellValue('E1', 'CUST')
                    ->setCellValue('F1', 'INV')
                    ->setCellValue('G1', 'TRANSAKSI')
                    ->setCellValue('H1', 'MET')
                    ->setCellValue('I1', 'NO KARTU')
                    ->setCellValue('J1', 'UANG MUKA')
                    ->setCellValue('K1', 'AMBIL')
                    ->setCellValue('L1', 'TGL AMBL')
                    ->setCellValue('M1', 'KSR AMBL');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(14);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(7);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(13);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(14);  
            
            if(!empty($sql)){
                $no = 1;
                $cell  = 2;
                $total = 0;
                foreach ($sql as $penj) {
                    $total    = $total + $penj->jml_gtotal;
                    $ong      = $ong + $penj->jml_ongkir;
                    $jml_brg  = $jml_brg + $penj->jml;
                    $tgl      = explode('-', $penj->tgl_simpan);
                    $tgl_byr  = explode('-', $penj->tgl_bayar);
                    $metode   = $this->db->select('*')->where('id', $penj->metode_bayar)->get('tbl_m_platform')->row();
                    $platform = $this->db->select('*')->where('id_penjualan', $penj->id)->get('tbl_trans_jual_plat')->row();
                    $cabang   = $this->db->select('*')->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                    $nota_det = $this->db->select('tbl_trans_jual_det.id_app, tbl_trans_jual_det.produk, tbl_trans_jual_det.harga as harga_jual, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->where('tbl_trans_jual_det.id_app', $penj->id_app)->where('tbl_trans_jual_det.no_nota', $penj->no_nota)->where('tbl_trans_jual_det.id_kategori2 !=', 0)->get('tbl_trans_jual_det')->result();
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$cell.':F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$cell.':M'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$cell, $val,PHPExcel_Cell_DataType::TYPE_STRING);
                    
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getNumberFormat()->setFormatCode('#,##0');
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$cell)->getNumberFormat()->setFormatCode('#,##0');

                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo2($penj->tgl_masuk).' ')
                            ->setCellValue('C'.$cell, $cabang->keterangan.'@'.$this->ion_auth->user($penj->id_user)->row()->username)
                            ->setCellValue('D'.$cell, general::status_bayar2($penj->status_bayar))
                            ->setCellValue('E'.$cell, strtoupper($penj->nama))
                            ->setCellValue('F'.$cell, '#'.$penj->no_nota)
                            ->setCellValue('G'.$cell, $penj->jml_gtotal)
                            ->setCellValue('H'.$cell, $metode->platform)
                            ->setCellValue('I'.$cell, $platform->keterangan)
                            ->setCellValue('J'.$cell, ($penj->jml_kurang == 0 ? '-' : general::format_angka($penj->jml_bayar)))
                            ->setCellValue('K'.$cell, ($penj->pengambilan != '' ? 'Sudah' : 'Belum'))
                            ->setCellValue('L'.$cell, ($penj->tgl_ambil != '0000-00-00' ? $this->tanggalan->tgl_indo2($penj->tgl_ambil).' ' : ''))
                            ->setCellValue('M'.$cell, $this->ion_auth->user($penj->id_pengambilan)->row()->username);
                    
                    $no++;
                    $cell++;
                }
                
                $sell1       = $cell;
                $jml_gtot_tr = 0;
                foreach ($sql_plat->result() as $plat) {
                    switch ($case) {
                        case 'semua':
                            if (!empty($sales)) {
                                $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                                ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                                ->like('metode_bayar', $tipe)
                                                ->where('id_user', $sales)
                                                ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                ->order_by('no_nota', 'desc')
                                                ->get('tbl_trans_jual')->result();
                            } else {
                                if ($_GET['tipe'] == '0') {
                                    $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                                    ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                    ->order_by('no_nota', 'desc')
                                                    ->get('tbl_trans_jual')->result();
                                } else {
                                    $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                                    ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                    ->like('metode_bayar', $tipe)
                                                    ->order_by('no_nota', 'desc')
                                                    ->get('tbl_trans_jual')->result();
                                }
                            }
                            break;

                        case 'cabang':
                                $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                     ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                     ->where('tbl_trans_jual.status_bayar', '1')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                     ->like('tbl_trans_jual.id_app', $cabang)
                                                     ->like('tbl_trans_jual.id_user', $sales)
                                                     ->get('tbl_trans_jual')->row();
                            break;

                        case 'per_tanggal':
                                $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                     ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                     ->where('tbl_trans_jual.status_bayar', '1')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                     ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                                     ->get('tbl_trans_jual')->row();
                            break;

                        case 'per_rentang':
                                $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                     ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                     ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                                     ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                                     ->where('tbl_trans_jual.status_bayar', '1')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                     ->get('tbl_trans_jual')->row();
                            break;

                        case 'per_sales':
                                $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                     ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                     ->where('tbl_trans_jual.id_user', $sales)
                                                     ->where('tbl_trans_jual.status_bayar', '1')
                                                     ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                     ->like('tbl_trans_jual.id_app', $cabang)
                                                     ->get('tbl_trans_jual')->row();
                            break;
                    }
                    
                    $jml_gtot_tr = $jml_gtot_tr + $nota->jml_gtotal;
                    
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$sell1)->getNumberFormat()->setFormatCode('#,##0');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$sell1.':J'.$sell1.'')->getFont()->setBold(TRUE);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$sell1.':J'.$sell1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $sell1, strtoupper($plat->platform))->mergeCells('A'.$sell1.':F'.$sell1.'')
                            ->setCellValue('G' . $sell1, $nota->jml_gtotal);
                    
                    
                    $sell1++;
                }
                
                $sell2 = $sell1++;
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sell2)->getNumberFormat()->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':J'.$sell2.'')->getFont()->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':J'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sell2, 'TOTAL')->mergeCells('A'.$sell2.':F'.$sell2.'')
                        ->setCellValue('G' . $sell2, $jml_gtot_tr);
            }
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle($judul);

            /** Page Setup * */
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setTop(0.25);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setRight(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setLeft(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setFooter(0);
            
            
            /** Page Setup * */
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
//            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_penjualan_'.(isset($_GET['filename']) ? $_GET['filename'] : 'laporan').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            
            ob_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_penjualan_det(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe  = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            
            $case      = $this->input->get('case');
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->group_by('tbl_trans_jual_det.produk')
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->group_by('tbl_trans_jual_det.produk')
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->group_by('tbl_trans_jual_det.produk')
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $sql = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, , SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
//                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
                        $sql = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, , SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                        
                    }else{
                        $sql = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
//                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
//                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
//                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
//                                             ->like('tbl_trans_jual.id_app', $cabang)
//                                             ->like('tbl_trans_jual.id_user', $sales)
//                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
//                                             ->get('tbl_trans_jual')->result(); 
                        $sql = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, , SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                        
                    }else{
                        $sql = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual_det.produk, , SUM(tbl_trans_jual_det.jml) as jml')
                                             ->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual_det.status_brg !=', '1')
                                             ->where('tbl_trans_jual_det.id_kategori2 !=', '0')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->group_by('tbl_trans_jual_det.produk')
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual_det')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }
            
            $sql_plat = $this->db->get('tbl_m_platform');
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA TERJUAL";

            $this->fpdf->FPDF('L', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('margin');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(27, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(27, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(27, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();

            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//          $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');
            
//          Header tabel
            $this->fpdf->Cell(1, .5, 'NO', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(2.25, .5, 'TANGGAL', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(15.5, .5, 'PRODUK', 1, 0, 'L', TRUE);
            $this->fpdf->Cell(1.5, .5, 'JML', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(5, .5, 'NAMA CUSTOMER', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(1.75, .5, 'NO. INV', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(2.5, .5, 'TRANSAKSI', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(2, .5, 'CARA BYR', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(3, .5, 'NO KARTU', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(2.5, .5, 'UANG MUKA', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();

            if (!empty($sql)) {
                $this->fpdf->SetFont('Arial', '', '10');
                
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $ong = 0;
                $jml_brg = 0;
                foreach ($sql as $penj) {
                    $tot      = $tot + $penj->jml_gtotal;
                    $ong      = $ong + $penj->jml_ongkir;
                    $jml_brg  = $jml_brg + $penj->jml;
                    $tgl      = explode('-', $penj->tgl_simpan);
                    $tgl_byr  = explode('-', $penj->tgl_bayar);
                    $metode   = $this->db->select('*')->where('id', $penj->metode_bayar)->get('tbl_m_platform')->row();
                    $platform = $this->db->select('*')->where('id_penjualan', $penj->id)->get('tbl_trans_jual_plat')->row();
                    $cabang   = $this->db->select('*')->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                    $nota_det = $this->db->select('tbl_trans_jual_det.id_app, tbl_trans_jual_det.produk, tbl_trans_jual_det.harga as harga_jual, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->where('tbl_trans_jual_det.id_app', $penj->id_app)->where('tbl_trans_jual_det.no_nota', $penj->no_nota)->where('tbl_trans_jual_det.id_kategori2 !=', 0)->get('tbl_trans_jual_det')->result();
                    
                    
                    $this->fpdf->Cell(1, .5, $no++, 'L', 0, 'C', FALSE);
//                    $this->fpdf->Cell(2.25, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(15.5, .5, $penj->produk, 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(1.5, .5, $penj->jml, 'LR', 0, 'C', FALSE);
                    $this->fpdf->Ln();
                }

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(18, .5, '', 'T', 0, 'C', FALSE);
                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }
			
			/*
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(13, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(13, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');
			*/
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_penjualan_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_penjualan2(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe      = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            $case      = $this->input->get('case');
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA TOTAL TRANSAKSI";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('margin');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $ong = 0;
                $jml_brg = 0;
                foreach ($sql as $penj) {
                    $tot      = $tot + $penj->jml_gtotal;
                    $ong      = $ong + $penj->jml_ongkir;
                    $jml_brg  = $jml_brg + $penj->jml;
                    $tgl      = explode('-', $penj->tgl_simpan);
                    $tgl_byr  = explode('-', $penj->tgl_bayar);
                    $cabang   = $this->db->select('*')->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                    $nota_det = $this->db->select('tbl_trans_jual_det.id_app, tbl_trans_jual_det.produk, tbl_trans_jual_det.harga as harga_jual, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->where('tbl_trans_jual_det.id_app', $penj->id_app)->where('tbl_trans_jual_det.no_nota', $penj->no_nota)->where('tbl_trans_jual_det.id_kategori2 !=', 0)->get('tbl_trans_jual_det')->result();

            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.25, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(4.5, .5, 'No. Inv', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(6.5, .5, 'Nama', 1, 0, 'L', TRUE);
            $this->fpdf->Cell(2.25, .5, 'Tgl Bayar', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Total', 1, 0, 'C', TRUE);
//            $this->fpdf->Ln();

            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(2.25, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(4.5, .5, '#'.$penj->no_nota.'@'.$cabang->keterangan, 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(6.5, .5, ucwords($penj->nama), 1, 0, 'L', FALSE);
                    $this->fpdf->Cell(2.25, .5, ($penj->tgl_bayar == '0000-00-00' ? '-' : $tgl_byr[1] . '/' . $tgl_byr[2] . '/' . $tgl_byr[0]), 1, 0, 'R', FALSE);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($penj->jml_gtotal), 1, 0, 'R', FALSE);
                    $this->fpdf->Ln();
                    
//                    $this->fpdf->SetFont('Arial', 'B', '10');
//                    $this->fpdf->Cell(1, .5, '', 'L', 0, 'R', FALSE);
//                    $this->fpdf->SetFont('Arial', '', '10');
//                    $this->fpdf->Cell(6.75, .5, $this->ion_auth->user($penj->id_user)->row()->first_name, 'LT', 0, 'L', FALSE);
//                    $this->fpdf->SetFont('Arial', 'B', '10');
//                    $this->fpdf->Cell(6.5, .5, 'Jenis Laundry', 'LTB', 0, 'L', TRUE);
//                    $this->fpdf->Cell(2.25, .5, 'Jml', 1, 0, 'C', TRUE);
//                    $this->fpdf->Cell(2.5, .5, 'Hrg Satuan', 1, 0, 'C', TRUE);                   
//                    $this->fpdf->Ln();
                    
//                    $this->fpdf->SetFont('Arial', '', '10');
//                    foreach ($nota_det as $nota_det){
//                        $this->fpdf->Cell(1, .5, '', 'L', 0, 'R', FALSE);
//                        $this->fpdf->Cell(6.75, .5, '', 'L', 0, 'R', FALSE);
//                        $this->fpdf->Cell(6.5, .5, $nota_det->produk, 'L', 0, 'L', FALSE);
//                        $this->fpdf->Cell(2.25, .5, $nota_det->jml, 'L', 0, 'C', FALSE);
//                        $this->fpdf->Cell(2.5, .5, general::format_angka($nota_det->harga_jual), 'LR', 0, 'R', FALSE);
//                        $this->fpdf->Ln();                        
//                    }

                    $fill = !$fill;
                    $no++;
                }

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Cell(16.5, .5, 'Total', 1, 0, 'R', $fill);
                $this->fpdf->Cell(2.5, .5, general::format_angka($tot), 1, 0, 'R', $fill);
                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }
/*
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');
*/
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_penjualan_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_keuangan(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe      = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            $case      = $this->input->get('case');
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->where('status_bayar', '1')
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->where('status_bayar', '1')
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->where('status_bayar', '1')
                                        ->like('metode_bayar', $tipe)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar', '1')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar', '1')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.id_user, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->where('status_bayar !=', '0')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.id_user, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->where('status_bayar !=', '0')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar', '1')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar', '1')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar', '1')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('status_bayar', '1')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }
            
            $sql_plat = $this->db->get('tbl_m_platform');
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA TOTAL TRANSAKSI";

            $this->fpdf->FPDF('L', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('margin');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(27, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(27, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(27, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();

            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//          $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');
            
//          Header tabel
            $this->fpdf->Cell(1, .5, 'NO', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.25, .5, 'TANGGAL', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(5.5, .5, 'OPERATOR', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(1.5, .5, 'SALES', 1, 0, 'L', TRUE);
            $this->fpdf->Cell(6.5, .5, 'NAMA CUSTOMER', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(1.75, .5, 'NO. INV', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'TRANSAKSI', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2, .5, 'CARA BYR', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'NO KARTU', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'UANG MUKA', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();

            if (!empty($sql)) {
                $this->fpdf->SetFont('Arial', '', '10');
                
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $ong = 0;
                $jml_brg = 0;
                foreach ($sql as $penj) {
                    $tot      = $tot + $penj->jml_gtotal;
                    $ong      = $ong + $penj->jml_ongkir;
                    $jml_brg  = $jml_brg + $penj->jml;
                    $tgl      = explode('-', $penj->tgl_simpan);
                    $tgl_byr  = explode('-', $penj->tgl_bayar);
                    $metode   = $this->db->select('*')->where('id', $penj->metode_bayar)->get('tbl_m_platform')->row();
                    $platform = $this->db->select('*')->where('id_penjualan', $penj->id)->get('tbl_trans_jual_plat')->row();
                    $cabang   = $this->db->select('*')->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                    $nota_det = $this->db->select('tbl_trans_jual_det.id_app, tbl_trans_jual_det.produk, tbl_trans_jual_det.harga as harga_jual, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->where('tbl_trans_jual_det.id_app', $penj->id_app)->where('tbl_trans_jual_det.no_nota', $penj->no_nota)->where('tbl_trans_jual_det.id_kategori2 !=', 0)->get('tbl_trans_jual_det')->result();

                    $this->fpdf->Cell(1, .5, $no++, 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(2.25, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(5.5, .5, $cabang->keterangan.'@'.$this->ion_auth->user($penj->id_user)->row()->username, 'L', 0, 'L', FALSE);
//                    $this->fpdf->Cell(1.5, .5, '', 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(6.5, .5, ucwords($penj->nama), 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(1.75, .5, '#'.$penj->no_nota, 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($penj->jml_gtotal), 'L', 0, 'R', FALSE);
                    $this->fpdf->Cell(2, .5, $metode->platform, 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(3, .5, $platform->keterangan, 'L', 0, 'R', FALSE);
                    $this->fpdf->Cell(2.5, .5, ($penj->jml_kurang == 0 ? '-' : general::format_angka($penj->jml_bayar)), 'LR', 0, 'R', FALSE);
                    $this->fpdf->Ln();

//                    $this->fpdf->Cell(1, .5, $no . '. ', 'L', 0, 'C', FALSE);
//                    $this->fpdf->Cell(2.25, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 'L', 0, 'C', FALSE);
//                    $this->fpdf->Cell(4.5, .5, '#'.$penj->no_nota.'@'.$cabang->keterangan, 'L', 0, 'L', FALSE);
//                    $this->fpdf->Cell(6.5, .5, ucwords($penj->nama), 1, 0, 'L', FALSE);
//                    $this->fpdf->Cell(2.25, .5, ($penj->tgl_bayar == '0000-00-00' ? '-' : $tgl_byr[1] . '/' . $tgl_byr[2] . '/' . $tgl_byr[0]), 1, 0, 'R', FALSE);
//                    $this->fpdf->Cell(2.5, .5, general::format_angka($penj->jml_gtotal), 1, 0, 'R', FALSE);
//                    $this->fpdf->Ln();
                }
                
                $this->fpdf->SetFont('Arial', 'B', '10');
                $i = 1;
                foreach ($sql_plat->result() as $plat) {
                    switch ($case){
                        case 'semua':
                            $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                 ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                 ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                 ->where('tbl_trans_jual.status_bayar', '1')
                                                 ->get('tbl_trans_jual')->row(); 
                            break;
                        
                        case 'cabang':
                            $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                 ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                 ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                 ->where('tbl_trans_jual.status_bayar', '1')
                                                 ->where('tbl_trans_jual.id_app', $cabang)
                                                 ->get('tbl_trans_jual')->row(); 
                            break;
                        
                        case 'per_sales':
                            $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                 ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                 ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                 ->where('tbl_trans_jual.status_bayar', '1')
                                                 ->where('tbl_trans_jual.id_user', $sales)
                                                 ->get('tbl_trans_jual')->row(); 
                            break;
                        
                        case 'per_rentang':
                            $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                 ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                 ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                 ->where('tbl_trans_jual.status_bayar', '1')
                                                 ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                                 ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                                 ->get('tbl_trans_jual')->row();                             
                            break;
                        
                        case 'per_tanggal':
                            $nota     = $this->db->select('tbl_trans_jual.no_nota, SUM(tbl_trans_jual.jml_gtotal) as jml_gtotal')
                                                 ->join('tbl_trans_jual_plat','tbl_trans_jual_plat.id_penjualan=tbl_trans_jual.id')
                                                 ->where('tbl_trans_jual_plat.id_platform', $plat->id)
                                                 ->where('tbl_trans_jual.status_bayar', '1')
                                                 ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                                 ->get('tbl_trans_jual')->row();                            
                            break;
                    };
                    
                    
                    $this->fpdf->Cell(17, .5, strtoupper($plat->platform), ($i == 1 ? 'T' : ''), 0, 'R', FALSE);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($nota->jml_gtotal), ($i == 1 ? 'T' : ''), 0, 'R', FALSE);
                    $this->fpdf->Cell(7.5, .5, '', ($i == 1 ? 'T' : ''), 0, 'R', FALSE);
                    $this->fpdf->Ln();
                    
                    $i++;
                }
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }
/*
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(13, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(13, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');
*/
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_penjualan_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_keuangan2(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe      = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            $case      = $this->input->get('case');
            switch ($case){
                case 'semua':
                    if (!empty($sales)) {
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->where('id_user', $sales)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                    } else {
                        if($_GET['tipe'] == '0'){
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                        }else{
                            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                        ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                        ->like('metode_bayar', $tipe)
                                        ->order_by('no_nota', 'desc')
                                        ->get('tbl_trans_jual')->result();
                            
                        }
                    }
                    break;
                
                case 'cabang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_tanggal':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan)', $kueri)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_rentang':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) >=', $tgl_awal)
                                             ->where('DATE(tbl_trans_jual.tgl_simpan) <=', $tgl_akhir)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->like('tbl_trans_jual.id_user', $sales)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
                
                case 'per_sales':
                    if($tipe == '0'){
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                        
                    }else{
                        $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, tbl_m_pelanggan.nama, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.status_nota, tbl_trans_jual.metode_bayar, tbl_trans_jual.status_bayar, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung')
                                             ->join('tbl_m_pelanggan','tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                                             ->where('tbl_trans_jual.id_user', $sales)
                                             ->like('tbl_trans_jual.id_app', $cabang)
                                             ->where('tbl_trans_jual.metode_bayar', $tipe)
                                             ->order_by('tbl_trans_jual.no_nota', 'desc')
                                             ->get('tbl_trans_jual')->result(); 
                    }
                    break;
            }
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA TOTAL TRANSAKSI";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('margin');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $ong = 0;
                $jml_brg = 0;
                foreach ($sql as $penj) {
                    $tot      = $tot + $penj->jml_gtotal;
                    $ong      = $ong + $penj->jml_ongkir;
                    $jml_brg  = $jml_brg + $penj->jml;
                    $tgl      = explode('-', $penj->tgl_simpan);
                    $tgl_byr  = explode('-', $penj->tgl_bayar);
                    $cabang   = $this->db->select('*')->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                    $nota_det = $this->db->select('tbl_trans_jual_det.id_app, tbl_trans_jual_det.produk, tbl_trans_jual_det.harga as harga_jual, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->where('tbl_trans_jual_det.id_app', $penj->id_app)->where('tbl_trans_jual_det.no_nota', $penj->no_nota)->where('tbl_trans_jual_det.id_kategori2 !=', 0)->get('tbl_trans_jual_det')->result();

            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.25, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(4.5, .5, 'No. Inv', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(6.5, .5, 'Nama', 1, 0, 'L', TRUE);
            $this->fpdf->Cell(2.25, .5, 'Tgl Bayar', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Total', 1, 0, 'C', TRUE);
//            $this->fpdf->Ln();

            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(2.25, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(4.5, .5, '#'.$penj->no_nota.'@'.$cabang->keterangan, 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(6.5, .5, ucwords($penj->nama), 1, 0, 'L', FALSE);
                    $this->fpdf->Cell(2.25, .5, ($penj->tgl_bayar == '0000-00-00' ? '-' : $tgl_byr[1] . '/' . $tgl_byr[2] . '/' . $tgl_byr[0]), 1, 0, 'R', FALSE);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($penj->jml_gtotal), 1, 0, 'R', FALSE);
                    $this->fpdf->Ln();
                    
//                    $this->fpdf->SetFont('Arial', 'B', '10');
//                    $this->fpdf->Cell(1, .5, '', 'L', 0, 'R', FALSE);
//                    $this->fpdf->SetFont('Arial', '', '10');
//                    $this->fpdf->Cell(6.75, .5, $this->ion_auth->user($penj->id_user)->row()->first_name, 'LT', 0, 'L', FALSE);
//                    $this->fpdf->SetFont('Arial', 'B', '10');
//                    $this->fpdf->Cell(6.5, .5, 'Jenis Laundry', 'LTB', 0, 'L', TRUE);
//                    $this->fpdf->Cell(2.25, .5, 'Jml', 1, 0, 'C', TRUE);
//                    $this->fpdf->Cell(2.5, .5, 'Hrg Satuan', 1, 0, 'C', TRUE);                   
//                    $this->fpdf->Ln();
                    
//                    $this->fpdf->SetFont('Arial', '', '10');
//                    foreach ($nota_det as $nota_det){
//                        $this->fpdf->Cell(1, .5, '', 'L', 0, 'R', FALSE);
//                        $this->fpdf->Cell(6.75, .5, '', 'L', 0, 'R', FALSE);
//                        $this->fpdf->Cell(6.5, .5, $nota_det->produk, 'L', 0, 'L', FALSE);
//                        $this->fpdf->Cell(2.25, .5, $nota_det->jml, 'L', 0, 'C', FALSE);
//                        $this->fpdf->Cell(2.5, .5, general::format_angka($nota_det->harga_jual), 'LR', 0, 'R', FALSE);
//                        $this->fpdf->Ln();                        
//                    }

                    $fill = !$fill;
                    $no++;
                }

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Cell(16.5, .5, 'Total', 1, 0, 'R', $fill);
                $this->fpdf->Cell(2.5, .5, general::format_angka($tot), 1, 0, 'R', $fill);
                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_penjualan_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_packing(){
        if (akses::aksesLogin() == TRUE) {
            $sales     = $this->input->get('sales');
            $cabang    = $this->input->get('cabang');
            $kueri     = $this->input->get('query');
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $tipe      = (!empty($_GET['tipe']) ? $this->input->get('tipe') : '0');
            
            $case      = $this->input->get('case');
            
            if(!empty($tgl_awal) && !empty($tgl_akhir)) {
                $sql = $this->db->select('DATE(tgl_simpan) as tgl_simpan, produk, jml')
								->where('status_brg', '1')
                                ->where('DATE(tbl_trans_jual_det.tgl_simpan) >=', $tgl_awal)
                                ->where('DATE(tbl_trans_jual_det.tgl_simpan) <=', $tgl_akhir)
								->get('tbl_trans_jual_det')->result();
            } else {
                $sql = $this->db->select('DATE(tgl_simpan) as tgl_simpan, produk, jml')
								->where('status_brg', '1')
								->where('DATE(tbl_trans_jual_det.tgl_simpan)', $kueri)
								->get('tbl_trans_jual_det')->result(); 
            }

            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA PACKING";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('margin');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            $this->fpdf->SetFont('Arial', 'B', '10');
//            $this->fpdf->Cell(3, .5, 'Tgl Keluar', 'LTB', 0, 'C', FALSE);
            $this->fpdf->Cell(6.5, .5, 'Packing Bahan', 'LTB', 0, 'L', FALSE);
            $this->fpdf->Cell(2.25, .5, 'Jml', 1, 0, 'C', FALSE);
            $this->fpdf->Ln();

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $ong = 0;
                $jml_brg = 0;
                $j_pcs = 0;
                foreach ($sql as $penj) {
                    $tot      = $tot + $penj->jml_gtotal;
                    $ong      = $ong + $penj->jml_ongkir;
                    $jml_brg  = $jml_brg + $penj->jml;
                    $tgl      = explode('-', $penj->tgl_simpan);
                    $tgl_byr  = explode('-', $penj->tgl_bayar);
                    $j_pcs    = $j_pcs + $penj->jml;
					$tgl 	  = explode('-', $penj->tgl_simpan);
                    
                    // Fill Colornya
                    $this->fpdf->SetFillColor(211, 223, 227);
                    $this->fpdf->SetTextColor(0);
                    
                    // $this->fpdf->SetDrawColor(128, 0, 0);
                    $this->fpdf->SetFont('Arial', 'B', '10');


                    // Header tabel
                    $this->fpdf->SetFillColor(235, 232, 228);
                    $this->fpdf->SetTextColor(0);
                    $this->fpdf->SetFont('Arial', '', '10');

//                    $this->fpdf->Cell(3, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 'L', 0, 'C', FALSE);
                    $this->fpdf->Cell(6.5, .5, $penj->produk, 'L', 0, 'L', FALSE);
                    $this->fpdf->Cell(2.25, .5, $penj->jml, 'LR', 0, 'R', FALSE);

                    $this->fpdf->Ln();
                    $fill = !$fill;
                    $no++;
                }

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Cell(9.5, .5, 'Total', 1, 0, 'R', $fill);
                $this->fpdf->Cell(2.25, .5, $j_pcs, 1, 0, 'C', $fill);
                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }
/*
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');
*/
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_packing_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_member(){
        if (akses::aksesLogin() == TRUE) {
            $nik       = $this->input->get('nik');
            $nama      = $this->input->get('nama');
            
            $sql = $this->db->select('id, DATE(tgl_simpan) as tgl_simpan, kode, nik, nama, alamat, no_hp, ')->like('nik', $nik)->like('nama', $nama)->get('tbl_m_pelanggan')->result();
                        
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA PELANGGAN / MEMBER";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('margin');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            if (!empty($sql)) {
                // Fill Colornya
                $this->fpdf->SetFillColor(211, 223, 227);
                $this->fpdf->SetTextColor(0);
                $this->fpdf->SetFont('Arial', 'B', '10');

                $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
                $this->fpdf->Cell(2, .5, 'Tgl Daftar', 1, 0, 'C', TRUE);
                $this->fpdf->Cell(4, .5, 'NIK', 1, 0, 'C', TRUE);
                $this->fpdf->Cell(4, .5, 'Nama', 1, 0, 'L', TRUE);
                $this->fpdf->Cell(5, .5, 'Alamat', 1, 0, 'C', TRUE);
                $this->fpdf->Cell(3, .5, 'No. HP', 1, 0, 'C', TRUE);
                $this->fpdf->Ln();

                $fill = FALSE;
                $no = 1;
                foreach ($sql as $penj) {
                    $tgl = explode('-', $penj->tgl_simpan);
                    
                    $this->fpdf->SetFont('Arial', '', '10');
                    $this->fpdf->Cell(1, .5, $no++, 1, 0, 'C', FALSE);
                    $this->fpdf->Cell(2, .5, $tgl[1].'/'.$tgl[2].'/'.$tgl[0], 1, 0, 'C', FALSE);
                    $this->fpdf->Cell(4, .5, $penj->nik, 1, 0, 'L', FALSE);
                    $this->fpdf->Cell(4, .5, ucwords($penj->nama), 1, 0, 'L', FALSE);
                    $this->fpdf->Cell(5, .5, $penj->alamat, 1, 0, 'L', FALSE);
                    $this->fpdf->Cell(3, .5, $penj->no_hp, 1, 0, 'L', FALSE);
                    $this->fpdf->Ln();
                }
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }
/*
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');
*/
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_penjualan_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_deposit(){
        if (akses::aksesLogin() == TRUE) {
            $nik       = $this->input->get('nik');
            $nama      = $this->input->get('nama');
            
            $sql = $this->db
                                   ->select('tbl_m_pelanggan.id, DATE(tbl_m_pelanggan.tgl_simpan) as tgl_simpan, tbl_m_pelanggan.kode, tbl_m_pelanggan.nik, tbl_m_pelanggan.nama, tbl_m_pelanggan.alamat, tbl_m_pelanggan_deposit.jml_deposit')
                                   ->join('tbl_m_pelanggan_deposit', 'tbl_m_pelanggan_deposit.id_pelanggan=tbl_m_pelanggan.id')
                                   ->like('tbl_m_pelanggan.nik', $nik)
                                   ->like('tbl_m_pelanggan.nama', $nama)
                                   ->get('tbl_m_pelanggan')->result();
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA PELANGGAN / MEMBER";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('margin');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            if (!empty($sql)) {
                // Fill Colornya
                $this->fpdf->SetFillColor(211, 223, 227);
                $this->fpdf->SetTextColor(0);
                $this->fpdf->SetFont('Arial', 'B', '10');

                $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
                $this->fpdf->Cell(2, .5, 'Tgl Daftar', 1, 0, 'C', TRUE);
                $this->fpdf->Cell(6, .5, 'NIK', 1, 0, 'C', TRUE);
                $this->fpdf->Cell(7, .5, 'Nama', 1, 0, 'L', TRUE);
                $this->fpdf->Cell(3, .5, 'Jml Deposit', 1, 0, 'C', TRUE);
                $this->fpdf->Ln();

                $fill = FALSE;
                $no = 1;
                foreach ($sql as $penj) {
                    $tgl = explode('-', $penj->tgl_simpan);
                    
                    $this->fpdf->SetFont('Arial', '', '10');
                    $this->fpdf->Cell(1, .5, $no++, 1, 0, 'C', FALSE);
                    $this->fpdf->Cell(2, .5, $tgl[1].'/'.$tgl[2].'/'.$tgl[0], 1, 0, 'C', FALSE);
                    $this->fpdf->Cell(6, .5, $penj->nik, 1, 0, 'L', FALSE);
                    $this->fpdf->Cell(7, .5, ucwords($penj->nama), 1, 0, 'L', FALSE);
                    $this->fpdf->Cell(3, .5, general::format_angka($penj->jml_deposit), 1, 0, 'R', FALSE);
                    $this->fpdf->Ln();
                }
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }
/*
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');
*/
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_penjualan_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_insentif(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $sql = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user')->where('status_nota >=','1')->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'sales':
                    $sql = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user')->where('status_nota >=','1')->where('id_user',$_GET['query'])->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_tanggal':
                    $sql = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user')->where('status_nota >=','1')->where('DATE(tgl_simpan)',$_GET['query'])->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_rentang':
                    $sql = $this->db->query("SELECT no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar, id_user FROM tbl_trans_jual WHERE DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."' AND status_nota >='1' ORDER BY no_nota DESC")->result();
                    break;
            }

            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA INCENTIVE";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//          Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3.5, .5, 'Sales', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2, .5, 'No. Inv', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(4.5, .5, 'Platform', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl Bayar', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Insentif', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $jml_brg = 0;
                foreach ($sql as $insentif) {
                    $jml_brg = $jml_brg + $insentif->jumlah;
                    $tgl     = explode('-', $insentif->tgl_simpan);
                    $tgl2    = explode('-', $insentif->tgl_simpan);
                    $sql_ins = $this->db->select('SUM(tbl_m_produk.insentif) as insentif')->join('tbl_m_produk','tbl_m_produk.id=tbl_trans_jual_det.id_produk')->where('no_nota', $insentif->no_nota)->get('tbl_trans_jual_det')->row();
                    $tot     = $tot + $sql_ins->insentif;
                    $sql_plt = $this->db->select('tbl_m_platform.platform, tbl_trans_jual_plat.keterangan')->join('tbl_m_platform','tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->where('tbl_trans_jual_plat.no_nota', $insentif->no_nota)->get('tbl_trans_jual_plat')->row();
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(3.5, .5, $this->ion_auth->user($insentif->id_user)->row()->first_name, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(2, .5, '#'.$insentif->no_nota, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(4.5, .5, ucwords($sql_plt->platform), 1, 0, 'L', $fill);
                    $this->fpdf->Cell(2.5, .5, $tgl2[1] . '/' . $tgl2[2] . '/' . $tgl2[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(3, .5, general::format_angka($sql_ins->insentif), 1, 0, 'R', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Cell(16, .5, 'Total Insentif', 1, 0, 'R', $fill);
                $this->fpdf->Cell(3, .5, general::format_angka($tot), 1, 0, 'R', $fill);
                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_insentif_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_pemasukan(){
        if (akses::aksesLogin() == TRUE) {
            $case   = $this->input->get('case');
            $status = $this->input->get('status');
            
            switch ($case){
                case 'semua':
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('status_kas',$status)
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_tanggal':
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('DATE(tgl)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_rentang':
//                    $sql = $this->db->query("SELECT kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis FROM tbl_akt_kas WHERE tipe='masuk' AND DATE(tgl) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."' ORDER BY id DESC")->result();
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('DATE(tgl) >',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) <',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','masuk')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) =<',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
            }

            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA PEMASUKAN";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(12.5, .5, 'Keterangan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Nominal', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                foreach ($sql as $pemasukan) {
                    $tot = $tot + $pemasukan->nominal;
                    $tgl     = explode('-', $pemasukan->tgl_simpan);
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5,$tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(12.5, .5, $pemasukan->keterangan, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(3, .5, general::format_angka($pemasukan->nominal), 1, 0, 'R', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(16, .5, 'Total', 1, 0, 'R');
                $this->fpdf->Cell(3, .5, general::format_angka($tot), 1, 0, 'R');
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_pemasukan_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_pengeluaran(){
        if (akses::aksesLogin() == TRUE) {
            $case   = $this->input->get('case');
            $status = $this->input->get('status');
            
            switch ($case){
                case 'semua':
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('status_kas',$status)
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_tanggal':
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('DATE(tgl)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_rentang':
//                    $sql = $this->db->query("SELECT kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis FROM tbl_akt_kas WHERE tipe='masuk' AND DATE(tgl) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."' ORDER BY id DESC")->result();
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('DATE(tgl) >',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) <',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, tipe, status_kas')
                           ->where('tipe','keluar')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) =<',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_kas')->result();
                        
                    }
                    break;
            }

            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA PENGELUARAN";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(7.5, .5, 'Keterangan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(5, .5, 'Jenis', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Nominal', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                foreach ($sql as $pemasukan) {
                    $tot = $tot + $pemasukan->nominal;
                    $tgl = explode('-', $pemasukan->tgl_simpan);
                    $jns = $this->db->where('id', $pemasukan->id_jenis)->get('tbl_akt_kas_jns')->row();
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5,$tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(7.5, .5, $pemasukan->keterangan, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(5, .5, ($pemasukan->id_jenis == 0 ? '-' : $jns->jenis), 1, 0, 'L', $fill);
                    $this->fpdf->Cell(3, .5, general::format_angka($pemasukan->nominal), 1, 0, 'R', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(16, .5, 'Total', 1, 0, 'R');
                $this->fpdf->Cell(3, .5, general::format_angka($tot), 1, 0, 'R');
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_pengeluaran_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_kas(){
        if (akses::aksesLogin() == TRUE) {
            $case   = $this->input->get('case');
            $status = $this->input->get('status');
            
            switch ($case){
                case 'semua':
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('status_kas',$status)
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_tanggal':
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('DATE(tgl)',$this->input->get('tgl_akhir'))
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl)',$this->input->get('query'))
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }
                    break;
                
                case 'per_rentang':
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('DATE(tgl) >',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) <',$this->input->get('tgl_akhir'))
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_jenis, kode, DATE(tgl) as tgl_simpan, keterangan, jumlah, nominal, debet, kredit, tipe, status_kas')
                           ->where('status_kas',$status)
                           ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl) =<',$this->input->get('tgl_akhir'))
//                           ->order_by('id','desc')
                           ->get('tbl_akt_kas')->result();
                        
                    }
                    break;
            }

            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA KAS";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(8, .5, 'Keterangan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Pengeluaran', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Pemasukan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Saldo', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill   = FALSE;
                $no     = 1;
                $tot_kr = 0;
                $tot_db = 0;
                foreach ($sql as $pemasukan) {
                    $tot_kr = $tot_kr + $pemasukan->kredit;
                    $tot_db = $tot_db + $pemasukan->debet;
                    $tgl = explode('-', $pemasukan->tgl_simpan);
                    $jns = $this->db->where('id', $pemasukan->id_jenis)->get('tbl_akt_kas_jns')->row();
                    $sal = ($pemasukan->kredit - $pemasukan->debet) + $sal++;
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5,$tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(8, .5, $pemasukan->keterangan, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($pemasukan->debet), 1, 0, 'R', $fill);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($pemasukan->kredit), 1, 0, 'R', $fill);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($sal), 1, 0, 'R', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
                
                $tot_sal =  $tot_kr - $tot_db;
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(11.5, .5, 'Total', 1, 0, 'R');
                $this->fpdf->Cell(2.5, .5, general::format_angka($tot_db), 1, 0, 'R');
                $this->fpdf->Cell(2.5, .5, general::format_angka($tot_kr), 1, 0, 'R');
                $this->fpdf->Cell(2.5, .5, general::format_angka($tot_sal), 1, 0, 'R');
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_pengeluaran_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }    

    public function pdf_piutang(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $sql = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual_det.no_nota, tbl_m_produk.produk, tbl_trans_jual_det.harga, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')->join('tbl_m_produk','tbl_m_produk.id=tbl_trans_jual_det.id_produk')->where('status_nota >','0')->where('status_bayar','0')->order_by('no_nota','desc')->get('tbl_trans_jual_det')->result();
//                    $sql = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar')->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'sales':
                    $sql = $this->db->select('DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual_det.no_nota, tbl_m_produk.produk, tbl_trans_jual_det.harga, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->join('tbl_trans_jual','tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')->join('tbl_m_produk','tbl_m_produk.id=tbl_trans_jual_det.id_produk')->where('tbl_trans_jual.id_user',$_GET['query'])->where('status_nota >','0')->where('status_bayar','0')->order_by('no_nota','desc')->get('tbl_trans_jual_det')->result();
//                    $sql = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar')->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_tanggal':
                    $sql = $this->db->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar')->where('DATE(tgl_simpan)',$_GET['query'])->where('status_nota >','0')->where('status_bayar','0')->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
                
                case 'per_rentang':
//                    $sql = $this->db->query("SELECT no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar FROM tbl_trans_jual WHERE DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."'")->result();
                    $sql = $this->db
                        ->select('no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, platform, jml_gtotal, jml_bayar, jml_ongkir, status_nota, status_bayar')
                        ->where('status_nota >','0')
                        ->where('status_bayar','0')
                        ->where('DATE(tgl_simpan) >',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl_simpan) <',$this->input->get('tgl_akhir'))
                        ->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                    break;
            }
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA TOTAL PIUTANG";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(9.5, .5, 'Produk', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(1, .5, 'Jml', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Harga', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Total Harga', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $jml_brg = 0;
                foreach ($sql as $penj) {
                    $tot     = $tot + $penj->subtotal;
                    $jml_brg = $jml_brg + $penj->jml;
                    $tgl     = explode('-', $penj->tgl_simpan);

                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(9.5, .5, $penj->produk, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(1, .5, $penj->jml, 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($penj->harga), 1, 0, 'R', $fill);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($penj->subtotal), 1, 0, 'R', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Cell(13, .5, 'Jml Barang', 1, 0, 'R', $fill);
                $this->fpdf->Cell(1, .5, $jml_brg, 1, 0, 'C', $fill);
                $this->fpdf->Cell(2.5, .5, '', 1, 0, 'R', $fill);
                $this->fpdf->Cell(2.5, .5, general::format_angka($tot), 1, 0, 'R', $fill);
                $this->fpdf->Ln();
//                $this->fpdf->SetFont('Arial', 'B', '10');
//                $this->fpdf->Cell(15.5, .5, 'Total Pendapatan', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(3.5, .5, general::format_angka($tot), 1, 0, 'L', $fill);
//                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_penjualan_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function pdf_modal(){
        if (akses::aksesLogin() == TRUE) {
            $case   = $this->input->get('case');
            $status = $this->input->get('status');
            
            switch ($case){
                case 'semua':
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           
                           
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }
                    break;
                
                case 'per_tanggal':
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           
                           ->where('DATE(tgl_simpan)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           
                           
                           ->where('DATE(tgl_simpan)',$this->input->get('query'))
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }
                    break;
                
                case 'per_rentang':
//                    $sql = $this->db->query("SELECT kode, DATE(tgl_simpan) as tgl_simpan, keterangan, jumlah, nominal, tipe, jenis FROM tbl_akt_modal WHERE tipe='masuk' AND DATE(tgl_simpan) BETWEEN '".$this->input->get('tgl_awal')."' AND '".$this->input->get('tgl_akhir')."' ORDER BY id DESC")->result();
                    if($status == 'semua'){
                       $sql = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           
                           ->where('DATE(tgl_simpan) >',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl_simpan) <',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }else{
                       $sql = $this->db
                           ->select('id_user, DATE(tgl_simpan) as tgl, kode, keterangan, nominal')
                           
                           
                           ->where('DATE(tgl_simpan) >=',$this->input->get('tgl_awal'))
                           ->where('DATE(tgl_simpan) =<',$this->input->get('tgl_akhir'))
                           ->order_by('id','desc')->get('tbl_akt_modal')->result();
                        
                    }
                    break;
            }

            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA MODAL";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(12.5, .5, 'Keterangan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Nominal', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                foreach ($sql as $pemasukan) {
                    $tot = $tot + $pemasukan->nominal;
                    $tgl = explode('-', $pemasukan->tgl);
                    $jns = $this->db->where('id', $pemasukan->id_jenis)->get('tbl_akt_kas_jns')->row();
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5,$tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(12.5, .5, $pemasukan->keterangan, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(3, .5, general::format_angka($pemasukan->nominal), 1, 0, 'R', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(16, .5, 'Total', 1, 0, 'R');
                $this->fpdf->Cell(3, .5, general::format_angka($tot), 1, 0, 'R');
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_modal_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }

    public function pdf_lr(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            switch ($case){
                case 'semua':
                    $subjudul  = 'LABA / RUGI';
                    
                    $penjualan = $this->db
                        ->select('SUM(jml_gtotal) as jml_gtotal')
                        ->where('status_nota >','0')
                        ->get('tbl_trans_jual')->row();
                    
                    $op_kas = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->get('tbl_akt_kas')->row();
                    
                    $op_kas_det = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->get('tbl_akt_kas')->result();
                    
                    $op_bank = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->get('tbl_akt_kas')->row();
                    
                    $op_bank_det = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->get('tbl_akt_kas')->result();
                    
                    $hpp = $this->db
                        ->select('SUM(tbl_m_produk.harga_beli) as harga_beli, SUM(tbl_trans_jual_det.jml) as jml')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->join('tbl_trans_jual_det','tbl_trans_jual_det.no_nota=tbl_trans_jual.no_nota')
                        ->join('tbl_m_produk','tbl_m_produk.id=tbl_trans_jual_det.id_produk')
                        ->get('tbl_trans_jual')->row();
                                        
                    $pnj = $penjualan->jml_gtotal;
                    $png = $hpp->harga_beli + $op_kas->nominal + $op_bank->nominal;
                    $lr  = $penjualan->jml_gtotal - ($hpp->harga_beli + $op_kas->nominal + $op_bank->nominal);
                    break;
                
                case 'per_tanggal':
                    $tgl       = explode('-', $this->input->get('query'));
                    $subjudul  = 'LABA / RUGI  '.$tgl[1].'/'.$tgl[1].'/'.$tgl[0];
                    
                    $penjualan = $this->db
                        ->select('SUM(jml_gtotal) as jml_gtotal')
                        ->where('status_nota >','0')
                        ->where('DATE(tgl_simpan)',$this->input->get('query'))
                        ->get('tbl_trans_jual')->row();
                    
                    $op_kas = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->where('DATE(tgl)',$this->input->get('query'))
                        ->get('tbl_akt_kas')->row();
                    
                    $op_kas_det = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->where('DATE(tgl)',$this->input->get('query'))
                        ->get('tbl_akt_kas')->result();
                    
                    $op_bank = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->where('DATE(tgl)',$this->input->get('query'))
                        ->get('tbl_akt_kas')->row();
                    
                    $op_bank_det = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->where('DATE(tgl)',$this->input->get('query'))
                        ->get('tbl_akt_kas')->result();
                    
                    $hpp = $this->db
                        ->select('SUM(tbl_m_produk.harga_beli) as harga_beli, SUM(tbl_trans_jual_det.jml) as jml')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->where('DATE(tbl_trans_jual.tgl_simpan)',$this->input->get('query'))
                        ->join('tbl_trans_jual_det','tbl_trans_jual_det.no_nota=tbl_trans_jual.no_nota')
                        ->join('tbl_m_produk','tbl_m_produk.id=tbl_trans_jual_det.id_produk')
                        ->get('tbl_trans_jual')->row();
                                        
                    $pnj = $penjualan->jml_gtotal;
                    $png = $hpp->harga_beli + $op_kas->nominal + $op_bank->nominal;
                    $lr = $penjualan->jml_gtotal - ($hpp->harga_beli + $op_kas->nominal + $op_bank->nominal);
                    break;
                
                case 'per_rentang':
                    $tgl_awal  = explode('-', $this->input->get('tgl_awal'));
                    $tgl_akhir = explode('-', $this->input->get('tgl_akhir'));
                    $subjudul  = 'LABA / RUGI  '.$tgl_awal[1].'/'.$tgl_awal[1].'/'.$tgl_awal[0].' s/d '.$tgl_akhir[1].'/'.$tgl_akhir[1].'/'.$tgl_akhir[0];
                    
                    $penjualan = $this->db
                        ->select('SUM(jml_gtotal) as jml_gtotal')
                        ->where('status_nota >','0')
                        ->where('DATE(tgl_simpan) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl_simpan) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_trans_jual')->row();
                    
                    $op_kas = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_akt_kas')->row();
                    
                    $op_kas_det = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','kas')
                        ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_akt_kas')->result();
                    
                    $op_bank = $this->db
                        ->select('SUM(nominal) as nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_akt_kas')->row();
                    
                    $op_bank_det = $this->db
                        ->select('id, kode, keterangan, nominal')
                        ->where('tipe','keluar')
                        ->where('status_kas','bank')
                        ->where('DATE(tgl) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tgl) <=',$this->input->get('tgl_akhir'))
                        ->get('tbl_akt_kas')->result();
                    
                    $hpp = $this->db
                        ->select('SUM(tbl_m_produk.harga_beli) as harga_beli, SUM(tbl_trans_jual_det.jml) as jml')
                        ->where('tbl_trans_jual.status_nota >','0')
                        ->where('DATE(tbl_trans_jual.tgl_simpan) >=',$this->input->get('tgl_awal'))
                        ->where('DATE(tbl_trans_jual.tgl_simpan) <=',$this->input->get('tgl_akhir'))
                        ->join('tbl_trans_jual_det','tbl_trans_jual_det.no_nota=tbl_trans_jual.no_nota')
                        ->join('tbl_m_produk','tbl_m_produk.id=tbl_trans_jual_det.id_produk')
                        ->get('tbl_trans_jual')->row();
                    
                    $pnj = $penjualan->jml_gtotal;
                    $png = $hpp->harga_beli + $op_kas->nominal + $op_bank->nominal;
                    $lr  = $penjualan->jml_gtotal - ($hpp->harga_beli + $op_kas->nominal + $op_bank->nominal);
                    break;
            }
            
            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN LABA / RUGI";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//           Header tabel
            $this->fpdf->Cell(19, .5, $subjudul, 0, 0, 'L', FALSE);
            $this->fpdf->Ln(1);
            
            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Cell(12, .5, 'Penjualan', 0, 0, 'L', FALSE);
            $this->fpdf->Cell(.5, .5, ':', 0, 0, 'C', FALSE);
            $this->fpdf->Cell(2.5, .5, '', 0, 0, 'R', FALSE);
            $this->fpdf->Cell(2.5, .5, general::format_angka($penjualan->jml_gtotal), 0, 0, 'R', FALSE);
            $this->fpdf->Ln(1);
            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Cell(12, .5, 'HPP Penjualan', 0, 0, 'L', FALSE);
            $this->fpdf->Cell(.5, .5, ':', 0, 0, 'C', FALSE);
            $this->fpdf->Cell(2.5, .5, general::format_angka($hpp->harga_beli), 0, 0, 'R', FALSE);
            $this->fpdf->Cell(2.5, .5, '', 0, 0, 'R', FALSE);
            $this->fpdf->Ln();
            
            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Cell(12, .5, 'Operasional Kas', 0, 0, 'L', FALSE);
            $this->fpdf->Cell(.5, .5, ':', 0, 0, 'C', FALSE);
            $this->fpdf->Cell(2.5, .5, general::format_angka($op_kas->nominal), 0, 0, 'R', FALSE);
            $this->fpdf->Cell(2.5, .5, '', 0, 0, 'R', FALSE);
            $this->fpdf->Ln();
            
            $this->fpdf->SetFont('Arial', '', '10');
            if (!empty($op_kas_det)) {
                $tot_kas = 0;
                $no      = 1;
                foreach ($op_kas_det as $op_kas_det) {
                    $tot_kas = $tot_kas + $op_kas_det->nominal;
                    
                    $this->fpdf->Cell(12, .5, ' '.$no.' ' . $op_kas_det->keterangan, 0, 0, 'L', FALSE);
                    $this->fpdf->Cell(.5, .5, ':', 0, 0, 'C', FALSE);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($op_kas_det->nominal), 0, 0, 'R', FALSE);
                    $this->fpdf->Cell(2.5, .5, '', 0, 0, 'R', FALSE);
                    $this->fpdf->Ln();
                    
                    if($no % 40 == 0){                        
                        $this->fpdf->AddPage();
                    }
                    $no++;
                }

                $this->fpdf->Cell(12, .5, 'Total', 0, 0, 'R', FALSE);
                $this->fpdf->Cell(.5, .5, ':', 0, 0, 'C', FALSE);
                $this->fpdf->Cell(2.5, .5, general::format_angka($tot_kas), 'T', 0, 'R', FALSE);
                $this->fpdf->Cell(2.5, .5, '', 0, 0, 'R', FALSE);
                $this->fpdf->Ln();
            }

            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Cell(12, .5, 'Operasional Bank', 0, 0, 'L', FALSE);
            $this->fpdf->Cell(.5, .5, ':', 0, 0, 'C', FALSE);
            $this->fpdf->Cell(2.5, .5, general::format_angka($op_bank->nominal), 0, 0, 'R', FALSE);
            $this->fpdf->Cell(2.5, .5, '', 0, 0, 'R', FALSE);
            $this->fpdf->Ln();
            
            $this->fpdf->SetFont('Arial', '', '10');
            if (!empty($op_bank_det)) {
                $tot_bank = 0;
                $no2      = 1;
                foreach ($op_bank_det as $op_bank_det) {
                    $tot_bank = $tot_bank + $op_bank_det->nominal;
                    
                    $this->fpdf->Cell(12, .5, ' '.$no2.' ' . $op_bank_det->keterangan, 0, 0, 'L', FALSE);
                    $this->fpdf->Cell(.5, .5, ':', 0, 0, 'C', FALSE);
                    $this->fpdf->Cell(2.5, .5, general::format_angka($op_bank_det->nominal), 0, 0, 'R', FALSE);
                    $this->fpdf->Cell(2.5, .5, '', 0, 0, 'R', FALSE);
                    $this->fpdf->Ln();
                    
                    if($no % 40 == 0){                        
                        $this->fpdf->AddPage();
                    }
                    $no2++;
                }
                
                $this->fpdf->Cell(12, .5, 'Total', 0, 0, 'R', FALSE);
                $this->fpdf->Cell(.5, .5, ':', 0, 0, 'C', FALSE);
                $this->fpdf->Cell(2.5, .5, general::format_angka($tot_bank), 'T', 0, 'R', FALSE);
                $this->fpdf->Cell(2.5, .5, '', 0, 0, 'R', FALSE);
                $this->fpdf->Ln();
            }

            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Cell(12, .5, 'Grand Total', '', 0, 'R', FALSE);
            $this->fpdf->Cell(.5, .5, ':', '', 0, 'C', FALSE);
            $this->fpdf->Cell(2.5, .5, '', 'T', 0, 'R', FALSE);
            $this->fpdf->Cell(2.5, .5, '('.general::format_angka($png).')', '0', 0, 'R', FALSE);
            $this->fpdf->Ln();
            
            $laba_rugi = ($lr < 0 ? '('.general::format_angka(str_replace('-','',$lr)).')' : general::format_angka($lr));
            
            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Cell(12, .5, 'L / R', 0, 0, 'R', FALSE);
            $this->fpdf->Cell(.5, .5, ':', 0, 0, 'C', FALSE);
            $this->fpdf->Cell(5, .5, $laba_rugi, 'T', 0, 'R', FALSE);
            $this->fpdf->Ln();
            
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_laba_rugi_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    
    
    public function set_lap_penjahit(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $penjahit    = $this->input->post('penjahit');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];
            
            if(!empty($tgl)){
                redirect('page=laporan&act=data_penjahit&case=per_tanggal&query='.$tgl_skrg);
            }elseif(!empty ($all)){
                redirect('page=laporan&act=data_penjahit&case=semua');
            }elseif(!empty ($penjahit)){
                redirect('page=laporan&act=data_penjahit&case=nama&query='.$penjahit);
            }elseif(!empty ($tgl_rentang)){
                redirect('page=laporan&act=data_penjahit&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_produk(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];
            
            if(!empty($tgl)){
                redirect('page=laporan&act=data_produk&case=per_tanggal&query='.$tgl_skrg);
            }elseif(!empty ($all)){
                redirect('page=laporan&act=data_produk&case=semua');
            }elseif(!empty ($tgl_rentang)){
                redirect('page=laporan&act=data_produk&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_penjualan(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $cabang      = $this->input->post('cabang');
            $tipe        = $this->input->post('tipe');
            $sb          = ($_POST['tipe_byr'] == '3' ? 'x' : $this->input->post('tipe_byr'));
            $rute        = $this->input->post('route');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty ($hari_ini)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan').'&case=per_tanggal&query='.$tgl_skrg.'&cabang='.$cabang.'&tipe='.$tipe.'&sb='.$sb);
            } else {
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan').'&case=cabang&cabang='.$cabang.'&tipe='.$tipe.'&sb='.$sb);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_penjualan_det(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $cabang      = $this->input->post('cabang');
            $tipe        = $this->input->post('tipe');
            $rute        = $this->input->post('route');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty ($hari_ini)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan_det').'&case=per_tanggal&query='.$tgl_skrg.'&cabang='.$cabang.'&tipe='.$tipe);
            } else {
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan_det').'&case=cabang&cabang='.$cabang.'&tipe='.$tipe);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_penjualan_det2(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $cabang      = $this->input->post('cabang');
            $tipe        = $this->input->post('tipe');
            $rute        = $this->input->post('route');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty ($tgl)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan_det').'&case=per_tanggal&query='.$tgl_skrg.'&cabang='.$cabang.'&tipe='.$tipe);
            }elseif(!empty ($tgl_rentang)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan_det').'&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&cabang='.$cabang.'&tipe='.$tipe);
            } else {
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan_det').'&case=cabang&cabang='.$cabang.'&tipe='.$tipe);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_keuangan(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $cabang      = $this->input->post('cabang');
            $tipe        = $this->input->post('tipe');
            $tipe_byr    = ($_POST['tipe_byr'] == '3' ? 'x' : $this->input->post('tipe_byr'));
            $rute        = $this->input->post('route');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty ($hari_ini)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_keuangan').'&case=per_tanggal&query='.$tgl_skrg.'&cabang='.$cabang.'&tipe='.$tipe.'&tipe_byr='.$tipe_byr);
            } else {
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_keuangan').'&case=cabang&cabang='.$cabang.'&tipe='.$tipe.'&tipe_byr='.$tipe_byr);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_keuangan2(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $cabang      = $this->input->post('cabang');
            $tipe        = $this->input->post('tipe');
            $rute        = $this->input->post('route');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty ($tgl)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_keuangan').'&case=per_tanggal&query='.$tgl_skrg.'&cabang='.$cabang.'&tipe='.$tipe);
            }elseif(!empty ($tgl_rentang)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_keuangan').'&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&cabang='.$cabang.'&tipe='.$tipe);
            } else {
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_keuangan').'&case=cabang&cabang='.$cabang.'&tipe='.$tipe);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_keuangan3(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $cabang      = $this->input->post('cabang');
            $sales       = $this->input->post('sales');
            $tipe        = $this->input->post('tipe');
            $rute        = $this->input->post('route');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty ($tgl)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_keuangan').'&case=per_sales&sales='.$sales.'&query='.$tgl_skrg.'&cabang='.$cabang.'&tipe='.$tipe);
            }elseif(!empty ($tgl_rentang)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_keuangan').'&case=per_sales&sales='.$sales.'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&cabang='.$cabang.'&tipe='.$tipe);
            }elseif(!empty ($sales)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_keuangan').'&case=per_sales&sales='.$sales.'&query=&cabang='.$cabang.'&tipe='.$tipe);
            } else {
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_keuangan').'');
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_packing(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $cabang      = $this->input->post('cabang');
            $tipe        = $this->input->post('tipe');
            $rute        = $this->input->post('route');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty ($hari_ini)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_packing').'&case=per_tanggal&query='.$tgl_skrg.'&cabang='.$cabang.'&tipe='.$tipe);
            } else {
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_packing').'&case=cabang&cabang='.$cabang.'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&tipe='.$tipe);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_penjualan2(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $cabang      = $this->input->post('cabang');
            $tipe        = $this->input->post('tipe');
            $sb          = ($_POST['tipe_byr'] == '3' ? 'x' : $this->input->post('tipe_byr'));
            $rute        = $this->input->post('route');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty ($tgl)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan').'&case=per_tanggal&query='.$tgl_skrg.'&cabang='.$cabang.'&tipe='.$tipe.'&sb='.$sb);
            }elseif(!empty ($tgl_rentang)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan').'&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&cabang='.$cabang.'&tipe='.$tipe.'&sb='.$sb);
            } else {
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan').'&case=cabang&cabang='.$cabang.'&tipe='.$tipe.'&sb='.$sb);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_penjualan3(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $cabang      = $this->input->post('cabang');
            $sales       = $this->input->post('sales');
            $tipe        = $this->input->post('tipe');
            $sb          = ($_POST['tipe_byr'] == '3' ? 'x' : $this->input->post('tipe_byr'));
            $rute        = $this->input->post('route');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty ($tgl)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan').'&case=per_sales&sales='.$sales.'&query='.$tgl_skrg.'&cabang='.$cabang.'&tipe='.$tipe.'&sb='.$sb);
            }elseif(!empty ($tgl_rentang)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan').'&case=per_sales&sales='.$sales.'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&cabang='.$cabang.'&tipe='.$tipe.'&sb='.$sb);
            }elseif(!empty ($sales)){
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan').'&case=per_sales&sales='.$sales.'&query=&cabang='.$cabang.'&tipe='.$tipe.'&sb='.$sb);
            } else {
                redirect('page=laporan&act='.(!empty($rute) ? $rute : 'data_penjualan').'');
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_member(){
        if (akses::aksesLogin() == TRUE) {
            $nik  = $this->input->post('nik');
            $nama = $this->input->post('nama');
            
            redirect('page=laporan&act=data_member&nik='.$nik.'&nama='.$nama);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_member_dep(){
        if (akses::aksesLogin() == TRUE) {
            $nik  = $this->input->post('nik');
            $nama = $this->input->post('nama');
            
            redirect('page=laporan&act=data_deposit&nik='.$nik.'&nama='.$nama);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
        
    public function set_lap_insentif(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');            
            $sales       = $this->input->post('sales');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty($all)){
                redirect('page=laporan&act=data_insentif&case=semua');

            }elseif(!empty($sales)){
                redirect('page=laporan&act=data_insentif&case=sales&query='.$sales);
                
            }elseif($tgl_skrg != '--'){
                redirect('page=laporan&act=data_insentif&case=per_tanggal&query='.$tgl_skrg);
                
            }elseif(!empty($tgl_rentang)){
                redirect('page=laporan&act=data_insentif&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir);
                
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_pemasukan(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $jenis       = $this->input->post('jenis');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty($all)){
                redirect('page=laporan&act=data_pemasukan&case=semua&status='.$jenis);
                
            }elseif($tgl_skrg != '--'){
                redirect('page=laporan&act=data_pemasukan&case=per_tanggal&query='.$tgl_skrg.'&status='.$jenis);
                
            }elseif(!empty($tgl_rentang)){
                redirect('page=laporan&act=data_pemasukan&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&status='.$jenis);
                
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_pengeluaran(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $jenis       = $this->input->post('jenis');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty($all)){
                redirect('page=laporan&act=data_pengeluaran&case=semua&status='.$jenis);
                
            }elseif($tgl_skrg != '--'){
                redirect('page=laporan&act=data_pengeluaran&case=per_tanggal&query='.$tgl_skrg.'&status='.$jenis);
                
            }elseif(!empty($tgl_rentang)){
                redirect('page=laporan&act=data_pengeluaran&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&status='.$jenis);
                
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_kas(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $jenis       = $this->input->post('jenis');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty($all)){
                redirect('page=laporan&act=data_kas&case=semua&status='.$jenis);
                
            }elseif($tgl_skrg != '--'){
                redirect('page=laporan&act=data_kas&case=per_tanggal&query='.$tgl_skrg.'&status='.$jenis);
                
            }elseif(!empty($tgl_rentang)){
                redirect('page=laporan&act=data_kas&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&status='.$jenis);
                
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_piutang(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $sales       = $this->input->post('sales');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty($all)){
                redirect('page=laporan&act=data_piutang&case=semua');

            }elseif(!empty($sales)){
                redirect('page=laporan&act=data_piutang&case=sales&query='.$sales);
                
            }elseif($tgl_skrg != '--'){
                redirect('page=laporan&act=data_piutang&case=per_tanggal&query='.$tgl_skrg);
                
            }elseif(!empty($tgl_rentang)){
                redirect('page=laporan&act=data_piutang&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir);
                
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_lr(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $jenis       = $this->input->post('jenis');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty($all)){
                redirect('page=laporan&act=data_lr&case=semua&status='.$jenis);
                
            }elseif($tgl_skrg != '--'){
                redirect('page=laporan&act=data_lr&case=per_tanggal&query='.$tgl_skrg.'&status='.$jenis);
                
            }elseif(!empty($tgl_rentang)){
                redirect('page=laporan&act=data_lr&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&status='.$jenis);
                
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    public function set_lap_modal(){
        if (akses::aksesLogin() == TRUE) {
            $all         = $this->input->post('semua');
            $hari_ini    = $this->input->post('hari_ini');
            $tgl         = $this->input->post('tgl');
            $tgl_rentang = $this->input->post('tgl_rentang');
            $jenis       = $this->input->post('jenis');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];

            if(!empty($all)){
                redirect('page=laporan&act=data_modal&case=semua&status='.$jenis);
                
            }elseif($tgl_skrg != '--'){
                redirect('page=laporan&act=data_modal&case=per_tanggal&query='.$tgl_skrg.'&status='.$jenis);
                
            }elseif(!empty($tgl_rentang)){
                redirect('page=laporan&act=data_modal&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&status='.$jenis);
                
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    
    public function set_filter_penjualan(){
        if (akses::aksesLogin() == TRUE) {
            $case        = $this->input->post('case');
            $query       = $this->input->post('query');
            $tgl_awal    = $this->input->post('tgl_awal');
            $tgl_akhir   = $this->input->post('tgl_akhir');
            $sales       = $this->input->post('sales');
            $tipe        = $this->input->post('tipe');
            
            $rentang     = explode('-', $tgl_rentang);
            $t_awal      = explode('/', str_replace(' ','',$rentang[0]));
            $t_akhir     = explode('/', str_replace(' ','',$rentang[1]));
            $tgl_awal    = $t_awal[2].'-'.$t_awal[0].'-'.$t_awal[1];
            $tgl_akhir   = $t_akhir[2].'-'.$t_akhir[0].'-'.$t_akhir[1];
            
            $tgl_ini     = (!empty($tgl) ? $tgl : $hari_ini);
            $dino_iki    = explode('/', $tgl_ini);
            $tgl_skrg    = $dino_iki[2].'-'.$dino_iki[0].'-'.$dino_iki[1];
            
            switch ($case){
                case 'semua':
                    redirect('page=laporan&act=data_penjualan&case=semua&tipe='.$tipe.'&sales='.$sales);
                    break;
                
                case 'sales':
                    redirect('page=laporan&act=data_penjualan&case=semua&tipe='.$tipe);
                    break;
                
                case 'per_tanggal':
                    redirect('page=laporan&act=data_penjualan&case=per_tanggal&query='.$query.'&tipe='.$tipe.'&sales='.$sales);
                    break;
                
                case 'per_rentang':
                    
                    break;
            }

//            if(!empty($all)){
//                redirect('page=laporan&act=data_penjualan&case=semua&tipe='.$tipe);
//
//            }elseif(!empty($sales)){
//                redirect('page=laporan&act=data_penjualan&case=sales&query='.$sales.'&tipe='.$tipe);
//                
//            }elseif($tgl_skrg != '--'){
//                redirect('page=laporan&act=data_penjualan&case=per_tanggal&query='.$tgl_skrg.'&tipe='.$tipe);
//                
//            }elseif(!empty($tgl_rentang)){
//                redirect('page=laporan&act=data_penjualan&case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&tipe='.$tipe);
//                
//            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
}
