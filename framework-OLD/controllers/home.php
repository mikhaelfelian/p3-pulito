<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Description of menu
 *
 * @author mike
 */
class home extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        if(akses::aksesLogin() == TRUE){
            $data['sess_jual']  = $this->session->userdata('trans_jual');

            $data['pelanggan']  = $this->db->where('id', $data['sess_jual']['id_pelanggan'])->get('tbl_m_pelanggan')->row(); 
          
                      
//            $data['trans_jual'] = $this->db->where('no_nota', $data['sess_jual']['no_nota'])->get('tbl_trans_jual')->row();            
//            if(!empty( $data['sess_jual'])){
//                redirect(base_url('dashboard.php?#data_pelanggan'));
//            }
//            }else{
            $setting                 = $this->db->get('tbl_pengaturan')->row();
            $data['kategori1']       = $this->db->get('tbl_m_kategori')->result();
            $data['no_nota']         = general::no_nota('', 'tbl_trans_jual', 'no_nota');
            $data['sql_member_tipe'] = $this->db->get('tbl_m_pelanggan_grup');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/content', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
//            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    public function json_pelanggan() {
        if(akses::aksesLogin() == TRUE){
            $term  = $this->input->get('term');
            $sql   = $this->db->where('status_hps', '0')->like('nama', $term)->or_like('no_hp', $term)->or_like('kode', $term)->get('tbl_m_pelanggan')->result();;
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $sql_tipe = $this->db->where('id', $sql->id_grup)->get('tbl_m_pelanggan_grup')->row();
                    $produk[] = array(
                        'id'          => $sql->id,
                        'kode'        => $sql->kode,
                        'nama'        => $sql->nama,
                        'no_hp'       => $sql->no_hp,
                        'grup'        => (!empty($sql_tipe->grup) ? ' ('.$sql_tipe->grup.')' : ''),
                    );
                }
                echo json_encode($produk);
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
//    public function index() {
//        if(akses::aksesLogin() == TRUE){
//            $setting            = $this->db->get('tbl_pengaturan')->row();
//            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
//
//            $this->load->view('sb-admin/1_atas', $data);
//            $this->load->view('sb-admin/2_navbar_no', $data);
//            $this->load->view('sb-admin/includes/dashboard/content', $data); // Beranda
//            $this->load->view('sb-admin/4_bawah', $data);
//        }else{
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
//            redirect();
//        }
//    }
}
