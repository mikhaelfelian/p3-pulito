 <?php
/**
 * Description of transaksi
 *
 * @author mike
 */
class transaksi extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->library('excel/PHPExcel');
    }

    public function set_nota() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_keluar = $this->input->post('tgl_keluar');
            $plgn       = $this->input->post('pelanggan');
//            $ket        = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'id_kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url());
            } else {
                $tgl_msk = explode('/', $tgl_masuk);
                $tgl_klr = explode('/', $tgl_keluar);
                
                $data = array(
                    'no_nota'      => $no_nota,
                    'tgl_masuk'    => $tgl_msk[2].'-'.$tgl_msk[0].'-'.$tgl_msk[1],
                    'tgl_keluar'   => $tgl_klr[2].'-'.$tgl_klr[0].'-'.$tgl_klr[1],
                    'id_pelanggan' => $plgn,
//                    'keterangan'   => $ket,
                );
                
                echo '<pre>';
                print_r($this->session->all_userdata());
                
                $this->session->set_userdata('trans_jual', $data);
                redirect(base_url('cart/cart-step-1.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function set_nota_update() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $no_nota    = $this->input->post('no_nota');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_keluar = $this->input->post('tgl_keluar');
            $plgn       = $this->input->post('pelanggan');
//            $ket        = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'id_kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url());
            } else {
                $tgl_msk = explode('/', $tgl_masuk);
                $tgl_klr = explode('/', $tgl_keluar);
                
                $data = array(
                    'no_nota'      => $no_nota,
                    'tgl_masuk'    => $tgl_msk[2].'-'.$tgl_msk[0].'-'.$tgl_msk[1],
                    'tgl_keluar'   => $tgl_klr[2].'-'.$tgl_klr[0].'-'.$tgl_klr[1],
                    'id_pelanggan' => $plgn,
                );
                
                $this->session->set_userdata('trans_jual_edit', $data);
                crud::update('tbl_trans_jual', 'id', $id, $data);
                redirect(base_url('cart/cart-step-1-edit.php?nota='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_step_1() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_kat1',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_step_1_edit() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_form_edit_cart1',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_step_1_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $kategori    = $this->input->post('kategori');
            $keterangan  = $this->input->post('keterangan');
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
            } else {
                $data_kat = array(
                    'id_app'      => $pengaturan->id_app,
                    'tgl_simpan'  => date('Y-m-d H:i:s'),
                    'kategori'    => $kategori,
                    'keterangan'  => $keterangan,
                    'status_temp' => '1',
                );

                crud::simpan('tbl_m_kategori',$data_kat);
                echo 'done!!';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_step_1_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            crud::delete('tbl_m_kategori','id', general::dekrip($id));
            redirect(base_url('cart/cart-step-1.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_step_2() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_kat2',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_step_2_edit() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_form_edit_cart2',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    
    public function cart_step_2_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id_kategori = $this->input->post('id_kategori');
            $kategori    = $this->input->post('kategori');
            $keterangan  = $this->input->post('keterangan');
            $harga       = str_replace('.','', $this->input->post('harga'));
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
            } else {
                $data_kat = array(
                    'id_app'      => $pengaturan->id_app,
                    'tgl_simpan'  => date('Y-m-d H:i:s'),
                    'id_kategori' => general::dekrip($id_kategori),
                    'kategori'    => $kategori,
                    'keterangan'  => $keterangan,
                    'harga'       => $harga,
                    'status_temp' => '1',
                );

                crud::simpan('tbl_m_kategori2',$data_kat);
                echo 'done!!';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_step_2_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');
            $id_kat1 = $this->input->get('id_kat1');
            crud::delete('tbl_m_kategori2','id', general::dekrip($id));
            redirect(base_url('cart/cart-step-2.php?id_kat1='.$id_kat1));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_step_3() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $id_kat2            = $this->input->get('id_kat2');
            $id_kat3            = $this->input->get('id_kat3');
            
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id', general::dekrip($id_kat2))->get('tbl_m_kategori2');
            
//            echo '<pre>';
//            print_r($data['kategori2']->row());
//            echo '</pre>';
//            echo '<pre>';
//            print_r(general::dekrip($id_kat2));
//            echo '</pre>';
//            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_cart',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    

//    public function cart_step_3() {
//        if (akses::aksesLogin() == TRUE) {
//            $setting            = $this->db->get('tbl_pengaturan')->row();
//            $id_kat1            = $this->input->get('id_kat1');
//            $id_kat2            = $this->input->get('id_kat2');
//            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
//            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();
//            $data['kategori3']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->where('id_kategori2', general::dekrip($id_kat2))->get('tbl_m_kategori3')->result();
//
//            $this->load->view('admin-lte-2/1_atas',$data);
//            $this->load->view('admin-lte-2/2_header',$data);
//            $this->load->view('admin-lte-2/includes/trans/trans_jual_kat3',$data);
//            $this->load->view('admin-lte-2/5_footer',$data);
//            $this->load->view('admin-lte-2/6_bawah',$data);
//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
//            redirect();
//        }
//    }
    
    public function cart_step_4() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $id_kat2            = $this->input->get('id_kat2');
            $id_kat3            = $this->input->get('id_kat3');
            
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();
            $data['kategori3']  = $this->db->where('id', general::dekrip($id_kat3))->get('tbl_m_kategori3');
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_cart',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_step_4_edit() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $nota               = $this->input->get('nota');
            $id_kat1            = $this->input->get('id_kat1');
            $id_kat2            = $this->input->get('id_kat2');
            $id_kat3            = $this->input->get('id_kat3');
            
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2');
            $data['cart']       = $this->db->where('id_penjualan', general::dekrip($nota))->where('id_kategori2 !=', '0')->where('status_brg !=', '1')->get('tbl_trans_jual_det')->result();
                        
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_form_edit_cart3',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_kat1  = $this->input->post('id_kat1');
            $id_kat2  = $this->input->post('id_kat2');
            $uk       = $this->input->post('uk');
            $qty      = $this->input->post('jml');
            $produk   = $this->input->post('jenis');
            $ket      = $this->input->post('keterangan');
            $biaya    = $this->input->post('charge');
            $potongan = $this->input->post('diskon');
            $harga    = str_replace('.', '', $this->input->post('harga'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_kat1', 'id_kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_kat1' => form_error('id_kat1'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('set_cart.php?id_kat1='.$id_kat1.'&id_kat2='.$id_kat2.'&id_kat3='.$id_kat3.''));
            } else {
                $sql_kat = $this->db->select('tbl_m_kategori.kategori as kat1, tbl_m_kategori2.kategori as kat2, tbl_m_kategori2.jml')
                                ->join('tbl_m_kategori','tbl_m_kategori.id=tbl_m_kategori2.id_kategori')
                                ->where('tbl_m_kategori2.id',general::dekrip($id_kat2))
                                ->get('tbl_m_kategori2')->row();
                $charge  = $this->db->where('id', $biaya)->get('tbl_m_charge')->row();
                $promo   = $this->db->where('id', $potongan)->get('tbl_m_promo')->row();
                
                $jml_pcs = ($sql_kat->jml == '0' ? '1' : $sql_kat->jml);
                $jml     = $uk * $qty;
                $subtot  = ($harga + $charge->nominal);
                $diskon  = ($promo->persen / 100) * $subtot;
                $subtotal= $subtot - $diskon;

                $data = array(
                    'id'      => general::dekrip($id_kat2),
                    'qty'     => (int)$jml,
                    'price'   => (float)round($subtotal , -2),
                    'name'    => $sql_kat->kat2,
                    'options' => array(
                            'keterangan' => (!empty($ket) ? $ket : '-'),
                            'id_kat1'    => $id_kat1,
                            'id_kat2'    => $id_kat2,
                            'harga'      => $harga,
                            'charge'     => $charge->nominal,
                            'charge_ket' => $charge->keterangan,
                            'promo'      => $diskon,
                            'promo_ket'  => $promo->keterangan,
                            'uk'         => (int)$uk,
                            'pcs'        => (int)($sql_kat->jml == '0' ? '1' : $sql_kat->jml),
                            'jml'        => (int)$qty,
                            'kat1'       => $sql_kat->kat1,
                            'kat2'       => $sql_kat->kat2,
                            'ket_tmbh'   => explode(';', str_replace(array("\n", "\r"),'',$_POST['keterangan'])) //$_POST['ket_tambahan']
                        )
                );
                
                $this->cart->insert($data);
                redirect(base_url('cart/cart-step-3.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_simpan_edit() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('nota');
            $id_kat1  = $this->input->post('id_kat1');
            $id_kat2  = $this->input->post('id_kat2');
            $uk       = $this->input->post('uk');
            $qty      = $this->input->post('jml');
            $produk   = $this->input->post('jenis');
            $ket      = $this->input->post('keterangan');
            $biaya    = $this->input->post('charge');
            $potongan = $this->input->post('diskon');
            $harga    = str_replace('.', '', $this->input->post('harga'));
            $ses_trans= $this->session->userdata('trans_jual_edit');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_kat1', 'id_kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_kat1' => form_error('id_kat1'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('set_cart.php?id_kat1='.$id_kat1.'&id_kat2='.$id_kat2.'&id_kat3='.$id_kat3.''));
            } else {
                $sql_kat = $this->db->select('tbl_m_kategori.kategori as kat1, tbl_m_kategori2.kategori as kat2, tbl_m_kategori2.harga as harga, tbl_m_kategori2.jml')
                                ->join('tbl_m_kategori','tbl_m_kategori.id=tbl_m_kategori2.id_kategori')
                                ->where('tbl_m_kategori2.id',general::dekrip($id_kat2))
                                ->get('tbl_m_kategori2')->row();
                $charge  = $this->db->where('id', $biaya)->get('tbl_m_charge')->row();
                $promo   = $this->db->where('id', $potongan)->get('tbl_m_promo')->row();
                $nota    = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $sql_barang = $this->db->select('tbl_m_kategori2_barang.id, tbl_m_kategori2_barang.id_kategori2, tbl_m_produk.produk, tbl_m_kategori2_barang.jml')->join('tbl_m_produk','tbl_m_produk.id=tbl_m_kategori2_barang.id_barang')->where('tbl_m_kategori2_barang.id_kategori2', general::dekrip($id_kat2))->get('tbl_m_kategori2_barang')->result();
                $pengaturan = $this->db->get('tbl_pengaturan')->row();
                
                $jml_pcs = ($sql_kat->jml == '0' ? '1' : $sql_kat->jml);
                $jml     = $uk * $qty;
                $subtot  = ($harga + $charge->nominal);
                $diskon  = ($promo->persen / 100) * $subtot;
                $subtotal= $subtot - $diskon;
                $gtotal  = $subtotal * $jml;
                
                $prod = array(
                    'id_penjualan'  => $nota->id,
                    'no_nota'       => $nota->no_nota,
                    'id_app'        => $pengaturan->id_app,
                    'tgl_simpan'    => $ses_trans['tgl_masuk'].' '.date('H:i:s'),
                    'id_kategori2'  => general::dekrip($id_kat1),
                    'produk'        => $sql_kat->kat2, //ucwords($item['options']['kat1'] . ' &raquo; ' . $item['options']['kat2'] . ($item['name'] == '-' ? '' : ' &raquo; ' . $item['name'])),
                    'harga'         => (float)$subtotal,
                    'charge'        => $charge->nominal,
                    'charge_ket'    => $charge->keterangan,
                    'diskon'        => $diskon,
                    'diskon_ket'    => $promo->keterangan,
                    'uk'            => (int)$uk,
                    'pcs'           => (int)($sql_kat->jml == '0' ? '1' : $sql_kat->jml),
                    'jml'           => (int)$jml,
                    'qty'           => (int)$qty,
                    'pcs'           => (int)($sql_kat->jml == '0' ? '1' : $sql_kat->jml),
                    'subtotal'      => (float)$gtotal,
                );
                
                foreach ($sql_barang as $barang){
                    $prod3 = array(
			'tgl_simpan'    => $ses_trans['tgl_masuk'].' '.date('H:i:s'),
                        'id_penjualan'  => $nota->id,
                        'no_nota'       => $nota->no_nota,
                        'id_app'        => $pengaturan->id_app,
                        'produk'        => $barang->produk,
                        'jml'           => $barang->jml * $jml,
                        'status_brg'    => '1',
                    );
                    echo '<pre>';
                    print_r($prod3);
                    echo '</pre>';
                    crud::simpan('tbl_trans_jual_det', $prod3);
                }
                
                foreach ($_POST['ket_tambahan'] as $ket){
                    $prod2 = array(
                        'id_penjualan'  => $nota->id,
                        'no_nota'       => $nota->no_nota,
                        'id_app'        => $pengaturan->id_app,
                        'produk'        => $ket,
                    );
                    echo '<pre>';
                    print_r($prod2);
                    echo '</pre>';
                    crud::simpan('tbl_trans_jual_det', $prod2);                    
                }
                
                    echo '<pre>';
                    print_r($prod);
                    echo '</pre>';
                crud::simpan('tbl_trans_jual_det', $prod);
                redirect(base_url('cart/cart-step-4-edit.php?nota='.general::enkrip($nota->id).'&id_kat1='.$id_kat1.'&id_kat2='.$id_kat2));
                
//                $data = array(
//                    'id'      => general::dekrip($no_nota),
//                    'qty'     => (int)$jml,
//                    'price'   => (float)$subtotal,
//                    'name'    => $sql_kat->kat2,
//                    'options' => array(
//                            'keterangan' => (!empty($ket) ? $ket : '-'),
//                            'id_kat1'    => $id_kat1,
//                            'id_kat2'    => $id_kat2,
//                            'harga'      => $harga,
//                            'charge'     => $charge->nominal,
//                            'charge_ket' => $charge->keterangan,
//                            'promo'      => $diskon,
//                            'promo_ket'  => $promo->keterangan,
//                            'uk'         => (int)$uk,
//                            'pcs'        => (int)($sql_kat->jml == '0' ? '1' : $sql_kat->jml),
//                            'jml'        => (int)$qty,
//                            'kat1'       => $sql_kat->kat1,
//                            'kat2'       => $sql_kat->kat2,
//                            'ket_tmbh'   => $_POST['ket_tambahan']
//                        )
//                );
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_simpan_brg() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $barang   = $this->input->post('barang');
            $qty      = $this->input->post('jml');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'No Nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('cart/trans_bayar.php?id='.$no_nota));
            } else {                
                $data = array(
                    'no_nota'   => general::dekrip($no_nota),
                    'tgl_simpan'=> date('Y-m-d H:i'),
                    'produk'    => $barang,
                    'jml'       => (int)$qty
                );
                
                crud::simpan('tbl_trans_jual_det',$data);
                redirect(base_url('cart/trans_bayar.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_update() {
        if (akses::aksesLogin() == TRUE) {
            $rowid  = $this->input->post('rowid');
            $jml    = $this->input->post('jml');
            $id_kat1= $this->input->post('id_kat1');
            $id_kat2= $this->input->post('id_kat2');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('rowid', 'id_kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'rowid' => form_error('rowid'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('set_cart.php?id_kat1='.$id_kat1.'&id_kat2='.$id_kat2.'&id_kat3='.$id_kat3.''));
            } else {
                $cart    = $this->cart->product_options($rowid);
                $qty     = $jml;
                $jml_tot = $qty * $cart['uk'];
                
                $data = array(
                    'rowid'   => $rowid,
                    'qty'     => (int)$jml_tot,
                    'options' => array(
                            'keterangan' => $cart['keterangan'],
                            'id_kat1'    => $cart['id_kat1'],
                            'id_kat2'    => $cart['id_kat2'],
                            'uk'         => (int)$cart['uk'],
                            'pcs'        => (int)$cart['pcs'],
                            'jml'        => (int)$jml,
                            'kat1'       => $cart['kat1'],
                            'kat2'       => $cart['kat2']
                        )
                );
                
//                $this->cart->update($data);
                $this->cart->update_options($data);
                redirect(base_url('cart/cart-step-3.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function cart_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->get('id');
            $id_kat1  = $this->input->get('id_kat1');
            $id_kat2  = $this->input->get('id_kat2');
            
            $data = array(
               'rowid' => $id,
               'qty'   => 0
            );
            
            $this->cart->update($data);            
            redirect(base_url('cart/cart-step-3.php?id_kat1='.$id_kat1.'&id_kat2='.$id_kat2.'&id_kat3='.$id_kat3.''));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }    

    public function cart_hapus_edit() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->get('id');
            $nota     = $this->input->get('nota');
            $id_kat1  = $this->input->get('id_kat1');
            $id_kat2  = $this->input->get('id_kat2');
                        
            crud::delete('tbl_trans_jual_det','id',general::dekrip($id));            
            redirect(base_url('cart/cart-step-4-edit.php?nota='.$nota.'&id_kat1='.$id_kat1.'&id_kat2='.$id_kat2));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_simpan() {
        if (akses::aksesLogin() == TRUE) {            
            $ses_trans  = $this->session->userdata('trans_jual');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $no_nota = general::no_nota('','tbl_trans_jual', 'no_nota');
            
            $data_trans = array(
                'no_nota'     => $no_nota,
                'tgl_simpan'  => $ses_trans['tgl_masuk'].' '.date('H:i:s'),
                'tgl_masuk'   => $ses_trans['tgl_masuk'],
                'tgl_keluar'  => $ses_trans['tgl_keluar'],
                'id_pelanggan'=> $ses_trans['id_pelanggan'],
                'id_user'     => $this->ion_auth->user()->row()->id,
                'id_app'      => $pengaturan->id_app,
                'jml_total'   => round($this->cart->total(), -2),
            );
//            echo '<pre>';
//            print_r($data_trans);
            
            /* Simpan ke tabel penjualan dan detailnya */
            crud::simpan('tbl_trans_jual',$data_trans);
            $sql = $this->db->select_max('id')->get('tbl_trans_jual')->row();
            
            // Simpan ke tabel penjualan detail
            foreach ($this->cart->contents() as $item) {
                $sql_kat = $this->db->select('tbl_m_kategori.kategori as kat1, tbl_m_kategori2.kategori as kat2, tbl_m_kategori2.jml')
                                ->join('tbl_m_kategori','tbl_m_kategori.id=tbl_m_kategori2.id_kategori')
                                ->where('tbl_m_kategori2.id',general::dekrip($item['options']['id_kat2']))
                                ->get('tbl_m_kategori2')->row();
                
                $sql_barang = $this->db->select('tbl_m_kategori2_barang.id, tbl_m_kategori2_barang.id_kategori2, tbl_m_produk.produk, tbl_m_kategori2_barang.jml')->join('tbl_m_produk','tbl_m_produk.id=tbl_m_kategori2_barang.id_barang')->where('tbl_m_kategori2_barang.id_kategori2', general::dekrip($item['options']['id_kat2']))->get('tbl_m_kategori2_barang')->result();
                $subtot     = $item['qty'] * $item['price'];
                
                $ketr = explode(';', str_replace(array("\n", "\r"),'',$item['options']['keterangan']));
                                
                $prod = array(
                    'id_penjualan'  => $sql->id,
                    'no_nota'       => $no_nota,
                    'id_app'        => $pengaturan->id_app,
                    'tgl_simpan'    => $ses_trans['tgl_masuk'].' '.date('H:i:s'),
                    'id_kategori2'  => general::dekrip($item['options']['id_kat2']),
                    'produk'        => $item['name'], //ucwords($item['options']['kat1'] . ' &raquo; ' . $item['options']['kat2'] . ($item['name'] == '-' ? '' : ' &raquo; ' . $item['name'])),
                    'harga'         => $item['options']['harga'],
                    'charge'        => (!empty($item['options']['charge']) ? $item['options']['charge'] : '0'),
                    'charge_ket'    => $item['options']['charge_ket'],
                    'diskon'        => $item['options']['promo'],
                    'diskon_ket'    => $item['options']['promo_ket'],
                    'jml'           => $item['qty'], 
                    'uk'            => $item['options']['uk'],
                    'qty'           => $item['options']['jml'],
                    'pcs'           => $item['options']['pcs'],
                    'subtotal'      => round($item['subtotal'], -2),
                    'keterangan'    => str_replace(array("\n", "\r"),'',$item['options']['keterangan']),
                );
                
                $prod2 = array(
                    'id_penjualan'  => $sql->id,
                    'no_nota'       => $no_nota,
                    'id_app'        => $pengaturan->id_app,
                    'produk'        => $item['options']['keterangan'],
                );
                
                foreach ($sql_barang as $barang){
                    $prod3 = array(
			'tgl_simpan'    => $ses_trans['tgl_masuk'].' '.date('H:i:s'),
                        'id_penjualan'  => $sql->id,
                        'no_nota'       => $no_nota,
                        'id_app'        => $pengaturan->id_app,
                        'produk'        => $barang->produk,
                        'jml'           => $barang->jml * $item['qty'],
                        'status_brg'    => '1',
                    );
                    
                    crud::simpan('tbl_trans_jual_det', $prod3);
                }
                
                crud::simpan('tbl_trans_jual_det', $prod);                
                crud::simpan('tbl_trans_jual_det', $prod2);
                
                foreach ($ketr as $ket){
                    $sql_ket_det = $this->db->where('id_penjualan', $sql->id)->where('produk', $item['name'])->get('tbl_trans_jual_det')->row();
                    $ket_tambahan = array(
			'id_penjualan'     => $sql->id,
			'id_penjualan_det' => $sql_ket_det->id,
			'tgl_simpan'  	   => $ses_trans['tgl_masuk'].' '.date('H:i:s'),
			'produk'           => $item['name'],
			'keterangan'       => $ket,
                    );
                        
                    if(!empty($ket_tambahan['keterangan'])){                            
                        crud::simpan('tbl_trans_jual_det_ket', $ket_tambahan);
                    }                   
                }
            }
            
            
            $sql_nota    = $this->db->select('SUM(subtotal) as subtotal, SUM(diskon) as diskon')->where('id_penjualan', $sql->id)->get('tbl_trans_jual_det')->row();
            $subtot_disk = $this->cart->total() - $sql_nota->diskon;
            
            $data_trans_upd = array(
                'jml_diskon'  => round($sql_nota->diskon, -2)
            );
            crud::update('tbl_trans_jual','id',$sql->id, $data_trans_upd);
            
            /* Hapus session cart */
            $this->cart->destroy();
            $this->session->unset_userdata('trans_jual');
            /* End Hapus session cart */

            echo '<pre>';
            print_r($data_trans);
            redirect(base_url('cart/trans_bayar.php?id='.general::enkrip($sql->id)));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_simpan_edit() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('nota');
            $ses_trans  = $this->session->userdata('trans_jual');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $nota       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
            $nota_det   = $this->db->select_sum('subtotal')->where('id_penjualan', general::dekrip($id))->get('tbl_trans_jual_det')->row();
            
            $data_trans = array(
                'jml_total'   => $nota_det->subtotal,
            );
            
            crud::update('tbl_trans_jual', 'id', $nota->id, $data_trans);
            
            redirect(base_url('cart/trans_bayar.php?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_diskon_itm() {
        if (akses::aksesLogin() == TRUE) {            
            $id      = $this->input->post('id');
            $id_penj = $this->input->post('id_penjualan');
            $dsk_itm = str_replace('.', '', $this->input->post('disk_item'));
            
            $sql_det  = $this->db->select('*')->where('id', general::dekrip($id))->get('tbl_trans_jual_det')->row();
            $sql_prom = $this->db->select('*')->where('id', $dsk_itm)->where('tipe', '0')->get('tbl_m_promo')->row();
			$diskon   = ($sql_prom->persen / 100) * $sql_det->harga;
            $subtotal = ($sql_det->harga - $diskon) * $sql_det->jml;
            
            $data_dt = array(
                'diskon'   => $diskon,
                'subtotal' => $subtotal,
            );
            
            crud::update('tbl_trans_jual_det','id',$sql_det->id,$data_dt);
            
            $sql_tot = $this->db->select_sum('subtotal')->where('id_penjualan', general::dekrip($id_penj))->get('tbl_trans_jual_det')->row();
            crud::update('tbl_trans_jual','id',$sql_det->id_penjualan,array('jml_total' => $sql_tot->subtotal));
            
            redirect(base_url('cart/trans_bayar.php?id='.$id_penj));            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_order_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $grup    = $this->ion_auth->get_users_groups()->row();
            $id_user = $this->ion_auth->user()->row()->id;

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');

            $nt = $this->input->get('filter_nota');
            $tg = $this->input->get('filter_tgl');
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_sales');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            $tgl= explode('/', $tg);
            /* -- End Blok Filter -- */

            /* -- jml halaman pada list -- */
            //if(akses::hakSA() == TRUE OR akses::hakAdmin() == TRUE){
                //$jml_hal = (!empty($jml) ? $jml  : $this->db->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('id_user', $sl)->like('status_nota', $sn)->get('tbl_trans_jual')->num_rows()$this->db->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('id_user', $sl)->like('status_nota', $sn)->get('tbl_trans_jual')->num_rows());
                $jml_hal = $this->db->select('id, id_app, no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, jml_total, jml_gtotal, pengambilan, id_user, status_nota, status_bayar, cetak')
                           ->where('id_user', $id_user)
                           ->like('id_app', $lk)
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
//                           ->like('status_nota', $sn)
                           ->like('status_bayar', $sb)
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual')->num_rows();
                /* -- Hitung jumlah halaman -- */
               // $jml_hal = (!empty($jml) ? $jml  : $this->db->where('id_user', $id_user)->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('status_nota', $sn)->get('tbl_trans_jual')->num_rows());
            //}

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('cart/trans_order_list.php?filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
            $config['total_rows']            = $jml_hal;

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
            /* -- End Blok Pagination -- */
            

            if(!empty($hal)){
                   $data['penj'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_total, tbl_trans_jual.jml_gtotal, tbl_trans_jual.pengambilan, tbl_trans_jual.id_user, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar, tbl_trans_jual.cetak, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp')
                           ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan', 'left')
                           ->limit($config['per_page'],$hal)
                           ->where('id_user', $id_user)
                           ->like('tbl_trans_jual.id_app', $lk)
                           ->like('tbl_trans_jual.no_nota', $nt)
                           ->like('tbl_m_pelanggan.nama', $nt)
                           ->like('tbl_m_pelanggan.no_hp', $nt)
                           ->like('DATE(tbl_trans_jual.tgl_masuk)', $tg)
                           ->like('tbl_trans_jual.status_bayar', $sb)
                           ->order_by('tbl_trans_jual.no_nota','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_total, tbl_trans_jual.jml_gtotal, tbl_trans_jual.pengambilan, tbl_trans_jual.id_user, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar, tbl_trans_jual.cetak, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp')
                           ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan', 'left')
                           ->limit($config['per_page'])
                           ->where('id_user', $id_user)
//                           ->like('tbl_trans_jual.id_app', $lk)
                           ->like('tbl_trans_jual.no_nota', $nt)
                           ->or_like('tbl_m_pelanggan.nama', $nt)
                           ->or_like('tbl_m_pelanggan.no_hp', $nt)
                           ->like('DATE(tbl_trans_jual.tgl_masuk)', $tg)
                           ->like('tbl_trans_jual.id_user', $sl)
                           ->like('tbl_trans_jual.status_bayar', $sb)
                           ->order_by('tbl_trans_jual.no_nota','desc')
                           ->get('tbl_trans_jual')->result();
            }

            $this->pagination->initialize($config);
            
            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_order_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_ambil_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $grup    = $this->ion_auth->get_users_groups()->row();
            $id_user = $this->ion_auth->user()->row()->id;

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');

            $nt = $this->input->get('filter_nota');
            $tg = $this->input->get('filter_tgl');
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_sales');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            /* -- End Blok Filter -- */

            /* -- jml halaman pada list -- */
            if(akses::hakSA() == TRUE OR akses::hakAdmin() == TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('id_user', $sl)->like('status_nota', $sn)->get('tbl_trans_jual')->num_rows());
            }else{
                /* -- Hitung jumlah halaman -- */
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('id_user', $id_user)->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('status_nota', $sn)->get('tbl_trans_jual')->num_rows());
            }

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = site_url('page=transaksi&act=trans_jual_list&filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
            $config['total_rows']            = $jml_hal;

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
            /* -- End Blok Pagination -- */
            
            $data['ambil']  = TRUE;
            if(!empty($hal)){
                   $data['penj'] = $this->db->select('id, id_app, no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, jml_total, jml_gtotal, pengambilan, id_user, status_nota, status_bayar, cetak')
                           ->where('status_nota','0')
                           ->like('id_app', $lk)
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('id_user', $sl)
//                           ->like('status_nota', $sn)
                           ->like('status_bayar', $sb)
                           ->limit($config['per_page'],$hal)
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('id, id_app, no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, jml_total, jml_gtotal, pengambilan, id_user, status_nota, status_bayar, cetak')
                           ->where('status_nota','0')
                           ->like('id_app', $lk)
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('id_user', $sl)
                           ->like('status_bayar', $sb)
                           ->limit($config['per_page'])
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual')->result();
            }
            
            $this->pagination->initialize($config);
            
            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_order_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_antrian_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $grup    = $this->ion_auth->get_users_groups()->row();
            $id_user = $this->ion_auth->user()->row()->id;
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');

            $nt = $this->input->get('filter_nota');
            $tg = $this->input->get('filter_tgl');
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_sales');
            $sn = $this->input->get('filter_status');
            /* -- End Blok Filter -- */

            /* -- jml halaman pada list -- */
            if(akses::hakSA() == TRUE OR akses::hakAdmin() == TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('id_user', $sl)->like('status_nota', $sn)->get('tbl_trans_jual')->num_rows());
            }else{
                /* -- Hitung jumlah halaman -- */
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('id_user', $id_user)->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('status_nota', $sn)->get('tbl_trans_jual')->num_rows());
            }

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('cart/trans_antrian_list.php?filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
            $config['total_rows']            = $jml_hal;

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
            /* -- End Blok Pagination -- */
            

//            if(!empty($hal)){
//                   $data['penj'] = $this->db->select('no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, jml_total, jml_gtotal, id_user, lokasi, status_nota, status_bayar')
//                           ->limit($config['per_page'],$hal)
//                           ->like('no_nota', $nt)
//                           ->like('DATE(tgl_masuk)', $tg)
//                           ->like('id_user', $sl)
//                           ->like('status_nota', $sn)
//                           ->like('status_bayar', $sb)
//                           ->limit($config['per_page'],$hal)
//                           ->order_by('no_nota','desc')
//                           ->get('tbl_trans_jual')->result();
//            }else{
//                   $data['penj'] = $this->db->select('no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, jml_total, jml_gtotal, id_user, lokasi, status_nota, status_bayar')
//                           ->limit($config['per_page'],$hal)
//                           ->like('no_nota', $nt)
//                           ->like('DATE(tgl_masuk)', $tg)
//                           ->like('id_user', $sl)
//                           ->like('status_nota', $sn)
//                           ->like('status_bayar', $sb)
//                           ->limit($config['per_page'])
//                           ->order_by('no_nota','desc')
//                           ->get('tbl_trans_jual')->result();
//            }
            
            if(!empty($hal)){
                   $data['penj'] = $this->db->select('id, id_app, no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, jml_total, jml_gtotal, id_user, status_nota, status_bayar')
                           ->limit($config['per_page'],$hal)
                           ->like('id_app', $lk)
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('id_user', $sl)
//                           ->like('status_nota', $sn)
                           ->like('status_bayar', $sb)
                           ->where('id_app', $pengaturan->id_app)
                           ->limit($config['per_page'],$hal)
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('id, id_app, no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, jml_total, jml_gtotal, id_user, status_nota, status_bayar')
                           ->limit($config['per_page'],$hal)
                           ->like('id_app', $lk)
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('id_user', $sl)
//                           ->like('status_nota', $sn)
                           ->like('status_bayar', $sb)
                           ->where('id_app', $pengaturan->id_app)
                           ->limit($config['per_page'])
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual')->result();
            }
            
            $this->pagination->initialize($config);
            
            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_antrian_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_bayar_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $grup    = $this->ion_auth->get_users_groups()->row();
            $id_user = $this->ion_auth->user()->row()->id;

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');

            $nt = $this->input->get('filter_nota');
            $tg = $this->input->get('filter_tgl');
            $sl = $this->input->get('filter_sales');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            /* -- End Blok Filter -- */
            /* -- jml halaman pada list -- */
            if(akses::hakSA() == TRUE OR akses::hakAdmin() == TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('id_user', $id_user)->get('tbl_trans_jual')->num_rows());
            }else{
                /* -- Hitung jumlah halaman -- */
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('id_user', $id_user)->get('tbl_trans_jual')->num_rows());
            }

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('cart/trans_bayar_list.php?filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
            $config['total_rows']            = $jml_hal;

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
            /* -- End Blok Pagination -- */
            

            if(!empty($hal)){
                   $data['penj'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_masuk) as tgl, tgl_ambil, tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_total, tbl_trans_jual.jml_gtotal, tbl_trans_jual.pengambilan, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar')
                           ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                           ->where('tbl_trans_jual.status_nota !=', '3')
                           ->where('tbl_trans_jual.id_user', $id_user)
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_trans_jual.no_nota', $nt)
                           ->or_like('tbl_m_pelanggan.nama', $nt)
                           ->or_like('tbl_m_pelanggan.no_hp', $nt)
                           ->order_by('tbl_trans_jual.no_nota','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_masuk) as tgl, tgl_ambil, tgl_keluar, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_total, tbl_trans_jual.jml_gtotal, tbl_trans_jual.pengambilan, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar')
                           ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                           ->where('tbl_trans_jual.status_nota !=', '3')
                           ->where('tbl_trans_jual.id_user', $id_user)
                           ->limit($config['per_page'])
                           ->like('tbl_trans_jual.no_nota', $nt)
                           ->or_like('tbl_m_pelanggan.nama', $nt)
                           ->or_like('tbl_m_pelanggan.no_hp', $nt)
                           ->order_by('tbl_trans_jual.no_nota','desc')
                           ->get('tbl_trans_jual')->result();
            }
                        
            $this->pagination->initialize($config);
            
            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_bayar_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_bayar() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();
            $data['kategori3']  = $this->db->where('id_kategori', general::dekrip($id_kat2))->where('id_kategori2', general::dekrip($id_kat2))->get('tbl_m_kategori3')->result();

            $data['diskon']     = $this->db->where('tipe', '1')->get('tbl_m_promo')->result();
            //$data['diskon_itm'] = $this->db->where('tipe', '0')->get('tbl_m_promo')->result();
            $data['biaya']      = $this->db->where('tipe', '1')->get('tbl_m_charge')->result();
            $data['platform']   = $this->db->get('tbl_m_platform')->result();
            $data['penj']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
            $data['penj_det']   = $this->db->where('id_penjualan', general::dekrip($id))->where('status_brg', '0')->where('id_kategori2 !=', '0')->get('tbl_trans_jual_det')->result();
            $data['plgn']       = $this->db->where('id', $data['penj']->id_pelanggan)->get('tbl_m_pelanggan')->row();
            $data['member_sal'] = $this->db->where('id_pelanggan', $data['penj']->id_pelanggan)->get('tbl_m_pelanggan_deposit')->row();

            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_bayar',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_detail() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();
            $data['kategori3']  = $this->db->where('id_kategori', general::dekrip($id_kat2))->where('id_kategori2', general::dekrip($id_kat2))->get('tbl_m_kategori3')->result();

            $data['diskon']     = $this->db->get('tbl_m_promo')->result();
            $data['biaya']      = $this->db->get('tbl_m_charge')->result();
            $data['penj']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
            $data['penj_det']   = $this->db->where('id_penjualan', $data['penj']->id)->where('id_kategori2 !=', 0)->get('tbl_trans_jual_det')->result();
            $data['plgn']       = $this->db->where('id', $data['penj']->id_pelanggan)->get('tbl_m_pelanggan')->row();
            $data['member_sal'] = $this->db->where('id_pelanggan', $data['penj']->id_pelanggan)->get('tbl_m_pelanggan_deposit')->row();
            
            if($data['penj']->status_bayar == '1'){
                $data['meta_equiv'] = $this->session->flashdata('meta_equiv');
            }
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_detail',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    

    public function trans_rak_list() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            
            if(isset($_GET['lokasi']) && isset($_GET['no_nota'])){
                /* -- Blok Filter -- */
                $query   = $this->input->get('q');
                $hal     = $this->input->get('halaman');
                $jml     = $this->input->get('jml');
                $lok     = ($_GET['lokasi'] == 'semua' ? '' : $this->input->get('lokasi'));
                $idj     = $this->input->get('no_nota');
                $cbg     = ($_GET['cabang'] == 'semua' ? '' : $this->input->get('cabang'));
                /* -- End Blok Filter -- */
                
                /* -- Blok Pagination -- */
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('id_user', $id_user)->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('status_nota', $sn)->get('tbl_trans_jual')->num_rows());
                
                $config['base_url']              = base_url('cart/trans_rak_list.php?no_nota='.$this->input->get('no_nota').'&lokasi='.$this->input->get('lokasi'));
                $config['total_rows']            = $jml_hal;

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
                /* -- End Blok Pagination -- */
                
                
                $data['sql_lokasi']     = $this->db->select('tbl_trans_jual.id, tbl_pengaturan_cabang.keterangan as cabang, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.id_user, tbl_m_lokasi.kode, tbl_m_lokasi.keterangan')
                                               ->join('tbl_pengaturan_cabang','tbl_pengaturan_cabang.id=tbl_trans_jual_lokasi.id_app')
                                               ->join('tbl_m_lokasi','tbl_m_lokasi.id=tbl_trans_jual_lokasi.id_lokasi')
                                               ->join('tbl_trans_jual','tbl_trans_jual.id=tbl_trans_jual_lokasi.id_penjualan')
                                               ->like('tbl_trans_jual.id_app', $cbg)
                                               ->like('tbl_m_lokasi.keterangan', $lok)
                                               ->like('tbl_trans_jual.no_nota', $idj)
											   ->where('tbl_trans_jual.id_app', $setting->id_app)
                                               ->get('tbl_trans_jual_lokasi')->result();
                
                
            }else{
                $data['sql_lokasi']     = $this->db->select('tbl_trans_jual.id, tbl_pengaturan_cabang.keterangan as cabang, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.id_user, tbl_m_lokasi.kode, tbl_m_lokasi.keterangan')
                                               ->join('tbl_pengaturan_cabang','tbl_pengaturan_cabang.id=tbl_trans_jual_lokasi.id_app')
                                               ->join('tbl_m_lokasi','tbl_m_lokasi.id=tbl_trans_jual_lokasi.id_lokasi')
                                               ->join('tbl_trans_jual','tbl_trans_jual.id=tbl_trans_jual_lokasi.id_penjualan')
                                               ->like('tbl_trans_jual.id_app', $cbg)
                                               ->like('tbl_m_lokasi.keterangan', $lok)
                                               ->like('tbl_trans_jual.no_nota', $idj)
											   ->where('tbl_trans_jual.id_app', $setting->id_app)
                                               ->get('tbl_trans_jual_lokasi')->result();
            }

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_rak_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_rak_det() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            $data['lokasi']     = $this->db->where('id', general::dekrip($id))->get('tbl_m_lokasi')->row();
            $data['lokasi_det'] = $this->db->where('id_lokasi', $data['lokasi']->id)->get('tbl_trans_jual_lokasi');
//            
//            echo '<pre>';
//            print_r($data['lokasi']);
//            echo '</pre>';
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_rak_det',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    

    public function trans_print_ex() {
        if (akses::aksesLogin() == TRUE) {
            $setting    = $this->db->get('tbl_pengaturan')->row();
            $id         = $this->input->get('id');
            $aid        = general::dekrip($id);
            $sql        = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.id_user, tbl_trans_jual.id_promo, tbl_trans_jual.id_app, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual.jml_total, tbl_trans_jual.jml_diskon, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.jml_kembali, tbl_trans_jual.jml_kurang, tbl_trans_jual.metode_bayar, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.cetak, tbl_m_pelanggan.id as id_pelanggan, tbl_m_pelanggan.id_grup as id_pelanggan_grup, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp, tbl_m_pelanggan.alamat')->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')->where('tbl_trans_jual.id', $aid)->get('tbl_trans_jual');
            $sql_grup   = $this->db->select('*')->where('tbl_m_pelanggan_grup.id', $sql->row()->id_pelanggan_grup)->get('tbl_m_pelanggan_grup');
//            $sql_sum    = $this->db->select_sum('subtotal')->where('tbl_trans_jual.id', $aid)->get('tbl_trans_jual_det')->row();
            $sql_det    = $this->db->where('id_penjualan', $aid)->where('id_kategori2 !=', '0')->get('tbl_trans_jual_det');
            $member     = $this->db->where('id', $sql->row()->id_pelanggan)->get('tbl_m_pelanggan')->row();
            $member_sal = $this->db->where('id_pelanggan', $sql->row()->id_pelanggan)->get('tbl_m_pelanggan_deposit')->row();
            $pengaturan = $this->db->join('tbl_pengaturan_cabang','tbl_pengaturan_cabang.id=tbl_pengaturan.id_app')->get('tbl_pengaturan')->row();
            $copy       = $this->input->get('status_ctk');
                                    
            $objPHPExcel = new PHPExcel();
//            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->getStyle('D1:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('A7:I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           
            // Font size nota
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setSize('10')->setName('');
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFont()->setSize('10')->setName('Tahoma');
            $objPHPExcel->getActiveSheet()->getStyle('D2:E2')->getFont()->setSize('10')->setName('Tahoma');
            $objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFont()->setSize('10')->setName('Tahoma');
            $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getFont()->setSize('10')->setName('Tahoma');
            $objPHPExcel->getActiveSheet()->getStyle('A5:E5')->getFont()->setSize('10')->setName('Tahoma')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->setSize('10')->setName('Tahoma')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A7:I7')->getFont()->setSize('10')->setName('Tahoma')->setBold(TRUE);
                        
            // Judul Nota
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '')->mergeCells('A1:C1')
                    ->setCellValue('D1', '')->mergeCells('D1:E1');
            // Sub Judul Nota
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A2', '')->mergeCells('A2:C2')
                    ->setCellValue('D2', '')
                    ->setCellValue('E2', '');
            // Alamat Nota
//            $objPHPExcel->setActiveSheetIndex(0)
//                    ->setCellValue('A3', '')->mergeCells('A3:D3')
//                    ->setCellValue('E3', $sql->row()->nama.' ('.$sql->row()->grup.')')->mergeCells('E3:H3')
//                    ->setCellValue('I3', '');
            // Kontak Nota
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A4', $sql->row()->nama.' ('.$sql_grup->row()->grup.') '.$sql->row()->no_hp)->mergeCells('A4:B4')
                    ->setCellValue('C4', $sql->row()->alamat)->mergeCells('C4:F4');
            

            // NOTA PEMESANAN
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'NOTA PEMESANAN')->mergeCells('A5:F5');
            
            // Nomor Nota
            $user = $sql->row()->id_user;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A6', 'No.#'.$sql->row()->no_nota.' '.$this->tanggalan->tgl_indo($sql->row()->tgl_simpan))->mergeCells('A6:B6')
                    ->setCellValue('C6', 'Masuk: '.$this->tanggalan->tgl_indo($sql->row()->tgl_masuk).' - Jadi: '.$this->tanggalan->tgl_indo($sql->row()->tgl_keluar))->mergeCells('C6:H6');
//                    ->setCellValue('F6', 'Keluar: '.$this->tanggalan->tgl_indo($sql->row()->tgl_keluar).' - Jadi: '.$this->tanggalan->tgl_indo($sql->row()->tgl_keluar))->mergeCells('F6:G6')
//                    ->setCellValue('H6', 'Jadi: '.$this->tanggalan->tgl_indo($sql->row()->tgl_jadi).' - Jadi: '.$this->tanggalan->tgl_indo($sql->row()->tgl_keluar));

            // Header Tabel Nota
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A7', 'NO')
                    ->setCellValue('B7', 'JENIS')
                    ->setCellValue('C7', 'KET')
                    ->setCellValue('D7', 'DISC')
                    ->setCellValue('E7', 'JML')
//                    ->setCellValue('H7', 'CHARGE')
                    ->setCellValue('F7', 'HARGA SATUAN');

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(1);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(1);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

            // border atas, nama kolom
            $objPHPExcel->getActiveSheet()->getStyle('A7:F7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DASHDOT);
            $objPHPExcel->getActiveSheet()->getStyle('A7:F7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DASHDOT);
            
            // Maximal baris
            $jmlbaris = 5 - (int) $sql_det->num_rows();
            
            $no    = 1;
            $cell  = 8;
			
            $pcs = 0;
            foreach ($sql_det->result() as $sql_det){
		$pcs     = $pcs + ($sql_det->jml * $sql_det->pcs);
                $sql_ket = $this->db->select('keterangan')->where('id_penjualan', $aid)->where('id_penjualan_det', $sql_det->id)->get('tbl_trans_jual_det_ket')->result();
                
//                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
//                
//                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell)->getFont()->setSize('6')->setName('Arial');
//                
                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('F' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('I'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                
                if($sql_det->jml == 0){
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$cell)->getFont()->setItalic(true);
                }
                
                $n = $no / 2;
                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$cell)->getAlignment()->setWrapText(true);
//                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell)->getAlignment()->setWrapText(true);
//                $objPHPExcel->getActiveSheet()->getStyle('E'.$cell)->getAlignment()->setWrapText(true);
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':F'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$cell, $no)
                        ->setCellValue('B'.$cell, strtoupper($sql_det->produk)) //$sql_det->produk
                        ->setCellValue('C'.$cell, str_replace(';',"\n",$sql_det->keterangan)) //$sql_det->produk
                        ->setCellValue('D'.$cell, ($sql_det->diskon != 0 ? number_format($sql_det->diskon,'0','.',',') : ''))
                        ->setCellValue('E'.$cell, ($sql_det->jml != 0 ? $sql_det->jml : ''))
//                        ->setCellValue('G'.$cell, ($sql_det->harga != 0 ? number_format($sql_det->harga,'0','.',',') : ''))
//                        ->setCellValue('H'.$cell, ($sql_det->charge != 0 ? number_format($sql_det->charge,'0','.',',') : ''))
                        ->setCellValue('F'.$cell, ($sql_det->harga != 0 ? number_format($sql_det->harga,'0','.',',') : ''));
//                        ->setCellValue('I'.$cell, ($sql_det->subtotal != 0 ? number_format($sql_det->subtotal,'0','.',',') : ''));

//                $objPHPExcel->getActiveSheet()->setCellValue('C' . $cell, str_replace(';',"\n",$sql_det->keterangan))->mergeCells('C' . $cell.':E' . $cell);
                
                $cell++;
                $no++;
            }

            // Font Nota Detail
            $objPHPExcel->getActiveSheet()->getStyle('A8:D'.$cell)->getFont()->setSize('10')->setName('Tahoma');
            $objPHPExcel->getActiveSheet()->getStyle('E8:F'.$cell)->getFont()->setSize('10')->setName('Tahoma');
            
            // Baris kosong space nota
            for ($i = 0; $i <= $jmlbaris; $i++) {
                $sell = $cell + $i;
                
//                $objPHPExcel->getActiveSheet()->getRowDimension($sell)->setRowHeight(50);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sell, '')
                        ->setCellValue('B' . $sell, '')
                        ->setCellValue('C' . $sell, '')
                        ->setCellValue('D' . $sell, '')
                        ->setCellValue('E' . $sell, '')
                        ->setCellValue('F' . $sell, '');
            }
            
            // Hitung sell bawah
            $sell2    = $sell;
            $sellbwh1 = $sell2 + 1;
            $sellbwh2 = $sellbwh1 + 1;
            $sellbwh3 = $sellbwh2 + 1;
            $sellbwh4 = $sellbwh3 + 1;            
            
//            $objPHPExcel->getActiveSheet()->getRowDimension($sell)->setRowHeight(14.5);
            // border bawah, subtotal
            $objPHPExcel->getActiveSheet()->getStyle('E' . $sell2.':F' . $sellbwh4)->getFont()->setBold(TRUE);
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':F'.$sell2)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DASHDOT);
//            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':E'.$sell2)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUMDASHED);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//            $objPHPExcel->getActiveSheet()->getStyle('D'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $objPHPExcel->getActiveSheet()->getStyle('F' . $sell2)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sell2, ($sql->row()->ck_jasa_lipat == 1 ? 'Lipat' : '').($sql->row()->ck_jasa_gantung == 1 ? ', Gantung' : ''))->mergeCells('A' . $sell2.':B' . $sell2)
                    ->setCellValue('C' . $sell2, 'PCS')
                    ->setCellValue('D' . $sell2, $pcs)
//                    ->setCellValue('G' . $sell2, '')
                    ->setCellValue('E' . $sell2, 'TOTAL')
                    ->setCellValue('F' . $sell2, number_format($sql->row()->jml_total,'0','.',','));

            // Font Nota Grandtotal Bawah
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':F'.$sell2)->getFont()->setSize('10')->setName('Tahoma');
            
            
            // Font nota diskon
            $sql_promo = $this->db->where('id', $sql->row()->id_promo)->get('tbl_m_promo')->row();
            $objPHPExcel->getActiveSheet()->getStyle('A' . $sellbwh1.':C'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $sellbwh1.':F'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $sellbwh1)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh1, ($sql->row()->id_promo != 0 ? 'PROMO '.$sql_promo->keterangan.' '.number_format($sql_promo->persen,'0','.',',').'%' : ''))->mergeCells('A' . $sellbwh1.':C' . $sellbwh1)
                    ->setCellValue('E' . $sellbwh1, 'DISKON')
                    ->setCellValue('F' . $sellbwh1, ($sql->row()->jml_diskon == 0 ? '0,0' : number_format($sql->row()->jml_diskon,'0','.',',')));
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1.':F'.$sellbwh1)->getFont()->setSize('10')->setName('Tahoma');
            
            
            // Font nota gtotal
            $objPHPExcel->getActiveSheet()->getStyle('D' . $sellbwh2.':F' . $sellbwh4)->getFont()->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $sellbwh2.':C'.$sellbwh2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $sellbwh2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sellbwh2.':F'.$sellbwh2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $sellbwh2)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh2, '')->mergeCells('A' . $sellbwh2.':B' . $sellbwh2)
                    ->setCellValue('C' . $sellbwh2, $member->ket1)
                    ->setCellValue('D' . $sellbwh2, 'GRAND TOTAL')->mergeCells('D' . $sellbwh2.':E' . $sellbwh2)
                    ->setCellValue('F' . $sellbwh2, ($sql->row()->jml_gtotal == 0 ? '0,0' : number_format($sql->row()->jml_gtotal,'0','.',',')));
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh2.':F'.$sellbwh2)->getFont()->setSize('10')->setName('Tahoma');
            
            
            // Font nota jml bayar
            $objPHPExcel->getActiveSheet()->getStyle('A' . $sellbwh3.':D'.$sellbwh3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//            $objPHPExcel->getActiveSheet()->getStyle('A' . $sellbwh3.':C'.$sellbwh3)->get()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $sellbwh3.':F'.$sellbwh3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $sellbwh3)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh3, ($sql->row()->cetak == '1' ? 'STORE COPY' : ''))->mergeCells('A' . $sellbwh3.':B' . $sellbwh3)
                    ->setCellValue('C' . $sellbwh3, $member->ket2)
                    ->setCellValue('D' . $sellbwh3, 'JML BAYAR')->mergeCells('D' . $sellbwh3.':E' . $sellbwh3)
                    ->setCellValue('F' . $sellbwh3, ($sql->row()->jml_bayar == 0 ? '0,0' : number_format($sql->row()->jml_bayar,'0','.',',')));
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh3.':F'.$sellbwh3)->getFont()->setSize('10')->setName('Tahoma');
            
            
            
            // Font nota jml kembali
            $objPHPExcel->getActiveSheet()->getStyle('A' . $sellbwh4.':D'.$sellbwh4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $sellbwh4.':F'.$sellbwh4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $sellbwh4)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh4, $this->ion_auth->user($sql->row()->id_user)->row()->username.'@'.$pengaturan->keterangan)->mergeCells('A' . $sellbwh4.':B' . $sellbwh4)
                    ->setCellValue('C' . $sellbwh4, $member->ket3)
                    ->setCellValue('D' . $sellbwh4, ($sql->row()->jml_kurang > 0 ? 'KEKURANGAN' : ($sql->row()->metode_bayar == 1 ? 'KEMBALIAN' : 'SALDO')))->mergeCells('D' . $sellbwh4.':E' . $sellbwh4)
                    ->setCellValue('F' . $sellbwh4, ($sql->row()->jml_kurang > 0 ? number_format($sql->row()->jml_kurang,'0','.',',') : ($sql->row()->metode_bayar == 1 ?  ($sql->row()->jml_kembali == 0 ? '0,0' : number_format($sql->row()->jml_kembali,'0','.',',')) : number_format($member_sal->jml_deposit,'0','.',','))));
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh4.':F'.$sellbwh4)->getFont()->setSize('10')->setName('Tahoma');
            
            
            $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Nota #'.$aid);

            /** Page Setup * */
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

            /* -- Margin -- */
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setTop(0.25);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setRight(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setLeft(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setFooter(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPrintArea('A1:I'.$sellbwh4);
            $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPrintArea('A1:I'.$sellbwh4);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
            //$objPHPExcel->getActiveSheet()
            //        ->getStyle()->getFont()->setName('Arial');

            /** Page Setup * */
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy("" . ucwords($createBy) . ' [' . strtoupper($namaPerusahaan) . ']')
                    ->setTitle("Nota Penjualan " . $sql->row()->no_nota . ($sql->row()->cetak == '1' ? ' Copy Customer' : ''))
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
                    ->setKeywords("POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="nota-' . $sql->row()->no_nota. ($sql->row()->cetak == '1' ? '-copy' : '') . '.xls"');
//            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
//            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            
            ob_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            
            if(!empty($id)){
               crud::update('tbl_trans_jual','id',$aid,array('cetak'=>'1'));
            }
            exit;
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_print_ket_ex() {
        if (akses::aksesLogin() == TRUE) {
            $setting    = $this->db->get('tbl_pengaturan')->row();
            $id         = $this->input->get('id');
            $aid        = general::dekrip($id);
            $sql        = $this->db->where('tbl_trans_jual.id', $aid)->get('tbl_trans_jual');
            $sql_det    = $this->db->where('id_penjualan', $sql->row()->id)->get('tbl_trans_jual_det_ket');
            $member     = $this->db->where('id', $sql->row()->id_pelanggan)->get('tbl_m_pelanggan')->row();
            $member_sal = $this->db->where('id_pelanggan', $sql->row()->id_pelanggan)->get('tbl_m_pelanggan_deposit');
            $pengaturan = $this->db->join('tbl_pengaturan_cabang','tbl_pengaturan_cabang.id=tbl_pengaturan.id_app')->get('tbl_pengaturan')->row();
                        
            
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getStyle('D1:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           
            // Font size nota
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setSize('14')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFont()->setSize('12')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('D2:E2')->getFont()->setSize('10')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setSize('10')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getFont()->setSize('10')->setName('Times New Roman');
//            $objPHPExcel->getActiveSheet()->getStyle('A5:E5')->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
//            $objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getFont()->setSize('12')->setName('Times New Roman');

            // Judul Nota
//            $objPHPExcel->setActiveSheetIndex(0)
//                    ->setCellValue('A1', '')->mergeCells('A1:C1')
//                    ->setCellValue('D1', '')->mergeCells('D1:E1');

            $user = $sql->row()->id_user;

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
//

//                // Header Tabel Nota
//                $objPHPExcel->setActiveSheetIndex(0)
//                        ->setCellValue('A3', 'NO')
//                        ->setCellValue('B3', 'NOTA')
//                        ->setCellValue('C3', 'NAMA')
//                        ->setCellValue('D3', 'TGL JADI')
//                        ->setCellValue('E3', 'KETERANGAN');
//
//            $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//
//            // border atas, nama kolom
//            $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            
            $cell  = 1;
            $no = 1;
            foreach ($sql_det->result() as $nota_det){
            
                $sql_kat = $this->db->where('id_penjualan', $nota_det->id_penjualan)->where('produk', $nota_det->produk)->get('tbl_trans_jual_det_ket')->row();
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':E'.$cell)->getFont()->setSize('8')->setName('Times New Roman');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':E'.$cell)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':E'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
		$objPHPExcel->getActiveSheet()->getStyle('A' . $cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DASHDOT);

                $objPHPExcel->getActiveSheet()->getRowDimension($cell)->setRowHeight(75);

                if (!empty($nota_det->keterangan)) {
//                    $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A' . $cell, $no)
//                            ->setCellValue('B' . $cell, '#'.$sql->row()->no_nota)
//                            ->setCellValue('C' . $cell, $member->nama)
//                            ->setCellValue('D' . $cell, $this->tanggalan->tgl_indo($sql->row()->tgl_keluar))
//                            ->setCellValue('A' . $cell, $no);

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $cell, "#" . $sql->row()->no_nota . "\n".$member->nama."\n".$this->tanggalan->tgl_indo($sql->row()->tgl_keluar)."\n".$nota_det->keterangan);
                }

                $cell++;
                $no++;
            }
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Nota #'.$aid);

            /** Page Setup * */
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

            /* -- Margin -- */
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setTop(0.25);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setRight(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setLeft(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setFooter(0);
            //$objPHPExcel->getActiveSheet()
            //        ->getStyle()->getFont()->setName('Arial');

            /** Page Setup * */
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy("" . ucwords($createBy) . ' [' . strtoupper($namaPerusahaan) . ']')
                    ->setTitle("Nota Penjualan " . $sql->row()->no_nota)
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
                    ->setKeywords("POS")
                    ->setCategory("Untuk mencetak nota dot matrix");

            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="nota-' . $sql->row()->no_nota . '-ket.xls"');
//            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
//            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            
            ob_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    

    public function set_order1() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function set_order2() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $id_kat2            = $this->input->get('id_kat2');
            
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();
            $data['kategori3']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->where('id_kategori2', general::dekrip($id_kat2))->get('tbl_m_kategori3')->result();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual2',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function set_cart() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $id_kat2            = $this->input->get('id_kat2');
            $id_kat3            = $this->input->get('id_kat3');
            
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();
            $data['kategori3']  = $this->db->where('id', general::dekrip($id_kat3))->get('tbl_m_kategori3');
//
//            echo '<pre>';
//            print_r($data['kategori3']->row());
//            echo '</pre>';
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_cart',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_lokasi_rak() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $no_nota  = $this->input->post('no_nota');
            $lokasi   = $this->input->post('lokasi');
            $halaman  = $this->input->post('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('lokasi', 'No. Nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'lokasi' => form_error('lokasi'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('cart/trans_antrian_list.php?halaman='.$halaman));
            } else {
                $sql_lokasi = $this->db->where('id', $lokasi)->get('tbl_m_lokasi')->row();
                
                $data = array(
                    'id_penjualan' => $id,
                    'id_app'       => $pengaturan->id_app,
                    'id_lokasi'    => $lokasi,
                    'no_nota'      => $no_nota,
                    'keterangan'   => $sql_lokasi->keterangan,
                );
                                
                crud::simpan('tbl_trans_jual_lokasi', $data);                
                redirect(base_url('cart/trans_antrian_list.php?halaman='.$halaman));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_lokasi_rak_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->get('id');
            $halaman  = $this->input->get('halaman');
            
            if(!empty($id)){
                crud::delete('tbl_trans_jual_lokasi','id',general::dekrip($id));
                redirect(base_url('cart/trans_antrian_list.php?id='.$id.(!empty($halaman) ? '&halaman='.$halaman : '')));
            }else{
                redirect(base_url('cart/trans_antrian_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_lokasi_rak2() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id       = $this->input->post('id');
            $ket      = $this->input->post('keterangan');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'No. Nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('cart/trans_rak_det.php?id='.$id));
            } else {
                $data = array(
                    'id_lokasi' => general::dekrip($id),
                    'no_nota'   => $no_nota,
                    'keterangan'=> $ket
                );
                
                crud::simpan('tbl_trans_jual_lokasi', $data);
                
                redirect(base_url('cart/trans_rak_det.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_bayar() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $no_nota  = general::dekrip($id);
            $id_biaya = $this->input->post('id_biaya');
//            $tgl_msk  = explode('/', $this->input->post('tgl_masuk'));
//            $tgl_klr  = explode('/', $this->input->post('tgl_keluar'));
//            $idpel    = $this->input->post('id_pelanggan');
//            $id_user  = $this->ion_auth->user()->row()->id;
//            $id_kat1  = $this->input->post('id_kat1');
//            $id_kat2  = $this->input->post('id_kat2');
//            $id_kat3  = $this->input->post('id_kat3');
//            $qty      = $this->input->post('jml');
            $rute       = $this->input->post('route');
            $pengambil  = $this->input->post('pengambil');
            $metode_byr = $this->input->post('metode_bayar');
            $no_kartu   = $this->input->post('no_kartu');
            $cetak      = $this->input->post('cetak');
            $jml_total  = str_replace('.', '', $this->input->post('jml_total'));
            $diskon     = $this->input->post('jml_diskon'); //str_replace('.', '', $this->input->post('jml_diskon'));
            $jml_bayar  = str_replace('.', '', $this->input->post('jml_bayar'));
//            $jml_biaya  = str_replace('.', '', $this->input->post('jml_biaya'));
            $ck_jasa_lipat   = ($_POST['ck_jasa_lipat'] == '1' ? '1' : '');
            $ck_jasa_gantung = ($_POST['ck_jasa_lipat'] == '0' ? '1' : '');;
//
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'No. Nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id' => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('form_bayar.php?id='.general::enkrip($no_nota)));
            } else {
                $sql_cek       = $this->db->where('id', $no_nota)->get('tbl_trans_jual')->row();
                $sql_cek_biaya = $this->db->where('id', $id_biaya)->get('tbl_m_charge')->row();
                $jml_biaya     = ($sql_cek_biaya->persen / 100) * $jml_total;
                
                $sql_diskon  = $this->db->where('id', $diskon)->get('tbl_m_promo')->row();
                $diskon      = ($sql_diskon->persen / 100) * round($jml_total, -2);
                $jml_gtotal  = (round($jml_total, -2) + round($jml_biaya, -2)) - round($diskon, -2);
                $jml_kembali = $jml_bayar - $jml_gtotal;
                $jml_kurang  = $jml_gtotal - $jml_bayar;
                $pengaturan  = $this->db->get('tbl_pengaturan')->row();
                
                
                /* Kalo pembayaran kurang */
                if($sql_cek->status_bayar > 1){
                    $jml_tot_bayar  = $sql_cek->jml_bayar + $jml_bayar;
                    $jml_sisa_bayar = $sql_cek->jml_kurang - $jml_bayar;
                    $jml_sisa_kmbli = $jml_sisa_bayar;
                    
                    if($jml_sisa_bayar <= 0){
                        $trans = array(
                            'tgl_bayar'    => date('Y-m-d'),
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'jml_bayar'    => round($jml_tot_bayar),
                            'jml_kurang'   => ($jml_sisa_bayar < 0 ? 0 : abs($jml_sisa_bayar)),
                            'jml_kembali'  => abs($jml_sisa_bayar),
                            'status_bayar' => '1',
                         );
                        
                        if($sql_cek->status_bayar != 1){
                            crud::update('tbl_trans_jual','id',$no_nota,$trans);
                        }
                    }else{
                        $trans = array(
                            'tgl_bayar'    => date('Y-m-d'),
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'jml_bayar'    => $jml_tot_bayar,
                            'jml_kurang'   => $jml_sisa_bayar,
                         );
                        
                        if($sql_cek->status_bayar != 1){
                            crud::update('tbl_trans_jual','id',$no_nota,$trans);
                        }
                    }
                }else{
                    /* Cek Pembayaran jika kurang, otomatis menjadi DP */
                    if($jml_bayar < $jml_gtotal){
                        $trans = array(
                            'tgl_bayar'    => date('Y-m-d'),
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'id_promo'     => $sql_diskon->id,
                            'id_biaya'     => $id_biaya,
                            'jml_diskon'   => round($diskon, -2),
                            'jml_biaya'    => round($jml_biaya, -2),
                            'jml_gtotal'   => round($jml_gtotal, -2),
                            'jml_bayar'    => round($jml_bayar, -2),
                            'jml_kurang'   => round($jml_kurang, -2),
                            'status_bayar' => ($jml_bayar == 0 ? '2' : '2'),
                            'metode_bayar' => $metode_byr,
                         );                        
                         
                        if($sql_cek->status_bayar != 1){
                            crud::update('tbl_trans_jual','id',$no_nota,$trans);
                        }
                    }else{
                        $trans = array(
                            'tgl_bayar'    => date('Y-m-d'),
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'id_promo'     => $sql_diskon->id,
                            'id_biaya'     => $id_biaya,
                            'jml_diskon'   => round($diskon, -2),
                            'jml_biaya'    => round($jml_biaya, -2),
                            'jml_gtotal'   => round($jml_gtotal, -2),
                            'jml_bayar'    => round($jml_bayar, -2),
                            'jml_kurang'   => round($jml_kurang, -2),
                            'status_bayar' => '1',
                            'metode_bayar' => $metode_byr,
                         );
                        
                        if($metode_byr == 2){
                            $sql_dep  = $this->db->where('id_pelanggan', $sql_cek->id_pelanggan)->get('tbl_m_pelanggan_deposit');
                            
                            // Cek sisa saldo setelah dikurangi biaya
                            $sisa_saldo = $sql_dep->row()->jml_deposit - $jml_gtotal;
                            
                            if($sisa_saldo < 0){
                                // Jika saldo kurang dari 0, maka tampilkan pesan ini
                                $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Saldo tidak mencukupi !!</div>');
                            }else{
                                // Simpan log transaksi deposit
                                $dep_hist = array(
                                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                                    'id_app'        => $pengaturan->id_app,
                                    'id_pelanggan'  => $sql_cek->id_pelanggan,
                                    'id_user'       => $this->ion_auth->user()->row()->id,
                                    'id_biaya'      => $id_biaya,
                                    'jml_deposit'   => $sisa_saldo,
                                    'debet'         => $jml_gtotal,
                                    'keterangan'    => 'Transaksi #'.$sql_cek->no_nota,                             
                                );
                                
                                // Kurangi saldo deposit
                                $dep_sald = array(
                                   'tgl_modif'   => date('Y-m-d H:i:s'),
                                   'jml_deposit' => $sisa_saldo,                                    
                                );
                                
                                crud::update('tbl_m_pelanggan_deposit','id',$sql_dep->row()->id,$dep_sald);
                                crud::simpan('tbl_m_pelanggan_deposit_hist',$dep_hist);
                            }
                        }
                        
                        if($sql_cek->status_bayar != 1){
                            crud::update('tbl_trans_jual','id',$no_nota,$trans);                            
                        }
                    }
                
                       $data_plat = array(
                            'id_app'       => $pengaturan->id_app,
                            'id_platform'  => $metode_byr,
                            'id_penjualan' => $no_nota,
                            'no_nota'      => $sql_cek->no_nota,
                            'keterangan'   => $no_kartu
                        );
                    if($sql_cek->status_bayar != 1){
                        crud::simpan('tbl_trans_jual_plat', $data_plat);
                    }
                    
//                    echo '<pre>';
//                    print_r($trans);
                }
                
                if(!empty($pengambil)){
                   $data_ambil = array(
                       'tgl_ambil'    => date('Y-m-d'),
                       'pengambilan'  => $pengambil,
                       'status_ambil' => '1',
                    );
                   
                    crud::update('tbl_trans_jual', 'id', $no_nota, $data_ambil);
                }
                
//                echo '<pre>';
//                print_r($trans);
                
                redirect(base_url('cart/trans_bayar.php?id='.general::enkrip($no_nota)).(!empty($rute) ? '&route='.$rute : ''));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_bayar_ket() {
        if (akses::aksesLogin() == TRUE) {
            $id_penjualan     = $this->input->post('id_penjualan');
            $id_penjualan_det = $this->input->post('id_penjualan_det');
            $keterangan       = $this->input->post('keterangan');
            $route            = $this->input->post('route');
//
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_penjualan', 'ID', 'required');
            $this->form_validation->set_rules('route', 'Route', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'    => form_error('id'),
                    'route' => form_error('route'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url($route));
            } else {
                $data_plat = array(
                    'id_penjualan'     => $id_penjualan,
                    'id_penjualan_det' => $id_penjualan_det,
                    'tgl_simpan'       => date('Y-m-d H:i'),
                    'keterangan'       => $keterangan
                );

                crud::simpan('tbl_trans_jual_det_ket', $data_plat);
                    
                redirect(base_url($route));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_bayar_cetak() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->get('id');
            $aid      = general::dekrip($id);
            
            if(!empty($id)){
               crud::update('tbl_trans_jual','id',$aid,array('cetak'=>'1')); 
            }
            
            redirect(base_url('cart/trans_detail.php?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_ambil_trans() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->post('id');
            $aid   = general::dekrip($id);
            $nama  = $this->input->post('pengambil');
            $route = $this->input->post('route');
//
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('pengambil', 'No. Nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'pengambil' => form_error('pengambil'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('form_pengambilan.php?id='.$id));
            } else {
                $sql_cek     = $this->db->where('id', $aid)->get('tbl_trans_jual')->row();
                
                $data = array(
                    'tgl_ambil'   => date('Y-m-d'),
                    'pengambilan' => $nama,
                    'status_nota' => '3',
                );
                crud::update('tbl_trans_jual','id',$aid,$data);
                
                redirect(base_url('cart/trans_bayar_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_trans() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $lokasi   = $this->input->post('cabang');
            $tanggal  = $this->input->post('tgl');
            $user     = $this->input->post('kasir');
            $cabang   = $this->input->post('cabang');
            $status_bayar = $this->input->post('status_bayar');
            $tgl      = explode('/', $tanggal); // mm/dd/yy 012
			

                   $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_total, tbl_trans_jual.jml_gtotal, tbl_trans_jual.pengambilan, tbl_trans_jual.id_user, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar, tbl_trans_jual.cetak, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp')
                           ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan', 'left')
                           ->like('tbl_trans_jual.id_app', $cabang)
                           ->like('tbl_trans_jual.no_nota', $no_nota)
//                           ->like('tbl_m_pelanggan.nama', $no_nota)
//                           ->like('tbl_m_pelanggan.no_hp', $no_nota)
                           ->like('DATE(tbl_trans_jual.tgl_masuk)', $tanggal)
                           ->like('tbl_trans_jual.id_user', $user)
                           ->like('tbl_trans_jual.status_bayar', $status_bayar)
                           ->order_by('tbl_trans_jual.no_nota','desc')
                           ->get('tbl_trans_jual')->num_rows();
						               
            redirect(base_url('cart/trans_order_list.php?'.(!empty($no_nota) ? 'filter_nota='.$no_nota : '').(!empty($lokasi) ? '&filter_lokasi='.$lokasi : '').(!empty($tanggal) ? '&filter_tgl='.$tgl[2] . '-' . $tgl[0] . '-' . $tgl[1] : '').(!empty($user) ? '&filter_sales='.$user : '').($status_bayar != '-' ? '&filter_bayar='.$status_bayar : '').'&jml='.$sql));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_byr() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $lokasi   = $this->input->post('cabang');
            $tanggal  = $this->input->post('tgl');
            $user     = $this->input->post('kasir');
            $status_bayar = $this->input->post('status_bayar');
            $tgl      = explode('/', $tanggal); // mm/dd/yy 012
			

            $sql = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_masuk) as tgl, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tbl_trans_jual.jml_total, tbl_trans_jual.jml_gtotal, tbl_trans_jual.pengambilan, tbl_trans_jual.id_user, tbl_trans_jual.id_pelanggan, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar')
                            ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan', 'left')
                            ->where('tbl_trans_jual.status_nota !=', '3')
                            ->where('tbl_trans_jual.status_ambil', '0')
//                            ->where('tbl_trans_jual.id_user', $user)
                            ->like('tbl_trans_jual.no_nota', $no_nota)
                            ->or_like('tbl_m_pelanggan.nama', $no_nota)
                            ->or_like('tbl_m_pelanggan.no_hp', $no_nota)
                            ->order_by('tbl_trans_jual.no_nota', 'desc')
                            ->get('tbl_trans_jual')->num_rows();

            redirect(base_url('cart/trans_bayar_list.php?'.(!empty($no_nota) ? 'filter_nota='.$no_nota : '').(!empty($lokasi) ? '&filter_lokasi='.$lokasi : '').(!empty($tanggal) ? '&filter_tgl='.$tgl[2] . '-' . $tgl[0] . '-' . $tgl[1] : '').(!empty($user) ? '&filter_sales='.$user : '').($status_bayar != '-' ? '&filter_bayar='.$status_bayar : '').'&jml='.$sql));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_antrian() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $lokasi   = $this->input->post('cabang');
            $tanggal  = $this->input->post('tgl');
            $user     = $this->input->post('kasir');
//            $status_bayar = $this->input->post('status_bayar');
            $tgl      = explode('/', $tanggal);
            
            redirect(base_url('cart/trans_antrian_list.php?'.(!empty($no_nota) ? 'filter_nota='.$no_nota : '').(!empty($lokasi) ? '&filter_lokasi='.$lokasi : '').(!empty($tanggal) ? '&filter_tgl='.$tgl[2] . '-' . $tgl[0] . '-' . $tgl[1] : '').(!empty($user) ? '&filter_sales='.$user : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_lokasi() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $lokasi   = $this->input->post('lokasi');
            $cbg      = $this->input->post('cabang');
                        
            redirect(base_url('cart/trans_rak_list.php?no_nota='.$no_nota.'&lokasi='.$lokasi.'&cabang='.$cbg));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function form_edit() {
        if(akses::aksesLogin() == TRUE){
            $nota               = $this->input->get('nota');
            $data['sess_jual']  = $this->db->where('id', general::dekrip($nota))->get('tbl_trans_jual')->row();
            $data['pelanggan']  = $this->db->where('id', $data['sess_jual']->id_pelanggan)->get('tbl_m_pelanggan')->row(); 
          
            $setting                 = $this->db->get('tbl_pengaturan')->row();
            $data['kategori1']       = $this->db->get('tbl_m_kategori')->result();
            $data['no_nota']         = general::no_nota('', 'tbl_trans_jual', 'no_nota');
            $data['sql_member_tipe'] = $this->db->get('tbl_m_pelanggan_grup');
            
//            echo '<pre>';
//            print_r($data['sess_jual']);
//            echo '</pre>';
            

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/trans/trans_form_edit', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
//            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function form_pengambilan() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            
            $data['diskon']     = $this->db->get('tbl_m_promo')->result();
            $data['penj']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
            $data['penj_det']   = $this->db->where('id_penjualan', $data['penj']->id)->where('id_kategori2 !=', 0)->get('tbl_trans_jual_det')->result();
            $data['plgn']       = $this->db->where('id', $data['penj']->id_pelanggan)->get('tbl_m_pelanggan')->row();
            $data['member_sal'] = $this->db->where('id_pelanggan', $data['penj']->id_pelanggan)->get('tbl_m_pelanggan_deposit')->row();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_form_pengambilan',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function form_pemesan() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_kat1            = $this->input->get('id_kat1');
            $id_kat2            = $this->input->get('id_kat2');
            $id_kat2            = $this->input->get('id_kat2');
            $id_kat3            = $this->input->get('id_kat3');
            
            $data['no_nota']   = general::no_nota('','tbl_trans_jual','no_nota');
            
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();
            $data['kategori3']  = $this->db->where('id_kategori', general::dekrip($id_kat2))->where('id_kategori2', general::dekrip($id_kat2))->get('tbl_m_kategori3')->result();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_form_pemesan',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    
    public function json_member() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, kode, nik, nama')->like('nama',$term)->or_like('kode',$term)->or_like('nik',$term)->order_by('DATE(tgl_simpan)')->get('tbl_m_pelanggan')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'tgl_simpan'  => $sql->tgl_simpan,
                        'id'          => $sql->id,
                        'kode'        => $sql->kode,
                        'nik'         => $sql->nik,
                        'nama'        => $sql->nama,
                    );
                }
                echo json_encode($produk);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function json_kasir() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('id, id_app, first_name as nama')->like('first_name',$term)->get('tbl_ion_users')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'id'     => $sql->id,
                        'id_app' => $sql->id_app,
                        'nama'   => $sql->nama,
                    );
                }
                echo json_encode($produk);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function get_diskon() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('id');
            $sql   = $this->db->where('id', $term)->get('tbl_m_promo')->row();
            echo (float)$sql->persen;
//            $data = array('nominal'=>(float)$sql->nominal);
//            echo json_encode($data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
}
