<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
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
	public function view_detail_per_log($nomor_identitas,$id_log)
	{
		$dataCondition['id_log'] 	=	$id_log;
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
		$dataCol					=	array('tanggal');
		$data['log_pengobatan']		=	$this->SO_M->readCol('log_pengobatan',$dataCondition,$dataCol)->result();

		unset($dataCondition['id_log']);

		// data user didapatkan untuk menu side bar :D
		$dataCondition['nomor_identitas']	=	$nomor_identitas;
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
		$data['obat'] 				=	$this->SO_M->read('master_obat',$dataCondition)->result();
		
		// ambil data catatan yang terdapat pada suatu obat
		$data['catatan_obat'] 		=	$this->SO_M->read('catatan_obat',$dataCondition)->result();

		// ambil kontra berdsarkan id obat
		$dataCondition['tipe'] 		=	'kontraindikasi';
		$data['kontraindikasi_obat']=	$this->SO_M->read('karakteristik_obat',$dataCondition)->result();

		// ambil indikasi
		$dataCondition['tipe'] 		=	'indikasi';
		$data['indikasi_obat']		=	$this->SO_M->read('karakteristik_obat',$dataCondition)->result();

		// ambil peringatan
		$dataCondition['tipe'] 		=	'peringatan';
		$data['peringatan_obat']	=	$this->SO_M->read('karakteristik_obat',$dataCondition)->result();

		// render di karakteristik_obat
		$this->load->view('html/header');
		$this->load->view('ppk/obat_per_log',$data);
		$this->load->view('html/footer');
	}

	// URL untuk masuk ke input gejala yang dialami oleh pasien
	public function view_gejala($nomor_identitas)
	{
		$dataWhere			=	array('nomor_identitas' => $nomor_identitas);
		$query				=	$this->SO_M->read('user',$dataWhere);
		$results			=	$query->result();
		if($query->num_rows() != 0){
			$data['user'] 	=	$results;
			$data['gejala']	=	$this->SO_M->readS('master_gejala')->result();
			$this->load->view('html/header');
			$this->load->view('ppk/form_gejala',$data);
			$this->load->view('html/sidebar-kanan',$data);
			$this->load->view('html/footer');
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Ppk_C/view_id'>Input id pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	public function view_hasil($nomor_identitas)
	{
		$dataWhere	=	array('nomor_identitas' => $nomor_identitas);
		$query		=	$this->SO_M->read('user',$dataWhere);
		if ($query->num_rows() != 0) {
			if ($this->input->post() !== NULL) {
				$gejalas = $this->input->post('gejala[]');
			}
			$data['user']	=	$query->result();
			$data['gejalas']=	$gejalas;
			$kirim = json_encode($data);
			$this->load->view('html/header');
			$this->load->view('ppk/hasil',$kirim);
			$this->load->view('html/footer');
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Akun_C/view_registered_user'>Cari identitas pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	public function get_hasil($nomor_identitas)
	{
		if ($this->input->post() != null) {
			$gejalas	=	$this->input->post('gejala[]');
			$where = "tipe = 'indikasi' AND (detail_tipe = ";
			$i = 1;
			foreach ($gejalas as $key => $value) {
				if ($i < sizeof($gejalas)) {
					$where .= "'".$value."' OR detail_tipe =";
				}else{
					$where .= "'".$value."')";
				}
				$i++;
			}
			$this->db->select('karakteristik_obat.id_obat , master_obat.nama_obat');
			$this->db->distinct();
			$this->db->where($where);
			$this->db->join('master_obat','karakteristik_obat.id_obat = master_obat.id_obat','inner');
			$querys = $this->db->get('karakteristik_obat');
			unset($where);
			$dataWhere = array('id_user' => $data['user'][0]->id_user);
			$kondisiPasien = $this->SO_M->read('kondisi',$dataWhere)->result_array();
			unset($dataWhere);
			$query = $querys->result();
			$data['obat'] = $query;
			for ($i=0; $i < ($querys->num_rows()) ; $i++) { 
				$dataWhere			=	array(	'tipe' => 'indikasi',	'id_obat' => $query[$i]->id_obat	);
				$dataIndikasi		=	$this->SO_M->read('karakteristik_obat',$dataWhere)->result();
				foreach ($dataIndikasi as $key => $value) {
					if (in_array($dataIndikasi[$key]->detail_tipe,$gejalas)) {
						$data['obat'][$i]->karakteristik['indikasi']['ada'][] = array(	'id_karakteristik'	=>	$dataIndikasi[$key]->id_karakteristik,'detail_tipe'		=>	$dataIndikasi[$key]->detail_tipe	);
					}else{
						$data['obat'][$i]->karakteristik['indikasi']['tanya'][] = array('id_karakteristik'	=>	$dataIndikasi[$key]->id_karakteristik,'detail_tipe'		=>	$dataIndikasi[$key]->detail_tipe	);
					}
				}
				$dataWhere			=	array(	'tipe' => 'kontraindikasi',	'id_obat' => $query[$i]->id_obat);
				$dataKontraindikasi	= $this->SO_M->read('karakteristik_obat',$dataWhere)->result();
				foreach ($dataKontraindikasi as $key => $value) {
					if ($this->in_array_r($dataKontraindikasi[$key]->detail_tipe,$kondisiPasien)) {
						$data['obat'][$i]->karakteristik['kontraindikasi']['ada'][] = array(	'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe	);
					}else{
						$data['obat'][$i]->karakteristik['kontraindikasi']['tanya'][] = array( 'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe);
					}
				}
				$dataWhere			=	array('tipe' => 'peringatan','id_obat' => $query[$i]->id_obat);
				$dataPeringatan		= $this->SO_M->read('karakteristik_obat',$dataWhere)->result();
				foreach ($dataPeringatan as $key => $value) {
					if ($this->in_array_r($dataPeringatan[$key]->detail_tipe,$kondisiPasien)) {
						$data['obat'][$i]->karakteristik['peringatan']['ada'][] = array('id_karakteristik'	=>	$dataPeringatan[$key]->id_karakteristik,'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe);
					}else{
						$data['obat'][$i]->karakteristik['peringatan']['tanya'][] = array('id_karakteristik'	=>	$dataPeringatan[$key]->id_karakteristik,'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe);
					}
				}
			}
			echo json_encode($data);
			return true;
			
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Ppk_C/view_gejala/".$data['user'][0]->nomor_identitas."'>Masukkan gejala yang dirasakan pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	// halaman untuk "checkout" keranjang obat
	public function view_resep()
	{
		$this->load->view('html/header');
		$this->load->view('ppk/resep');
		$this->load->view('html/sidebar-kanan');
		$this->load->view('html/footer');
	}

	// untuk menangani submit form pada view_id yang berisi nomor identitas pasien. function ini menghasilkan daftar kondisi yang dimiliki oleh seorang pasien
	public function view_detail_user($nomor_identitas)
	{
		$dataWhere			=	array('nomor_identitas' => $nomor_identitas);
		$query				=	$this->SO_M->read('user',$dataWhere);
		$results			=	$query->result();
		if($query->num_rows() != 0){
			$data['user']				=	$results;
			unset($dataWhere);
			$dataWhere					=	array('id_user' => $results[0]->id_user);
			$data['log_pengobatan']		=	$this->SO_M->read('log_pengobatan',$dataWhere)->result();

			$dataCondition				=	array();
			$dataCol					=	array('id_master_kondisi AS id','detail_kondisi AS text');
			$data['master_kondisi']		=	$this->SO_M->readCol('master_kondisi',$dataCondition,$dataCol)->result();

			$this->load->view('html/header');
			$this->load->view('ppk/log_pengobatan',$data);
			$this->load->view('html/footer');
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Ppk_C/view_id'>Input id pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
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
			alert('','success','Berhasil','Data telah dihapus dari tabel log_pengobatan',false);
		}else{
			alert('','danger','Gagal','Data gagal dihapus dari tabel log_pengobatan',false);
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
				alert('','success','Berhasil','Data telah dimasukkan ke tabel kondisi',false);
			}
			else{
				alert('','danger','Gagal','Tidak ada data yang masuk pada tabel kondisi',false);
			}
		}
		else{
			alert('','danger','Gagal','Tidak ada data yang masuk pada tabel kondisi',false);
		}
	}

	// untuk menghapus kondisi seorang pasien pada tabel konisi
	public function handle_delete_kondisi()
	{
		$dataCondition['id_kondisi'] 	=	 $this->input->post('id_kondisi');
		$result 						=	$this->SO_M->delete('kondisi',$dataCondition);
		if ($result) {
			alert('','success','Berhasil','Data telah dihapus dari tabel kondisi',false);
		}else{
			alert('','danger','Gagal','Tidak ada data yang dihapus pada tabel kondisi',false);
		}
	}

	// digunakan untuk handle ajax form eddit kondisi
	public function handle_update_kondisi()
	{
		$dataCondition			=	array(
										"id_user"				=>	$this->input->post('id_user'),
										"detail_kondisi"		=>	$this->input->post('detail_kondisi')
										// 'id_kondisi'			=>	$this->input->post('id_kondisi')
									);
		// var_dump($dataCondition);
		$result 				= 	$this->SO_M->read('kondisi',$dataCondition);
		// cek apakah seorang pasien telah memiliki kondisi tersebut
		// jika belum, maka ambil inputan tadi, lalu tambahkan ke tabel kondisi
		if ($result->num_rows() == 0) {
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
				alert('','success','Berhasil','Data telah ditambahkan ke tabel kondisi',false);
			}
			else{
				alert('','danger','Gagal','Tidak ada data yang diperbarui pada tabel kondisi',false);
				var_dump($results);
			}
		}
		else{
			alert('','warning','Peringatan','Data tersebut mengalami duplikasi',false);
		}
	}

	// finding values between multidimensional array. paste from https://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array
	// usage :
	// $b = array(array("Mac", "NT"), array("Irix", "Linux"));
	// echo in_array_r("Irix", $b) ? 'found' : 'not found';
	public function in_array_r($needle, $haystack, $strict = false) {
		foreach ($haystack as $item) {
			// echo "<br>|---------------| <br>";
			// var_dump($item);
			// echo "-----<br>";
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
				return true;
			}
		}
		return false;
	}
}



	/*detai per user dari menu registered user. untuk yang dari halaman pemeriksaan di handle oleh function handle_form_id pada kontroller ini. beda function, fungsinya sama*/
	// public function view_detail_log_per_user($id_user)
	// {
	// 	/*untuk aksi pada tombol detail user dari datatable registered user pada halaman registered user*/
	// 	$dataCondition['id_user']	=	$id_user;
	// 	$dataCol					=	array('id_user','nama_user','nomor_identitas','no_hp','link_foto');
		
	// 	// cari informasi identitas user
	// 	$data['user']				=	$this->SO_M->readCol('user',$dataCondition,$dataCol)->result();

	// 	// cari log pengobatan
	// 	$data['log_pengobatan']		=	$this->SO_M->read('log_pengobatan',$dataCondition)->result();

	// 	// dapatkan seluruh data pada master_kondisi untuk dijadikan selcet elemen'
	// 	unset($dataCol,$dataCondition);
	// 	$dataCondition				=	array();
	// 	$dataCol					=	array('id_master_kondisi AS id','detail_kondisi AS text');
	// 	$data['master_kondisi']		=	$this->SO_M->readCol('master_kondisi',$dataCondition,$dataCol)->result();

	// 	$this->load->view('html/header');
	// 	$this->load->view('ppk/log_pengobatan',$data);
	// 	$this->load->view('html/footer');	
	// }