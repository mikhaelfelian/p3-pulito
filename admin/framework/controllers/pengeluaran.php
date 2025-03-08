<?php

/**
 * Description of pengeluaran
 *
 * @author mike
 */
class pengeluaran extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('fpdf');
        $this->load->library('cart');
    }    
   
    public function pengeluaran_list(){
        if (akses::aksesLogin() == TRUE OR akses::aksesUser() == TRUE) {
//            if (isset($_GET['jml'])) {
//                $config['base_url']     = base_url('index.php?page=transaksi&act=pengeluaran_list&q=' . $_GET['q'] . '&jml=' . $_GET['jml']);
//                $config['total_rows']   = $_GET['jml'];
//            } else {
//                $config['base_url']     = base_url('index.php?page=transaksi&act=pengeluaran_list');
//                $config['total_rows']   = $this->db->count_all('tbl_pengeluaran');
//            }
//
//            $config['query_string_segment'] = 'halaman';
//            $config['page_query_string'] = TRUE;
//            $config['per_page'] = 10;
//            $config['num_links'] = 1;
//
//            $config['first_link'] = $this->first;
//            $config['prev_link'] = $this->prev;
//            $config['next_link'] = $this->next;
//            $config['last_link'] = $this->last;
//
//            $config['cur_tag_open'] = '<a href="#" style="color:#ffffff;background-color:#999999;cursor:default;">';
//            $config['cur_tag_close'] = '</a>';
//
//            $this->pagination->initialize($config);
//
//            $data['total_rows'] = $config['total_rows'];
//            $data['PerPage'] = $config['per_page'];
//
//            if (isset($_GET['halaman']) AND ! empty($_GET['halaman'])) {
//                if (isset($_GET['q'])) {
//                    $data['pengeluaran'] = $this->db->query("SELECT id_pengeluaran, DATE(tgl) as tgl, TIME(tgl) as waktu, kode, pengeluaran, nominal FROM tbl_pengeluaran WHERE tbl_pengeluaran.pengeluaran LIKE '%" . $_GET['q'] . "%' OR kode LIKE '%".$_GET['q']."%' ORDER BY tbl_pengeluaran.id_pengeluaran ASC LIMIT " . $_GET['halaman'] . "," . $config['per_page'] . "")->result();
//                } else {
//                    $data['pengeluaran'] = $this->db->query("SELECT id_pengeluaran, DATE(tgl) as tgl, TIME(tgl) as waktu, kode, pengeluaran, nominal FROM tbl_pengeluaran ORDER BY tbl_pengeluaran.id_pengeluaran ASC LIMIT " . $_GET['halaman'] . "," . $config['per_page'] . "")->result();
//                }
//            } else {
                if (isset($_GET['q'])) {
                    $data['pengeluaran'] = $this->db->query("SELECT id, DATE(tgl) as tgl, TIME(tgl) as waktu, kode, pengeluaran, nominal, jenis FROM tbl_pengeluaran WHERE tbl_pengeluaran.pengeluaran LIKE '%" . $_GET['q'] . "%' OR kode LIKE '%".$_GET['q']."%' ORDER BY tbl_pengeluaran.id ASC")->result();
                } else {
                    $data['pengeluaran'] = $this->db->query("SELECT id, DATE(tgl) as tgl, TIME(tgl) as waktu, kode, pengeluaran, nominal, jenis FROM tbl_pengeluaran ORDER BY tbl_pengeluaran.id ASC")->result();
                }
//            }

            $data['pagination'] = ''; //$this->pagination->create_links();
            
            $this->load->view('1_atas', $data);
            $this->load->view('2_navbar', $data);
            $this->load->view('includes/pengeluaran/pengeluaran', $data); // Beranda
            $this->load->view('4_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect(site_url());
        }
    }
    
    public function pengeluaran_tambah(){
        if (akses::aksesLogin() == TRUE OR akses::aksesUser() == TRUE) {
            $data['pemb']        = $this->session->userdata('temp_peng_set');
            $data['pemb_detail'] = $this->cart->contents();
            $data['dal']         = $this->db->query("SELECT * FROM tbl_peng_anggaran WHERE id='".$data['pemb']['anggaran']."'")->row();
            $data['da']          = $this->db->query("SELECT * FROM tbl_peng_anggaran WHERE status='setuju'")->result();
            $data['anggaran']    = $this->db->query("SELECT * FROM tbl_peng_anggaran_det")->result();
            $data['anggaran_det']= $this->db->query("SELECT * FROM tbl_peng_anggaran_det WHERE id='".$data['pemb']['kode']."'")->row();
            
            $this->load->view('1_atas', $data);
            $this->load->view('2_navbar', $data);
            $this->load->view('includes/pengeluaran/pengeluaran_t', $data); // Beranda
            $this->load->view('4_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect(site_url());
        }
    }
    
    public function pengeluaran_det(){
        if (akses::aksesLogin() == TRUE OR akses::aksesUser() == TRUE) {
            $id = general::dekrip($_GET['id']);
            $data['pemb']        = $this->db->query("SELECT DATE(tgl) as tgl,kode,pengeluaran,nominal,id_anggaran_det FROM tbl_pengeluaran WHERE kode='".$id."'")->row();
            $data['pemb_detail'] = $this->db->query("SELECT * FROM tbl_pengeluaran_det WHERE kode='".$id."'")->result();
            
            $this->load->view('1_atas', $data);
            $this->load->view('2_navbar', $data);
            $this->load->view('includes/pengeluaran/pengeluaran_d', $data); // Beranda
            $this->load->view('4_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect(site_url());
        }
    }
    
    public function temp_peng_set() {
        if (akses::aksesLogin() == TRUE) {
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            $this->form_validation->set_rules('no_nota', 'Supplier', 'required');
            $this->form_validation->set_rules('tgl', 'Tanggal', 'required');
            $this->form_validation->set_rules('kode', 'Kode Anggaran', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'tgl'        => form_error('tgl'),
                    'nota_nota'  => form_error('no_nota'),
                    'kode'       => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=pengeluaran&act=pengeluaran_tambah');
            } else {
                $tgl     = $this->input->post('tgl');
                $no_nota = $this->input->post('no_nota');
                $nama    = $this->input->post('nama_supplier');
                $kode    = $this->input->post('kode');
                $anggaran= $this->input->post('nama_anggaran');

                $data = Array(
                    'tgl_simpan' => $tgl,
                    'no_nota'    => $no_nota,
                    'nama'       => $nama,
                    'kode'       => $kode,
                    'anggaran'   => $anggaran,
                );

                $this->session->set_userdata('temp_peng_set', $data);
                redirect('page=pengeluaran&act=pengeluaran_tambah');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function temp_cart_set() {
        if (akses::aksesLogin() == TRUE) {
            $nota      = $this->input->post('nota');

            $bahan     = $this->input->post('bahan');
            $qty       = $this->input->post('jml');
            $harga     = $this->input->post('harga');
            $ket       = $this->input->post('ket');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            $this->form_validation->set_rules('bahan', 'Bahan', 'required');
            $this->form_validation->set_rules('jml', 'Jml', 'trim|required|numeric');
            $this->form_validation->set_rules('harga', 'Harga', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'bahan'     => form_error('bahan'),
                    'jml'       => form_error('jml'),
                    'harga'     => form_error('harga'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=pengeluaran&act=pengeluaran_tambah');
            } else {
                $price    = str_replace('.', '', $harga);
                $data = array(
                    'id'    => rand(1,64).rand(1, 32),
                    'name'  => $bahan,
                    'qty'   => $qty,
                    'price' => $price,
                    'options' => array(
                        'nota'      => $nota,
                        'ket'       => $ket
                    )
                );

                $this->cart->insert($data);
//                crud::update('tbl_m_bahan','id',$id_bahan, array('qty_awal'=>$tot_stok));
//                crud::simpan('tbl_pembelian_det', $data);
                redirect('page=pengeluaran&act=pengeluaran_tambah');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function temp_cart_del() {
        if (akses::aksesLogin() == TRUE) {
            $id = general::dekrip($_GET['id']);
            $nota = $_GET['nota'];
            $data = array(
                'rowid' => $id,
                'qty' => 0
            );

//            crud::delete('tbl_pembelian_det', 'id', $id);
            $this->cart->update($data);
            redirect('page=pengeluaran&act=pengeluaran_tambah');
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function proses_pemb() {
        if (akses::aksesLogin() == TRUE) {
            $peng = $this->session->userdata('temp_peng_set');
            $cart = $this->cart->contents();
            
            if(!empty($cart)){
                foreach ($cart as $cart){
                    $pem_det = array(
                        'ket'      => $cart['options']['ket'],
                        'kode'     => $cart['options']['nota'],
                        'barang'   => $cart['name'],
                        'qty'      => $cart['qty'],
                        'harga'    => $cart['price'],
                        'subtotal' => $cart['subtotal'],
                    );
                    
                    crud::simpan('tbl_pengeluaran_det',$pem_det);
                }
                
                $pem_data = array(
                    'tgl'              => $peng['tgl_simpan'],
                    'kode'             => $peng['no_nota'],
                    'pengeluaran'      => $peng['nama'],
                    'nominal'          => $this->cart->total(),
                    'id_anggaran_det'  => $peng['kode'],
                    'id_anggaran'      => $peng['anggaran'],
                );
                
                crud::simpan('tbl_pengeluaran',$pem_data);
                
                $this->session->unset_userdata('temp_peng_set');
                $this->cart->destroy();
            }
            redirect('page=pengeluaran&act=pengeluaran_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function pengeluaran_simpan(){
        if (akses::aksesLogin() == TRUE OR akses::aksesUser() == TRUE) {
            $tgl            = $this->input->post('tgl');
            $kode           = $this->input->post('kode');
            $cetak          = $this->input->post('cetak');
            $pengeluaran    = $this->input->post('pengeluaran');
            $nominal        = str_replace(array('.'),'',$this->input->post('nominal'));
            
                   
            // Setting Validasi Form
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode Pengeluaran', 'required');
            $this->form_validation->set_rules('pengeluaran', 'Pengeluaran', 'required');
            $this->form_validation->set_rules('nominal', 'Nama Produk', 'required');
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'          => form_error('kode'),
                    'pengeluaran'   => form_error('pengeluaran'),
                    'nominal'       => form_error('nominal')
                );

                $has_error = array(
                    'kode'          => 'has-error',
                    'pengeluaran'   => 'has-error',
                    'nominal'       => 'has-error'
                );

                // Form Error
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                redirect('page=pengeluaran&act=pengeluaran_tambah');
            } else {
                $data = array(
                    'tgl'           => $tgl,
                    'kode'          => $kode,
                    'pengeluaran'   => $pengeluaran,
                    'nominal'       => $nominal,
                    'anggaran'      => $anggaran,
                );

                $cu = crud::simpan('tbl_pengeluaran', $data);
                if ($cu == TRUE) {
                    if($cetak == '1'){
                        redirect('page=pengeluaran&act=termal_pengeluaran&id='.$kode.'&return=pengeluaran_list');
                    }else{                        
                        $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Pengeluaran berhasil disimpan !!</div>');
                        redirect('page=pengeluaran&act=pengeluaran_list');
                    }
                } else {
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Pengeluaran gagal disimpan !!</div>');
                    redirect('page=pengeluaran&act=pengeluaran_list');
                }
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect(site_url());
        }
    }
    
    public function pengeluaran_hps(){
        if (akses::aksesLogin() == TRUE OR akses::aksesUser() == TRUE) {
            $id = (isset($_GET['id']) ? $this->encrypt->decode_url($_GET['id']) : '');
            
            $sql = crud::delete('tbl_pengeluaran','id_pengeluaran',$id);
            if($sql == TRUE){
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Pemasukan berhasil disimpan !!</div>');
                redirect('page=transaksi&act=pengeluaran_list');
            }else{
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Pemasukan berhasil disimpan !!</div>');
                redirect('page=transaksi&act=pengeluaran_list');                
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect(site_url());
        }
    }
    
    
    public function pdf_pengeluaran() {
        if (akses::aksesLogin() == TRUE OR akses::aksesUser() == TRUE) {
            $setting    = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            
            if(!empty($_GET['order_tgl'])){
                $sql = $this->db->query("SELECT * FROM tbl_pengeluaran".(!empty($_GET['order_tgl']) ? " WHERE DATE(tgl)='".$_GET['order_tgl']."'" : ""))->result();
            }elseif(!empty($_GET['tgl_awal']) AND !empty($_GET['tgl_akhir'])){
                $sql = $this->db->query("SELECT * FROM tbl_pengeluaran WHERE DATE(tgl) BETWEEN '".$_GET['tgl_awal']."' AND '".$_GET['tgl_akhir']."'")->result();
            }else{
                $sql = $this->db->query("SELECT * FROM tbl_pengeluaran WHERE DATE(tgl)='".date('Y-m-d')."'")->result();
            }
            
            $judul      = "PENGELUARAN";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 0, 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->Cell(19, .5, $setting->tlp, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', 'B', '10');
            
            $this->fpdf->Cell(1, .5, 'No.', 1, 0, 'C');
            $this->fpdf->Cell(5, .5, 'Tgl', 1, 0, 'C');
            $this->fpdf->Cell(6.5, .5, 'Pengeluaran', 1, 0, 'L');
            $this->fpdf->Cell(6.5, .5, 'Nominal', 1, 0, 'C');
            $this->fpdf->Ln();
            
            $this->fpdf->SetFont('Arial', '', '10');
            if(!empty($sql)){
                $no    = 1;
                $total = 0;
                foreach ($sql as $sql){
                    $total = $total + $sql->nominal;
                    
                    $this->fpdf->Cell(1, .5, $no, 'LR', 0, 'C');
                    $this->fpdf->Cell(5, .5, general::tgl_indo($sql->tgl), 'LR', 0, 'C');
                    $this->fpdf->Cell(6.5, .5, $sql->pengeluaran, 'LR', 0, 'L');
                    $this->fpdf->Cell(6.5, .5, 'Rp. '.general::format_number($sql->nominal), 'LR', 0, 'L');
                    $this->fpdf->Ln();
                    $no++;
                }
                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Cell(12.5, .5, 'Grand Total', 1, 0, 'R');
                $this->fpdf->Cell(6.5, .5, 'Rp. '.general::format_number($total), 'BRT', 0, 'L');
            }
            
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            $this->fpdf->Output(date('Y-m-d').'_pengeluaran'. '.pdf', $type);
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect(site_url());
        }
    }
    

    // Cetak ke Nota
    public function termal_pengeluaran() {
        if (akses::aksesLogin() == TRUE) {            
            $setting    = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            
            if(isset($_GET['id'])){
                $sql = $this->db->query("SELECT id_pengeluaran, DATE(tgl) as tgl, kode, pengeluaran, jumlah, nominal FROM tbl_pengeluaran".(!empty($_GET['id']) ? " WHERE kode='".$_GET['id']."'" : ""))->result();
            }elseif(!empty($_GET['order_tgl'])){
                $sql = $this->db->query("SELECT id_pengeluaran, DATE(tgl) as tgl, kode, pengeluaran, jumlah, nominal FROM tbl_pengeluaran".(!empty($_GET['order_tgl']) ? " WHERE DATE(tgl)='".$_GET['order_tgl']."'" : ""))->result();
            }elseif(!empty($_GET['tgl_awal']) AND !empty($_GET['tgl_akhir'])){
                $sql = $this->db->query("SELECT id_pengeluaran, DATE(tgl) as tgl, kode, pengeluaran, jumlah, nominal FROM tbl_pengeluaran WHERE DATE(tgl) BETWEEN '".$_GET['tgl_awal']."' AND '".$_GET['tgl_akhir']."'")->result();
            }else{
                $sql = $this->db->query("SELECT id_pengeluaran, DATE(tgl) as tgl, kode, pengeluaran, jumlah, nominal FROM tbl_pengeluaran WHERE DATE(tgl)='".date('Y-m-d')."'")->result();
            }

            /* Printer Setting => Ambil dari database */
            $platform_os    = $setting->print_os;
            $printer_driver = $setting->print_driver;
            $printer_name   = $setting->print_name;
            $printer_method = $setting->print_method;
            require_once(realpath("./framework/libraries/escpos/Escpos.php"));
            $connector = new WindowsPrintConnector("EPSON TM-U220 Receipt");
            $printer = new Escpos($connector);

            $printer->setJustification(Escpos::JUSTIFY_CENTER);
            $printer->text($setting->judul . "\n");
            $printer->text($setting->alamat . "\n");
            $printer->text($setting->tlp . "\n");
            $printer->text("========================================\n");
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text("PENGELUARAN\n");
            $printer->text("\n");

            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $tot_bayar = 0;
            $no = 1;
            $gtotal = 0;
            foreach ($sql as $nota_det) {                
                $gtotal = $gtotal + $nota_det->nominal;
                $printer->text($no.".  ".general::tgl_indo($nota_det->tgl)."\n");
                $printer->text(" ".$nota_det->pengeluaran." Rp. ".general::format_number($nota_det->nominal)."\n");
            
                $no++;
            }
            

            $printer->text("----------------------------------------\n");
            $printer->setJustification(Escpos::JUSTIFY_RIGHT);
            $printer->text("Grand Total : Rp. ".general::format_number($gtotal)."\n");

            $printer->setJustification(Escpos::JUSTIFY_CENTER);
            $printer->text("\n");
            $printer->cut(Escpos::CUT_FULL, 10);
            $printer->close();

            if($_GET['return'] == 'pengeluaran_list'){
                redirect('page=pengeluaran&act=pengeluaran_list');
            }else{
                redirect('page=pengeluaran&act=pdf_peng&order_tgl='.$_GET['order_tgl'].'&tgl_awal='.$_GET['tgl_awal'].'&tgl_akhir='.$_GET['tgl_akhir']);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">' . $errors . '</div>');
            redirect('front/login.php');
        }
    }
}
