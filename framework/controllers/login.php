<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

class login extends CI_Controller {

    function __construct() {
        parent::__construct();
//        $this->load->helper('captcha');
//        $this->load->library('recaptcha');
    }

    public function index2() {
        $this->load->view('4-col-portofolio/1_atas');
        $this->load->view('4-col-portofolio/2_header');
        $this->load->view('4-col-portofolio/3_navbar');
        $this->load->view('4-col-portofolio/content');
        $this->load->view('4-col-portofolio/5_footer');
        $this->load->view('4-col-portofolio/6_bawah');
    }

    public function index() {
        if (akses::akseslogin() == TRUE):
            redirect('page=home');
        else:            
            $data['login'] = 'TRUE';
        
//            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/includes/user/login', $data);
//            $this->load->view('admin-lte-2/6_bawah', $data);
        endif;
    }

    public function cek_login() {
        $user   = $this->input->post('user');
        $pass   = $this->input->post('pass');
        $inga   = $this->input->post('ingat');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        $this->form_validation->set_rules('user', 'Username', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $msg_error = array(
                'user' => form_error('user'),
                'pass' => form_error('pass')
            );

            $this->session->set_flashdata('form_error', $msg_error);
            
            $this->session->set_flashdata('user', $user);
            redirect('page=login');
        } else {
            $inget_ya = ($inga == 'ya' ? 'TRUE' : 'FALSE');
            $login    = $this->ion_auth->login($user,$pass,$inget_ya);
            $user     = $this->ion_auth->user()->row();
            $grup     = $this->ion_auth->get_users_groups()->row();
            
            if($login == FALSE){
                $this->session->set_flashdata('login', '<p class="login-box-msg text-bold text-danger">Username atau Kata sandi salah !!</p>');
                redirect();                
            }else{
                if($grup->name == 'kasir' OR $grup->name == 'superadmin'){
                    redirect(base_url('dashboard.php'));
                }else{
                    redirect('page=login&act=logout');
                }
            }
        }
    }

    public function logout() {
        ob_start();
        $user  = $this->ion_auth->user()->row();
        $grup  = $this->ion_auth->get_users_groups($user->id)->row();
                
        $this->ion_auth->logout();
        $this->session->set_flashdata('login','<p class="login-box-msg text-success">Anda berhasil logout !!</p>');
        redirect(base_url());
        ob_end_flush();
    }

    public function kirim_notif() {
        // Load email library
        $this->load->library('email');

        $setting         = $this->db->get('tbl_pengaturan')->row();
        $sql_mail        = $this->db->get('tbl_pengaturan_mail')->row();
        $sql_bcc         = $this->db->get('tbl_pengaturan_notif')->result();
        
        // Data Limit
        $data['limit']   = $setting->stok_limit;
        
        // Data barang
        $data['barang']  = $this->db->order_by('id','asc')->get('tbl_m_produk')->result();      
        

        $this->email->clear();
        $this->email->from($sql_mail->user, '[NGSpecialist.com]');
        $this->email->to($setting->email);
        
        if(!empty($sql_bcc)){
            foreach ($sql_bcc as $bcc){
                $this->email->bcc($bcc->email);
            }
        }        

        $this->email->subject('NG Pengingat Stok');
        $mail = $this->load->view('4-col-portofolio/mail/notifikasi',$data, TRUE);

        $this->email->message($mail);

        $this->email->send();
        
        redirect('page=home');
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
