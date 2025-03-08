<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Description of produk
 *
 * @author mike
 */
class produk extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('pagination');
    }

    public function prod_penj_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_penjahit'));
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_penj_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 5;
            $config['num_links']             = 2;
            
            $config['first_tag_open']        = '<li>';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li>';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li>';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li>';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li>';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li><a href="#"><b>';
            $config['cur_tag_close']         = '</b></a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            
            
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['penjahit'] = $this->db->limit($config['per_page'],$hal)->like('penjahit', $query)->get('tbl_m_penjahit')->result();
                } else {
                    $data['penjahit'] = $this->db->limit($config['per_page'],$hal)->get('tbl_m_penjahit')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['penjahit'] = $this->db->limit($config['per_page'],$hal)->like('penjahit', $query)->get('tbl_m_penjahit')->result();
                } else {
                    $data['penjahit'] = $this->db->limit($config['per_page'])->get('tbl_m_penjahit')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_penj_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_penj_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $penjahit    = $this->input->post('penjahit');
            $keterangan  = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('penjahit', 'Nama Penjahit', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'penjahit'     => form_error('penjahit'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_penj_list');
            } else {
                $data_penj = array(
                    'tgl_simpan' => date('Y-m-d'),
                    'penjahit'   => $penjahit,
                    'keterangan' => $keterangan
                );

                crud::simpan('tbl_m_penjahit',$data_penj);
                redirect('page=produk&act=prod_penj_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_penj_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_penjahit','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_penj_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function prod_plat_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_platform'));
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_plat_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 5;
            $config['num_links']             = 2;
            
            $config['first_tag_open']        = '<li>';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li>';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li>';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li>';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li>';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li><a href="#"><b>';
            $config['cur_tag_close']         = '</b></a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            
            
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['platform'] = $this->db->limit($config['per_page'],$hal)->like('platform', $query)->get('tbl_m_platform')->result();
                } else {
                    $data['platform'] = $this->db->limit($config['per_page'],$hal)->get('tbl_m_platform')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['platform'] = $this->db->limit($config['per_page'],$hal)->like('platform', $query)->get('tbl_m_platform')->result();
                } else {
                    $data['platform'] = $this->db->limit($config['per_page'])->get('tbl_m_platform')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_plat_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_plat_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $platform    = $this->input->post('platform');
            $keterangan  = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('platform', 'Nama Penjahit', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'platform'     => form_error('platform'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_plat_list');
            } else {
                $data_penj = array(
                    'platform'   => $platform,
                    'keterangan' => $keterangan
                );

                crud::simpan('tbl_m_platform',$data_penj);
                redirect('page=produk&act=prod_plat_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_plat_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_platform','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_plat_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
  
    public function prod_kat_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_kategori'));
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_kat_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 5;
            $config['num_links']             = 2;
            
            $config['first_tag_open']        = '<li>';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li>';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li>';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li>';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li>';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li><a href="#"><b>';
            $config['cur_tag_close']         = '</b></a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            
            
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->like('kategori', $query)->get('tbl_m_kategori')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->get('tbl_m_kategori')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->like('kategori', $query)->get('tbl_m_kategori')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'])->get('tbl_m_kategori')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_kat_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kat_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $kategori    = $this->input->post('kategori');
            $keterangan  = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Nama Penjahit', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_kat_list');
            } else {
                $data_penj = array(
                    'kategori'   => $kategori,
                    'keterangan' => $keterangan
                );

                crud::simpan('tbl_m_kategori',$data_penj);
                redirect('page=produk&act=prod_kat_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kat_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_kategori','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_kat_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_stok_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            
            $pj = $this->input->get('filter_pj');
            $kd = $this->input->get('filter_kode');
            $pr = $this->input->get('filter_produk');
            $qt = $this->input->get('filter_qty');
            $hb = $this->input->get('filter_hb');
            $hj = $this->input->get('filter_hj');
            
            $jml_hal = (isset($_GET['jml']) ? $jml  : $this->db->count_all('tbl_m_produk'));
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_stok_list&filter_pj='.$pj.'&filter_kode='.$kd.'&filter_produk='.$pr.'&filter_qty='.$qt.'&filter_hb='.$hb.'&filter_hj='.$hj.'&jml='.$jml);
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 10;
            $config['num_links']             = 2;
            
            $config['first_tag_open']        = '<li>';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li>';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li>';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li>';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li>';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li><a href="#"><b>';
            $config['cur_tag_close']         = '</b></a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            
            
            if(!empty($hal)){
                $data['produk'] = $this->db->select('tbl_m_penjahit.penjahit, tbl_m_produk.id, tbl_m_produk.tgl_simpan, tbl_m_produk.kode, tbl_m_produk.produk, tbl_m_produk.harga_beli, tbl_m_produk.harga_jual, tbl_m_produk_stok.stok')
                        ->join('tbl_m_produk','tbl_m_produk.id=tbl_m_produk_stok.id_produk')
                        ->join('tbl_m_penjahit','tbl_m_penjahit.id=tbl_m_produk_stok.id_penjahit')                    ->like('tbl_m_penjahit.penjahit', $pj)
                        ->like('tbl_m_produk.kode', $kd)
                        ->like('tbl_m_produk.produk', $pr)
//                        ->like('tbl_m_produk_stok.stok', $sql)
                        ->like('tbl_m_produk.harga_beli', $hb)
                        ->like('tbl_m_produk.harga_jual', $hj)
                        ->limit($config['per_page'],$hal)
                        ->order_by('tbl_m_produk.id', 'desc')
                        ->get('tbl_m_produk_stok')->result();
            
            }else{
                $data['produk'] = $this->db->select('tbl_m_penjahit.penjahit, tbl_m_produk.id, tbl_m_produk.tgl_simpan, tbl_m_produk.kode, tbl_m_produk.produk, tbl_m_produk.harga_beli, tbl_m_produk.harga_jual, tbl_m_produk_stok.stok')
                        ->join('tbl_m_produk','tbl_m_produk.id=tbl_m_produk_stok.id_produk')
                        ->join('tbl_m_penjahit','tbl_m_penjahit.id=tbl_m_produk_stok.id_penjahit')                    ->like('tbl_m_penjahit.penjahit', $pj)
                        ->like('tbl_m_produk.kode', $kd)
                        ->like('tbl_m_produk.produk', $pr)
//                        ->like('tbl_m_produk_stok.stok', $sql)
                        ->like('tbl_m_produk.harga_beli', $hb)
                        ->like('tbl_m_produk.harga_jual', $hj)
                        ->limit($config['per_page'])
                        ->order_by('tbl_m_produk.id', 'desc')
                        ->get('tbl_m_produk_stok')->result();
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_stok_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            
            /* Filter Pencarian */
            $kd = $this->input->get('filter_kode');
            $pr = $this->input->get('filter_produk');
            $qt = $this->input->get('filter_qty');
            $hb = $this->input->get('filter_hb');
            $hj = $this->input->get('filter_hj');
            
            $jml_hal = (isset($_GET['jml']) ? $jml  : $this->db->count_all('tbl_m_produk'));
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_list&filter_kode='.$kd.'&filter_produk='.$pr.'&filter_qty='.$qt.'&filter_hb='.$hb.'&filter_hj='.$hj.(!empty($jml) ? '&jml='.$jml : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 10;
            $config['num_links']             = 2;
            
            $config['first_tag_open']        = '<li>';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li>';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li>';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li>';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li>';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li><a href="#"><b>';
            $config['cur_tag_close']         = '</b></a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            
            
            if(!empty($hal)){
                $data['produk'] = $this->db->like('kode',$kd)->like('produk',$pr)->like('jml',$qt)->like('harga_beli',$hb)->like('harga_jual',$hj)->limit($config['per_page'],$hal)->order_by('id','desc')->get('tbl_m_produk')->result();
            }else{
                $data['produk'] = $this->db->like('kode',$kd)->like('produk',$pr)->like('jml',$qt)->like('harga_beli',$hb)->like('harga_jual',$hj)->limit($config['per_page'])->order_by('id','desc')->get('tbl_m_produk')->result();
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_det() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            $data['produk']    = $this->db
                    ->select('DATE(tgl_simpan) as tgl_simpan, id_kategori, id_penjahit, kode, produk, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, insentif, lama_pengerjaan')
                    ->where('id',general::dekrip($id))
                    ->get('tbl_m_produk')->row();
            
            $data['produk_hrg'] = $this->db
                    ->select('DATE(tgl_simpan) as tgl_simpan, id_produk, keterangan, harga')
                    ->where('id_produk',general::dekrip($id))
                    ->get('tbl_m_produk_harga')->result();
            
            $data['produk_hist'] = $this->db
                    ->select('DATE(tgl_simpan) as tgl_simpan, TIME(tgl_simpan) as wkt_simpan, id, keterangan')
                    ->where('id_produk',general::dekrip($id))
                    ->get('tbl_m_produk_hist')->result();
            
            $data['produk_stok'] = $this->db
                    ->select('DATE(tbl_m_produk_stok.tgl_simpan) as tgl_simpan, tbl_m_produk_stok.id, tbl_m_produk_stok.id_produk, tbl_m_penjahit.penjahit, tbl_m_produk_stok.stok')
                    ->join('tbl_m_penjahit','tbl_m_penjahit.id=tbl_m_produk_stok.id_penjahit')
                    ->where('tbl_m_produk_stok.id_produk',general::dekrip($id))
                    ->get('tbl_m_produk_stok')->result();
            
            $data['produk_tot_stok'] = $this->db->select('SUM(stok) as jml')->where('id_produk',general::dekrip($id))->get('tbl_m_produk_stok')->row();
            
            $data['penjahit'] = $this->db->get('tbl_m_penjahit')->result();
            $data['hasError'] = $this->session->flashdata('form_error');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_det', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            $data['produk']   = $this->db
                    ->select('DATE(tgl_simpan) as tgl_simpan, id_kategori, id_penjahit, kode, produk, jml, harga_ongk, harga_beli, harga_jual, harga_grosir, berat, insentif, lama_pengerjaan')
                    ->where('id',general::dekrip($id))
                    ->get('tbl_m_produk')->row();
            
            $data['produk_hrg'] = $this->db
                    ->select('DATE(tgl_simpan) as tgl_simpan, id, id_produk, keterangan, harga')
                    ->where('id_produk',general::dekrip($id))
                    ->get('tbl_m_produk_harga')->result();
            
            $data['produk_stok'] = $this->db
                    ->select('DATE(tbl_m_produk_stok.tgl_simpan) as tgl_simpan, tbl_m_produk_stok.id, tbl_m_produk_stok.id_produk, tbl_m_penjahit.penjahit, tbl_m_produk_stok.stok')
                    ->join('tbl_m_penjahit','tbl_m_penjahit.id=tbl_m_produk_stok.id_penjahit')
                    ->where('tbl_m_produk_stok.id_produk',general::dekrip($id))
                    ->get('tbl_m_produk_stok')->result();
            
            $data['penjahit'] = $this->db->get('tbl_m_penjahit')->result();
            $data['hasError'] = $this->session->flashdata('form_error');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/'.(!empty($id) ? 'prod_edit' : 'prod_tambah'), $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_simpan() {
        if (akses::aksesLogin() == TRUE) {
//            $kategori  = $this->input->post('kategori');
//            $penjahit  = $this->input->post('penjahit');
            $kode      = $this->input->post('kode');
            $produk    = $this->input->post('produk');
            $tgl       = $this->input->post('tgl');
            $jml       = $this->input->post('jml');
            $hrg_beli  = $this->input->post('hrg_beli');
            $hrg_jual  = $this->input->post('hrg_jual');
//            $hrg_grosir= $this->input->post('hrg_grosir');
            $hrg_ongk  = $this->input->post('hrg_ongk');
            $berat     = $this->input->post('berat');
            $insentif  = $this->input->post('insentive');
            $lm_peng   = $this->input->post('lama_pengerjaan');
            
            $tgl_skrg  = explode('/', $tgl);
            $hb        = str_replace(array('.'), '', $hrg_beli);
            $hj        = str_replace(array('.'), '', $hrg_jual);
            $hg        = str_replace(array('.'), '', $hrg_grosir);
            $ongkos_tas= str_replace(array('.'), '', $hrg_ongk);
            $ins       = str_replace(array('.'), '', $insentif);
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

//            $this->form_validation->set_rules('kategori', 'Kategori', 'required');
//            $this->form_validation->set_rules('penjahit', 'Nama Penjahit', 'required');
            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('produk', 'Produk', 'required');
            $this->form_validation->set_rules('tgl', 'Tanggal', 'required');
//            $this->form_validation->set_rules('hrg_beli', 'Harga Beli', 'required');
            $this->form_validation->set_rules('hrg_jual', 'Harga Jual', 'required');
//            $this->form_validation->set_rules('hrg_grosir', 'Harga Grosir', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
//                    'kategori'   => form_error('kategori'),
//                    'penjahit'   => form_error('penjahit'),
                    'kode'       => form_error('kode'),
                    'produk'     => form_error('produk'),
                    'tgl'        => form_error('tgl'),
//                    'hrg_beli'   => form_error('hrg_beli'),
                    'hrg_jual'   => form_error('hrg_jual'),
//                    'hrg_grosir' => form_error('hrg_grosir'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_tambah');
            } else {
                $sql_cek = $this->db->where('kode',$kode)->get('tbl_m_produk');
                
                if($sql_cek->num_rows() > 0){
                    $this->session->set_flashdata('produk','<div class="alert alert-danger">Kode produk ['.$kode.'] sudah ada.</div>');
                    redirect('page=produk&act=prod_tambah');
                }else{
                   $data_penj = array(
                       'tgl_simpan'      => $tgl_skrg[2].'-'.$tgl_skrg[0].'-'.$tgl_skrg[1].' '.date('H:i'),
                       'kode'            => $kode,
                       'produk'          => $produk,
                       'harga_ongk'      => $ongkos_tas,
                       'harga_beli'      => $hb,
                       'harga_jual'      => $hj,
                       'berat'           => $berat,
                       'insentif'        => $ins,
                       'lama_pengerjaan' => $lm_peng,
                   );
   
                   crud::simpan('tbl_m_produk',$data_penj);
                   $sql = $this->db->where('kode',$kode)->get('tbl_m_produk')->row();
                   redirect('page=produk&act=prod_tambah&id='.general::enkrip($sql->id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_simpan_stok() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $penjahit   = $this->input->post('penjahit');
            $jml        = $this->input->post('jml');
                        
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('penjahit', 'Penjahit', 'required');
            $this->form_validation->set_rules('jml', 'Stok', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'         => form_error('id'),
                    'penjahit'   => form_error('penjahit'),
                    'jml'        => form_error('jml'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_tambah&id='.$id);
            } else {
                $sql_cek = $this->db->where('id_produk',general::dekrip($id))->where('id_penjahit',$penjahit)->get('tbl_m_produk_stok');
                
//                if($sql_cek->num_rows() > 0){
//                    $this->session->set_flashdata('produk','<div class="alert alert-danger">Nama penjahit tidak boleh lebih dari 1.</div>');
//                    redirect('page=produk&act=prod_tambah&id='.$id);
//                }else{
                    $data_penj = array(
                        'id_produk'   => general::dekrip($id),
                        'id_penjahit' => $penjahit,
                        'tgl_simpan'  => date('Y-m-d'),
                        'stok_awal'   => $jml,
                        'stok'        => $jml,
                    );
    
                    crud::simpan('tbl_m_produk_stok',$data_penj);
                   
                    $sql_stok = $this->db->select_max('id')->get('tbl_m_produk_stok')->row();
                    
                    
                    // Simpan histori penambahan produk
                    $data_hist = array(
                        'id_stok'     => $sql_stok->id,
                        'id_produk'   => general::dekrip($id),
                        'id_penjahit' => $penjahit,
                        'tgl_simpan'  => date('Y-m-d H:i:s'),
                        'keterangan'  => 'Penambahan <b>'.$jml.'</b> stok <b>'.$this->db->where('id',general::dekrip($id))->get('tbl_m_produk')->row()->kode.' - '.$this->db->where('id',$penjahit)->get('tbl_m_penjahit')->row()->penjahit.'</b>',
                    );
                    crud::simpan('tbl_m_produk_hist',$data_hist);
                    redirect('page=produk&act=prod_tambah&id='.$id.'#jml');
//                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_simpan_hrg() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $keterangan = $this->input->post('keterangan');
            $hrg        = $this->input->post('harga');
            
            $tgl_skrg  = explode('/', $tgl);
            $hj        = str_replace(array('.'), '', $hrg);
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'         => form_error('id'),
                    'keterangan' => form_error('keterangan'),
                    'hrg_res'    => form_error('harga'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_tambah&id='.$id);
            } else {
                $data_penj = array(
                    'id_produk'       => general::dekrip($id),
                    'tgl_simpan'      => date('Y-m-d'),
                    'keterangan'      => $keterangan,
                    'harga'           => $hj
                );

                crud::simpan('tbl_m_produk_harga',$data_penj);
                redirect('page=produk&act=prod_tambah&id='.$id.'#hrg_res');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_update() {
        if (akses::aksesLogin() == TRUE) {
            $id        = $this->input->post('id');
            $kategori  = $this->input->post('kategori');
            $penjahit  = $this->input->post('penjahit');
            $kode      = $this->input->post('kode');
            $produk    = $this->input->post('produk');
            $tgl       = $this->input->post('tgl');
            $jml       = $this->input->post('jml');
            $hrg_ongk  = $this->input->post('hrg_ongk');
            $hrg_beli  = $this->input->post('hrg_beli');
            $hrg_jual  = $this->input->post('hrg_jual');
//            $hrg_grosir= $this->input->post('hrg_grosir');
            $berat     = $this->input->post('berat');
            $insentif  = $this->input->post('insentive');
            $lm_peng   = $this->input->post('lama_pengerjaan');
            
            $tgl_skrg  = explode('/', $tgl);
            $hb        = str_replace(array('.'), '', $hrg_beli);
            $hj        = str_replace(array('.'), '', $hrg_jual);
            $hg        = str_replace(array('.'), '', $hrg_grosir);
            $ongkos_tas= str_replace(array('.'), '', $hrg_ongk);
            $ins       = str_replace(array('.'), '', $insentif);
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

//            $this->form_validation->set_rules('kategori', 'Kategori', 'required');
//            $this->form_validation->set_rules('penjahit', 'Nama Penjahit', 'required');
            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('produk', 'Produk', 'required');
//            $this->form_validation->set_rules('jml', 'Jumlah', 'required');
//            $this->form_validation->set_rules('hrg_beli', 'Harga Beli', 'required');
            $this->form_validation->set_rules('hrg_jual', 'Harga Jual', 'required');
//            $this->form_validation->set_rules('hrg_grosir', 'Harga Grosir', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
//                    'kategori'   => form_error('kategori'),
//                    'penjahit'   => form_error('penjahit'),
                    'kode'       => form_error('kode'),
                    'produk'     => form_error('produk'),
//                    'jml'        => form_error('jml'),
//                    'hrg_beli'   => form_error('hrg_beli'),
                    'hrg_jual'   => form_error('hrg_jual'),
//                    'hrg_grosir' => form_error('hrg_grosir'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_tambah&id=aaa'.$id);
            } else {
                $data_penj = array(
//                    'id_kategori'     => $kategori,
                    'id_penjahit'     => $penjahit,
                    'tgl_simpan'      => $tgl_skrg[2].'-'.$tgl_skrg[0].'-'.$tgl_skrg[1].' '.date('H:i'),
                    'kode'            => $kode,
                    'produk'          => $produk,
                    'jml'             => $jml,
                    'harga_ongk'      => $ongkos_tas,
                    'harga_beli'      => $hb,
                    'harga_jual'      => $hj,
//                    'harga_grosir'    => $hg,
                    'berat'           => $berat,
                    'insentif'        => $ins,
//                    'lama_pengerjaan' => $lm_peng,
                );
                
                crud::update('tbl_m_produk','id',general::dekrip($id),$data_penj);
                redirect('page=produk&act=prod_tambah&id='.$id);
                echo '<pre>';
                print_r($data_penj);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_produk','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_hapus_hrg() {
        if (akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $ref = $this->input->get('ref');
            
            if(!empty($id)){
                crud::delete('tbl_m_produk_harga','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_tambah&id='.$ref);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_hapus_stok() {
        if (akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $ref = $this->input->get('ref');
            
            if(!empty($id)){
                // ambil id stok
                $sql_stok = $this->db
                                 ->select('tbl_m_produk_stok.id, tbl_m_produk_stok.id_penjahit, tbl_m_produk.id as id_produk, tbl_m_produk.kode, tbl_m_penjahit.penjahit')
                                 ->join('tbl_m_produk','tbl_m_produk.id=tbl_m_produk_stok.id_produk')
                                 ->join('tbl_m_penjahit','tbl_m_penjahit.id=tbl_m_produk_stok.id_penjahit')
                                 ->where('tbl_m_produk_stok.id', general::dekrip($id))
                                 ->get('tbl_m_produk_stok')->row();
                
                // simpan ke history barang
                $data_hist = array(
                        'id_stok'       => $sql_stok->id,
                        'id_produk'     => $sql_stok->id_produk,
                        'id_penjahit'   => $sql_stok->id_penjahit,
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'keterangan'    => 'Hapus stok <b>'.$sql_stok->kode.'</b> - <b>'.ucwords($sql_stok->penjahit).'</b>'
                    );
                
                crud::simpan('tbl_m_produk_hist', $data_hist);                               
                crud::delete('tbl_m_produk_stok','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_tambah&id='.$ref);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    
    
    
    
    
    // Set cari penjahit
    public function set_cari_plat() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('platform',$id)->get('tbl_m_platform')->num_rows();
                redirect('page=produk&act=prod_plat_list&q='.$id.'&jml='.$jml);
            }else{
                redirect('page=produk&act=prod_plat_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    // Set cari penjahit
    public function set_cari_penj() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('penjahit',$id)->get('tbl_m_penjahit')->num_rows();
                redirect('page=produk&act=prod_penj_list&q='.$id.'&jml='.$jml);
            }else{
                redirect('page=produk&act=prod_penj_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    // Set cari Produk
    public function set_cari_prod() {
        if (akses::aksesLogin() == TRUE) {
            $kd = $this->input->post('kode');
            $pr = $this->input->post('produk');
            $qt = $this->input->post('qty');
            $hb = str_replace('.', '', $this->input->post('hb'));
            $hj = str_replace('.', '', $this->input->post('hj'));
//            $hl = $this->input->post('hal');
            
//            if(!empty($kd) )
            
//            switch ()
            
            $sql = $this->db->like('kode',$kd)->like('produk',$pr)->like('jml',$qt)->like('harga_beli',$hb)->like('harga_jual',$hj)->get('tbl_m_produk');
            redirect('page=produk&act=prod_list&halaman='.$hl.'&filter_kode='.$kd.'&filter_produk='.$pr.'&filter_qty='.$qt.'&filter_hb='.$hb.'&filter_hj='.$hj.'&jml='.$sql->num_rows());
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    // Set cari Produk Stok
    public function set_cari_prod_stok() {
        if (akses::aksesLogin() == TRUE) {
            $pj = $this->input->post('pj');
            $kd = $this->input->post('kode');
            $pr = $this->input->post('produk');
            $qt = $this->input->post('qty');
            $hb = str_replace('.', '', $this->input->post('hb'));
            $hj = str_replace('.', '', $this->input->post('hj'));
            
            $sql = $this->db->select('tbl_m_penjahit.penjahit, tbl_m_produk.id, tbl_m_produk.tgl_simpan, tbl_m_produk.kode, tbl_m_produk.produk, tbl_m_produk.harga_beli, tbl_m_produk.harga_jual, tbl_m_produk_stok.stok')
                    ->join('tbl_m_produk','tbl_m_produk.id=tbl_m_produk_stok.id_produk')
                    ->join('tbl_m_penjahit','tbl_m_penjahit.id=tbl_m_produk_stok.id_penjahit')
                    ->like('tbl_m_penjahit.penjahit', $pj)
                    ->like('tbl_m_produk.kode', $kd)
                    ->like('tbl_m_produk.produk', $pr)
//                    ->like('tbl_m_produk_stok.stok', $sql)
                    ->like('tbl_m_produk.harga_beli', $hb)
                    ->like('tbl_m_produk.harga_jual', $hj)
                    ->order_by('tbl_m_produk.id', 'desc')
                    ->get('tbl_m_produk_stok');
            
            redirect('page=produk&act=prod_stok_list&halaman='.$hl.'&filter_pj='.$pj.'&filter_kode='.$kd.'&filter_produk='.$pr.'&filter_qty='.$qt.'&filter_hb='.$hb.'&filter_hj='.$hj.'&jml='.$sql->num_rows());
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
}
