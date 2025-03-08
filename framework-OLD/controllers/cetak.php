<?php
/**
 * Description of transaksi
 *
 * @author mike
 */
class cetak extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->library('excel/PHPExcel');
    }

    public function nota_jual() {
        if (akses::aksesLogin() == TRUE) {
            $id                 = $this->input->get('id');
            $aid                = general::dekrip($id);
            
            $data['pengaturan'] = $this->db->join('tbl_pengaturan_cabang','tbl_pengaturan_cabang.id=tbl_pengaturan.id_app')->get('tbl_pengaturan')->row();
            $data['kategori1']  = $this->db->get('tbl_m_kategori')->result();
            $data['kategori2']  = $this->db->where('id_kategori', general::dekrip($id_kat1))->get('tbl_m_kategori2')->result();
            $data['kategori3']  = $this->db->where('id_kategori', general::dekrip($id_kat2))->where('id_kategori2', general::dekrip($id_kat2))->get('tbl_m_kategori3')->result();

            $data['diskon']     = $this->db->where('tipe', '1')->get('tbl_m_promo')->result();
            $data['biaya']      = $this->db->where('tipe', '1')->get('tbl_m_charge')->result();
            $data['platform']   = $this->db->get('tbl_m_platform')->result();
            $data['penj']       = $this->db->select('tbl_trans_jual.id, tbl_trans_jual.no_nota, DATE(tbl_trans_jual.tgl_simpan) as tgl_simpan, tbl_trans_jual.id_user, tbl_trans_jual.id_promo, tbl_trans_jual.id_app, tbl_trans_jual.tgl_masuk, tbl_trans_jual.tgl_keluar, tbl_trans_jual.jml_total, tbl_trans_jual.jml_diskon, tbl_trans_jual.jml_gtotal, tbl_trans_jual.jml_bayar, tbl_trans_jual.jml_kembali, tbl_trans_jual.jml_kurang, tbl_trans_jual.metode_bayar, tbl_trans_jual.ck_jasa_lipat, tbl_trans_jual.ck_jasa_gantung, tbl_trans_jual.cetak, tbl_m_pelanggan.id as id_pelanggan, tbl_m_pelanggan.id_grup as id_pelanggan_grup, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp, tbl_m_pelanggan.alamat')->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_jual.id_pelanggan')->where('tbl_trans_jual.id', $aid)->get('tbl_trans_jual')->row();
            $data['penj_det']   = $this->db->where('id_penjualan', general::dekrip($id))->where('status_brg', '0')->where('id_kategori2 !=', '0')->get('tbl_trans_jual_det')->result();
            $data['plgn']       = $this->db->where('id', $data['penj']->id_pelanggan)->get('tbl_m_pelanggan')->row();
            $data['member_sal'] = $this->db->where('id_pelanggan', $data['penj']->id_pelanggan)->get('tbl_m_pelanggan_deposit')->row();

            
            $this->load->view('admin-lte-2/includes/cetak/nota_jual',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
}
