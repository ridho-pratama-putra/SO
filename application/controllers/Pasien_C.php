<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_C extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('SO_M');
		if ($this->session->userdata('logged_in')['akses'] !== 'pasien' ){
			redirect();
		}
	}
	
	// dapatkan semua obat pada database dan render
	// public function view_read_obat()
	// {
	// 	/*baca semua obat yang pada pada database, kemudian render*/
	// 	$data['result'] = $this->SO_M->readS('master_obat')->result();
	// 	$this->load->view('html/header');
	// 	$this->load->view('ppk/read_obat',$data);
	// 	$this->load->view('html/footer');	
	// }

	// dapatkan semua log pengobatan pasien X
	public function view_log_pengobatan()
	{
		
		/*untuk aksi pada tombol detail user dari datatable registered user pada halaman registered user*/
		$dataCondition['id_user']	=	$this->session->userdata('logged_in')['id_user'];
		$dataCol					=	array('id_user','nama_user','nomor_identitas','no_hp','link_foto');
		
		// cari informasi identitas user
		$data['user']				=	$this->SO_M->readCol('user',$dataCondition,$dataCol)->result();

		// cari kondisi user
		$data['kondisi']			=	$this->SO_M->read('kondisi',$dataCondition)->result();

		// cari log pengobatan
		$data['log_pengobatan']		=	$this->SO_M->read('log_pengobatan',$dataCondition)->result();

		$this->load->view('html/header');
		$this->load->view('html/sidebar-kanan');
		$this->load->view('pasien/log_pengobatan',$data);
		$this->load->view('html/footer');
	}

	// dapatkan informasi gejala maupun obat yang diberikan
	public function view_detail_per_log($id_log,$id_user)
	{
		if ($id_user == $this->session->userdata('logged_in')['id_user']) {
			$dataCondition['id_log'] 	=	$id_log;
			if ($this->SO_M->read('log_pengobatan',array('id_log'=>$id_log))->num_rows() == 1) {
				$data['gejala_per_log']		=	$this->SO_M->rawQuery("	SELECT
																		gejala_log.id_log_gejala,
																		gejala_log.id_log,
																		master_gejala.detail_gejala

																		FROM
																		gejala_log
																		INNER JOIN master_gejala ON gejala_log.id_gejala = master_gejala.id_gejala
																		WHERE id_log = ".$id_log)->result();
				$data['obat_per_log']		=	$this->SO_M->rawQuery("	SELECT
																		obat_log.id_log_obat,
																		obat_log.id_log,
																		master_obat.id_obat,
																		master_obat.nama_obat

																		FROM
																		obat_log
																		INNER JOIN master_obat ON obat_log.id_obat = master_obat.id_obat
																		WHERE id_log = ".$id_log)->result();
				$data['log_pengobatan']		=	$this->SO_M->read('log_pengobatan',$dataCondition)->result();
				$data['kondisi_per_log']	=	$this->SO_M->readCol('kondisi_log',array('id_log'=>$id_log,'status'=>0),array('detail_kondisi','status'))->result();

				$data['pesan_per_log']		=	$this->SO_M->read('pesan_log',array('id_log'=>$id_log))->result();


				unset($dataCondition['id_log']);
				$dataCondition['id_user']	=	$this->session->userdata('logged_in')['id_user'];
				$dataCol					=	array('id_user','nama_user','nomor_identitas','no_hp','link_foto');

				// cari informasi identitas user
				$data['user']				=	$this->SO_M->readCol('user',$dataCondition,$dataCol)->result();

				$this->load->view('html/header');
				$this->load->view('pasien/detail_per_log',$data);
				$this->load->view('html/footer');
			}else{
				$data['heading']	= "Data tidak ditemukan";
				$data['message']	= "<p>Data log pengobatan tidak ditemukan. <a href='".base_url('Pasien_C/view_log_pengobatan/')."'> Kembali</a></p>";
				$this->load->view('errors/html/error_general',$data);
			}
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Data log pengobatan tidak ditemukan. <a href='".base_url('Pasien_C/view_log_pengobatan/')."'> Kembali</a></p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	// digunakan untuk menampilkan informasi mengenai suatu obat pada table log pengobatan.
	public function view_karakteristik_obat($id_log,$id_obat,$id_user)
	{
		if ($id_user == $this->session->userdata('logged_in')['id_user']) {
			if ($this->SO_M->read('log_pengobatan',array('id_log'=>$id_log))->num_rows() == 1) {
				if ($this->SO_M->read('obat_log',array('id_log'=>$id_log,'id_obat'=>$id_obat))->num_rows() == 1) {
					
					$dataCondition['id_obat'] = $id_obat;

					// ambil data nama obat berdsarkan idnya
					$data['obat'] = $this->SO_M->read('master_obat',$dataCondition)->result();

					// ambil kontra berdsarkan id obat
					$dataCondition['tipe'] = 'kontraindikasi';
					$data['kontraindikasi_obat']= $this->SO_M->read('karakteristik_obat',$dataCondition)->result();
					unset($dataCondition['tipe']);

					// ambil indikasi
					$dataCondition['tipe'] = 'indikasi';
					$data['indikasi_obat']= $this->SO_M->read('karakteristik_obat',$dataCondition)->result();
					unset($dataCondition['tipe']);

					// ambil peringatan
					$dataCondition['tipe'] = 'peringatan';
					$data['peringatan_obat']= $this->SO_M->read('karakteristik_obat',$dataCondition)->result();
					unset($dataCondition['tipe']);

					// ambil pesan
					$data['catatan_obat'] = $this->SO_M->read('catatan_obat',array('id_obat'=>$id_obat))->result();

					// render di karakteristik_obat
					$this->load->view('html/header');
					$this->load->view('pasien/obat_per_log',$data);
					$this->load->view('html/footer');
				}else{
					$data['heading']	= "Data tidak ditemukan";
					$data['message']	= "<p>Data log pengobatan tidak ditemukan. <a href='".base_url('Pasien_C/view_log_pengobatan/')."'>Kembali.</a></p>";
					$this->load->view('errors/html/error_general',$data);
				}
			}else{
				$data['heading']	= "Data tidak ditemukan";
				$data['message']	= "<p>Data log pengobatan tidak ditemukan. <a href='".base_url('Pasien_C/view_log_pengobatan/')."'>Kembali.</a></p>";
				$this->load->view('errors/html/error_general',$data);
			}
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Data log pengobatan tidak ditemukan. <a href='".base_url('Pasien_C/view_log_pengobatan/')."'>Kembali.</a></p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	// action untuk form pada halaman create_rekam medis
	public function view_create_data_rekam_medis()
	{
		$dataCondition			=	array('id_user' => $id_user);
		$result 				=	$data['result'] = $this->SO_M->read("log_pengobatan",$dataCondition)->result();
	}

	// cari rekam medis pasien dan render
	public function view_lihat_data_rekam_medis()
	{
		$dataCondition['id_user'] = $this->session->userdata('logged_in')['id_user'];
		$data = $this->SO_M->read('kondisi',$dataCondition)->result();
		$this->load->view('html/header');
		$this->load->view('pasien/rekam_medis',$data);
		$this->load->view('html/footer');
	}
}