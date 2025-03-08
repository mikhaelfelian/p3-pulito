<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Description of produk
 *
 * @author mike
 */

class produk extends CI_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('excel/PHPExcel');
    }
    
    public function prod_pelanggan_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->where('status_hps', '0')->get('tbl_m_pelanggan')->num_rows());
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_pelanggan_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 100;
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
                    $data['pelanggan'] = $this->db->where('status_hps', '0')->like('nama', $query)->limit($config['per_page'],$hal)->get('tbl_m_pelanggan')->result();
                } else {
                    $data['pelanggan'] = $this->db->where('status_hps', '0')->limit($config['per_page'],$hal)->order_by('id','asc')->get('tbl_m_pelanggan')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['pelanggan'] = $this->db->where('status_hps', '0')->like('nama', $query)->limit($config['per_page'],$hal)->get('tbl_m_pelanggan')->result();
                } else {
                    $data['pelanggan'] = $this->db->where('status_hps', '0')->limit($config['per_page'])->order_by('id','asc')->get('tbl_m_pelanggan')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_plgn_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
        
    public function prod_pelanggan_tambah() {
        if (akses::aksesLogin() == TRUE) {
//            $id = $this->input->get('id');
//            
//            if($_GET['case'] == 'deposit'){
//                $data['member_saldo'] = $this->db->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit')->row();
//                $data['member_hist']  = $this->db->select('id_pelanggan, DATE(tgl_simpan) as tgl_simpan, jml_deposit, keterangan')->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit_hist')->result();
//            }
            
            $data['member']       = '';//$this->db->where('id', general::dekrip($id))->get('tbl_m_pelanggan')->row();
            $data['member_tipe']  = $this->db->get('tbl_m_pelanggan_grup');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_plgn_edit', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
        
    public function prod_pelanggan_edit() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if($_GET['case'] == 'deposit'){
                $data['member_saldo'] = $this->db->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit')->row();
                $data['member_hist']  = $this->db->select('id_pelanggan, DATE(tgl_simpan) as tgl_simpan, jml_deposit, keterangan')->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit_hist')->result();
            }
            
            $data['member']       = $this->db->where('id', general::dekrip($id))->get('tbl_m_pelanggan')->row();
            $data['member_tipe']  = $this->db->get('tbl_m_pelanggan_grup');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_plgn_edit', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_pelanggan_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $nik     = $this->input->post('nik');
            $nama    = $this->input->post('nama');
            $no_hp   = $this->input->post('no_hp');
            $alamat  = $this->input->post('alamat');
            $tipe    = $this->input->post('tipe_member');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'     => form_error('nama'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_pelanggan_tambah');
            } else {
                $sql_num = $this->db->get('tbl_m_pelanggan')->num_rows() + 1;
                $kode    = sprintf('%05d', $sql_num);
                
                $data_penj = array(
                    'id_app'      => 1,
                    'id_grup'     => $tipe,
                    'tgl_simpan'  => date('Y-m-d H:i:s'),
                    'kode'        => $kode,
                    'nik'         => $nik,
                    'nama'        => $nama,
                    'no_hp'       => $no_hp,
                    'alamat'      => $alamat,
                    'status_plgn' => '1',
                    'status_hps'  => '0',
                );
				
				echo '<pre>';
				print_r($data_penj);
                
                crud::simpan('tbl_m_pelanggan',$data_penj);
                
                $this->session->set_flashdata('produk', '<div class="alert alert-success">Data pelanggan berhasil disimpan...</div>');
                redirect('page=produk&act=prod_pelanggan_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_pelanggan_update() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $nik     = $this->input->post('nik');
            $nama    = $this->input->post('nama');
            $no_hp   = $this->input->post('no_hp');
            $alamat  = $this->input->post('alamat');
            $tipe    = $this->input->post('tipe_member');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'     => form_error('nama'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_pelanggan_edit&id='.$id);
            } else {
                $sql_num = $this->db->get('tbl_m_pelanggan')->num_rows() + 1;
                $kode    = sprintf('%05d', $sql_num);
                
                $data_penj = array(
                    'nik'         => $nik,
                    'nama'        => $nama,
                    'no_hp'       => $no_hp,
                    'alamat'      => $alamat,
                    'id_grup'     => $tipe,
                    'status_plgn' => '1',
                );
                
                crud::update('tbl_m_pelanggan','id',general::dekrip($id),$data_penj);
                
                $this->session->set_flashdata('produk', '<div class="alert alert-success">Perubahan berhasil disimpan...</div>');
                redirect('page=produk&act=prod_pelanggan_edit&id='.$id);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function prod_pelanggan_import() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['barang'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_plgn_import', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function prod_pelanggan_upload() {
        if (akses::aksesLogin() == TRUE) {
            $this->load->helper('file');
            
            if (!empty($_FILES['fupload']['name'])) {
                $folder = realpath('file/import');
                $config['upload_path']      = './file/import';
                $config['allowed_types']    = 'xls|xlsx';
                $config['remove_spaces']    = TRUE;
                $config['overwrite']        = TRUE;
                $this->load->library('upload', $config);
                
                if (!$this->upload->do_upload('fupload')) {
                    $this->session->set_flashdata('pengaturan', 'Error : <b>' . $this->upload->display_errors() . '</b>.');
                    redirect('page=produk&act=prod_pelanggan_import&err='.$this->upload->display_errors());
                }else{
                    $f           = $this->upload->data();
                    $path        = realpath('./file/import') . '/';                    
                    $objPHPExcel = PHPExcel_IOFactory::load($path.$f['orig_name']);
                                        
                    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle     = $worksheet->getTitle();
                        $highestRow         = $worksheet->getHighestRow();
                        $highestColumn      = $worksheet->getHighestColumn();
                        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                        
                        $no = 1;
                        for ($row = 2; $row <= $highestRow; ++ $row) {
                            $val=array();
                            
                            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                                $val[] = $cell->getValue();
                            }
			
                            if (!empty($val[1])) {
                                $sql_num  = $this->db->get('tbl_m_pelanggan')->num_rows();
                                $kode     = sprintf('%05d', $sql_num + 1);
                                        
                                $produk = array(
                                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                                    'id_app'        => '1',
                                    'kode'          => $kode,
                                    'id_grup'       => 5,
                                    'nik'           => $val[0],
                                    'nama'          => $val[1],
                                    'no_hp'         => str_replace('\'', '', $val[2]),
                                    'alamat'        => $val[3],
                                );
                                crud::simpan('tbl_m_pelanggan', $produk);
                            }
                            
                            $no++;
                        }
                    }
                    
                    unlink($path.$f['orig_name']);
                    redirect('page=produk&act=prod_pelanggan_list');
                }
            }  
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }    
    
    public function prod_pelanggan_tmp_xls(){
        if (akses::aksesLogin() == TRUE) {
                       
            $objPHPExcel = new PHPExcel();
            
            // Header Tabel Nota
            $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(TRUE);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'NIK')
                    ->setCellValue('B1', 'Nama')
                    ->setCellValue('C1', 'No. HP')
                    ->setCellValue('D1', 'Alamat');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);  
            
            
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A2', '220720001')
                            ->setCellValue('B2', 'Ahmad Albar')
                            ->setCellValue('C2', '\'085741220427')
                            ->setCellValue('D2', 'Jl. S. Parman 47B, Gajahmungkur, Kota Semarang ');
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Stok');

            /** Page Setup * */
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setTop(0.25);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setRight(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setLeft(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setFooter(0);
            
            
            /** Page Setup * */
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Data pelanggan")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Data Pelanggan Pulito")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
//            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="tmpl_data_pelanggan.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            
            ob_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');            
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }

    public function prod_deposit_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->post('id');
            $dep  = str_replace('.', '', $this->input->post('jml_deposit'));
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'Nama Pelanggan', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'     => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_pelanggan_edit&id='.$id.'&case=deposit');
            } else {
                $sql_dep = $this->db->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit');
                $jml_dep = $sql_dep->row()->jml_deposit + $dep;
                
                if($sql_dep->num_rows() > 0){
                    $data_penj = array(
                        'tgl_modif'     => date('Y-m-d H:i:s'),
                        'jml_deposit'   => $jml_dep
                    );
                    
                    $data_log = array(
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'id_app'        => $pengaturan->id_app,
                        'id_pelanggan'  => general::dekrip($id),
                        'id_user'       => $this->ion_auth->user()->row()->id,
                        'jml_deposit'   => $jml_dep,
                        'kredit'        => $dep,
                        'keterangan'    => 'Deposit sebesar '.general::format_angka($dep),
                    );
                    
                    crud::update('tbl_m_pelanggan_deposit','id',$sql_dep->row()->id,$data_penj);
                    crud::simpan('tbl_m_pelanggan_deposit_hist',$data_log);
                }else{
                    $data_penj = array(
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'id_app'        => $pengaturan->id_app,
                        'id_pelanggan'  => general::dekrip($id),
                        'jml_deposit'   => $jml_dep,
                    );
                    
                    $data_log = array(
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'id_app'        => $pengaturan->id_app,
                        'id_pelanggan'  => general::dekrip($id),
                        'id_user'       => $this->ion_auth->user()->row()->id,
                        'jml_deposit'   => $jml_dep,
                        'kredit'        => $jml_dep,
                        'keterangan'    => 'Deposit pertama sebesar '.general::format_angka($jml_dep),
                    );
                    
                    crud::simpan('tbl_m_pelanggan_deposit',$data_penj);
                    crud::simpan('tbl_m_pelanggan_deposit_hist',$data_log);
                }                
                
                redirect('page=produk&act=prod_pelanggan_edit&id='.$id.'&case=deposit');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_pelanggan_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::update('tbl_m_pelanggan','id',general::dekrip($id), array('status_plgn'=>'1', 'status_hps'=>'1'));
                crud::update('tbl_m_pelanggan_deposit','id_pelanggan',general::dekrip($id), array('status_plgn'=>'1', 'status_hps'=>'1'));
                crud::update('tbl_m_pelanggan_deposit_hist','id_pelanggan',general::dekrip($id), array('status_plgn'=>'1', 'status_hps'=>'1'));
//                crud::delete('tbl_m_pelanggan','id',general::dekrip($id));
//                crud::delete('tbl_m_pelanggan_deposit','id_pelanggan',general::dekrip($id));
//                crud::delete('tbl_m_pelanggan_deposit_hist','id_pelanggan',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_pelanggan_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function prod_barang_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            
            /* Filter Pencarian */
            $kd = $this->input->get('filter_kode');
            $pr = $this->input->get('filter_produk');
            $qt = $this->input->get('filter_qty');
            $hb = $this->input->get('filter_hb');
            $hj = $this->input->get('filter_hj');
            
            $jml_hal = (isset($_GET['jml']) ? $jml  : $this->db->count_all('tbl_m_produk'));
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_barang_list&filter_kode='.$kd.'&filter_produk='.$pr.(!empty($jml) ? '&jml='.$jml : ''));
            $config['total_rows']             = $jml_hal;
            
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
                $data['produk'] = $this->db->like('kode',$kd)->like('produk',$pr)->like('jml',$qt)->like('harga_beli',$hb)->like('harga_jual',$hj)->limit($config['per_page'],$hal)->order_by('id','desc')->get('tbl_m_produk')->result();
            }else{
                $data['produk'] = $this->db->like('kode',$kd)->like('produk',$pr)->like('jml',$qt)->like('harga_beli',$hb)->like('harga_jual',$hj)->limit($config['per_page'])->order_by('id','desc')->get('tbl_m_produk')->result();
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_barang_det() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            $data['produk']    = $this->db
                    ->select('DATE(tgl_simpan) as tgl_simpan, id_kategori, kode, produk, jml, harga_beli, harga_jual')
                    ->where('id',general::dekrip($id))
                    ->get('tbl_m_produk')->row();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_det', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_barang_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
                        
            $data['produk']   = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_tambah', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_barang_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $kode      = $this->input->post('kode');
            $produk    = $this->input->post('produk');
//            $jml       = $this->input->post('stok');
            $ket       = $this->input->post('keterangan');
                        
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('produk', 'Produk', 'required');
//            $this->form_validation->set_rules('stok', 'Stok', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'       => form_error('kode'),
                    'produk'     => form_error('produk'),
//                    'stok'       => form_error('stok'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_barang_tambah');
            } else {
                $sql_cek = $this->db->where('kode',$kode)->get('tbl_m_produk');
                
                if($sql_cek->num_rows() > 0){
                    $this->session->set_flashdata('produk','<div class="alert alert-danger">Kode produk ['.$kode.'] sudah ada.</div>');
                    redirect('page=produk&act=prod_barang_tambah');
                }else{
                   $data_penj = array(
                       'tgl_simpan'      => date('Y-m-d H:i:s'),
                       'kode'            => $kode,
                       'produk'          => $produk,
//                       'jml'             => $jml,
                       'keterangan'      => $ket,
                       'tipe_produk'     => '2'
                   );
                   
                   crud::simpan('tbl_m_produk',$data_penj);
                   redirect('page=produk&act=prod_barang_list');
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_barang_update() {
        if (akses::aksesLogin() == TRUE) {
            $id        = $this->input->post('id');
            $kode      = $this->input->post('kode');
            $produk    = $this->input->post('produk');
//            $jml       = $this->input->post('stok');
            $ket       = $this->input->post('keterangan');
                        
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('produk', 'Produk', 'required');
//            $this->form_validation->set_rules('stok', 'Stok', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'       => form_error('kode'),
                    'produk'     => form_error('produk'),
//                    'stok'       => form_error('stok'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_barang_tambah&id='.$id);
            } else {
                $sql_cek = $this->db->where('kode',$kode)->get('tbl_m_produk');
                                   $data_penj = array(
                       'tgl_modif'      => date('Y-m-d H:i:s'),
                       'kode'            => $kode,
                       'produk'          => $produk,
//                       'jml'             => $jml,
                       'keterangan'      => $ket,
                       'tipe_produk'     => '2'
                   );
                   
                   crud::update('tbl_m_produk', 'id', general::dekrip($id), $data_penj);
                   redirect('page=produk&act=prod_barang_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_promo_list() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
                        
            $data['lokasi']   = $this->db->order_by('id','ASC')->get('tbl_m_promo');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_promo', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_promo_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $ket     = $this->input->post('keterangan');
            $jml     = str_replace(array('.'),'', $this->input->post('nominal'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'keterangan'     => form_error('keterangan'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_promo_list');
            } else {           
                $data_lok = array(
                    'tgl_simpan'  => date('Y-m-d H:i'),
                    'keterangan'  => $ket,
                    'nominal'     => $jml
                );
                
                crud::simpan('tbl_m_promo', $data_lok);
               
                redirect('page=produk&act=prod_promo_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_promo_hps() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');
            
            crud::delete('tbl_m_promo','id',general::dekrip($id));
            redirect('page=produk&act=prod_promo_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_lokasi_list() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            
            /* Filter Pencarian */
            $kd = $this->input->get('filter_kode');
            $pr = $this->input->get('filter_lokasi');
            $qt = $this->input->get('filter_qty');
            $hb = $this->input->get('filter_hb');
            $hj = $this->input->get('filter_hj');
            
            $jml_hal = (isset($_GET['jml']) ? $jml  : $this->db->count_all('tbl_m_lokasi'));
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=lokasi&act='.$this->input->get('act').'&filter_kode='.$kd.'&filter_lokasi='.$pr.(!empty($jml) ? '&jml='.$jml : ''));
            $config['total_rows']             = $jml_hal;
            
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
                $data['lokasi'] = $this->db->like('kode',$kd)->like('keterangan',$pr)->limit($config['per_page'],$hal)->order_by('id','desc')->get('tbl_m_lokasi')->result();
            }else{
                $data['lokasi'] = $this->db->like('kode',$kd)->like('keterangan',$pr)->limit($config['per_page'])->order_by('id','desc')->get('tbl_m_lokasi')->result();
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
//            $data['lokasi']   = $this->db->order_by('tipe','ASC')->get('tbl_m_lokasi');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_lokasi', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_lokasi_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $kode    = $this->input->post('kode');
            $ket     = str_replace(array('-','_',' '), '', $this->input->post('keterangan'));
            $jml     = $this->input->post('jml');
            $tipe    = $this->input->post('tipe_lokasi');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'     => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_lokasi_list');
            } else {
                $sql_num = $this->db->where('tipe',$tipe)->get('tbl_m_lokasi')->num_rows() + 1;
                $kd      = sprintf('%05d', $sql_num);
                
                echo $sql_num;
                
                for($i=1; $i<=$jml; $i++){
                    $l      = $i + ($sql_num - 1);              
                    $data_lok = array(
                        'id_app'      => $pengaturan->id_app,
                        'tgl_simpan'  => date('Y-m-d H:i'),
                        'kode'        => $kode.sprintf('%05d', $l),
                        'keterangan'  => $ket.' '.$l,
                        'tipe'        => $tipe
                    );
                    
                    crud::simpan('tbl_m_lokasi', $data_lok);
                }              
//                
                redirect('page=produk&act=prod_lokasi_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_member_list() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
                        
            $data['member']   = $this->db->order_by('id','ASC')->get('tbl_m_pelanggan_grup');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_member', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_member_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $member  = $this->input->post('member');
            $ket     = $this->input->post('keterangan');
            $st_dep  = $this->input->post('status_dep');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('member', 'Member', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'member'     => form_error('member'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_member_list');
            } else { 
                $data_grp = array(
                    'tgl_simpan'     => date('Y-m-d H:i'),
                    'grup'           => $member,
                    'keterangan'     => $ket,
                    'status_deposit' => $st_dep,
                );

                crud::simpan('tbl_m_pelanggan_grup', $data_grp);

                redirect('page=produk&act=prod_member_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
        
    public function prod_member_hps() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');
            
            crud::delete('tbl_m_pelanggan_grup','id',general::dekrip($id));
            redirect('page=produk&act=prod_member_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_diskon_list() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
                        
            $data['member']   = $this->db->order_by('id','ASC')->get('tbl_m_promo');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_diskon', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_diskon_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $diskon  = $this->input->post('diskon');
            $ket     = $this->input->post('keterangan');
            $st_dep  = $this->input->post('status_disk');
            $nominal = str_replace('.', '', $this->input->post('nominal'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('keterangan', 'Diskon', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'keterangan'     => form_error('diskon'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_diskon_list');
            } else { 
                $data_grp = array(
                    'tgl_simpan'  => date('Y-m-d H:i'),
                    'keterangan'  => $ket,
                    'persen'      => $diskon,
                    'nominal'     => $nominal,
                    'tipe'        => (!empty($st_dep) ? $st_dep : '0'),
                );

                crud::simpan('tbl_m_promo', $data_grp);

                redirect('page=produk&act=prod_diskon_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
        
    public function prod_diskon_hps() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');
            
            crud::delete('tbl_m_promo','id',general::dekrip($id));
            redirect('page=produk&act=prod_diskon_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_charge_list() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
                        
            $data['member']   = $this->db->order_by('id','ASC')->get('tbl_m_charge');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_charge', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_charge_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $diskon  = str_replace('.', '', $this->input->post('nominal'));
            $persen  = str_replace('.', '', $this->input->post('persen'));
            $ket     = $this->input->post('keterangan');
            $st_dep  = $this->input->post('status_dep');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('keterangan', 'Diskon', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'keterangan'     => form_error('keterangan'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_charge_list&err='.$msg_error);
            } else { 
                $data_grp = array(
                    'tgl_simpan'  => date('Y-m-d H:i'),
                    'keterangan'  => $ket,
                    'nominal'     => $diskon,
                    'persen'      => $persen,
                    'tipe'        => $st_dep,
                );

                crud::simpan('tbl_m_charge', $data_grp);

                redirect('page=produk&act=prod_charge_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
        
    public function prod_charge_hps() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');
            
            crud::delete('tbl_m_charge','id',general::dekrip($id));
            redirect('page=produk&act=prod_charge_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

//    public function prod_barang_simpan() {
//        if (akses::aksesLogin() == TRUE) {
//            $kode      = $this->input->post('kode');
//            $produk    = $this->input->post('produk');
//            $jml       = $this->input->post('stok');
//            $ket       = $this->input->post('keterangan');
//                        
//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
//            $this->form_validation->set_rules('kode', 'Kode', 'required');
//            $this->form_validation->set_rules('produk', 'Produk', 'required');
//            $this->form_validation->set_rules('stok', 'Stok', 'required');
//
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'kode'       => form_error('kode'),
//                    'produk'     => form_error('produk'),
//                    'stok'       => form_error('stok'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                redirect('page=produk&act=prod_barang_tambah');
//            } else {
//                $sql_cek = $this->db->where('kode',$kode)->get('tbl_m_produk');
//                
//                if($sql_cek->num_rows() > 0){
//                    $this->session->set_flashdata('produk','<div class="alert alert-danger">Kode produk ['.$kode.'] sudah ada.</div>');
//                    redirect('page=produk&act=prod_barang_tambah');
//                }else{
//                   $data_penj = array(
//                       'tgl_simpan'      => date('Y-m-d H:i:s'),
//                       'kode'            => $kode,
//                       'produk'          => $produk,
//                       'jml'             => $jml,
//                       'keterangan'      => $ket,
//                       'tipe_produk'     => '2'
//                   );
//                   
//                   crud::simpan('tbl_m_produk',$data_penj);
//                   redirect('page=produk&act=prod_barang_list');
//                }
//            }
//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
//            redirect();
//        }
//    }
    

    public function prod_kategori_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->like('kategori', $query)->get('tbl_m_kategori2')->num_rows());
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_kategori_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 50;
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
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->like('kategori', $query)->get('tbl_m_kategori2')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->get('tbl_m_kategori2')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'])->like('kategori', $query)->get('tbl_m_kategori2')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'])->get('tbl_m_kategori2')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_kat_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    

    public function prod_kategori1_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->like('kategori', $query)->get('tbl_m_kategori')->num_rows());
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_kategori1_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 20;
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
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->like('kategori', $query)->get('tbl_m_kategori')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->get('tbl_m_kategori')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'])->like('kategori', $query)->get('tbl_m_kategori')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'])->get('tbl_m_kategori')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['kat_edit']   = $this->db->where('id', general::dekrip($_GET['id']))->get('tbl_m_kategori')->row();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_kat1_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori2_brg_list() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->get('id');
            $id_bahan = $this->input->get('id_bahan');
            $data['kategori'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_kategori2')->row();
            $data['barang']   = $this->db->where('id_kategori2', general::dekrip($id))->get('tbl_m_kategori2_barang')->result();
            $data['bahan']    = $this->db->select('tbl_m_kategori2_barang.id, tbl_m_kategori2_barang.jml, tbl_m_kategori2_barang.keterangan, tbl_m_produk.produk')->join('tbl_m_produk','tbl_m_produk.id=tbl_m_kategori2_barang.id_barang')->where('tbl_m_kategori2_barang.id', general::dekrip($id_bahan))->get('tbl_m_kategori2_barang')->row();
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_kat2_brg_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori2_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $id      = $this->input->get('id');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_kategori2'));
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_kategori2_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 20;
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
            
            if(!isset($_GET['id'])){
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->like('kategori', $query)->get('tbl_m_kategori2')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->get('tbl_m_kategori2')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->like('kategori', $query)->get('tbl_m_kategori2')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'])->get('tbl_m_kategori2')->result();
                }
            }
			}else{
				
            $data['kategori'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_kategori2')->row();
            $data['barang']   = $this->db->where('id_kategori2', general::dekrip($id))->get('tbl_m_kategori2_barang')->result();
			}
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_kat2_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori3_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_kategori3'));
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = site_url('page=produk&act=prod_kategori3_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 20;
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
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->like('kategori', $query)->get('tbl_m_kategori3')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->get('tbl_m_kategori3')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)->like('kategori', $query)->get('tbl_m_kategori3')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'])->get('tbl_m_kategori3')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/produk/prod_kat3_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $kategori    = $this->input->post('kategori');
            $keterangan  = $this->input->post('keterangan');
            $rute        = $this->input->post('route');
            $route       = explode('/', $_POST['route']);
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_kategori_list');
            } else {
                $data_penj = array(
                    'id_app'     => $pengaturan->id_app,
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'kategori'   => $kategori,
                    'keterangan' => $keterangan
                );

                crud::simpan('tbl_m_kategori',$data_penj);
                $sql = $this->db->select('MAX(id) as last_id')->get('tbl_m_kategori')->row();
                
                if(!empty($rute)){
                    redirect('page=produk&act='.$route[0].'&id_kat='.$route[1].'&sub='.$route[2]);
                }else{
                    redirect('page=produk&act=prod_kategori_list&id_kat='.general::enkrip($sql->last_id).'&sub=1');
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori_update() {
        if (akses::aksesLogin() == TRUE) {
            $id          = $this->input->post('id');
            $kategori    = $this->input->post('kategori');
            $keterangan  = $this->input->post('keterangan');
            $rute        = $this->input->post('route');
            $route       = explode('/', $_POST['route']);
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_kategori1_list');
            } else {
                $data_penj = array(
                    'tgl_modif'  => date('Y-m-d H:i:s'),
                    'kategori'   => $kategori,
                    'keterangan' => $keterangan
                );

                crud::update('tbl_m_kategori', 'id', general::dekrip($id),$data_penj);
                
                if(!empty($rute)){
                    redirect('page=produk&act='.$route[0].'&id_kat='.$route[1].'&sub='.$route[2]);
                }else{
                    redirect('page=produk&act=prod_kategori1_list&id='.$id);
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori2_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $kategori    = $this->input->post('kategori');
            $kategori2   = $this->input->post('kategori2');
            $keterangan  = $this->input->post('keterangan');
            $rute        = $this->input->post('route');
            $jml         = $this->input->post('jml');
            $tipe        = $this->input->post('tipe');
            $harga       = str_replace('.','', $this->input->post('harga'));
            $route       = explode('/', $_POST['route']);
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_kategori_list');
            } else {
                $data_penj = array(
                    'id_app'        => $pengaturan->id_app,
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'id_kategori'   => $kategori,
                    'kategori'      => $kategori2,
                    'jml'           => $jml,
                    'keterangan'    => $keterangan,
                    'harga'         => $harga,
                    'status_karpet' => $tipe,
                );

                crud::simpan('tbl_m_kategori2',$data_penj);
                $sql = $this->db->select('MAX(id) as last_id')->get('tbl_m_kategori2')->row();
                
                redirect('page=produk&act=prod_kategori2_brg_list&id='.general::enkrip($sql->last_id));
//                if(!empty($rute)){
//                    redirect('page=produk&act='.$route[0].'&id_kat='.$route[1].'&sub='.$route[2]);
//                }else{
//                    redirect('page=produk&act=prod_kategori_list&id_kat='.general::enkrip($kategori).'&id_kat2='.general::enkrip($sql->last_id).'&sub=2');
//                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori2_update() {
        if (akses::aksesLogin() == TRUE) {
            $id          = $this->input->post('id');
            $aid         = general::dekrip($id);
            $id_kat      = $this->input->post('id_kat');
            $kategori    = $this->input->post('kategori');
            $kategori2   = $this->input->post('kategori2');
            $keterangan  = $this->input->post('ket');
            $rute        = $this->input->post('route');
            $harga       = str_replace('.','', $this->input->post('harga'));
            $jml         = str_replace('.','', $this->input->post('jml'));
            $route       = explode('/', $_POST['route']);
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_kategori_list');
            } else {
                $data_penj = array(
                    //'id_app'        => $pengaturan->id_app,
                    'tgl_modif'     => date('Y-m-d H:i:s'),
                    //'id_kategori'   => $kategori,
                    'kategori'      => $kategori2,
                    'jml'           => $jml,
                    'harga'         => $harga,
                    'keterangan'    => $keterangan,
                );

                crud::update('tbl_m_kategori2','id',$aid,$data_penj);
                
                redirect('page=produk&act=prod_kategori2_list');
//                redirect('page=produk&act=prod_kategori2_brg_list&id='.general::enkrip($sql->last_id));
//                if(!empty($rute)){
//                    redirect('page=produk&act='.$route[0].'&id_kat='.$route[1].'&sub='.$route[2]);
//                }else{
//                    redirect('page=produk&act=prod_kategori_list&id_kat='.general::enkrip($kategori).'&id_kat2='.general::enkrip($sql->last_id).'&sub=2');
//                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori2_brg_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $id_bahan   = $this->input->post('id_bahan');
            $jml        = $this->input->post('jml');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'     => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_kategori2_brg_list');
            } else {
                $data_penj = array(
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'id_app'       => $pengaturan->id_app,
                    'id_kategori2' => general::dekrip($id),
                    'id_barang'    => $id_bahan,
                    'jml'          => $jml
                );

                crud::simpan('tbl_m_kategori2_barang',$data_penj);                
                redirect('page=produk&act=prod_kategori2_brg_list&id='.$id);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori2_brg_update() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $id_bahan   = $this->input->post('id_bahan');
            $jml        = $this->input->post('jml');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'     => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_kategori2_brg_list');
            } else {
                $data_penj = array(
                    'jml'          => $jml
                );

                crud::update('tbl_m_kategori2_barang','id',general::dekrip($id_bahan),$data_penj);
                
                redirect('page=produk&act=prod_kategori2_brg_list&id='.$id);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori2_brg_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $idk = $this->input->get('id_kategori');
            
            if(!empty($id)){
                crud::delete('tbl_m_kategori2_barang','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_kategori2_brg_list&id='.$idk);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori3_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $kategori    = $this->input->post('kategori');
            $kategori2   = $this->input->post('kategori2');
            $kategori3   = $this->input->post('kategori3');
            $keterangan  = $this->input->post('keterangan');
            $harga       = str_replace('.', '', $this->input->post('harga'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_kategori_list');
            } else {
                $data_penj = array(
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'id_kategori'   => $kategori,
                    'id_kategori2'  => $kategori2,
                    'kategori'      => $kategori3,
                    'harga'         => (float)$harga,
                    'keterangan'    => $keterangan
                );
                
                crud::simpan('tbl_m_kategori3',$data_penj);
//                $sql = $this->db->select('MAX(id) as last_id')->get('tbl_m_kategori3')->row();
                redirect('page=produk&act=prod_kategori_list');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_kategori_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_kategori2','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_kategori_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    
    public function prod_kategori1_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_kategori','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_kategori1_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function prod_kategori2_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_kategori2','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_kategori2_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function prod_kategori3_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_kategori3','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_kategori3_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function prod_simpan_stok() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $bahan   = $this->input->post('bahan');
            $jml        = $this->input->post('jml');
                        
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('bahan', 'Penjahit', 'required');
            $this->form_validation->set_rules('jml', 'Stok', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'         => form_error('id'),
                    'bahan'   => form_error('bahan'),
                    'jml'        => form_error('jml'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_tambah&id='.$id);
            } else {
                $sql_cek = $this->db->where('id_produk',general::dekrip($id))->where('id_bahan',$bahan)->get('tbl_m_produk_stok');
                
//                if($sql_cek->num_rows() > 0){
//                    $this->session->set_flashdata('produk','<div class="alert alert-danger">Nama bahan tidak boleh lebih dari 1.</div>');
//                    redirect('page=produk&act=prod_tambah&id='.$id);
//                }else{
                    $data_penj = array(
                        'id_produk'   => general::dekrip($id),
                        'id_bahan' => $bahan,
                        'tgl_simpan'  => date('Y-m-d'),
                        'stok_awal'   => $jml,
                        'stok'        => $jml,
                    );
    
                    crud::simpan('tbl_m_produk_stok',$data_penj);
                   
                    $sql_stok = $this->db->select_max('id')->get('tbl_m_produk_stok')->row();
                    
                    
                    // Simpan histori penambahan produk
                    $data_hist = array(
                        'id_stok'     => $sql_stok->id,
                        'id_produk'   => general::dekrip($id),
                        'id_bahan' => $bahan,
                        'tgl_simpan'  => date('Y-m-d H:i:s'),
                        'keterangan'  => 'Penambahan <b>'.$jml.'</b> stok <b>'.$this->db->where('id',general::dekrip($id))->get('tbl_m_produk')->row()->kode.' - '.$this->db->where('id',$bahan)->get('tbl_m_bahan')->row()->bahan.'</b>',
                    );
                    crud::simpan('tbl_m_produk_hist',$data_hist);
                    redirect('page=produk&act=prod_tambah&id='.$id.'#jml');
//                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_simpan_hrg() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $keterangan = $this->input->post('keterangan');
            $hrg        = $this->input->post('harga');
            
            $tgl_skrg  = explode('/', $tgl);
            $hj        = str_replace(array('.'), '', $hrg);
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'         => form_error('id'),
                    'keterangan' => form_error('keterangan'),
                    'hrg_res'    => form_error('harga'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_tambah&id='.$id);
            } else {
                $data_penj = array(
                    'id_produk'       => general::dekrip($id),
                    'tgl_simpan'      => date('Y-m-d'),
                    'keterangan'      => $keterangan,
                    'harga'           => $hj
                );

                crud::simpan('tbl_m_produk_harga',$data_penj);
                redirect('page=produk&act=prod_tambah&id='.$id.'#hrg_res');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_update() {
        if (akses::aksesLogin() == TRUE) {
            $id        = $this->input->post('id');
            $kode      = $this->input->post('kode');
            $produk    = $this->input->post('produk');
            $hrg_beli  = $this->input->post('hrg_beli');
            $hrg_jual  = $this->input->post('hrg_jual');
            
            $hb        = str_replace(array('.'), '', $hrg_beli);
            $hj        = str_replace(array('.'), '', $hrg_jual);
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('produk', 'Produk', 'required');
            $this->form_validation->set_rules('hrg_jual', 'Harga Jual', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'       => form_error('kode'),
                    'produk'     => form_error('produk'),
                    'hrg_jual'   => form_error('hrg_jual'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect('page=produk&act=prod_tambah&id='.$id);
            } else {
                $data_penj = array(
                    'tgl_simpan'      => date('Y-m-d H:i:s'),
                    'kode'            => $kode,
                    'produk'          => $produk,
                    'harga_beli'      => $hb,
                    'harga_jual'      => $hj,
                );
                
                crud::update('tbl_m_produk','id',general::dekrip($id),$data_penj);
                redirect('page=produk&act=prod_tambah&id='.$id);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function prod_barang_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_produk','id',general::dekrip($id));
            }
            
            redirect('page=produk&act=prod_barang_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_kategori_perm() {
        if (akses::aksesLogin() == TRUE) {
            $term = $this->input->get('id');
            crud::update('tbl_m_kategori2', 'id', general::dekrip($term), array('keterangan' => 'Kategori Tambahan', 'status_temp' => '0'));
            redirect('page=produk&act=prod_kategori_list');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function json_barang() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('*')->like('produk',$term)->order_by('id','desc')->get('tbl_m_produk')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $transaksi[] = array(
                        'id'     => $sql->id,
                        'kode'   => $sql->kode,
                        'produk' => $sql->produk,
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
    

    public function set_cari_plgn() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
//            if(!empty($id)){
                $jml = $this->db->where('status_hps', '0')->like('nama',$id)->get('tbl_m_pelanggan')->num_rows();
                redirect('page=produk&act=prod_pelanggan_list'.($jml > 0 ? '&q='.$id.'&jml='.$jml : '&q='.$id.'&jml=' ));
//            }else{
//                redirect('page=produk&act=prod_pelanggan_list');
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function set_cari_kat() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            $rt = $this->input->post('route');
            
            if(!empty($id)){
                $jml = $this->db->like('tbl_m_kategori.kategori',$id)
                                ->like('tbl_m_kategori2.kategori',$id)
                                ->join('tbl_m_kategori','tbl_m_kategori.id=tbl_m_kategori2.id_kategori')
                                ->get('tbl_m_kategori2')->num_rows();
                redirect('page=produk&act='.$rt.'&q='.$id.'&jml='.$jml);
            }else{
                redirect('page=produk&act='.$rt.'');
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function set_cari_prod() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('kode');
            $pr = $this->input->post('produk');
            $rt = $this->input->post('route');
            
//            if(!empty($id)){
                $jml = $this->db->like('kode',$id)
                                ->like('produk',$pr)
                                ->get('tbl_m_produk')->num_rows();
                if($jml > 0){
                    redirect('page=produk&act='.$rt.'&filter_kode='.$id.'&filter_produk='.$pr.'&jml='.$jml);
                }else{
                    redirect('page=produk&act='.$rt.'');
                }
//            }else{
//                redirect('page=produk&act='.$rt.'');
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function set_cari_lokasi() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('kode');
            $pr = $this->input->post('produk');
            $rt = $this->input->post('route');
            
//            if(!empty($id)){
                $jml = $this->db->like('kode',$id)
                                ->like('keterangan',$pr)
                                ->get('tbl_m_lokasi')->num_rows();
                if($jml > 0){
                    redirect('page=produk&act='.$rt.'&filter_kode='.$id.'&filter_produk='.$pr.'&jml='.$jml);
                }else{
                    redirect('page=produk&act='.$rt.'');
                }
//            }else{
//                redirect('page=produk&act='.$rt.'');
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
}

//
//  
//    public function prod_plgngrp_list() {
//        if (akses::aksesLogin() == TRUE) {
//            $query   = $this->input->get('q');
//            $hal     = $this->input->get('halaman');
//            $jml     = $this->input->get('jml');
//            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pelanggan_grup'));
//            
//            $data['hasError'] = $this->session->flashdata('form_error');
//                        
//            $config['base_url']               = site_url('page=produk&act=prod_plgngrp_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
//            $config['total_rows']             = $jml_hal;
//            
//            $config['query_string_segment']  = 'halaman';
//            $config['page_query_string']     = TRUE;
//            $config['per_page']              = 10;
//            $config['num_links']             = 2;
//            
//            $config['first_tag_open']        = '<li>';
//            $config['first_tag_close']       = '</li>';
//            
//            $config['prev_tag_open']         = '<li>';
//            $config['prev_tag_close']        = '</li>';
//            
//            $config['num_tag_open']          = '<li>';
//            $config['num_tag_close']         = '</li>';
//            
//            $config['next_tag_open']         = '<li>';
//            $config['next_tag_close']        = '</li>';
//            
//            $config['last_tag_open']         = '<li>';
//            $config['last_tag_close']        = '</li>';
//            
//            $config['cur_tag_open']          = '<li><a href="#"><b>';
//            $config['cur_tag_close']         = '</b></a></li>';
//            
//            $config['first_link']            = '&laquo;';
//            $config['prev_link']             = '&lsaquo;';
//            $config['next_link']             = '&rsaquo;';
//            $config['last_link']             = '&raquo;';
//            
//            
//            if(!empty($hal)){
//                if (!empty($query)) {
//                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_m_pelanggan_grup')->result();
//                } else {
//                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->order_by('id','asc')->get('tbl_m_pelanggan_grup')->result();
//                }
//            }else{
//                if (!empty($query)) {
//                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_m_pelanggan_grup')->result();
//                } else {
//                    $data['pelanggan'] = $this->db->limit($config['per_page'])->order_by('id','asc')->get('tbl_m_pelanggan_grup')->result();
//                }
//            }
//            
//            $this->pagination->initialize($config);
//            
//            $data['total_rows'] = $config['total_rows'];
//            $data['PerPage']    = $config['per_page'];
//            $data['pagination'] = $this->pagination->create_links();
//            
//            if(isset($_GET['id'])){
//                $data['pelanggan_agt'] = $this->db->select('tbl_m_pelanggan.id, tbl_m_pelanggan.nama, tbl_m_pelanggan.lokasi')->where('tbl_m_pelanggan.id_grup', '0')->where('tbl_m_pelanggan.id !=', '1')->order_by('tbl_m_pelanggan.kode','asc')->get('tbl_m_pelanggan')->result();
//            }
//
//            $this->load->view('admin-lte-2/1_atas', $data);
//            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
//            $this->load->view('admin-lte-2/includes/produk/prod_plgngrp_list', $data);
//            $this->load->view('admin-lte-2/5_footer', $data);
//            $this->load->view('admin-lte-2/6_bawah', $data);
//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
//            redirect();
//        }
//    }
//
//    public function prod_plgngrp_simpan() {
//        if (akses::aksesLogin() == TRUE) {
//            $grup    = $this->input->post('grup');
//            $diskon  = str_replace(array('.'), '', $this->input->post('diskon'));
//            $ket     = $this->input->post('keterangan');
//
//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
//            $this->form_validation->set_rules('grup', 'Grup Pelanggan', 'required');
//
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'grup'     => form_error('grup'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                redirect('page=produk&act=prod_plgngrp_list');
//            } else {                
//                $data_penj = array(
//                    'tgl_simpan'  => date('Y-m-d H:i'),
//                    'grup'        => $grup,
//                    'potongan'    => $diskon,
//                    'keterangan'  => $ket
//                );
//                
//                crud::simpan('tbl_m_pelanggan_grup',$data_penj);
//                redirect('page=produk&act=prod_plgngrp_list');
//            }
//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
//            redirect();
//        }
//    }
//
//    public function prod_plgngrp_simpan_agt() {
//        if (akses::aksesLogin() == TRUE) {
//            $id    = $this->input->post('id');
//
//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
//            $this->form_validation->set_rules('id', 'ID Pelanggan', 'required');
//
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'id'     => form_error('id'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                redirect('page=produk&act=prod_plgngrp_list');
//            } else {   
////                if(isset($_POST['ck'])){
//                    /* Mengurai array cekbox */
//                    foreach ($_POST['ck'] as $key => $ck){
//                        $sql = $this->db->where('id',general::dekrip($ck))->get('tbl_m_pelanggan_grup')->row();
//                        
//                        crud::update('tbl_m_pelanggan','id',$key,array('id_grup'=>general::dekrip($ck)));
//                        crud::simpan('tbl_m_pelanggan_agt',array('id_pelanggan_grup'=>general::dekrip($ck), 'id_pelanggan'=>$key, 'potongan'=>$sql->potongan));
//                    }
//                    
//                    redirect('page=produk&act=prod_plgngrp_list');
////                }
//            }
//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
//            redirect();
//        }
//    }
//
//    public function prod_plgngrp_hapus() {
//        if (akses::aksesLogin() == TRUE) {
//            $id = $this->input->get('id');
//            
//            if(!empty($id)){
//                crud::delete('tbl_m_pelanggan_grup','id',general::dekrip($id));
//            }
//            
//            redirect('page=produk&act=prod_plgngrp_list');
//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
//            redirect();
//        }
//    }