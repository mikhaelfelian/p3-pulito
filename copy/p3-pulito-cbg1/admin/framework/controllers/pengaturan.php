<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Description of pengaturan
 *
 * @author miki
 * 
 */
class pengaturan extends CI_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->dbforge();
    }
    
    public function printer() {
        if (akses::aksesLogin() == TRUE) {
            $data['pengaturan']  = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['printer']     = $this->db->query("SELECT * FROM tbl_printer")->result();

            $this->load->view('1_atas', $data);
            $this->load->view('2_navbar', $data);
            $this->load->view('includes/pengaturan/printer', $data); // Beranda
            $this->load->view('4_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function printer_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');            
            if(isset($id)){
                crud::delete('tbl_printer','id',general::dekrip($id));
                $this->session->set_flashdata('pengaturan','<div class="alert alert-success">Data printer berhasil dihapus !!</div>');
                redirect('page=pengaturan&act=printer');
            }else{
                $this->session->set_flashdata('pengaturan','<div class="alert alert-danger">Proses gagal !!</div>');
                redirect('page=pengaturan&act=printer');
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function printer_simpan() {
        if (akses::aksesLogin() == TRUE) {
            
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    
    public function index() {
        if (akses::aksesLogin() == TRUE) {
            $data['pengaturan']  = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['hasError']  = $this->session->flashdata('form_error');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/user/pengaturan_db', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function backup_db() {
        if (akses::aksesLogin() == TRUE) {            
            $cek_tabel = $this->db->table_exists('tbl_util_backup');
            if($cek_tabel == 1){                
                $prefs = array(
                    'tables'     => $tabel, // Array of tables to backup.
                    'ignore'     => array(), // List of tables to omit from the backup
                    'format'     => 'txt', // gzip, zip, txt
                    'add_drop'   => TRUE, // Whether to add DROP TABLE statements to backup file
                    'add_insert' => TRUE, // Whether to add INSERT data to backup file
                    'newline'    => "\r\n"  // Newline character used in backup file
                );
                $backup = & $this->dbutil->backup($prefs);
                $path = realpath('../database/backup');
                write_file($path . '/temp_backup.sql', $backup); 
            }else{
                $fields = array(
                    'id' => array(
                        'type'           => 'INT',
                        'constraint'     => 11,
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE
                    ),
                    
                    'tgl' => array(
                        'type'           => 'TIMESTAMP',
                        'null'           => TRUE,
                    ),
                    
                    'name' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => 160
                    )
                );
                $this->dbforge->add_field($fields);
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('tbl_util_backup', TRUE);
            }

            $data['pengaturan']  = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['backup_list'] = $this->db->query("SELECT DATE(tgl) as tgl, TIME(tgl) as jam, name FROM tbl_util_backup ORDER BY tgl DESC")->result();
            $data['user']        = $this->ion_auth->user()->row();
            $data['hasError']  = $this->session->flashdata('form_error');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/user/backup_db', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function backup_download() {
        if (akses::aksesLogin() == TRUE) {
            $dbs    = $this->dbutil->list_databases();
            $user   = $this->ion_auth->user()->row();
            $tabel  = $this->db->list_tables();
            
            $prefs = array(
                'tables'     => $tabel, // Array of tables to backup.
                'ignore'     => array(), // List of tables to omit from the backup
                'format'     => 'txt', // gzip, zip, txt
                'filename'   => 'backup_'.date('YmdHis').'.sql', // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'   => TRUE, // Whether to add DROP TABLE statements to backup file
                'add_insert' => TRUE, // Whether to add INSERT data to backup file
                'newline'    => "\n"               // Newline character used in backup file
            );
            $backup = & $this->dbutil->backup($prefs);
            $path   = realpath('./database/backup').'/';
            $file   = 'backup_'.date('YmdHis').'_'.$user->username.'.sql';
            
            if(isset($_GET['trigger'])){
                if($_GET['trigger'] == 'create'){
                    $data = array(
                        'tgl'  => date('Y-m-d H:i:s'),
                        'name' => $file
                    );
                    crud::simpan('tbl_util_backup',$data);
                    write_file($path.$file, $backup);
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Backup data, berhasil dibuat !!</div>');
                    redirect('page=pengaturan&act=backup_db');
                }
            }else{                
                write_file($path, $backup); 
                force_download($file, $backup);
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function backup_file_download(){
        if (akses::aksesLogin() == TRUE) {
            $id   = $_GET['id'];
            $path = realpath('./database/backup').'/';
            $file = general::dekrip($id);
            force_download($file,  file_get_contents($path.$file));
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function backup_file_hapus(){
        if (akses::aksesLogin() == TRUE) {
            $id   = $_GET['id'];
            $path = realpath('./database/backup').'/';
            $file = general::dekrip($id);
            unlink($path.$file);
            crud::delete('tbl_util_backup','name',$file);
            redirect('page=pengaturan&act=backup_db');
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function restore_db(){
        if (akses::aksesLogin() == TRUE) {
            $lines = file($_FILES['frestore']['tmp_name']);
            
            foreach ($lines as $line){
                // Lompat jika berupa baris komentar
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;

                // Tambahkan baris berikut, pada segment ini
                $templine .= $line;
                // Titik komea menandakan akhir dari kueri
                if (substr(trim($line), -1, 1) == ';') {
                    // jika MySQL 5.1 maka cek foreign key-nya
                    $this->db->query("SET FOREIGN_KEY_CHECKS=0;");
                    // Kueri MySQL
                    $this->db->query($templine);
                    $templine = '';
                }
            }
            
            $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Database, berhasil dikembalikan !!</div>');
            redirect('page=pengaturan&act=backup_db');
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function ganti_password()
    {
        if (akses::aksesLogin() == TRUE) {
        
            $data['pengaturan']  = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['user']  = $this->db->query("SELECT DATE(last_login) as last_tgl, TIME(last_login) as last_waktu, nama, username, level, status FROM tbl_user WHERE level !='root'")->result();
           
            $this->load->view('1_atas', $data);
            $this->load->view('2_navbar', $data);
            $this->load->view('includes/pengaturan/ganti_password', $data); // Beranda
            $this->load->view('4_bawah', $data);
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
	
    public function profile_update()
    {
        if (akses::aksesLogin() == TRUE) {
            $eml   = $this->input->post('email');
            $usr   = $this->input->post('username');
            $nm    = $this->input->post('nama');
            $pass  = $this->input->post('pass1');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('email', 'Grup', 'required');
            $this->form_validation->set_rules('nama', 'Keterangan', '');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'   => form_error('nama'),
                    'email'  => form_error('email')
                );
                
                $this->session->set_flashdata('form_error', $msg_error);

                $this->session->set_flashdata('nama', $nama);
                $this->session->set_flashdata('ket', $ket);
                redirect('page=pengaturan&act=profile');
            }else{
                if(!empty($pass)){
                    $data = array(
                        'username'    => $usr,
                        'first_name'  => $nm,
                        'password'    => $pass,
                    );
                }else{
                    $data = array(
                        'username'    => $usr,
                        'first_name'  => $nm,
                    );
                }
                
                $this->ion_auth->update($id,$data);
                redirect('page=pengaturan&act=profile');
            }
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }    
    
    public function simpan() {
        if (akses::aksesLogin() == TRUE) {
            $user  = $this->input->post('email');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('stok_limit', 'Email', 'trim|required|numeric');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_message('valid_email', 'Format salah !!. Cth : user@namadomain.com');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'email'   => form_error('email'),
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('email', $user);
                redirect('page=pengaturan&act=mail_notif');
            }else{
                crud::update('tbl_pengaturan','id_pengaturan','1',$_POST);
                redirect('page=pengaturan&act=mail_notif');
            }
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function profile() {
        if (akses::aksesLogin() == TRUE) {
            $ses           = $this->session->userdata('login');
            $data['user']  = $this->ion_auth->user()->row();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/user/profile', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function cabang_list() {
        if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdmin() == TRUE) {
            $id = $this->input->get('id');
            $data['user']      = $this->db->where('id',general::dekrip($id))->get('tbl_pengaturan_cabang')->row();
            $data['users']     = $this->db->get('tbl_pengaturan_cabang')->result();
            $data['hasError']  = $this->session->flashdata('form_error');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/user/cabang_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function cabang_update() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->post('id');
            $nama  = $this->input->post('nama');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Cabang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'   => form_error('nama')
                );
                
                $has_error = array(
                    'nama'   => 'has-error'
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('nama', $nama);
                redirect('page=pengaturan&act=cabang_list&id='.$id);;
            }else{                    
                    $data_user = array(
                        'keterangan' => $nama,
                    );
                    
                    crud::update('tbl_pengaturan_cabang', 'id',general::dekrip($id), $data_user);
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Data cabang berhasil disimpan !!</div>');
                    redirect('page=pengaturan&act=cabang_list');
                }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    

    public function user_list() {
        if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdmin() == TRUE) {
            $id = $this->input->get('id');
            $data['user']      = $this->ion_auth->user(general::dekrip($id))->row();
            $data['users']     = $this->ion_auth->users()->result();
            $data['hasError']  = $this->session->flashdata('form_error');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/user/user_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function user_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $nama  = $this->input->post('nama');
            $user  = $this->input->post('user');
            $pass1 = $this->input->post('pass1');
            $pass2 = $this->input->post('pass2');
            $group = $this->input->post('grup');
            $idcbg = $this->input->post('cabang');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('user', 'Username', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[5]|matches[pass2]');
            $this->form_validation->set_rules('pass2', 'Ulang Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('grup', 'Grup Pengguna', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'   => form_error('nama'),
                    'user'   => form_error('user'),
                    'pass1'  => form_error('pass1'),
                    'pass2'  => form_error('pass2'),
                    'grup'   => form_error('grup'),
                );
                
                $has_error = array(
                    'nama'   => 'has-error',
                    'user'   => 'has-error',
                    'pass1'  => 'has-error',
                    'pass2'  => 'has-error',
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('nama', $nama);
                $this->session->set_flashdata('user', $user);
                redirect('page=pengaturan&act=user_list');
            }else{
                $cek         = $this->ion_auth->username_check($user);

                if($cek == TRUE) {
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-danger">Username tidak bisa digunakan / sudah ada !!</div>');
                    redirect('page=pengaturan&act=user_list');
                } else {
                    $data_user = array(
                        'first_name' => $nama,
                        'id_app'     => $idcbg,
                    );
                    $this->ion_auth->register($user, $pass2, 'admin@admin.com', $data_user, array($group));
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Username berhasil disimpan !!</div>');
                    redirect('page=pengaturan&act=user_list');
                }
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function user_update() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->post('id');
            $nama  = $this->input->post('nama');
            $user  = $this->input->post('user');
            $pass1 = $this->input->post('pass1');
            $pass2 = $this->input->post('pass2');
            $cbg   = $this->input->post('cabang');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('user', 'Username', 'trim|required|min_length[4]');
//            $this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[5]|matches[pass2]');
//            $this->form_validation->set_rules('pass2', 'Ulang Password', 'trim|required|min_length[5]');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'   => form_error('nama'),
                    'user'   => form_error('user'),
//                    'pass1'  => form_error('pass1'),
//                    'pass2'  => form_error('pass2'),
                );
                
                $has_error = array(
                    'nama'   => 'has-error',
                    'user'   => 'has-error',
//                    'pass1'  => 'has-error',
//                    'pass2'  => 'has-error',
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('nama', $nama);
                $this->session->set_flashdata('user', $user);
                redirect('page=pengaturan&act=user_list&id='.$id);;
            }else{
                    if(!empty($pass1)){
                        $data_user = array(
                            'first_name' => $nama,
                            'username'   => $user,
                            'password'   => $pass2,
                            'id_app'     => $cbg,
                        );                        
                    }else{
                        $data_user = array(
                            'first_name' => $nama,
                            'username'   => $user,
                            'id_app'     => $cbg,
                        );                          
                    }
                    
                    $this->ion_auth->update(general::dekrip($id), $data_user);
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Username berhasil disimpan !!</div>');
                    redirect('page=pengaturan&act=user_list&id='.$id);
                }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function user_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->encrypt->decode_url($_GET['id']);
            $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Username : <b>' . $this->ion_auth->user($id)->row()->username. '</b>, berhasil dihapus !!</div>');
            $this->ion_auth->delete_user($id);
            redirect('page=pengaturan&act=user_list');
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function mail_notif() {
        if (akses::aksesLogin() == TRUE) {
            $data['users']     = $this->db->get('tbl_pengaturan_notif')->result();
            $data['setting']   = $this->db->get('tbl_pengaturan')->row();
            $data['hasError']  = $this->session->flashdata('form_error');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/user/user_mail', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function mail_notif_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $user  = $this->input->post('email');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_message('valid_email', 'Format salah !!. Cth : user@namadomain.com');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'email_bcc'   => form_error('email'),
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('email', $user);
                redirect('page=pengaturan&act=mail_notif');
            }else{
                crud::simpan('tbl_pengaturan_notif',array('email'=>$user));
                redirect('page=pengaturan&act=mail_notif');
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function mail_notif_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->encrypt->decode_url($_GET['id']);
            $this->session->set_flashdata('pengaturan', '<div class="alert alert-success"> Data berhasil dihapus !!</div>');
            crud::delete('tbl_pengaturan_notif','id',$id);
            redirect('page=pengaturan&act=mail_notif');
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function mail_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $nama  = $this->input->post('nama');
            $user  = $this->input->post('user');
            $pass1 = $this->input->post('pass1');
            $pass2 = $this->input->post('pass2');
            $group = $this->input->post('grup');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('user', 'Username', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[5]|matches[pass2]');
            $this->form_validation->set_rules('pass2', 'Ulang Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('grup', 'Grup Pengguna', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'   => form_error('nama'),
                    'user'   => form_error('user'),
                    'pass1'  => form_error('pass1'),
                    'pass2'  => form_error('pass2'),
                    'grup'   => form_error('grup'),
                );
                
                $has_error = array(
                    'nama'   => 'has-error',
                    'user'   => 'has-error',
                    'pass1'  => 'has-error',
                    'pass2'  => 'has-error',
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('nama', $nama);
                $this->session->set_flashdata('user', $user);
                redirect('page=pengaturan&act=user_list');
            }else{
                $cek         = $this->ion_auth->username_check($user);
                
                if($cek == TRUE) {
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-danger">Username tidak bisa digunakan / sudah ada !!</div>');
                    redirect('page=pengaturan&act=user_list');
                } else {
                    $data_user = array(
                        'first_name' => $nama,
                    );
                    $this->ion_auth->register($user, $pass2, 'admin@admin.com', $data_user, array($group));
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Username berhasil disimpan !!</div>');
                    redirect('page=pengaturan&act=user_list');
                }
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    
    
//    =======================================================
    public function trans_eksport() {
        if (akses::aksesLogin() == TRUE) {
            $data['pengaturan'] = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['trans_exp'] = $this->db->select('id, DATE(tgl_simpan) as tgl, TIME(tgl_simpan) as jam, file')->get('tbl_util_eksport');
            $data['user'] = $this->ion_auth->user()->row();
            $data['raw_data']   = file_get_contents(realpath('./file/export').'/'.$_GET['file']);
            $data['hasError'] = $this->session->flashdata('form_error');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/pengaturan/trans_eksp', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function trans_import() {
        if (akses::aksesLogin() == TRUE) {
            $data['pengaturan'] = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['trans_exp'] = $this->db->select('DATE(tgl_simpan) as tgl, TIME(tgl_simpan) as jam, id, file')->get('tbl_util_import');
            $data['user'] = $this->ion_auth->user()->row();
            $data['raw_data']   = file_get_contents(realpath('./file/export').'/'.$_GET['file']);
            $data['hasError'] = $this->session->flashdata('form_error');
            
            

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/pengaturan/trans_import', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function eksport_create() {
        if (akses::aksesLogin() == TRUE) {
            $dbs        = $this->dbutil->list_databases();
            $user       = $this->ion_auth->user()->row();
            $tabel      = $this->db->list_tables();
            $setting    = $this->db->get('tbl_pengaturan')->row();
            $app        = $this->db->where('id', $setting->id_app)->get('tbl_pengaturan_cabang')->row();
            
            /* Table wants to export */
//          tbl_ion_users
            $sql_users = $this->db->get('tbl_ion_users');
            foreach ($sql_users->result() as $trans) {
                $tbl_ion_users[] = array(
                    'id'           => $trans->id,
                    'id_app'       => $trans->id_app,
                    'username'     => $trans->username,
                    'password'     => $trans->password,
                    'first_name'   => $trans->first_name,
                    'salt'         => $trans->salt,
                    'active'       => $trans->active,
                    'created_on'   => $trans->created_on,
                );
            }
            
//          tbl_ion_users_groups
            $sql_users_groups = $this->db->get('tbl_ion_users_groups');
            foreach ($sql_users_groups->result() as $trans) {
                $tbl_ion_users_groups[] = array(
                    'id'           => $trans->id,
                    'user_id'      => $trans->user_id,
                    'group_id'     => $trans->group_id,
                );
            }

//          tbl_m_kategori
            $sql_kategori = $this->db->get('tbl_m_kategori');
            foreach ($sql_kategori->result() as $trans) {
                $tbl_m_kategori[] = array(
                    'id'           => $trans->id,
                    'id_app'       => $trans->id_app,
                    'tgl_simpan'   => $trans->tgl_simpan,
                    'kategori'     => $trans->kategori,
                    'keterangan'   => $trans->keterangan,
                );
            }

//          tbl_m_kategori2
            $sql_kategori2 = $this->db->get('tbl_m_kategori2');
            foreach ($sql_kategori2->result() as $trans) {
                $tbl_m_kategori2[] = array(
                    'id'           => $trans->id,
                    'id_app'       => $trans->id_app,
                    'tgl_simpan'   => $trans->tgl_simpan,
                    'id_kategori'  => $trans->id_kategori,
                    'kategori'     => $trans->kategori,
                    'keterangan'   => $trans->keterangan,
                    'harga'        => $trans->harga,
                );
            }

            // tbl_m_produk
            $sql_produk = $this->db->get('tbl_m_produk');
            foreach ($sql_produk->result() as $trans) {
                $tbl_m_produk[] = array(
                    'id'          => $trans->id,
                    'id_app'      => $trans->id_app,
                    'tgl_simpan'  => $trans->tgl_simpan,
                    'kode'        => $trans->kode,
                    'produk'      => $trans->produk,
                    'jml'         => $trans->jml,
                    'tipe_produk' => $trans->tipe_produk,
                );
            }

            // tbl_m_kategori2_barang
            $sql_kategori2_barang = $this->db->get('tbl_m_kategori2_barang');
            foreach ($sql_kategori2_barang->result() as $trans) {
                $tbl_m_kategori2_barang[] = array(
                    'id'           => $trans->id,
                    'id_app'       => $trans->id_app,
                    'tgl_simpan'   => $trans->tgl_simpan,
                    'id_kategori2' => $trans->id_kategori2,
                    'id_barang'    => $trans->id_barang,
                    'jml'          => $trans->jml,
                );
            }            

            // tbl_m_pelanggan
            $sql_pelanggan = $this->db->where('status_plgn', '1')->get('tbl_m_pelanggan');
            foreach ($sql_pelanggan->result() as $trans) {
                $tbl_m_pelanggan[] = array(
                    'id'          => $trans->id,
                    'id_app'      => $trans->id_app,
                    'id_grup'     => (!empty($trans->id_grup) ? $trans->id_grup : '0'),
                    'tgl_simpan'  => $trans->tgl_simpan,
                    'tgl_modif'   => $trans->tgl_modif,
                    'kode'        => $trans->kode,
                    'nik'         => $trans->nik,
                    'nama'        => $trans->nama,
                    'no_hp'       => $trans->no_hp,
                    'alamat'      => $trans->alamat,
                    'status_plgn' => $trans->status_plgn,
                    'status_hps'  => $trans->status_hps,
                );
                
                crud::update('tbl_m_pelanggan', 'id', $trans->id, array('status_plgn'=>'0'));
            }
            
            // tbl_m_pelanggan_deposit
            $sql_pelanggan_deposit = $this->db->where('status_plgn', '1')->get('tbl_m_pelanggan_deposit');
            foreach ($sql_pelanggan_deposit->result() as $trans) {
                $tbl_m_pelanggan_deposit[] = array(
                    'tgl_simpan'    => $trans->tgl_simpan,
                    'tgl_modif'     => $trans->tgl_modif,
                    'id_app'        => $trans->id_app,
                    'id_pelanggan'  => $trans->id_pelanggan,
                    'jml_deposit'   => $trans->jml_deposit,
                    'keterangan'    => $trans->keterangan,
                );
                
                crud::update('tbl_m_pelanggan_deposit', 'id', $trans->id_pelanggan, array('status_plgn'=>'0'));
            }
            
            // tbl_m_pelanggan_deposit_hist
            $sql_pelanggan_deposit_hist = $this->db->where('status_plgn', '1')->get('tbl_m_pelanggan_deposit_hist');
            foreach ($sql_pelanggan_deposit_hist->result() as $trans) {
                $tbl_m_pelanggan_deposit_hist[] = array(
                    'tgl_simpan'    => $trans->tgl_simpan,
                    'id_app'        => $trans->id_app,
                    'id_pelanggan'  => $trans->id_pelanggan,
                    'id_user'       => $trans->id_user,
                    'jml_deposit'   => $trans->jml_deposit,
                    'debet'         => $trans->debet,
                    'kredit'        => $trans->kredit,
                    'keterangan'    => $trans->keterangan,
                );
                
                crud::update('tbl_m_pelanggan_deposit_hist', 'id', $trans->id_pelanggan, array('status_plgn'=>'0'));
            }
            
            // tbl_m_pelanggan_grup
            $sql_pelanggan_grup = $this->db->get('tbl_m_pelanggan_grup');
            foreach ($sql_pelanggan_grup->result() as $trans) {
                $tbl_m_pelanggan_grup[] = array(
                    'id'             => $trans->id,
                    'id_app'         => $trans->id_app,
                    'tgl_simpan'     => $trans->tgl_simpan,
                    'grup'           => $trans->grup,
                    'keterangan'     => $trans->keterangan,
                    'status_deposit' => $trans->status_deposit,
                );
            }
            
            // tbl_m_promo
            $sql_promo = $this->db->get('tbl_m_promo');
            foreach ($sql_promo->result() as $trans) {
                $tbl_m_promo[] = array(
                    'id'          => $trans->id,
                    'id_app'      => $trans->id_app,
                    'tgl_simpan'  => $trans->tgl_simpan,
                    'keterangan'  => $trans->keterangan,
                    'nominal'     => $trans->nominal,
                    'persen'      => $trans->persen,
                    'tipe'        => $trans->tipe,
                );
            }
            
            // tbl_m_platform
            $sql_platform = $this->db->get('tbl_m_platform');
            foreach ($sql_platform->result() as $trans) {
                $tbl_m_platform[] = array(
                    'id'          => $trans->id,
                    'platform'    => $trans->platform,
                    'keterangan'  => $trans->keterangan
                );
            }
            
            // tbl_m_charge
            $sql_charge = $this->db->get('tbl_m_charge');
            foreach ($sql_charge->result() as $trans) {
                $tbl_m_charge[] = array(
                    'id'          => $trans->id,
                    'tgl_simpan'  => $trans->tgl_simpan,
                    'keterangan'  => $trans->keterangan,
                    'nominal'     => $trans->nominal,
                    'persen'      => $trans->persen,
                    'tipe'        => $trans->tipe,
                );
            }
            
            // tbl_pengaturan_cabang
            $sql_pengaturan_cabang = $this->db->get('tbl_pengaturan_cabang');
            foreach ($sql_pengaturan_cabang->result() as $trans) {
                $tbl_pengaturan_cabang[] = array(
                    'id'            => $trans->id,
                    'tgl_simpan'    => $trans->tgl_simpan,
                    'keterangan'    => $trans->keterangan,
                );
            }
            
            // export to json
            $backup = array('tbl_ion_users'                 => $tbl_ion_users,
                            'tbl_ion_users_groups'          => $tbl_ion_users_groups,
                            'tbl_pengaturan_cabang'         => $tbl_pengaturan_cabang,
                            'tbl_m_kategori'                => $tbl_m_kategori,
                            'tbl_m_kategori2'               => $tbl_m_kategori2,
                            'tbl_m_kategori2_barang'        => $tbl_m_kategori2_barang,
                            'tbl_m_produk'                  => $tbl_m_produk,
                            'tbl_m_promo'                   => $tbl_m_promo,
                            'tbl_m_platform'                => $tbl_m_platform,
                            'tbl_m_charge'                  => $tbl_m_charge,
                            'tbl_m_pelanggan'               => $tbl_m_pelanggan,
                            'tbl_m_pelanggan_deposit'       => $tbl_m_pelanggan_deposit,
                            'tbl_m_pelanggan_deposit_hist'  => $tbl_m_pelanggan_deposit_hist,
                            'tbl_m_pelanggan_grup'          => $tbl_m_pelanggan_grup,
                        );

            if (isset($_GET['file'])) {
                $path = realpath('../file/export') . '/';
                $file = $path . $this->input->get('file');
                force_download($_GET['file']);
            } else {
                $path   = realpath('../file/export') . '/';
                $file   = 'pulito_' . date('YmdHi') . '_' . str_replace(array('-','.',' '), '_', $app->keterangan) . '.json';
                $output = json_encode($backup);

                $data = array(
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'file'       => $file
                );

                crud::simpan('tbl_util_eksport', $data);
                write_file($path . $file, $output);
                $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Eksport data, berhasil dibuat !!</div>');
                redirect('page=pengaturan&act=trans_eksport');
            }
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function eksport_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $file    = $this->input->get('file');
            $id      = $this->input->get('id');
            $folder  = realpath('../file/export').'/';
            
            if(!empty($id)){
                unlink($folder.$file);
                crud::delete('tbl_util_eksport','id', general::dekrip($id));
            }
            
            redirect('page=pengaturan&act=trans_eksport');
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function eksport_download() {
        if (akses::aksesLogin() == TRUE) {
            $dbs     = $this->dbutil->list_databases();
            $user    = $this->ion_auth->user()->row();
            $tabel   = $this->db->list_tables();
            $setting = $this->db->get('tbl_pengaturan')->row();
            $app     = $this->db->where('id', $setting->id_app)->get('tbl_pengaturan_cabang')->row();

            $path = realpath('../file/export').'/';
            $file = $path.$this->input->get('file');
            
            ob_clean();
            force_download($this->input->get('file'), file_get_contents($file));
            
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function import_create() {
        if (akses::aksesLogin() == TRUE) {
            if (!empty($_FILES['frestore']['name'])) {
                $folder = realpath('file/import');
                $config['upload_path'] = '../file/import';
                $config['allowed_types'] = 'json|txt|app';
//                $config['max_size']         = '10000';
                $config['remove_spaces']    = TRUE;
                $config['overwrite'] = TRUE;
                $this->load->library('upload', $config);
//                    $this->upload->initialize();

                if (!$this->upload->do_upload('frestore')) {
                    $this->session->set_flashdata('pengaturan', 'Error : <b>' . $this->upload->display_errors() . '</b>.');
                    redirect('page=pengaturan&act=trans_import&err_msg=' . $this->upload->display_errors());
                } else {
                    $f = $this->upload->data();

                    $path = realpath('../file/import') . '/';
                    $file = file_get_contents($path . $f['orig_name']);
                    $json = json_decode($file, TRUE);

                    if (!empty($json)) {
//                        $sql = $this->db->select('MAX(id) as id')->get('tbl_trans_jual')->row();
                        $i   = 0;
                        foreach ($json['tbl_trans_jual'] as $kat) {
                            $sql_cek = $this->db->where('no_nota', $kat['no_nota'])->where('id_app', $kat['id_app'])->get('tbl_trans_jual');
                            
                            $tbl_trans_jual = array(
                                'id_app'                 => $kat['id_app'],
                                'no_nota'                => $kat['no_nota'],
                                'id_promo'               => $kat['id_promo'],
                                'tgl_simpan'             => $kat['tgl_simpan'],
                                'tgl_ambil'              => $kat['tgl_ambil'],
                                'tgl_modif'              => $kat['tgl_modif'],
                                'tgl_bayar'              => $kat['tgl_bayar'],
                                'tgl_masuk'              => $kat['tgl_masuk'],
                                'tgl_keluar'             => $kat['tgl_keluar'],
                                'jml_total'              => $kat['jml_total'],
                                'jml_diskon'             => $kat['jml_diskon'],
                                'jml_biaya'              => $kat['jml_biaya'],
                                'jml_gtotal'             => $kat['jml_gtotal'],
                                'jml_bayar'              => $kat['jml_bayar'],
                                'jml_kembali'            => $kat['jml_kembali'],
                                'jml_kurang'             => $kat['jml_kurang'],
                                'pengambilan'         	 => $kat['pengambilan'],
                                'id_user'                => $kat['id_user'],
                                'id_pelanggan'           => $kat['id_pelanggan'],
                                'id_pengambilan'         => $kat['id_pengambilan'],
                                'metode_bayar'           => $kat['metode_bayar'],
                                'status_bayar'           => $kat['status_bayar'],
                                'status_ambil'           => $kat['status_ambil'],
                                'ck_jasa_lipat'          => $kat['ck_jasa_lipat'],
                                'ck_jasa_gantung'        => $kat['ck_jasa_gantung']
                            );
							
                            if($sql_cek->num_rows() == 0){
                                crud::simpan('tbl_trans_jual', $tbl_trans_jual);
                                $sql = $this->db->select('MAX(id) as id')->get('tbl_trans_jual')->row();  
                                $aid = $sql->id + 1;
                                
                                foreach ($kat['tbl_trans_jual_det'] as $trans_det){
                                    $tbl_trans_jual_det[$i] = array(
                                        'id_app'        => $trans_det['id_app'],
                                        'id_penjualan'  => $sql->id,
                                        'id_kategori2'  => $trans_det['id_kategori2'],
                                        'tgl_simpan'    => $trans_det['tgl_simpan'],
                                        'no_nota'       => $trans_det['no_nota'],
                                        'produk'        => $trans_det['produk'],
                                        'keterangan'    => $trans_det['keterangan'],
                                        'harga'         => $trans_det['harga'],
                                        'jml'           => $trans_det['jml'],
                                        'subtotal'      => $trans_det['subtotal'],
                                        'status_app'    => $trans_det['status_app'],
                                        'status_hrg'    => $trans_det['status_hrg'],
                                        'status_brg'    => $trans_det['status_brg'],
                                    );
                                    
                                    crud::simpan('tbl_trans_jual_det', $tbl_trans_jual_det[$i]);
                                }
                                
                                foreach ($kat['tbl_trans_jual_det_ket'] as $trans_det_ket){
                                    $tbl_trans_jual_det_ket[$i] = array(
                                        'id_app'            => $trans_det_ket['id_app'],
                                        'id_penjualan'      => $sql->id,
                                        'id_penjualan_det'  => $trans_det_ket['id_kategori2'],
                                        'tgl_simpan'        => $trans_det_ket['tgl_simpan'],
                                        'produk'            => $trans_det_ket['no_nota'],
                                        'keterangan'        => $trans_det_ket['produk'],
                                    );
                                    
                                    crud::simpan('tbl_trans_jual_det_ket', $tbl_trans_jual_det_ket[$i]);
                                }
                                
                                foreach ($kat['tbl_trans_jual_plat'] as $trans_plat){
                                    $tbl_trans_jual_plat = array(
                                        'id_app'        => $trans_plat['id_app'],
                                        'id_penjualan'  => $sql->id,
                                        'id_platform'   => $trans_plat['id_platform'],
                                        'no_nota'       => $trans_plat['no_nota'],
                                        'keterangan'    => $trans_plat['keterangan'],
                                    );
                                    
                                    crud::simpan('tbl_trans_jual_plat', $tbl_trans_jual_plat);
                                }
                                
                                foreach ($kat['tbl_trans_jual_lokasi'] as $trans_lokasi){
                                    $tbl_trans_jual_lokasi = array(
                                        'id_app'        => $trans_lokasi['id_app'],
                                        'id_penjualan'  => $sql->id,
                                        'id_lokasi'     => $trans_lokasi['id_lokasi'],
                                        'no_nota'       => $trans_lokasi['no_nota'],
                                        'keterangan'    => $trans_lokasi['keterangan'],
                                    );
                                    
                                    crud::simpan('tbl_trans_jual_lokasi', $tbl_trans_jual_lokasi);
                                }
                            }else{
                                $this->db
                                        ->where('no_nota', $kat['no_nota'])
                                        ->where('id_app', $kat['id_app'])
                                        ->update('tbl_trans_jual', $tbl_trans_jual);
                            }
                            
                            $i++;
                        }
                        
                        foreach ($json['tbl_m_pelanggan'] as $kat) {
                            $sql_cek = $this->db->where('id', $kat['id'])->get('tbl_m_pelanggan');
                            
                            $tbl_m_pelanggan[] = array(
                                'id'          => $kat['id'],
                                'id_app'      => $kat['id_app'],
                                'id_grup'     => (!empty($kat['id_grup']) ? $kat['id_grup'] : '0'),
                                'tgl_simpan'  => $kat['tgl_simpan'],
                                'tgl_modif'   => $kat['tgl_modif'],
                                'kode'        => $kat['kode'],
                                'nik'         => $kat['nik'],
                                'nama'        => $kat['nama'],
                                'no_hp'       => $kat['no_hp'],
                                'alamat'      => $kat['alamat'],
                                'status_hps'  => $kat['status_hps'],
                                'status_plgn' => '1',
                            );
                            
                            if ($sql_cek->num_rows() == 0) {
                                crud::simpan('tbl_m_pelanggan', $kat);
                            } else {
                                crud::update('tbl_m_pelanggan', 'id', $kat['id'], $kat);
                            }
                        }

                        foreach ($json['tbl_m_pelanggan_deposit'] as $kat) {
                            $sql_cek = $this->db->where('id', $kat['id'])->get('tbl_m_pelanggan_deposit');

                            if ($sql_cek->num_rows() == 0) {
                                crud::simpan('tbl_m_pelanggan_deposit', $kat);
                            } else {
                                crud::update('tbl_m_pelanggan_deposit', 'id', $kat['id'], $kat);
                            }
                        }

                        foreach ($json['tbl_m_pelanggan_deposit_hist'] as $kat) {
                            $sql_cek = $this->db->where('id', $kat['id'])->get('tbl_m_pelanggan_deposit_hist');

                            if ($sql_cek->num_rows() == 0) {
                                crud::simpan('tbl_m_pelanggan_deposit_hist', $kat);
                            } else {
                                crud::update('tbl_m_pelanggan_deposit_hist', 'id', $kat['id'], $kat);
                            }
                        }
                        
                        foreach ($json['tbl_m_kategori'] as $kat) {
                            $sql_cek = $this->db->where('kategori',$kat['kategori'])->get('tbl_m_kategori');

                            $tbl_m_kategori = array(
                                'id_app'       => $kat['id_app'],
                                'tgl_simpan'   => $kat['tgl_simpan'],
                                'tgl_modif'    => date('Y-m-d H:i:s'),
                                'kategori'     => $kat['kategori'],
                                'keterangan'   => $kat['keterangan'],
                                'status_temp'  => '1',
                            );
                            
                            if($sql_cek->num_rows() == 0){
                                crud::simpan('tbl_m_kategori', $tbl_m_kategori);
                                $id_kat = $this->db->insert_id();
                            }
                        }                            
                        
                        foreach ($json['tbl_m_kategori2'] as $kat) {
//                            $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_kategori2');
                            
                            $tbl_m_kategori2 = array(
                                'id_app'       => $kat['id_app'],
                                'tgl_simpan'   => $kat['tgl_simpan'],
                                'id_kategori'  => $id_kat,
                                'kategori'     => $kat['kategori'],
                                'keterangan'   => $kat['keterangan'],
                                'harga'        => $kat['harga'],
                            );
                            
//                            if($sql_cek->num_rows() == 0){
                                crud::simpan('tbl_m_kategori2', $tbl_m_kategori2);                                
//                            }
                        }
                        
                        foreach ($json['tbl_m_kategori2_barang'] as $kat) {
//                            $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_kategori2_barang');
                            
                            $tbl_m_kategori2_barang = array(
                                'id_app'       => $kat['id_app'],
                                'tgl_simpan'   => $kat['tgl_simpan'],
                                'id_kategori2' => $id_kat,
                                'id_barang'    => $kat['id_barang'],
                                'jml'          => $kat['jml'],
                            );
                            
//                            if($sql_cek->num_rows() == 0){
                                crud::simpan('tbl_m_kategori2_barang', $tbl_m_kategori2_barang);
//                            }
                        }

                        $data = array(
                            'tgl_simpan' => date('Y-m-d H:i:s'),
                            'file'       => $f['orig_name']
                        );

                        crud::simpan('tbl_util_import', $data);
                        redirect('page=pengaturan&act=trans_import&msg=sukses');
                    } else {
                        redirect('page=pengaturan&act=trans_import&msg=gagal');
                    }
                }
            } else {
                
            }
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function import_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $file    = $this->input->get('file');
            $id      = $this->input->get('id');
            $folder  = realpath('file/import').'/';
            
            if(!empty($id)){
                unlink($folder.$file);
                crud::delete('tbl_util_import','id', general::dekrip($id));
            }
            
            redirect('page=pengaturan&act=trans_import');
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
}
