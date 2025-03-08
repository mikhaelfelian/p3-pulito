<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

class akses extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function cek_login($user, $pass) {
        $this->db->select('*');
        $this->db->where('username', $user);
        $this->db->where('password', $pass);
        $sql = $this->db->get('tbl_user');
        if ($sql->num_rows() == 1) {
            foreach ($sql->result() as $row) {
                $data = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }
    
//     Cek Sudah login belun
    function aksesLogin() {
        if (!$this->ion_auth->logged_in()):
            return FALSE;
        else:
            $user = $this->ion_auth->user()->row();
            $grup = $this->ion_auth->get_users_groups()->row();

            switch ($grup->name) {
                case 'superadmin':
                    return TRUE;
                    break;

                case 'owner':
                    return TRUE;
                    break;

                case 'admin':
                    return TRUE;
                    break;

                case 'kasir':
                    return TRUE;
                    break;

                case 'gudang':
                    return TRUE;
                    break;
            }
        endif;
    }
    
//    Cek Root
    function aksesRoot() {
        if (!$this->ion_auth->is_admin()):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    

    function hakSA() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'superadmin'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function hakOwner() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'owner'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function hakAdmin() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'admin'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function hakSales() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'sales'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function hakGudang() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups()->row();
        
        if ($grup->name == 'gudang'):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function aksesPrivilege() {
        $auth = $this->session->userdata('login');
        $sql  = $this->db->query("SELECT * FROM tbl_privilege WHERE id='".$auth['id']."'");
        $res  = $sql->result();
    }
    
    function menuAkses() {
        $user = $this->ion_auth->user()->row();
        $grup = $this->ion_auth->get_users_groups($user->id)->row();
        
        switch ($grup->name){
            case 'superadmin':
                $this->load->view('admin-lte-2/includes/menu/menu_sadmin');
                break;
            
            case 'owner':
                $this->load->view('admin-lte-2/includes/menu/menu_owner');
                break;
            
            case 'admin':
                $this->load->view('admin-lte-2/includes/menu/menu_admin');
                break;
            
            case 'sales':
                $this->load->view('admin-lte-2/includes/menu/menu_sales');
                break;
            
            case 'gudang':
                $this->load->view('admin-lte-2/includes/menu/menu_gudang');
                break;
            
            default:
                $this->load->view('admin-lte-2/includes/menu/menu_sadmin');
                break;
        }
    }

}
