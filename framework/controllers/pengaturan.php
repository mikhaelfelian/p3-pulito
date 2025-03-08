<?php
/**
 * Description of pengaturan
 *
 * @author USER
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

    public function trans_eksport() {
        if (akses::aksesLogin() == TRUE) {
            $data['pengaturan'] = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['trans_exp'] = $this->db->select('id, DATE(tgl_simpan) as tgl, TIME(tgl_simpan) as jam, file')->get('tbl_util_eksport');
            $data['user'] = $this->ion_auth->user()->row();
            $data['raw_data']   = file_get_contents(realpath('./file/export').'/'.$_GET['file']);
            $data['hasError'] = $this->session->flashdata('form_error');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
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
            $data['trans_exp'] = $this->db->select('DATE(tgl_simpan) as tgl, TIME(tgl_simpan) as jam, file')->get('tbl_util_import');
            $data['user'] = $this->ion_auth->user()->row();
            $data['raw_data']   = file_get_contents(realpath('./file/export').'/'.$_GET['file']);
            $data['hasError'] = $this->session->flashdata('form_error');
            
            

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
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
            
//          tbl_m_kategori
            $sql_kategori = $this->db->where('status_temp', '1')->get('tbl_m_kategori');
            foreach ($sql_kategori->result() as $trans) {
                $tbl_m_kategori[] = array(
                    'id'           => $trans->id,
                    'id_app'       => $trans->id_app,
                    'tgl_simpan'   => $trans->tgl_simpan,
                    'kategori'     => $trans->kategori,
                    'keterangan'   => 'Kategori Sementara @ '.$app->keterangan,
                    'status_temp'  => $trans->status_temp,
                );
            }

//          tbl_m_kategori2
            $sql_kategori2 = $this->db->where('status_temp', '1')->get('tbl_m_kategori2');
            foreach ($sql_kategori2->result() as $trans) {
                $tbl_m_kategori2[] = array(
                    'id'           => $trans->id,
                    'id_app'       => $trans->id_app,
                    'tgl_simpan'   => $trans->tgl_simpan,
                    'id_kategori'  => $trans->id_kategori,
                    'kategori'     => $trans->kategori,
                    'keterangan'   => 'Kategori Sementara @ '.$app->keterangan,
                    'harga'        => $trans->harga,
                    'status_temp'  => $trans->status_temp,
                );
            }
            
            // tbl_m_pelanggan
            $sql_pelanggan = $this->db->where('status_plgn', '1')->get('tbl_m_pelanggan');
            foreach ($sql_pelanggan->result() as $trans) {
                $tbl_m_pelanggan[] = array(
                    'id'          => $trans->id,
                    'id_app'      => $trans->id_app,
                    'id_grup'     => $trans->id_grup,
                    'tgl_simpan'  => $trans->tgl_simpan,
                    'kode'        => $trans->kode,
                    'nik'         => $trans->nik,
                    'nama'        => $trans->nama,
                    'no_hp'       => $trans->no_hp,
                    'alamat'      => $trans->alamat,
                    'status_hps'  => $trans->status_hps
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
                    'status_hps'    => $trans->status_hps
                );
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
                    'status_hps'    => $trans->status_hps
                );
            }
            
            // tbl_m_lokasi
            $sql_lokasi = $this->db-->get('tbl_m_lokasi');
            foreach ($sql_lokasi->result() as $trans) {
                $tbl_m_lokasi[] = array(
                    'id'            => $trans->id,
                    'id_app'        => $trans->id_app,
                    'tgl_simpan'    => $trans->tgl_simpan,
                    'kode'          => $trans->kode,
                    'keterangan'    => $trans->keterangan,
                    'tipe'          => $trans->tipe
                );
            }
            
            // tbl_trans_jual
            $sql_trans = $this->db->where('status_trx', '1')->get('tbl_trans_jual');
            foreach ($sql_trans->result() as $key => $trans) {
                $sql_trans_det    = $this->db->where('id_penjualan', $trans->id)->get('tbl_trans_jual_det');
                $sql_trans_det_ket= $this->db->where('id_penjualan', $trans->id)->get('tbl_trans_jual_det_ket');
                $sql_trans_plat   = $this->db->where('id_penjualan', $trans->id)->get('tbl_trans_jual_plat');
                $sql_trans_lokasi = $this->db->where('id_penjualan', $trans->id)->get('tbl_trans_jual_lokasi');
                
                foreach ($sql_trans_det->result() as $trans_det){
                    $tbl_trans_jual_det[$key][] = array(
                        'id_app'        => $trans_det->id_app,
                        'id_kategori2'  => $trans_det->id_kategori2,
                        'tgl_simpan'    => $trans_det->tgl_simpan,
                        'no_nota'       => $trans_det->no_nota,
                        'produk'        => $trans_det->produk,
                        'keterangan'    => $trans_det->keterangan,
                        'harga'         => $trans_det->harga,
                        'diskon'        => $trans_det->diskon,
                        'jml'           => $trans_det->jml,
                        'pcs'           => $trans_det->pcs,
                        'uk'            => $trans_det->uk,
                        'qty'           => $trans_det->qty,
                        'subtotal'      => $trans_det->subtotal,
                        'status_app'    => $trans_det->status_app,
                        'status_hrg'    => $trans_det->status_hrg,
                        'status_brg'    => $trans_det->status_brg,
                    );
                }   
                
                foreach ($sql_trans_det_ket->result() as $trans_det_ket){
                    $tbl_trans_jual_det_ket[$key][] = array(
                        'tgl_simpan'        => $trans_det->tgl_simpan,
                        'produk'            => $trans_det_ket->no_nota,
                        'keterangan'        => $trans_det_ket->produk,
                    );
                }      
                
                foreach ($sql_trans_plat->result() as $trans_plat){
                    $tbl_trans_jual_plat[$key][] = array(
                        'id_app'        => $trans_plat->id_app,
                        'id_platform'   => $trans_plat->id_platform,
                        'id_penjualan'  => $trans_plat->id_penjualan,
                        'no_nota'       => $trans_plat->no_nota,
                        'keterangan'    => $trans_plat->keterangan
                    );
                }      
                
                foreach ($sql_trans_lokasi->result() as $trans_lok){
                    $tbl_trans_jual_lokasi[$key][] = array(
                        'id_app'        => $trans_lok->id_app,
                        'id_penjualan'  => $trans_lok->id_penjualan,
                        'id_lokasi'     => $trans_lok->id_lokasi,
                        'no_nota'       => $trans_lok->no_nota,
                        'keterangan'    => $trans_lok->keterangan
                    );
                }      

                $tbl_trans_jual[] = array(
                    'id_app'                 => $trans->id_app,
                    'no_nota'                => $trans->no_nota,
                    'id_promo'               => $trans->id_promo,
                    'tgl_simpan'             => $trans->tgl_simpan,
                    'tgl_modif'              => $trans->tgl_modif,
                    'tgl_bayar'              => $trans->tgl_bayar,
                    'tgl_masuk'              => $trans->tgl_masuk,
                    'tgl_keluar'             => $trans->tgl_keluar,
                    'tgl_ambil'              => $trans->tgl_ambil,
                    'jml_total'              => $trans->jml_total,
                    'jml_diskon'             => $trans->jml_diskon,
                    'jml_biaya'              => $trans->jml_biaya,
                    'jml_gtotal'             => $trans->jml_gtotal,
                    'jml_bayar'              => $trans->jml_bayar,
                    'jml_kembali'            => $trans->jml_kembali,
                    'jml_kurang'             => $trans->jml_kurang,
                    'pengambilan'            => $trans->pengambilan,
                    'id_user'                => $trans->id_user,
                    'id_biaya'               => $trans->id_biaya,
                    'id_pelanggan'           => $trans->id_pelanggan,
                    'id_pengambilan'         => $trans->id_pengambilan,
                    'metode_bayar'           => $trans->metode_bayar,
                    'status_bayar'           => $trans->status_bayar,
                    'status_ambil'           => $trans->status_ambil,
                    'ck_jasa_lipat'          => $trans->ck_jasa_lipat,
                    'ck_jasa_gantung'        => $trans->ck_jasa_gantung,
                    'tbl_trans_jual_det'     => $tbl_trans_jual_det[$key],
                    'tbl_trans_jual_det_ket' => $tbl_trans_jual_det_ket[$key],
                    'tbl_trans_jual_plat'    => $tbl_trans_jual_plat[$key],
                    'tbl_trans_jual_lokasi'  => $tbl_trans_jual_lokasi[$key],
                );
				
		crud::update('tbl_trans_jual', 'id', $trans->id, array('status_trx'=>'0'));
            }
            
            // export to json
            $backup = array('tbl_trans_jual'                => $tbl_trans_jual,
                            'tbl_m_pelanggan'               => $tbl_m_pelanggan,
                            'tbl_m_pelanggan_deposit'       => $tbl_m_pelanggan_deposit,
                            'tbl_m_pelanggan_deposit_hist'  => $tbl_m_pelanggan_deposit_hist,
                            'tbl_m_kategori'                => $tbl_m_kategori,
                            'tbl_m_kategori2'               => $tbl_m_kategori2,
                            'tbl_m_lokasi'                  => $tbl_m_lokasi,
                        );

            if (isset($_GET['file'])) {
                $path = realpath('./file/export') . '/';
                $file = $path . $this->input->get('file');
                force_download($_GET['file']);
            } else {
                $output = json_encode($backup);
                $path   = realpath('./file/export') . '/';
                $file   = 'pulito_'.date('YmdHi').'_'.str_replace(array('-','.',' '), '_', $app->keterangan) . '.json';

                $data = array(
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'file'       => $file
                );
                write_file($path . $file, $output);

                crud::simpan('tbl_util_eksport', $data);
                $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Eksport data, berhasil dibuat !!</div>');
                redirect(base_url('pengaturan/eksport.php'));

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
            $folder  = realpath('file/export').'/';
            
            if(!empty($id)){
                unlink($folder.$file);
                crud::delete('tbl_util_eksport','id', general::dekrip($id));
            }
            
            redirect(base_url('pengaturan/eksport.php'));
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

            $path = realpath('./file/export').'/';
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
            $folder      = realpath('file/import');
            
             if (!empty($_FILES['frestore']['name'])) {
                    $config['upload_path']      = $folder;
                    $config['allowed_types']    = 'json|txt|app';
                    $config['max_size']         = '10000';
                    $config['remove_spaces']    = TRUE;
                    $config['overwrite']        = TRUE;
                    $this->load->library('upload', $config);
                    
                    if (!$this->upload->do_upload('frestore')) {
                        $this->session->set_flashdata('pengaturan', 'Error : <b>' . $this->upload->display_errors() . '</b>.');
                        redirect(base_url('pengaturan/import.php?err_msg='.$this->upload->display_errors()));
                    }else{
                        $f = $this->upload->data();
                        
                        $path = realpath('./file/import').'/';
                        $file = file_get_contents($path.$f['orig_name']);
                        $json = json_decode($file, TRUE);
                            
                        if(!empty($json)){
                            // Hapus isi tabel barang di kategori2
                            $this->db->query("DELETE FROM tbl_m_kategori2_barang WHERE 1");
                            // Hapus tabel kategori2 dulu
                            $this->db->query("DELETE FROM tbl_m_kategori2 WHERE 1");
                            // Hapus isi tabel kategori 1
                            $this->db->query("DELETE FROM tbl_m_kategori WHERE 1");
                            
                            $this->db->query("DELETE FROM tbl_ion_users WHERE 1");
                            foreach ($json['tbl_ion_users'] as $kat) {
                                crud::simpan('tbl_ion_users', $kat);
                            }
                            
                            $this->db->query("DELETE FROM tbl_ion_users_groups WHERE 1");
                            foreach ($json['tbl_ion_users_groups'] as $kat) {
                                crud::simpan('tbl_ion_users_groups', $kat);
                            }
			
                            $sql_truncate = $this->db->query("TRUNCATE tbl_pengaturan_cabang");
                            foreach ($json['tbl_pengaturan_cabang'] as $kat) {
								crud::simpan('tbl_pengaturan_cabang', $kat);                                
                            }                            
			
                            $sql_truncate = $this->db->query("TRUNCATE tbl_m_platform");
                            foreach ($json['tbl_m_platform'] as $kat) {
								crud::simpan('tbl_m_platform', $kat);                                
                            }                            
                                                        
                            foreach ($json['tbl_m_kategori'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_kategori');
    
                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_kategori', $kat);
                                }
                            }                            
                            
                            foreach ($json['tbl_m_kategori2'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_kategori2');
                                
                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_kategori2', $kat);                                
                                }
                            }
                            
                            foreach ($json['tbl_m_kategori2_barang'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_kategori2_barang');
                                
                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_kategori2_barang', $kat);
                                }
                            }
    
                            foreach ($json['tbl_m_produk'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_produk');
                                
                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_produk', $kat);                                
                                }else{
                                    crud::update('tbl_m_produk', 'id', $kat['id'], $kat);
                                }
                            }
    
                            foreach ($json['tbl_m_pelanggan'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_pelanggan');
                                
                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_pelanggan', $kat);
                                }else{
                                    crud::update('tbl_m_pelanggan', 'id', $kat['id'], $kat);
                                }
                            }
    
                            foreach ($json['tbl_m_pelanggan_deposit'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_pelanggan_deposit');
                                
                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_pelanggan_deposit', $kat);                                
                                }else{
                                    crud::update('tbl_m_pelanggan_deposit', 'id', $kat['id'], $kat);
                                }
                            }
    
                            foreach ($json['tbl_m_pelanggan_deposit_hist'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_pelanggan_deposit_hist');
                                
                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_pelanggan_deposit_hist', $kat);                                
                                }else{
                                    crud::update('tbl_m_pelanggan_deposit_hist', 'id', $kat['id'], $kat);
                                }
                            }
    
                            foreach ($json['tbl_m_pelanggan_grup'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_pelanggan_grup');
                                
                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_pelanggan_grup', $kat);                                
                                }else{
                                    crud::update('tbl_m_pelanggan_grup', 'id', $kat['id'], $kat);
                                }
                            }

                            foreach ($json['tbl_m_charge'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_charge');

                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_charge', $kat);                                
                                }else{
                                    crud::update('tbl_m_charge', 'id', $kat['id'], $kat);
                                }
                            }
							
                            foreach ($json['tbl_m_promo'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_promo');

                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_promo', $kat);                                
                                }else{
                                    crud::update('tbl_m_promo', 'id', $kat['id'], $kat);
                                }
                            }
							
                            foreach ($json['tbl_m_platform'] as $kat) {
                                $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_platform');

                                if($sql_cek->num_rows() == 0){
                                    crud::simpan('tbl_m_platform', $kat);                                
                                }else{
                                    crud::update('tbl_m_platform', 'id', $kat['id'], $kat);
                                }
                            }
    
                            $data = array(
                                'tgl_simpan' => date('Y-m-d H:i:s'),
                                'file'       => $f['orig_name']
                            );
                            
                            crud::simpan('tbl_util_import', $data);
                            redirect(base_url('pengaturan/import.php?msg=sukses'));
                        }else{
                            redirect(base_url('pengaturan/import.php?msg=gagal'));
                        }
                    }
             }else{
                 
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
            
            redirect(base_url('pengaturan/eksport.php'));
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    
    
    public function test() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('file');
            $path = realpath('./file/export') . '/';
            $file = file_get_contents($path.$term);
            $json = json_decode($file);
            
                echo '<pre>';
                print_r($json);
                echo '</pre>';
                
            foreach ($json->data as $key => $tabel){
//                echo $key;
//                echo '<pre>';
//                print_r($tabel);
//                echo '</pre>';
            }            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
}
