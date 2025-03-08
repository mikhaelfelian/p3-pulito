<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Description of anggota
 *
 * @author mike
 */
class akuntability extends CI_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    public function akt_pem_kas_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe','masuk')->where('status_kas','kas')->get('tbl_akt_kas')->num_rows());
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=akuntability&act=akt_pem_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
                if (!empty($query)) {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, status_kas')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('tipe','masuk')->where('status_kas','kas')->order_by('id','desc')->get('tbl_akt_kas')->result();
                } else {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, status_kas')->limit($config['per_page'],$hal)->where('tipe','masuk')->where('status_kas','kas')->order_by('id','desc')->get('tbl_akt_kas')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, status_kas')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('tipe','masuk')->where('status_kas','kas')->order_by('id','desc')->get('tbl_akt_kas')->result();
                } else {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, status_kas')->limit($config['per_page'])->where('tipe','masuk')->where('status_kas','kas')->order_by('id','desc')->get('tbl_akt_kas')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akt/akt_pem_kas_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_pem_bank_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe','masuk')->where('status_kas','bank')->get('tbl_akt_kas')->num_rows());
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=akuntability&act=akt_pem_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
                if (!empty($query)) {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, status_kas')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('tipe','masuk')->where('status_kas','bank')->order_by('id','desc')->get('tbl_akt_kas')->result();
                } else {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, status_kas')->limit($config['per_page'],$hal)->where('tipe','masuk')->where('status_kas','bank')->order_by('id','desc')->get('tbl_akt_kas')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, status_kas')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('tipe','masuk')->where('status_kas','bank')->order_by('id','desc')->get('tbl_akt_kas')->result();
                } else {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, status_kas')->limit($config['per_page'])->where('tipe','masuk')->where('status_kas','bank')->order_by('id','desc')->get('tbl_akt_kas')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akt/akt_pem_bank_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_pem_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $tgl      = $this->input->post('tgl');
            $ket      = $this->input->post('keterangan');
            $nominal  = str_replace('.', '', $this->input->post('nominal'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('tgl', 'No. Nota', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_rules('nominal', 'Nominal', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'tgl'        => form_error('tgl'),
                    'keterangan' => form_error('keterangan'),
                    'nominal'    => form_error('nominal'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=akuntability&act=akt_pem_list');
            } else {
                $tgl_s = explode('/', $tgl);
                $trans = array(
                    'tgl'        => $tgl_s[2].'-'.$tgl_s[0].'-'.$tgl_s[1],
                    'keterangan' => $ket,
                    'nominal'    => $nominal,
                    'tipe'       => 'masuk',
                );
                
                crud::simpan('tbl_akt_kas',$trans);
                redirect('page=akuntability&act=akt_pem_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function akt_pem_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');
            crud::delete('tbl_akt_kas','id',general::dekrip($id));
            redirect('page=akuntability&act=akt_pem_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_peng_kas_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            
            if(akses::hakSales() != TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe','keluar')->get('tbl_akt_kas')->num_rows());
            }else{
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('jenis','3')->where('tipe','keluar')->get('tbl_akt_kas')->num_rows());
            }
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=akuntability&act=akt_peng_kas_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
            
            
            if(akses::hakSales() == TRUE){
                $id = $this->ion_auth->user()->row()->id;
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, id_jenis')
                                ->limit($config['per_page'],$hal)
                                ->like('keterangan', $query)
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->where('id_user',$id)
                                ->order_by('id','desc')
                                ->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, id_jenis')
                                ->limit($config['per_page'],$hal)
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->where('id_user',$id)
                                ->order_by('id','desc')
                                ->get('tbl_akt_kas')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, id_jenis')
                                ->limit($config['per_page'],$hal)
                                ->like('keterangan', $query)
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->where('id_user',$id)
                                ->order_by('id','desc')
                                ->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, id_jenis')
                                ->limit($config['per_page'])
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->where('id_user',$id)
                                ->order_by('id','desc')
                                ->get('tbl_akt_kas')->result();
                    }
                }
            }else{
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, id_jenis')
                                ->limit($config['per_page'],$hal)
                                ->like('keterangan', $query)
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->order_by('id','desc')
                                ->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, id_jenis')
                                ->limit($config['per_page'],$hal)
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->order_by('id','desc')
                                ->get('tbl_akt_kas')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, id_jenis')
                                ->limit($config['per_page'],$hal)
                                ->like('keterangan', $query)
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->order_by('id','desc')
                                ->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, id_jenis')
                                ->limit($config['per_page'])
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->order_by('id','desc')
                                ->get('tbl_akt_kas')->result();
                    }
                }
            }

            $this->pagination->initialize($config);

            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akt/akt_peng_kas_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_peng_bank_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            
//            if(akses::hakSales() != TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe','keluar')->where('status_kas','bank')->get('tbl_akt_kas')->num_rows());
//            }else{
//                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('jenis','3')->where('tipe','keluar')->get('tbl_akt_kas')->num_rows());
//            }
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=akuntability&act=akt_peng_bank_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
            
            
            if(akses::hakSales() != TRUE){
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db
                                ->select('id, id_user, kode, DATE(tgl) as tgl, keterangan, nominal, jenis')
                                ->limit($config['per_page'],$hal)
                                ->like('keterangan', $query)
                                ->where('tipe','keluar')
                                ->where('status_kas','bank')
                                ->order_by('id','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db
                                ->select('id, id_user, kode, DATE(tgl) as tgl, keterangan, nominal, jenis')
                                ->limit($config['per_page'],$hal)
                                ->where('tipe','keluar')
                                ->where('status_kas','bank')
                                ->order_by('id','desc')->get('tbl_akt_kas')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db
                                ->select('id, id_user, kode, DATE(tgl) as tgl, keterangan, nominal, jenis')
                                ->limit($config['per_page'],$hal)
                                ->like('keterangan', $query)
                                ->where('tipe','keluar')
                                ->where('status_kas','bank')
                                ->order_by('id','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db
                                ->select('id, id_user, kode, DATE(tgl) as tgl, keterangan, nominal, jenis')
                                ->limit($config['per_page'])
                                ->where('tipe','keluar')
                                ->where('status_kas','bank')
                                ->order_by('id','desc')->get('tbl_akt_kas')->result();
                    }
                }
            }else{
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db
                                ->select('id, id_user, kode, DATE(tgl) as tgl, keterangan, nominal, jenis')
                                ->limit($config['per_page'],$hal)
                                ->like('keterangan', $query)
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->order_by('id','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db
                                ->select('id, id_user, kode, DATE(tgl) as tgl, keterangan, nominal, jenis')
                                ->limit($config['per_page'],$hal)
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->order_by('id','desc')->get('tbl_akt_kas')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db
                                ->select('id, id_user, kode, DATE(tgl) as tgl, keterangan, nominal, jenis')
                                ->limit($config['per_page'],$hal)
                                ->like('keterangan', $query)
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->order_by('id','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db
                                ->select('id, id_user, kode, DATE(tgl) as tgl, keterangan, nominal, jenis')
                                ->limit($config['per_page'])
                                ->where('tipe','keluar')
                                ->where('status_kas','kas')
                                ->order_by('id','desc')->get('tbl_akt_kas')->result();
                    }
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akt/akt_peng_bank_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_peng_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            
            if(akses::hakSales() != TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe','keluar')->get('tbl_akt_kas')->num_rows());
            }else{
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('jenis','3')->where('tipe','keluar')->get('tbl_akt_kas')->num_rows());
            }
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=akuntability&act=akt_peng_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
            
            
            if(akses::hakSales() != TRUE){
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'],$hal)->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'])->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    }
                }
            }else{
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('jenis','3')->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'],$hal)->where('jenis','3')->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('jenis','3')->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['pemasukan'] = $this->db->select('id, id_user, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'])->where('jenis','3')->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                    }
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akt/akt_peng_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_peng_kas_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $tgl      = $this->input->post('tgl');
            $ket      = $this->input->post('keterangan');
            $jns      = $this->input->post('jenis');
            $nominal  = str_replace('.', '', $this->input->post('nominal'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('tgl', 'No. Nota', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_rules('nominal', 'Nominal', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'tgl'        => form_error('tgl'),
                    'keterangan' => form_error('keterangan'),
                    'nominal'    => form_error('nominal'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=akuntability&act=akt_peng_kas_list');
            } else {
                // ->where('tipe','keluar')->where('status_kas','kas')
                $cek_saldo = $this->db->select('id, saldo')->order_by('id','desc')->limit('1')->get('tbl_akt_kas')->row();
                $tot_saldo = $cek_saldo->saldo - $nominal;
                $kode      = general::no_nota('','tbl_akt_kas','kode', "tipe='keluar' AND status_kas='kas'");
                                
                $tgl_s = explode('/', $tgl);
                $trans = array(
                    'id_user'    => $this->ion_auth->user()->row()->id,
                    'id_jenis'   => $jns,
                    'tgl'        => $tgl_s[2].'-'.$tgl_s[0].'-'.$tgl_s[1].' '.date('H:i:s'),
                    'kode'       => $kode,
                    'keterangan' => $ket,
                    'nominal'    => $nominal,
                    'debet'      => $nominal,
                    'saldo'      => $tot_saldo,
                    'tipe'       => 'keluar',
                    'status_kas' => 'kas',
                );
                
                crud::simpan('tbl_akt_kas',$trans);
                redirect('page=akuntability&act=akt_peng_kas_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_peng_bank_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $tgl      = $this->input->post('tgl');
            $ket      = $this->input->post('keterangan');
            $status   = $this->input->post('status');
            $jns      = $this->input->post('jenis');
            $nominal  = str_replace('.', '', $this->input->post('nominal'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('tgl', 'No. Nota', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_rules('nominal', 'Nominal', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'tgl'        => form_error('tgl'),
                    'keterangan' => form_error('keterangan'),
                    'nominal'    => form_error('nominal'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=akuntability&act=akt_peng_list');
            } else {
                // ->where('tipe','keluar')->where('status_kas','kas')
                $cek_saldo = $this->db->select('id, saldo')->order_by('id','desc')->limit('1')->get('tbl_akt_kas')->row();
                $tgl_s     = explode('/', $tgl);
                              
                switch ($status){
                    case '0':
                        $kode      = general::no_nota('','tbl_akt_kas','kode', "tipe='keluar' AND status_kas='kas'");
                        $tot_saldo = $cek_saldo->saldo + $nominal;
                        
                        $trans = array(
                            'id_user'    => $this->ion_auth->user()->row()->id,
                            'id_jenis'   => $jns,
                            'tgl'        => $tgl_s[2].'-'.$tgl_s[0].'-'.$tgl_s[1].' '.date('H:i:s'),
                            'kode'       => $kode,
                            'keterangan' => $ket,
                            'nominal'    => $nominal,
                            'kredit'     => $nominal,
                            'saldo'      => $tot_saldo,
                            'tipe'       => 'keluar',
                            'status_kas' => 'bank',
                        );
                        
                        crud::simpan('tbl_akt_kas',$trans);
                        
                        // Pengeluaran bank, jenis kas. adalah pemasukan pada menu kas
                        // Simpan di bagian pemasukan kas
                        $saldo_kas2 = $this->db->select('MAX(id), SUM(saldo) as saldo')->get('tbl_akt_kas')->row();
                        $kode2      = general::no_nota('','tbl_akt_kas','kode',"tipe='masuk'");
                        $tot_saldo2 = $saldo_kas2->saldo + $cek_nota->jml_gtotal;
                        
                        $pem = array(
                            'tgl'         => date('Y-m-d H:i:s'),
                            'id_user'     => $this->ion_auth->user()->row()->id,
                            'kode'        => $kode2,
                            'keterangan'  => $ket,
                            'nominal'     => $nominal,
                            'kredit'      => $nominal,
                            'saldo'       => $tot_saldo,
                            'tipe'        => 'masuk',
                            'status_kas'  => 'kas',
                            'status_hps'  => 'kode='.$kode,
                        );
                        
                        crud::simpan('tbl_akt_kas',$pem);
                        /* ----- End of Pemasukan Kas ----- */
                        
//                        redirect('page=akuntability&act=akt_pem_kas_list');
                        redirect('page=akuntability&act=akt_peng_bank_list');
                        break;
                    
                    case '1':
                        $kode      = general::no_nota('','tbl_akt_kas','kode', "tipe='keluar' AND status_kas='kas'");
                        $tot_saldo = $cek_saldo->saldo - $nominal;
                        
                        $trans = array(
                            'id_user'    => $this->ion_auth->user()->row()->id,
                            'id_jenis'   => $jns,
                            'tgl'        => $tgl_s[2].'-'.$tgl_s[0].'-'.$tgl_s[1].' '.date('H:i:s'),
                            'kode'       => $kode,
                            'keterangan' => $ket,
                            'nominal'    => $nominal,
                            'debet'      => $nominal,
                            'saldo'      => $tot_saldo,
                            'tipe'       => 'keluar',
                            'status_kas' => 'bank',
                        );
                        
                        crud::simpan('tbl_akt_kas',$trans);
                        redirect('page=akuntability&act=akt_peng_bank_list');
                        break;
                }                
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_peng_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $tgl      = $this->input->post('tgl');
            $ket      = $this->input->post('keterangan');
            $jns      = $this->input->post('jenis');
            $nominal  = str_replace('.', '', $this->input->post('nominal'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('tgl', 'No. Nota', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_rules('nominal', 'Nominal', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'tgl'        => form_error('tgl'),
                    'keterangan' => form_error('keterangan'),
                    'nominal'    => form_error('nominal'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=akuntability&act=akt_peng_list');
            } else {
                $tgl_s = explode('/', $tgl);
                $trans = array(
                    'id_user'    => $this->ion_auth->user()->row()->id,
                    'tgl'        => $tgl_s[2].'-'.$tgl_s[0].'-'.$tgl_s[1],
                    'keterangan' => $ket,
                    'nominal'    => $nominal,
                    'jenis'      => $jns,
                    'tipe'       => 'keluar',
                );
                
                crud::simpan('tbl_akt_kas',$trans);
                redirect('page=akuntability&act=akt_peng_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function akt_peng_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');
            $rute    = $this->input->get('route');
            $kode    = $this->input->get('kode');
            
            if(!empty($kode)){
                crud::delete('tbl_akt_kas','status_hps','kode='.$kode);
            }
            
            crud::delete('tbl_akt_kas','id',general::dekrip($id));
            redirect('page=akuntability&act='.$rute);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_bank_msk_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->where('status_nota','2')->get('tbl_trans_jual')->num_rows());
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=akuntability&act=akt_bank_msk_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
                if (!empty($query)) {
                    $data['bank_msk'] = $this->db
                            ->select('DATE(tgl_simpan) as tgl, no_nota, jml_gtotal, id_user, id_gudang, status_nota')
                            ->limit($config['per_page'],$hal)
                            ->like('no_nota', $query)
                            ->where('status_nota','2')
                            ->order_by('no_nota','desc')
                            ->get('tbl_trans_jual')->result();
                } else {
                    $data['bank_msk'] = $this->db
                            ->select('DATE(tgl_simpan) as tgl, no_nota, jml_gtotal, id_user, id_gudang, status_nota')
                            ->limit($config['per_page'],$hal)
                            ->like('no_nota', $query)
                            ->where('status_nota','2')
                            ->order_by('no_nota','desc')
                            ->get('tbl_trans_jual')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['bank_msk'] = $this->db
                            ->select('DATE(tgl_simpan) as tgl, no_nota, jml_gtotal, id_user, id_gudang, status_nota')
                            ->limit($config['per_page'],$hal)
                            ->like('no_nota', $query)
                            ->where('status_nota','2')
                            ->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                } else {
                    $data['bank_msk'] = $this->db
                            ->select('DATE(tgl_simpan) as tgl, no_nota, jml_gtotal, id_user, id_gudang, status_nota')
                            ->limit($config['per_page'])
                            ->where('status_nota','2')
                            ->order_by('no_nota','desc')
                            ->get('tbl_trans_jual')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akt/akt_bank_msk_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_bank_klr_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe','keluar')->get('tbl_akt_kas')->num_rows());
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=akuntability&act=akt_bank_klr_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
                if (!empty($query)) {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                } else {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'],$hal)->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'],$hal)->like('keterangan', $query)->where('tipe','keluar')->order_by('id','desc')->get('tbl_akt_kas')->result();
                } else {
                    $data['pemasukan'] = $this->db->select('id, DATE(tgl) as tgl, keterangan, nominal, jenis')->limit($config['per_page'])->where('tipe','keluar')->order_by('id','DESC')->get('tbl_akt_kas')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akt/akt_bank_klr_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_modal_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            
            if(akses::hakSales() != TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->get('tbl_akt_modal')->num_rows());
            }else{
                $jml_hal = (!empty($jml) ? $jml  : $this->db->get('tbl_akt_modal')->num_rows());
            }
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=akuntability&act=akt_peng_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
            
            
            if(akses::hakSales() != TRUE){
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['modal'] = $this->db->select('id, id_user, DATE(tgl_simpan) as tgl, keterangan, nominal')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('id','desc')->get('tbl_akt_modal')->result();
                    } else {
                        $data['modal'] = $this->db->select('id, id_user, DATE(tgl_simpan) as tgl, keterangan, nominal')->limit($config['per_page'],$hal)->order_by('id','desc')->get('tbl_akt_modal')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['modal'] = $this->db->select('id, id_user, DATE(tgl_simpan) as tgl, keterangan, nominal')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('id','desc')->get('tbl_akt_modal')->result();
                    } else {
                        $data['modal'] = $this->db->select('id, id_user, DATE(tgl_simpan) as tgl, keterangan, nominal')->limit($config['per_page'])->order_by('id','desc')->get('tbl_akt_modal')->result();
                    }
                }
            }else{
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['modal'] = $this->db->select('id, id_user, DATE(tgl_simpan) as tgl, keterangan, nominal')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('id','desc')->get('tbl_akt_modal')->result();
                    } else {
                        $data['modal'] = $this->db->select('id, id_user, DATE(tgl_simpan) as tgl, keterangan, nominal')->limit($config['per_page'],$hal)->order_by('id','desc')->get('tbl_akt_modal')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['modal'] = $this->db->select('id, id_user, DATE(tgl_simpan) as tgl, keterangan, nominal')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('id','desc')->get('tbl_akt_modal')->result();
                    } else {
                        $data['modal'] = $this->db->select('id, id_user, DATE(tgl_simpan) as tgl, keterangan, nominal')->limit($config['per_page'])->order_by('id','desc')->get('tbl_akt_modal')->result();
                    }
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akt/akt_modal_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_modal_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $tgl      = $this->input->post('tgl');
            $ket      = $this->input->post('keterangan');
            $jns      = $this->input->post('jenis');
            $nominal  = str_replace('.', '', $this->input->post('nominal'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('tgl', 'No. Nota', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_rules('nominal', 'Nominal', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'tgl'        => form_error('tgl'),
                    'keterangan' => form_error('keterangan'),
                    'nominal'    => form_error('nominal'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=akuntability&act=akt_modal_list');
            } else {
                $tgl_s = explode('/', $tgl);
                $kode  = general::no_nota('','tbl_akt_modal','kode');
                $trans = array(
                    'kode'       => $kode,
                    'id_user'    => $this->ion_auth->user()->row()->id,
                    'tgl_simpan' => $tgl_s[2].'-'.$tgl_s[0].'-'.$tgl_s[1],
                    'keterangan' => $ket,
                    'nominal'    => $nominal
                );
                
                crud::simpan('tbl_akt_modal',$trans);
                redirect('page=akuntability&act=akt_modal_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function akt_modal_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');
            crud::delete('tbl_akt_modal','id',general::dekrip($id));
            redirect('page=akuntability&act=akt_modal_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    
    // Set cari Pengeluaran kas
    public function set_cari_peng_kas() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('keterangan',$id)->where('tipe','keluar')->where('status_kas','kas')->get('tbl_akt_kas')->num_rows();
                redirect('page=akuntability&act=akt_peng_kas_list&q='.$id.'&jml='.$jml);
            }else{
                redirect('page=akuntability&act=akt_peng_kas_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    // Set cari Pengeluaran bank
    public function set_cari_peng_bank() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('keterangan',$id)->where('tipe','keluar')->where('status_bank','bank')->get('tbl_akt_kas')->num_rows();
                redirect('page=akuntability&act=akt_peng_bank_list&q='.$id.'&jml='.$jml);
            }else{
                redirect('page=akuntability&act=akt_peng_bank_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifibanki gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    // Set cari Pemasukan kas
    public function set_cari_pem_kas() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('keterangan',$id)->where('tipe','masuk')->where('status_kas','kas')->get('tbl_akt_kas')->num_rows();
                redirect('page=akuntability&act=akt_pem_kas_list&q='.$id.'&jml='.$jml);
            }else{
                redirect('page=akuntability&act=akt_pem_kas_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    // Set cari Pemasukan bank
    public function set_cari_pem_bank() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('keterangan',$id)->where('tipe','masuk')->where('status_bank','bank')->get('tbl_akt_kas')->num_rows();
                redirect('page=akuntability&act=akt_pem_bank_list&q='.$id.'&jml='.$jml);
            }else{
                redirect('page=akuntability&act=akt_pem_bank_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifibanki gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
}
