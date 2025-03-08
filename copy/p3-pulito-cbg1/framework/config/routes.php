<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = '';

/* Dashboard */
$route['home.php']   = "home/index";

/* FrontEnd */
$route['cek_login.php']        = "login/cek_login";
$route['dashboard.php']        = "home/index";
//$route['set-order-step-2.php'] = "transaksi/set_order1";
//$route['set-order-step-3.php'] = "transaksi/set_order2";
//$route['set_cart.php']         = "transaksi/set_cart";
//$route['simpan_cart.php']      = "transaksi/set_cart_simpan";
//$route['hapus_cart.php']       = "transaksi/set_cart_hapus";
//$route['form_pemesan.php']     = "transaksi/form_pemesan";
//$route['set_nota_simpan.php']  = "transaksi/set_nota_simpan";

/* Transaksi */ 
$route['cart/set_nota.php']             = "transaksi/set_nota";
$route['cart/set_nota_update.php']      = "transaksi/set_nota_update";
$route['cart/cart-step-1.php']          = "transaksi/cart_step_1";
$route['cart/cart-step-1-edit.php']     = "transaksi/cart_step_1_edit";
$route['cart/cart-step-1-simpan.php']   = "transaksi/cart_step_1_simpan";
$route['cart/cart-step-1-hapus.php']    = "transaksi/cart_step_1_hapus";
$route['cart/cart-step-2.php']          = "transaksi/cart_step_2";
$route['cart/cart-step-2-edit.php']     = "transaksi/cart_step_2_edit";
$route['cart/cart-step-2-simpan.php']   = "transaksi/cart_step_2_simpan";
$route['cart/cart-step-2-hapus.php']    = "transaksi/cart_step_2_hapus";
$route['cart/cart-step-3.php']          = "transaksi/cart_step_3";
$route['cart/cart-step-4.php']          = "transaksi/cart_step_4";
$route['cart/cart-step-4-edit.php']     = "transaksi/cart_step_4_edit";
$route['cart/cart_simpan.php']          = "transaksi/cart_simpan";
$route['cart/cart_simpan_edit.php']     = "transaksi/cart_simpan_edit";
$route['cart/cart_simpan_brg.php']      = "transaksi/cart_simpan_brg";
$route['cart/cart_update.php']          = "transaksi/cart_update";
$route['cart/cart_hapus.php']           = "transaksi/cart_hapus";
$route['cart/cart_hapus_edit.php']      = "transaksi/cart_hapus_edit";
$route['cart/set_nota_simpan.php']      = "transaksi/set_nota_simpan";
$route['cart/set_nota_simpan_edit.php'] = "transaksi/set_nota_simpan_edit";
$route['cart/set_nota_diskon_itm.php']  = "transaksi/set_nota_diskon_itm";
$route['cart/trans_order_list.php']     = "transaksi/trans_order_list";
$route['cart/trans_antrian_list.php']   = "transaksi/trans_antrian_list";
$route['cart/trans_bayar_list.php']     = "transaksi/trans_bayar_list";
$route['cart/trans_bayar.php']          = "transaksi/trans_bayar";
$route['cart/set_nota_bayar.php']       = "transaksi/set_nota_bayar";
$route['cart/set_nota_bayar_ket.php']   = "transaksi/set_nota_bayar_ket";
$route['cart/trans_rak_list.php']       = "transaksi/trans_rak_list";
$route['cart/trans_rak_det.php']        = "transaksi/trans_rak_det";
$route['cart/trans_detail.php']         = "transaksi/trans_detail";
$route['cart/trans_edit_ket.php']       = "transaksi/trans_detail_edit_ket";
$route['cart/trans_edit_ket_upd.php']   = "transaksi/trans_detail_edit_ket_upd";
$route['cart/set_lokasi_rak.php']       = "transaksi/set_lokasi_rak";
$route['cart/trans_lokasi_hapus.php']   = "transaksi/set_lokasi_rak_hapus";
$route['cart/set_cari_trans.php']       = "transaksi/set_cari_trans";
$route['cart/set_cari_byr.php']       = "transaksi/set_cari_byr";
$route['cart/set_cari_antrian.php']     = "transaksi/set_cari_antrian";
$route['cart/set_cari_lokasi.php']      = "transaksi/set_cari_lokasi";
$route['cart/trans_ambil_list.php']     = "transaksi/trans_ambil_list";
$route['cart/form_pengambilan.php']     = "transaksi/form_pengambilan";
$route['cart/set_ambil_trans.php']      = "transaksi/set_ambil_trans";

$route['cart/form_edit.php']            = "transaksi/form_edit";

$route['cart/set_cetak_nota.php']       = "transaksi/set_nota_bayar_cetak";
$route['cart/cetak_nota.php']           = "transaksi/trans_print_ex";
$route['cart/cetak_nota_ket.php']       = "transaksi/trans_print_ket_ex";
$route['cart/cetak_nota_jual.php']      = "cetak/nota_jual";
$route['cart/get_diskon.php']           = "transaksi/get_diskon";

//$route['order_list.php']       = "transaksi/trans_jual_list";
//$route['pembayaran_list.php']  = "transaksi/trans_bayar_list";
//$route['form_bayar.php']       = "transaksi/set_form_bayar";
//$route['set_nota_bayar.php']   = "transaksi/set_nota_bayar";

/* Member */ 
$route['member.php']                 = "member/member_list";
$route['member_deposit.php']         = "member/member_deposit";
$route['member_grup.php']            = "member/member_grup";
$route['member_grup_agt.php']        = "member/member_grup_agt";
$route['member_grup_add.php']        = "member/member_grup_simpan";
$route['member/member_ubah.php']     = "member/member_ubah";
$route['member/member_deposit.php']  = "member/member_deposit";
$route['member/member_deposit_simpan.php']  = "member/member_deposit_simpan";
$route['member/member_simpan.php']   = "member/member_simpan";
$route['member/member_simpan2.php']  = "member/member_simpan2";

/* Pengaturan */
$route['pengaturan/eksport.php']         = "pengaturan/trans_eksport";
$route['pengaturan/import.php']          = "pengaturan/trans_import";
$route['pengaturan/eksport_create.php']  = "pengaturan/eksport_create";
$route['pengaturan/eksport_hapus.php']   = "pengaturan/eksport_hapus";
$route['pengaturan/eksport_download.php']= "pengaturan/eksport_download";
$route['pengaturan/import_create.php']   = "pengaturan/import_create";
$route['pengaturan/import_hapus.php']    = "pengaturan/import_hapus";

$route['json_member.php']      = "transaksi/json_member";
$route['logout.php']           = "login/logout";


/* End of file routes.php */
/* Location: ./application/config/routes.php */