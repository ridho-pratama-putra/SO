<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_C extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('SO_M');
		if ($this->session->userdata('logged_in')['akses'] !== 'admin' ){
			redirect();
		}
	}
	
	public function view_read_obat()
	{
		$data['result'] = $this->SO_M->readDistinct('master_obat')->result();
		$this->load->view('html/header');
		$this->load->view('admin/read_obat',$data);
		$this->load->view('html/footer');	
	}
	
	public function view_create_obat()
	{
		$this->load->view('html/header');
		$this->load->view('admin/create_obat');
		$this->load->view('html/footer');
	}

	public function handle_delete_obat($nama_obat)
	{
		$dataCondition = array('nama_obat' => $nama_obat);

		// cari di database where id obat
		$data = $this->SO_M->read("master_obat",$dataCondition);

		// jika, tidak ada di database
		if ($data->num_rows() == 0) {
			// info kenapa eror nya
			$error = $this->db->error();
			$datae['heading']	=	"Delete gagal";
			$datae['message']	=	"<p>ID obat tidak ditemukan. Coba lihat <a href='".base_url()."Admin_C/view_read_obat'>daftar obat</a>.</p>";

			$this->load->view('errors/html/error_404',$datae);
		}

		// jika ada di database, maka hapus
		else{
			$result = $this->SO_M->delete("master_obat",$dataCondition);
			if ($result ) {
				$this->session->set_flashdata(
					"alert_delete_obat",
					"<div class='alert alert-success alert-dismissible fade show' role='alert'> Delete Berhasil <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div> "
				);
			}
			else{
				$this->session->set_flashdata(
					"alert_delete_obat",
					"<div class='alert alert-warning alert-danger fade show' role='alert'>Gagal!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div> "
				);
			}
			redirect('Admin_C/view_read_obat/');
		}
	}

	public function view_update_obat($nama_obat)
	{
		$dataCondition = array('nama_obat' => $nama_obat);
		$data = $this->SO_M->read("master_obat",$dataCondition);

		if ($data->num_rows() == 0) {
			$datae['heading']= "Data obat tidak ditemukan";
			$datae['message']= "<p>ID pada tabel obat tidak ditemukan. Coba lihat <a href='".base_url()."Admin_C/view_read_obat'>daftar obat</a> </p>";
			$this->load->view('errors/html/error_404',$datae);
		}
		else{
			$datav['result'] = $data->result();
			$this->load->view('html/header');
			$this->load->view('admin/update_obat',$datav);
			$this->load->view('html/footer');
		}
	}

	public function handle_create_obat()
	{
		if ($this->input->post() == null) {
			$data['heading']= "Tidak ada form data yang di POST";
			$data['message']= "<p>Coba lagi <a href='".base_url()."Admin_C/view_create_obat'>Create obat</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
		else{
			
			// $data = array(
			// 				'nama_obat'	=>	$this->input->post('nama_obat'),
			// 				'indikasi'	=>	$this->input->post('indikasi[]')
			// );

			$nama_obat_dari_form		=	$this->input->post('nama_obat');
			$indikasi_dari_form			=	$this->input->post('indikasi[]');
			$kontraindikasi_dari_form	=	$this->input->post('kontraindikasi[]');
			$peringatan_dari_form		=	$this->input->post('peringatan[]');


			// $data = array(
			// array(
			// 'title' => 'My title',
			// 'name' => 'My Name',
			// 'date' => 'My date'
			// ),
			// array(
			// 'title' => 'Another title',
			// 'name' => 'Another Name',
			// 'date' => 'Another date'
			// )
			// );

			// echo "<pre>";
			// var_dump($data);
			// echo "-----------------------------------------------------------";
			// echo "<br>";
			// echo "</pre>";



			// echo count($peringatan_dari_form);

			// if (empty($peringatan_dari_form)) {
			// 	echo "string";
			// }
			// else{
			// 	echo "str";
			// }
			
			// echo "<pre>";
			// var_dump($indikasi_dari_form);
			// echo "<br>";
			// var_dump($kontraindikasi_dari_form);
			// echo "<br>";
			// print_r($indikasi_dari_form);

			// var_dump($peringatan_dari_form);
			// echo "</pre>";
			// echo "<br>";

			$panjang_ke_db = 0;
			if ($indikasi_dari_form[0] !== '') {
				$panjang_indikasi = 0
				// $indikasi_db = array();
				foreach ($indikasi_dari_form as $key) {
					// $indikasi_db[$key]		=	array(
					// 									'nama_obat' 	=>	$nama_obat_dari_form,
					// 									'tipe'			=>	'indikasi',
					// 									'detail_tipe' 	=>	$indikasi_dari_form[$key]
					// );
					$panjang++;
					$panjang_indikasi++;
				}
				// echo "<pre>";
				// echo count($indikasi_db);
				// print_r($indikasi_db);
				// echo "<br>";
				// echo "</pre>";
			}

			if ($kontraindikasi_dari_form[0] !== '') {
				$panjang_kontraindikasi = 0;
				// $kontraindikasi_db = array();
				foreach ($kontraindikasi_dari_form as $key => $value) {
					// $kontraindikasi_db[$key]	=	array(
					// 									'nama_obat' 	=>	$nama_obat_dari_form,
					// 									'tipe'			=>	'kontraindikasi',
					// 									'detail_tipe' 	=>	$kontraindikasi_dari_form[$key]
					// );
					$panjang++;
					$panjang_kontraindikasi++;
				}
				// echo "<pre>";
				// print_r($kontraindikasi_db);
				// echo "<br>";
				// echo "</pre>";
			}


			if ($peringatan_dari_form[0] !== '') {
				$panjang_peringatan = 0
				// $peringatan_db = array();
				foreach ($peringatan_dari_form as $key => $value) {
					// $peringatan_db[$key]	=	array(
					// 								'nama_obat' 	=>	$nama_obat_dari_form,
					// 								'tipe'			=>	'peringatan',
					// 								'detail_tipe' 	=>	$peringatan_dari_form[$key]
					// );
					$panjang++;
					$panjang_peringatan++;
				}
				// echo "<pre>";
				// print_r($peringatan_db);
				// echo "<br>";
				// echo "</pre>";
			}

			$masuk_db = array();
			for ($i=0; $i < $panjang; $i++) { 
				if ($panjang_indikasi > 0) {
					$masuk_db[$i] = 
				}
			}

			//$data['result'] = $this->SO_M->createS('master_obat', )
		}
	}
}