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

    public function testing() {
        // Set the password
        $password = 'ALFA8475';

        // Get the hash, letting the salt be automatically generated
        $enkr = hash('sha512',$password);
        $hash = crypt($password,'$1$'.$this->config->item('encryption_key').'$');
        echo $hash;
    }

    public function index() {
        if(akses::aksesLogin() == TRUE){
            $setting           = $this->db->get('tbl_pengaturan')->row();

//            $data['limit']     = $setting->stok_limit; 
//            $data['p_limit']   = $this->db->order_by('id','desc')->get('tbl_m_produk')->result();
//            $data['p_pending'] = $this->db->limit(10)->order_by('id','desc')->get('tbl_m_produk')->result();
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/3_navbar',$data);
            $this->load->view('admin-lte-2/content',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function user_ganti_pass() {
        if(akses::aksesLogin() == TRUE){        
            $data['user'] = $this->ion_auth->user()->row();
                    
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/anggota/agt_ubah_pass', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function user_update_pass() {
        if(akses::aksesLogin() == TRUE){
            $id    = $this->input->post('id');
            $user  = $this->input->post('username');
            $pass1 = $this->input->post('pass1');
            $pass2 = $this->input->post('pass2');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('username', 'User', 'required');
            $this->form_validation->set_rules('pass1', 'Kategori', 'trim|matches[pass2]|required');
            $this->form_validation->set_rules('pass2', 'Penerbit', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'username' => form_error('username'),
                    'pass1'    => form_error('pass1'),
                    'pass2'    => form_error('pass2')
                );

                $this->session->set_flashdata('form_error', $msg_error);

                $this->session->set_flashdata('user', $user);
                $this->ion_auth->logout();
                redirect('member/login.html');
            } else {
                $usr = $this->ion_auth->user()->row();
                $data = array(
                    'password'=> $pass2
                );
                
                $this->ion_auth->update($id,$data);
                crud::update('tbl_data_siswa','email',$usr->email,array('status_user'=>'1'));
                redirect('page=home');
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
}
