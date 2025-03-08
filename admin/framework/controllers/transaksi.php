<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Description of transaksi
 *
 * @author mike
 */

class transaksi extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    public function trans_jual() {
        if (akses::aksesLogin() == TRUE) {
            $prod_id = $this->input->get('prod_ref');
            $data['platform'] = $this->db->get('tbl_m_platform')->result();
            
            $data['prod_brg']  = $this->db->where('id',general::dekrip($prod_id))->get('tbl_m_produk')->row();
            $data['prod_hrg']  = $this->db->where('id_produk',general::dekrip($prod_id))->get('tbl_m_produk_harga')->result();
            
            $data['no_nota']   = general::no_nota('','tbl_trans_jual','no_nota');
            $data['customer']  = $this->session->userdata('trans_jual');
            $data['penj']      = $this->db->where('no_nota',$data['customer']['no_nota'])->get('tbl_trans_jual')->row();
            $data['penj_det']  = $this->db->select('tbl_trans_jual_det.id, tbl_trans_jual_det.id_produk, tbl_m_produk.kode, tbl_m_produk.produk, tbl_trans_jual_det.harga, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->join('tbl_m_produk','tbl_trans_jual_det.id_produk=tbl_m_produk.id')->where('no_nota',$data['customer']['no_nota'])->get('tbl_trans_jual_det')->result();
            $data['penj_plat'] = $this->db->select('tbl_m_platform.id, tbl_m_platform.platform, tbl_trans_jual_plat.keterangan')->where('tbl_trans_jual_plat.no_nota',$data['customer']['no_nota'])->join('tbl_m_platform','tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->get('tbl_trans_jual_plat')->row();
            
            $data['hasError']  = $this->session->flashdata('form_error');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            
            if(isset($_GET['prod_ref'])){
                $this->load->view('admin-lte-2/includes/trans/trans_jual_hrg', $data);
            }else{
                $this->load->view('admin-lte-2/includes/trans/trans_jual', $data);
            }
            
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $tgl      = $this->input->post('tgl');
            $platform = $this->input->post('platform');
            $ket      = $this->input->post('keterangan');
            $ongkir   = str_replace('.', '', $this->input->post('ongkir'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'No. Nota', 'required');
            $this->form_validation->set_rules('tgl', 'Tanggal', 'required');
            $this->form_validation->set_rules('platform', 'Platform', 'required');
            $this->form_validation->set_rules('keterangan', 'Platform', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota'    => form_error('no_nota'),
                    'tgl'        => form_error('tgl'),
                    'platform'   => form_error('platform'),
                    'keterangan' => form_error('keterangan'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=transaksi&act=trans_jual');
            } else {
                $tgl_s = explode('/', $tgl);
                $trans = array(
                    'no_nota'    => $no_nota,
                    'tgl_simpan' => $tgl_s[2].'-'.$tgl_s[0].'-'.$tgl_s[1],
                    'jml_ongkir' => $ongkir,
                    'id_user'    => $this->ion_auth->user()->row()->id,
                    'status_nota'=> '0',
                );
                
                $platform = array(
                    'no_nota'     => $no_nota,
                    'id_platform' => $platform,
                    'keterangan'  => $ket,
                );
                
                crud::simpan('tbl_trans_jual',$trans);
                crud::simpan('tbl_trans_jual_plat',$platform);
                $this->session->set_userdata('trans_jual',$trans);
                redirect('page=transaksi&act=trans_jual&id='.general::enkrip($no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_edit() {
        if (akses::aksesLogin() == TRUE) {
            $data['no_nota']  = general::no_nota('','tbl_trans_jual','no_nota');
            $data['customer'] = $this->input->get('id');
            
            $prod_id = $this->input->get('prod_ref');
            $data['prod_brg']  = $this->db->where('id',general::dekrip($prod_id))->get('tbl_m_produk')->row();
            $data['prod_hrg']  = $this->db->where('id_produk',general::dekrip($prod_id))->get('tbl_m_produk_harga')->result();
            
            $data['penj']     = $this->db->select('DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, no_nota, platform, jml_gtotal, jml_ongkir, id_user, id_gudang, status_nota, metode_bayar, status_bayar')->where('no_nota',general::dekrip($data['customer']))->get('tbl_trans_jual')->row();
            $data['penj_det'] = $this->db->select('tbl_trans_jual_det.id, tbl_trans_jual_det.id_produk, tbl_m_produk.kode, tbl_m_produk.produk, tbl_trans_jual_det.harga, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->join('tbl_m_produk','tbl_trans_jual_det.id_produk=tbl_m_produk.id')->where('no_nota',general::dekrip($data['customer']))->get('tbl_trans_jual_det')->result();
            $data['penj_plat'] = $this->db->select('tbl_m_platform.id, tbl_m_platform.platform, tbl_trans_jual_plat.keterangan')->where('tbl_trans_jual_plat.no_nota',general::dekrip($data['customer']))->join('tbl_m_platform','tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->get('tbl_trans_jual_plat')->row();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_edit', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_app() {
        if (akses::aksesLogin() == TRUE) {
            $data['no_nota']   = general::no_nota('','tbl_trans_jual','no_nota');
            $data['customer']  = $this->input->get('id');
            $data['penj']      = $this->db->select('DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, no_nota, platform, jml_gtotal, jml_ongkir, id_user, id_gudang, status_nota, status_bayar')->where('no_nota',general::dekrip($data['customer']))->get('tbl_trans_jual')->row();
            $data['penj_det']  = $this->db->select('tbl_trans_jual_det.id, tbl_trans_jual_det.id_produk, tbl_m_produk.kode, tbl_m_produk.produk, tbl_trans_jual_det.harga, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal, tbl_trans_jual_det.status_app')->join('tbl_m_produk','tbl_trans_jual_det.id_produk=tbl_m_produk.id')->where('no_nota',general::dekrip($data['customer']))->get('tbl_trans_jual_det')->result();
            $data['penj_plat'] = $this->db->select('tbl_m_platform.id, tbl_m_platform.platform, tbl_trans_jual_plat.keterangan')->where('tbl_trans_jual_plat.no_nota',general::dekrip($data['customer']))->join('tbl_m_platform','tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->get('tbl_trans_jual_plat')->row();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_app', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_app_list() {
        if (akses::aksesLogin() == TRUE) {
            $penj_id  = $this->input->get('order_ref');
            $prod_id  = $this->input->get('prod_ref');
            $data['customer']  = $this->input->get('id');
            
            $data['penj']      = $this->db->select('DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, no_nota, platform, jml_gtotal, jml_ongkir, id_user, id_gudang, status_nota, status_bayar')->where('no_nota',general::dekrip($data['customer']))->get('tbl_trans_jual')->row();
            $data['penj_det']  = $this->db->select('tbl_trans_jual_det.id, tbl_trans_jual_det.id_produk, tbl_m_produk.kode, tbl_m_produk.produk, tbl_trans_jual_det.harga, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->join('tbl_m_produk','tbl_trans_jual_det.id_produk=tbl_m_produk.id')->where('tbl_trans_jual_det.id',general::dekrip($penj_id))->get('tbl_trans_jual_det')->row();
            $data['penj_plat'] = $this->db->select('tbl_m_platform.id, tbl_m_platform.platform, tbl_trans_jual_plat.keterangan')->where('tbl_trans_jual_plat.no_nota',general::dekrip($data['customer']))->join('tbl_m_platform','tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->get('tbl_trans_jual_plat')->row();
            $data['prod']      = $this->db->select('tbl_m_produk.id, tbl_m_produk.produk')->where('tbl_m_produk.id',general::dekrip($prod_id))->get('tbl_m_produk')->row();
            $data['prod_stok'] = $this->db->select('tbl_m_produk_stok.id, tbl_m_penjahit.penjahit, tbl_m_produk_stok.stok')->where('tbl_m_produk_stok.id_produk',general::dekrip($prod_id))->join('tbl_m_penjahit','tbl_m_penjahit.id=tbl_m_produk_stok.id_penjahit')->get('tbl_m_produk_stok')->result();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_app_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_detail() {
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
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_det',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
            
//            $this->load->view('admin-lte-2/1_atas', $data);
//            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
//            $this->load->view('admin-lte-2/includes/trans/trans_jual_det', $data);
//            $this->load->view('admin-lte-2/5_footer', $data);
//            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_jual_print() {
        if (akses::aksesLogin() == TRUE) {
            $data['customer'] = $this->input->get('id');
            $data['penj']     = $this->db->select('DATE(tgl_simpan) as tgl_simpan, DATE(tgl_bayar) as tgl_bayar, no_nota, platform, jml_gtotal, jml_ongkir, id_user, id_gudang, status_nota, status_bayar')->where('no_nota',general::dekrip($data['customer']))->get('tbl_trans_jual')->row();
            $data['penj_det'] = $this->db->select('tbl_trans_jual_det.id, tbl_m_produk.kode, tbl_m_produk.produk, tbl_trans_jual_det.harga, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->join('tbl_m_produk','tbl_trans_jual_det.id_produk=tbl_m_produk.id')->where('no_nota',general::dekrip($data['customer']))->get('tbl_trans_jual_det')->result();
            $data['penj_plat'] = $this->db->select('tbl_m_platform.id, tbl_m_platform.platform, tbl_trans_jual_plat.keterangan')->where('tbl_trans_jual_plat.no_nota',general::dekrip($data['customer']))->join('tbl_m_platform','tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->get('tbl_trans_jual_plat')->row();
            
            $this->load->view('admin-lte-2/includes/trans/trans_jual_print', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_jual_hps() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            $nota = $this->input->get('nota');
            $rute = $this->input->get('route');
                    
            crud::delete('tbl_trans_jual','id',general::dekrip($id));
            redirect('page=transaksi&act='.(!empty($rute) ? $rute : 'trans_jual_list'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id       = $this->input->post('id');
            $qty      = $this->input->post('qty');
            $harga    = str_replace('.', '', $this->input->post('harga'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'No. Nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=transaksi&act=trans_jual');
            } else {
                $cust    = $this->session->userdata('trans_jual');
                $sql     = $this->db->where('id',$id)->get('tbl_m_produk');
                $sql_stok= $this->db->where('id_produk',$sql->row()->id)->get('tbl_m_stok');
//                $sql_penj= $this->db->where('id_penjahit',$sql_stok->row()->id_penjahit)->get('tbl_m_penjahit');
                $sql_jml = $this->db->select_sum('stok')->where('id_produk',$id)->get('tbl_m_produk_stok');
                $sql_ck  = $this->db->where('no_nota',$no_nota)->where('id_produk',$id)->get('tbl_trans_jual_det');
                $sql_lmt = $this->db->where('no_nota',$no_nota)->get('tbl_trans_jual_det');
                
                if($sql_ck->num_rows() > 0){
                   $sql_prod = $sql_jml->row();
                   $prod     = $sql_ck->row();
                   $jml_brg  = $prod->jml + (!empty($qty) ? $qty : '1');
                   $subtotal = $sql->row()->harga_jual * $jml_brg;
                   
                   if($qty > $sql_prod->stok){
                       $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Stok barang tidak mencukupi !!</div>');
                   }else{
                        $cart = array(
                            'no_nota'    => $no_nota,
                            'tgl_simpan' => $cust['tgl_simpan'],
                            'id_produk'  => $sql->row()->id,
                            'produk'     => $sql->row()->produk,
                            'harga'      => $sql->row()->harga_jual,
                            'jml'        => $jml_brg,
                            'subtotal'   => $subtotal,
                        );
                        
                        crud::update('tbl_trans_jual_det','id',$prod->id,$cart); 
                   }
                }else{
                    $prod     = $sql_jml->row();
                    $subtotal = $sql->row()->harga_jual * $qty;
                    
//                    if ($sql_lmt->num_rows() != 0) {
//                        $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Limit, hanya boleh memasukkan barang dalam 1 nota !!</div>');
//                    } else {
                       if($qty > $prod->stok){
                           $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Stok barang tidak mencukupi !! '.$prod->stok.'</div>');
                       }else{
                           $cart = array(
                               'no_nota'    => $no_nota,
                               'tgl_simpan' => $cust['tgl_simpan'],
                               'id_produk'  => $sql->row()->id,
                               'produk'     => $sql->row()->produk,
//                               'penjahit'   => $sql->row()->id_penjahit,
                               'harga'      => $sql->row()->harga_jual,
                               'jml'        => (!empty($qty) ? $qty : '1'),
                               'subtotal'   => $subtotal,
                           );
                           crud::simpan('tbl_trans_jual_det',$cart);
                       }
//                    }
                }
                
                redirect('page=transaksi&act=trans_jual&id='.general::enkrip($no_nota).'#gtotal');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_edit() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id       = $this->input->post('id');
            $qty      = $this->input->post('qty');
            $harga    = str_replace('.', '', $this->input->post('harga'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'No. Nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=transaksi&act=trans_jual_edit&id='.$no_nota);
            } else {
                $cust    = $this->db->where('no_nota',general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $sql     = $this->db->where('id',$id)->get('tbl_m_produk');
                $sql_ck  = $this->db->where('no_nota',general::dekrip($no_nota))->where('id_produk',$id)->get('tbl_trans_jual_det');
                $sql_lmt = $this->db->where('no_nota',general::dekrip($no_nota))->get('tbl_trans_jual_det');


//                if($sql_lmt->num_rows() != 0){
//                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Limit, hanya boleh memasukkan barang dalam 1 nota !!</div>');
//                }else{
                   if($sql_ck->num_rows() > 0){
                      $prod     = $sql_ck->row();
                      $jml_brg  = $prod->jml + (!empty($qty) ? $qty : '1');
                      $subtotal = $sql->row()->harga_jual * $jml_brg;
                      
                      $cart = array(
                          'no_nota'    => general::dekrip($no_nota),
                          'tgl_simpan' => date('Y-m-d'),
                          'id_produk'  => $sql->row()->id,
                          'jml'        => $jml_brg,
                      );
                      
                      crud::update('tbl_trans_jual_det','id',$prod->id,$cart);
                   }else{
                      $subtotal = $sql->row()->harga_jual * $qty;
                      
                      $cart = array(
                          'no_nota'    => general::dekrip($no_nota),
                          'tgl_simpan' => date('Y-m-d'),
                          'id_produk'  => $sql->row()->id,
                          'jml'        => $qty,
                      );
                      
                      crud::simpan('tbl_trans_jual_det',$cart);
                   }
//                }
                
                redirect('page=transaksi&act=trans_jual_edit&id='.$no_nota);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            $nota = $this->input->get('nota');
            $rute = $this->input->get('route');
                    
            crud::delete('tbl_trans_jual_det','id',general::dekrip($id));
            redirect('page=transaksi&act='.(!empty($rute) ? $rute : 'trans_jual').'&id='.$nota);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    

    public function set_nota_proses() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('id');
            $tgl        = $this->input->post('tgl_bayar');
            $status_byr = $this->input->post('status_bayar');
            $metode_byr = $this->input->post('metode_bayar');
            $gtotal     = str_replace('.', '', $this->input->post('gtotal'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'No. Nota', 'required');
            $this->form_validation->set_rules('gtotal', 'Jml Total', 'required');
//            $this->form_validation->set_rules('tgl_bayar', 'Tanggal Bayar', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'        => form_error('id'),
                    'gtotal'    => form_error('gtotal'),
//                    'tgl_bayar' => form_error('tgl_bayar'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('gtotal', $gtotal);
//                $this->session->set_flashdata('tgl_bayar', $tgl);
                redirect('page=transaksi&act=trans_jual&id='.$no_nota.'#gtotal');
            } else {
                $sql_n = $this->db->where('no_nota',general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $sql_d = $this->db->select_sum('subtotal')->where('no_nota',general::dekrip($no_nota))->get('tbl_trans_jual_det')->row();
                $tgl_s = explode('/', $tgl);
                
                if($gtotal < $sql_d->subtotal){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah pembayaran kurang dari jumlah tagihan !!</div>');
                    redirect('page=transaksi&act=trans_jual&id='.$no_nota);
                }  else {
                    $trans = array(
                        'tgl_bayar'    => (!empty($tgl) ? $tgl_s[2].'-'.$tgl_s[0].'-'.$tgl_s[1] : ''),
                        'jml_total'    => $sql_d->subtotal,
                        'jml_gtotal'   => $gtotal,
                        'status_nota'  => '1',
                        'metode_bayar' => $metode_byr,
                        'status_bayar' => $status_byr,
                    );

                    crud::update('tbl_trans_jual','no_nota',general::dekrip($no_nota),$trans);
                    $this->session->unset_userdata('trans_jual');
                    redirect('page=transaksi&act=trans_jual_edit&id='.$no_nota);
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_update() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('id');
            $tgl        = $this->input->post('tgl_bayar');
            $metode_byr = $this->input->post('metode_bayar');
            $status_byr = $this->input->post('status_bayar');
            $gtotal     = str_replace('.', '', $this->input->post('gtotal'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'No. Nota', 'required');
//            $this->form_validation->set_rules('tgl_bayar', 'Tanggal', 'required');
            $this->form_validation->set_rules('gtotal', 'Jml Grand Total', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'        => form_error('id'),
//                    'tgl_bayar' => form_error('tgl_bayar'),
                    'gtotal'    => form_error('gtotal'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=transaksi&act=trans_jual_edit&id='.$no_nota);
            } else {
                $tgl_s = explode('/', $tgl);
                $tglny = $tgl_s[2].'-'.$tgl_s[0].'-'.$tgl_s[1];
                $trans = array(
                    'tgl_bayar'    => $tglny,
                    'jml_total'    => $gtotal,
                    'jml_gtotal'   => $gtotal,
                    'status_nota'  => '1',
                    'status_bayar' => $status_byr,
                    'metode_bayar' => $metode_byr,
                );
                
                crud::update('tbl_trans_jual','no_nota',general::dekrip($no_nota),$trans);
                redirect('page=transaksi&act=trans_jual_edit&id='.$no_nota);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_approve() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota     = $this->input->get('id');
            
//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
//            $this->form_validation->set_rules('id', 'No. Nota', 'required');
//
//            if ($this->form_validation->run() == FALSE) {
//                redirect('page=transaksi&act=trans_jual_app&id='.$no_nota);
//            }else{
                $cek_nota     = $this->db->select('tbl_trans_jual.no_nota, tbl_trans_jual.id_user, tbl_trans_jual.jml_gtotal, tbl_trans_jual.status_bayar, tbl_trans_jual.metode_bayar, tbl_m_platform.platform, tbl_trans_jual_plat.keterangan')->join('tbl_trans_jual_plat','tbl_trans_jual_plat.no_nota=tbl_trans_jual.no_nota')->join('tbl_m_platform','tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->where('tbl_trans_jual.no_nota',general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $cek_nota_det = $this->db->where('no_nota',general::dekrip($no_nota))->where('status_app','0')->get('tbl_trans_jual_det');
                                
                if($cek_nota_det->num_rows() == 0){
                    if($cek_nota->status_bayar == '1' AND $cek_nota->metode_bayar == '0'){
                        $saldo_kas = $this->db->select('MAX(id), SUM(saldo) as saldo')->get('tbl_akt_kas')->row();
                        $kode      = general::no_nota('','tbl_akt_kas','kode',"tipe='masuk'");
                        $tot_saldo = $saldo_kas->saldo + $cek_nota->jml_gtotal;
                        
                        $pem = array(
                            'tgl'         => date('Y-m-d H:i:s'),
                            'id_user'     => $cek_nota->id_user,
                            'kode'        => $kode,
                            'keterangan'  => $cek_nota->no_nota.' - '.ucwords($cek_nota->platform).' ['.strtoupper($cek_nota->keterangan).']',
                            'nominal'     => $cek_nota->jml_gtotal,
                            'kredit'      => $cek_nota->jml_gtotal,
                            'saldo'       => $tot_saldo,
                            'tipe'        => 'masuk',
                            'status_kas'  => 'bank',
                        );
                        
                        $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Approve berhasil, data penjualan sudah disimpan</div>');
                        crud::simpan('tbl_akt_kas',$pem);
                        
                    // Kas Masuk
                    }elseif($cek_nota->status_bayar == '1' AND $cek_nota->metode_bayar == '1'){
                        $saldo_kas = $this->db->select('MAX(id), SUM(saldo) as saldo')->get('tbl_akt_kas')->row();
                        $kode      = general::no_nota('','tbl_akt_kas','kode',"tipe='masuk'");
                        $tot_saldo = $saldo_kas->saldo + $cek_nota->jml_gtotal;
                        
                        $pem = array(
                            'tgl'         => date('Y-m-d H:i:s'),
                            'id_user'     => $cek_nota->id_user,
                            'kode'        => $kode,
                            'keterangan'  => $cek_nota->no_nota.' - '.ucwords($cek_nota->platform).' ['.strtoupper($cek_nota->keterangan).']',
                            'nominal'     => $cek_nota->jml_gtotal,
                            'kredit'      => $cek_nota->jml_gtotal,
                            'saldo'       => $tot_saldo,
                            'tipe'        => 'masuk',
                            'status_kas'  => 'kas',
                        );
                        
                        crud::simpan('tbl_akt_kas',$pem);
                    }
                    
                   // Simpan ke penjualan
                   $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Approve berhasil, data penjualan sudah disimpan</div>');
                   crud::update('tbl_trans_jual','no_nota',general::dekrip($no_nota), array('id_gudang'=>$this->ion_auth->user()->row()->id,'status_nota'=>'2')); 
                }else{
                   $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Approve gagal, barang belum di approve !!</div>');
                }
                
                redirect('page=transaksi&act=trans_jual_detail&id='.$no_nota);
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_brg_approve() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota     = $this->input->post('id');
            $no_nota_det = $this->input->post('order_ref');
            $prod_id     = $this->input->post('prod_ref');
            $jml         = $this->input->post('jml');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'No. Nota', 'required');
            $this->form_validation->set_rules('order_ref', 'No. Nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                redirect('page=transaksi&act=trans_jual_app&id='.$no_nota);
            }else{
                $tot_qty = 0;
                foreach ($_POST['qty'] as $key => $qty){
                    $sql     = $this->db->where('id',$_POST['id_stok'][$key])->get('tbl_m_produk_stok')->row();
                    $tot     = (int)$sql->stok - (int)$qty;
                    $tot_qty = $tot_qty + $qty;
                    
                    // Cek jumlah stok, jika < qty lempar keluar dulu
                    if($sql->stok < $qty){
                        $this->session->set_flashdata('transaksi'.$sql->id,'<p class="text-danger">Stok kurang dari <b>'.$sql->stok.'</b></p>');
                        redirect('page=transaksi&act=trans_jual_app_list&id='.$no_nota.'&order_ref='.$no_nota_det.'&prod_ref='.$prod_id);
                    }else{
                        // Kalo berhasil simpan dalam array, 
                        $stok[] = array(
                            'id'          => $sql->id,
                            'id_produk'   => $sql->id_produk,
                            'id_penjahit' => $sql->id_penjahit,
                            'produk'      => $this->db->where('id', $sql->id_produk)->get('tbl_m_produk')->row()->produk,
                            'penjahit'    => $this->db->where('id', $sql->id_penjahit)->get('tbl_m_penjahit')->row()->penjahit,
                            'qty'         => $qty,
                            'stok'        => $tot, // ==> jumlah stok akhir
                        );
                    }
                }
                
                // Jika total qty tadi, melebihi jumlah penjualan maka tendang keluar tampilkan pesan error
                if($tot_qty > $jml){
                    $this->session->set_flashdata('transaksi','<div class="alert alert-danger">Jumlah approve tidak boleh melebihi <b>'.$jml.'</b></div>');
                    redirect('page=transaksi&act=trans_jual_app_list&id='.$no_nota.'&order_ref='.$no_nota_det.'&prod_ref='.$prod_id);
                }else{
                    
                    foreach ($stok as $stok){                        
                        // update stok yang laku
//                        crud::update('tbl_m_produk_stok','id',$stok['id'],array('stok'=>$stok['stok']));
                        
                        if(!empty($stok['qty'])){
                            // simpan ke histori penjualan
                            $data_hist = array(
                                         'id_stok'     => $stok['id'],
                                         'id_produk'   => $stok['id_produk'],
                                         'id_penjahit' => $stok['id_penjahit'],
                                         'produk'      => $stok['produk'],
                                         'penjahit'    => $stok['penjahit'],
                                         'tgl_simpan'  => date('Y-m-d H:i:s'),
                                         'keterangan'  => 'Penjualan <b>'.anchor('page=transaksi&act=trans_jual_detail&id='.$no_nota, '#'.general::dekrip($no_nota)).'</b> - <b>'.$this->db->where('id',$stok['id_produk'])->get('tbl_m_produk')->row()->kode.'</b> sejumlah <b>'.$stok['qty'].'</b> dari penjahit <b>'.$this->db->where('id', $stok['id_penjahit'])->get('tbl_m_penjahit')->row()->penjahit.'</b>',
                                    );
echo '<pre>';
print_r($data_hist);
//                            crud::simpan('tbl_m_produk_hist',$data_hist);
                        }
                    }
                    
                    
//                    crud::update('tbl_trans_jual_det','id',general::dekrip($no_nota_det),array('status_app'=>'1'));
//                    $this->session->set_flashdata('transaksi','<div class="alert alert-success">Approve berhasil</div>');
//                    redirect('page=transaksi&act=set_nota_approve&id='.$no_nota);
//                    redirect('page=transaksi&act=trans_jual_app&id='.$no_nota);
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function set_nota_hj() {
        if (akses::aksesLogin() == TRUE) {
            $id_nota     = $this->input->get('id');
            $id_nota_det = $this->input->get('order_ref');
            $id_prod     = $this->input->get('prod_ref');
            $harga_jual  = $this->input->get('hrg_ref');
            $status_hrg  = $this->input->get('ref');

            $sql_det     = $this->db->where('id',general::dekrip($id_nota_det))->get('tbl_trans_jual_det')->row();

            if(!empty($id_nota) AND !empty($id_nota_det) AND !empty($id_prod) AND !empty($harga_jual)){
                $subtot = $harga_jual * $sql_det->jml;
                $set_harga = array(
                    'harga'      => $harga_jual,
                    'subtotal'   => $subtot,
                    'status_hrg' => $status_hrg,
                );
                
                crud::update('tbl_trans_jual_det','id',$sql_det->id,$set_harga);
            }
            
            redirect('page=transaksi&act='.(isset($_GET['route']) ? $_GET['route'] : 'trans_jual').'&id='.$id_nota.'#gtotal');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_jual_list() {
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
                $jml_hal = $this->db->select('id, id_app, no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, tgl_ambil, jml_total, jml_gtotal, pengambilan, id_user, status_nota, status_bayar, cetak')
//                           ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                           ->like('tbl_trans_jual.id_app', $lk)
                           ->like('tbl_trans_jual.no_nota', $nt)
//                           ->like('tbl_m_pelanggan.nama', $nt)
//                           ->like('tbl_m_pelanggan.no_hp', $nt)
                           ->like('DATE(tbl_trans_jual.tgl_masuk)', $tg)
                           ->like('tbl_trans_jual.id_user', $sl)
                           ->like('tbl_trans_jual.status_bayar', $sb)
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual')->num_rows();
                /* -- Hitung jumlah halaman -- */
               // $jml_hal = (!empty($jml) ? $jml  : $this->db->where('id_user', $id_user)->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('status_nota', $sn)->get('tbl_trans_jual')->num_rows());
            //}

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
            

            if(!empty($hal)){
                   $data['penj'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tgl_ambil, tbl_trans_jual.jml_total, tbl_trans_jual.jml_gtotal, tbl_trans_jual.pengambilan, tbl_trans_jual.id_user, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar, tbl_trans_jual.cetak, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp')
                           ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_trans_jual.id_app', $lk)
                           ->like('tbl_trans_jual.no_nota', $nt)
//                           ->like('tbl_m_pelanggan.nama', $nt)
//                           ->like('tbl_m_pelanggan.no_hp', $nt)
                           ->like('DATE(tbl_trans_jual.tgl_masuk)', $tg)
                           ->like('tbl_trans_jual.status_bayar', $sb)
                           ->order_by('tbl_trans_jual.no_nota','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.id_app, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_masuk) as tgl_masuk, DATE(tbl_trans_jual.tgl_bayar) as tgl_bayar, tgl_ambil, tbl_trans_jual.jml_total, tbl_trans_jual.jml_gtotal, tbl_trans_jual.pengambilan, tbl_trans_jual.id_user, tbl_trans_jual.status_nota, tbl_trans_jual.status_bayar, tbl_trans_jual.cetak, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp')
                           ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan', 'left')
                           ->limit($config['per_page'])
                           ->like('tbl_trans_jual.id_app', $lk)
                           ->like('tbl_trans_jual.no_nota', $nt)
//                           ->like('tbl_m_pelanggan.nama', $nt)
//                           ->like('tbl_m_pelanggan.no_hp', $nt)
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
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/trans/trans_order_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_jual_gdg_list() {
        if (akses::aksesLogin() == TRUE) {            
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_trans_jual'));
            
            $data['hasError']                = $this->session->flashdata('form_error');
                        
            $config['base_url']              = site_url('page=transaksi&act=trans_jual_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
            
            
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['penj'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl, DATE(tgl_bayar) as tgl_bayar, platform, jml_total, jml_ongkir, jml_gtotal, id_user, id_gudang, status_nota, status_bayar')->limit($config['per_page'],$hal)->like('no_nota', $query)->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                } else {
                    $data['penj'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl, DATE(tgl_bayar) as tgl_bayar, platform, jml_total, jml_ongkir, jml_gtotal, id_user, id_gudang, status_nota, status_bayar')->limit($config['per_page'],$hal)->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['penj'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl, DATE(tgl_bayar) as tgl_bayar, platform, jml_total, jml_ongkir, jml_gtotal, id_user, id_gudang, status_nota, status_bayar')->limit($config['per_page'],$hal)->like('no_nota', $query)->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                } else {
                    $data['penj'] = $this->db->select('no_nota, DATE(tgl_simpan) as tgl, DATE(tgl_bayar) as tgl_bayar, platform, jml_total, jml_ongkir, jml_gtotal, id_user, id_gudang, status_nota, status_bayar')->limit($config['per_page'])->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
            $data['no_nota']    = general::no_nota('','tbl_trans_jual','no_nota');
            $data['customer']   = $this->session->userdata('trans_jual');
            $data['penj_det']   = $this->db->select('tbl_trans_jual_det.id, tbl_m_produk.kode, tbl_m_produk.produk, tbl_trans_jual_det.harga, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->join('tbl_m_produk','tbl_trans_jual_det.id_produk=tbl_m_produk.id')->where('no_nota',$data['customer']['no_nota'])->get('tbl_trans_jual_det')->result();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function json_produk() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_penjahit, id_kategori,kode,produk,harga_jual')->like('produk',$term)->or_like('kode',$term)->order_by('DATE(tgl_simpan)')->get('tbl_m_produk')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $penjahit = $this->db->where('id',$sql->id_penjahit)->get('tbl_m_penjahit')->row();
                    $produk[] = array(
                        'tgl_simpan'  => $sql->tgl_simpan,
                        'id'          => $sql->id,
                        'id_penjahit' => $penjahit->penjahit,
                        'id_kategori' => $sql->id_kategori,
                        'kode'        => $sql->kode,
                        'produk'      => $sql->produk,
                        'harga_jual'  => general::format_angka($sql->harga_jual),
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
    
    public function json_transaksi() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('no_nota')->like('no_nota',$term)->order_by('no_nota','desc')->get('tbl_trans_jual')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $transaksi[] = array(
                        'no_nota'  => $sql->no_nota
                    );
                }
                echo json_encode($transaksi);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function json_sales() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('tbl_ion_users.id, tbl_ion_users.first_name, tbl_ion_groups.name')
                    ->join('tbl_ion_users_groups','tbl_ion_users_groups.user_id=tbl_ion_users.id')
                    ->join('tbl_ion_groups','tbl_ion_groups.id=tbl_ion_users_groups.group_id')
                    ->like('first_name',$term)
                    ->order_by('id','desc')->get('tbl_ion_users')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $sales[] = array(
                        'id_sales'  => $sql->id,
                        'sales'     => $sql->first_name,
                    );
                }
                echo json_encode($sales);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    

    // Set cari transaksi
    public function set_cari_penj() {
        if (akses::aksesLogin() == TRUE) {
            $nt = $this->input->post('no_nota');
            $tg = explode('/', $this->input->post('tgl'));
            $sl = $this->input->post('sales');
//            $sn = $this->input->post('status_nota');
            $hl = $this->input->post('hal');
            
            if ($this->input->server('REQUEST_METHOD') == 'GET') {
                $sn = $this->input->get('status_nota');
            } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $sn = $this->input->post('status_nota');
            } 
            
            $tgl = $tg[2].'-'.$tg[0].'-'.$tg[1];
            $sql = $this->db->like('no_nota',$nt)->like('DATE(tgl_simpan)',$tgl)->like('id_user',$sl)->like('status_nota',$sn)->get('tbl_trans_jual');
            redirect('page=transaksi&act=trans_jual_list&halaman='.$hl.'&filter_nota='.$nt.'&filter_tgl='.($tgl == '--' ? '' : $tgl).'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$sql->num_rows());
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
						   
						   echo $sql;
						   echo '<pre>';
						   print_r($_POST);
            
            redirect(site_url('page=transaksi&act=trans_jual_list&'.(!empty($no_nota) ? 'filter_nota='.$no_nota : '').(!empty($lokasi) ? '&filter_lokasi='.$lokasi : '').(!empty($tanggal) ? '&filter_tgl='.$tgl[2] . '-' . $tgl[0] . '-' . $tgl[1] : '').(!empty($user) ? '&filter_sales='.$user : '').($status_bayar != '-' ? '&filter_bayar='.$status_bayar : '').'&jml='.$sql));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
}
