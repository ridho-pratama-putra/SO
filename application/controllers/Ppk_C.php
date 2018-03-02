<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppk_C extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('SO_M');
		date_default_timezone_set("Asia/Jakarta");
		if ($this->session->userdata('logged_in')['akses'] !== 'ppk' ){
			redirect();
		}
	}
	
	// masukkan id user untuk pencarian rekam medis seorang pasien
	public function view_id()
	{
		$this->load->view('html/header');
		$this->load->view('ppk/input_form_identitas_pasien');
		$this->load->view('html/footer');
	}

	// dapatkan semua obat pada database lalu render
	public function view_read_obat()
	{
		/*baca semua obat yang pada pada database, kemudian render*/
		$data['result'] = $this->SO_M->readS('master_obat')->result();
		$this->load->view('html/header');
		$this->load->view('ppk/read_obat',$data);
		$this->load->view('html/footer');	
	}

	/*detai per user dari menu registered user. untuk yang dari halaman pemeriksaan di handle oleh function handle_form_id pada kontroller ini. beda function, fungsinya sama*/
	public function view_detail_log_per_user($id_user)
	{
		/*untuk aksi pada tombol detail user dari datatable registered user pada halaman registered user*/
		$dataCondition['id_user']	=	$id_user;
		$dataCol					=	array('id_user','nama_user','nomor_identitas','no_hp','link_foto');
		
		// cari informasi identitas user
		$data['user']				=	$this->SO_M->readCol('user',$dataCondition,$dataCol)->result();

		// cari log pengobatan
		$data['log_pengobatan']		=	$this->SO_M->read('log_pengobatan',$dataCondition)->result();

		// dapatkan seluruh data pada master_kondisi untuk dijadikan selcet elemen'
		unset($dataCol,$dataCondition);
		$dataCondition				=	array();
		$dataCol					=	array('id_master_kondisi AS id','detail_kondisi AS text');
		$data['master_kondisi']		=	$this->SO_M->readCol('master_kondisi',$dataCondition,$dataCol)->result();
		// $data['master_kondisi_array']		=	$this->SO_M->readS('master_kondisi')->result_array();

		$this->load->view('html/header');
		$this->load->view('ppk/log_pengobatan',$data);
		$this->load->view('html/footer');	
	}

	/*function ini digunakan untuk dipanggil oleh ajax saat render data kondisi seorang pasien*/
	public function dataTable_kondisi($id_user)
	{
		$dataCondition['id_user']				=	$id_user;
		$result['kondisi']						=	$this->SO_M->read('kondisi',$dataCondition)->result();
		echo json_encode($result);
	}

	// function dibawah ini untuk get data log pengobatan seorang pasien yang dipanggil pada halaman log_pengobatan.php
	public function dataTable_log($id_user)
	{
		$dataCondition['id_user']	=	$id_user;
		$result['log_pengobatan']	=	$this->SO_M->read('log_pengobatan',$dataCondition)->result();
		echo json_encode($result);
	}

	// detail untuk setiap log pengobatan. detailnya yakni gejalanya apa saja, obatnya apa saja. obat bisa diklik untuk melihat karakteristiknya
	public function view_detail_per_log($id_log,$id_user)
	{
		$dataCondition['id_log'] 	=	$id_log;
		$data['gejala_per_log']		=	$this->SO_M->rawQuery("	SELECT
																gejala_log.id_log_gejala,
																gejala_log.id_log,
																master_gejala.nama_gejala

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
		$dataCol					=	array('tanggal');
		$data['log_pengobatan']		=	$this->SO_M->readCol('log_pengobatan',$dataCondition,$dataCol)->result();

		unset($dataCondition['id_log']);

		// data user didapatkan untuk menu side bar :D
		$dataCondition['id_user']	=	$id_user;
		$dataCol					=	array('id_user','nama_user','nomor_identitas','no_hp','link_foto');

		// cari informasi identitas user
		$data['user']				=	$this->SO_M->readCol('user',$dataCondition,$dataCol)->result();

		$this->load->view('html/header');
		$this->load->view('ppk/detail_per_log',$data);
		$this->load->view('html/footer');
	}

	// digunakan untuk menampilkan informasi mengenai karakteristik yang dimiliki suatu obat pada table log pengobatan dan pada knowledge base obat.
	public function view_karakteristik_obat($id_obat)
	{
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

		// render di karakteristik_obat
		$this->load->view('html/header');
		$this->load->view('ppk/obat_per_log',$data);
		$this->load->view('html/footer');
	}

	// URL untuk masuk ke input gejala yang dialami oleh pasien
	public function view_gejala()
	{
		$this->load->view('html/header');
		$this->load->view('ppk/form_gejala');
		$this->load->view('html/sidebar-kanan');
		$this->load->view('html/footer');
	}

	// halaman untuk menampilkan hasil inputan gejala. disini ditampilkan obat-obat beserta karakteristiknya dan kecocokannya dengan seorang pasien
	public function view_hasil()
	{
		$this->load->view('html/header');
		$this->load->view('ppk/hasil');
		$this->load->view('html/sidebar-kanan');
		$this->load->view('html/footer');
	}

	// halaman untuk "checkout" keranjang obat
	public function view_resep()
	{
		$this->load->view('html/header');
		$this->load->view('ppk/resep');
		$this->load->view('html/sidebar-kanan');
		$this->load->view('html/footer');
	}

	/*
	untuk menangani submit form pada view_id yang berisi nomor identitas pasien
	function ini menghasilkan daftar kondisi yang dimiliki oleh seorang pasien
	*/
	public function handle_view_id()
	{
		if ($this->input->get() != NULL) {
			$id_user			= 	$this->input->post('id_user');
			redirect('Ppk_C/view_detail_per_user/'.$id_user);
		}
		else{
			$data['heading']	= "Tidak ada form data yang di POST";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Ppk_C/view_id'>Input id pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	// untuk menambah  kondisi yang dimiliki seorang pasien. pada halaman log_pengobatan
	public function handle_add_kondisi()
	{
		$dataAdd		=	array(
									"id_user"				=>	$this->input->post('id_user'),
									"id_master_kondisi"		=>	$this->input->post('id_master_kondisi'),
									"detail_kondisi"		=>	$this->input->post('detail_kondisi'),
									"tanggal_ditambahkan"	=>	$this->input->post('tanggal'),
									"status"				=>	$this->input->post('status')
							);
		// cari apakah ada record kondisi. jika sudah, jangan masukkan ke dalam database
		$dataCondition	=	array(
									"id_user"			=> $dataAdd['id_user'],
									"detail_kondisi"	=> $dataAdd['detail_kondisi']
							);
		$result 		= 	$this->SO_M->read('kondisi',$dataCondition);

		// var_dump($result);
		// jika belum ada di tabel kondisi
		if ($result->num_rows() == 0) {
			$result 	=	$this->SO_M->create('kondisi',$dataAdd);
			$results	=	json_decode($result,true);
			if ($results['status']) {
				echo "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> Create kondisi <strong>berhasil!</strong></div>";
			}
			else{
				echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> Gagal! </strong> Tidak ada data yang masuk pada tabel kondisi</div>";
			}
		}
		else{
			echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> Duplikasi! </strong> Tidak ada data yang masuk pada tabel kondisi</div>";
		}
	}

	// untuk menghapus kondisi seorang pasien pada tabel konisi
	public function handle_delete_kondisi()
	{
		$dataCondition['id_kondisi'] 	=	 $this->input->post('id_kondisi');

		$result 						=	$this->SO_M->delete('kondisi',$dataCondition);
		if ($result) {
			echo "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus</div>";
		}else{
			echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> Gagal! </strong> Tidak ada data yang dihapus pada tabel kondisi</div>";
		}
	}

	// digunakan untuk handle ajax form eddit kondisi
	public function handle_update_kondisi()
	{
		$dataCondition			=	array(
										"id_user"				=>	$this->input->post('id_user'),
										"detail_kondisi"		=>	$this->input->post('detail_kondisi'),
										'id_kondisi !='			=>	$this->input->post('id_kondisi')
									);

		// var_dump($dataCondition);
		$result 				= 	$this->SO_M->read('kondisi',$dataCondition)->result();
		// cek apakah seorang pasien telah memiliki kondisi tersebut
		// jika belum, maka ambil inputan tadi, lalu tambahkan ke tabel kondisi
		if ($result == array()) {
			$dataUpdate			=	array(
											"id_master_kondisi" 	=>$this->input->post('id_master_kondisi'),
											"detail_kondisi"		=>$dataCondition['detail_kondisi'],
											"tanggal_ditambahkan"	=>$this->input->post("tanggal"),
											"status"				=>$this->input->post("status")
									);

			unset($dataCondition);
			$dataCondition['id_kondisi']	=	$this->input->post('id_kondisi');
			$result 		=	$this->SO_M->update('kondisi',$dataCondition,$dataUpdate);
			$results		=	json_decode($result,true);
			if ($results['status']) {
				echo "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data kondisi pasien telah ditambhakan</div>";
			}
			else{
				var_dump($results);
				echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data kondisi gagal dimasukkan ke database</div>";
			}
		}
		else{
		// 	echo "stringo";
			echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> Duplikasi! </strong> Kondisi seorang pasien tersebut telah telah didefinisikan</div>";
		}
		// echo "<pre>";
		// var_dump($dataCondition);
		// var_dump($dataUpdate);
		// echo "</pre>";
	}

	// dapatkan suatu kondisi seseorang. fungsi ini diguankan saat modal edit kondisi dipanggil
	public function get_kondisi($id_kondisi)
	{
		$dataCondition['id_kondisi']	= 	$id_kondisi;
		$result 						=	$this->SO_M->read('kondisi',$dataCondition)->result();
		echo json_encode($result);
	}

	// untuk handle delete log pengobatan seorang user pada halam log pengobatan setiap user. dipanggil oleh ajax pada halaman tersebut
	public function handle_delete_log()
	{
		$dataCondition['id_log'] 	= 	$this->input->post('id_log');
		$result						= 	$this->SO_M->delete('log_pengobatan',$dataCondition);
		if ($result == true) {
			echo "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> Hapus data pada log_pengobatan <strong>berhasil!</strong></div>";
		}else{
			echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> Hapus data pada log_pengobatan<strong> gagal! </strong></div>";
		}
	}
}