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
		
		$data['log_pengobatan']		=	$this->SO_M->readCol('log_pengobatan',array('id_log'=>$id_log),array('tanggal'))->result();

		$data['kondisi_per_log']	=	$this->SO_M->readCol('kondisi_log',array('id_log'=>$id_log,'status'=>0),array('detail_kondisi','status'))->result();

		$data['pesan_per_log']		=	$this->SO_M->read('pesan_log',array('id_log'=>$id_log))->result();

		// cari informasi identitas user
		$data['user']				=	$this->SO_M->readCol('user',array('nomor_identitas'=>$nomor_identitas),array('id_user','nama_user','nomor_identitas','no_hp','link_foto','tanggal_lahir'))->result();

		$today = new DateTime();
		$tanggal_lahir = new DateTime($data['user'][0]->tanggal_lahir);
		
		$data['umur'] = $today->diff($tanggal_lahir);

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
			$today = new DateTime();
			$tanggal_lahir = new DateTime($data['user'][0]->tanggal_lahir);
			$data['umur'] = $today->diff($tanggal_lahir);
			$data['gejala']	=	$this->SO_M->readS('master_gejala')->result();
			$this->load->view('html/header');
			$this->load->view('ppk/form_gejala',$data);
			$this->load->view('html/footer');
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Ppk_C/view_id'>Input id pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	// untuk tampilkan form bagian atas pada halaman hasil, isi formnya berua inputan gejala
	public function view_hasil($nomor_identitas)
	{
		$dataWhere	=	array('nomor_identitas' => $nomor_identitas);
		$dataCol	=	array('id_user','nama_user','nomor_identitas','tanggal_lahir','alamat','akses','no_hp','link_foto');
		$query		=	$this->SO_M->readCol('user',$dataWhere,$dataCol);
		if ($query->num_rows() != 0) {
			if ($this->input->post() !== NULL) {
				$gejalas 				=	$this->input->post('gejala[]');
				$data['gejala_master']	=	$this->SO_M->readS('master_gejala')->result();
				$data['user']			=	$query->result();
				$today 					=	new DateTime();
				$tanggal_lahir 			=	new DateTime($data['user'][0]->tanggal_lahir);
				
				$data['umur'] 			=	$today->diff($tanggal_lahir);
				$data['gejala_pasien']	=	json_encode($gejalas);
				$kirim['data'] 			=	json_encode($data);
				$this->load->view('html/header');
				$this->load->view('ppk/hasil',$kirim);
				$this->load->view('html/footer');
			}
			else{
				$data['heading']	= "Tidak ada form data yang di POST";
				$data['message']	= "<p>Coba inputkan gejala <a href='".base_url()."Ppk_C/view_gejala/$nomor_identitas'>lagi</a> </p>";
				$this->load->view('errors/html/error_general',$data);
			}
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Akun_C/view_registered_user'>Cari identitas pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	// untuk tampilan input gejala tok, ini dipanggil setelah masukkan identitas pasien
	public function handle_view_id()
	{
		if ($this->input->post() != null) {
			redirect('Ppk_C/view_detail_user/'.$this->input->post('nomor_identitas'));
		}
	}

	// metode untuk dari input gejala ek tampilan list obat sesuai gejala. untuk yang dari list sesuai gejala ke dafatar peresepan obat ada di function cari_hasil_
	public function cari_hasil($nomor_identitas)
	{
		$dataWhere		=	array('nomor_identitas' => $nomor_identitas);
		$dataCol		=	array('id_user');
		$data['user']	=	$this->SO_M->readCol('user',$dataWhere,$dataCol)->result();

		if ($this->input->post()!= NULL) {
			$gejalas	=	$this->input->post('gejala[]');
			// $data['gejala'] = $gejalas;

			// var_dump($data);die();

			// parameter untuk cari indikasi suatu obat yang cocok
			$where = "tipe = 'indikasi' AND (id_tipe_master = ";
			$i = 1;

			// parameter untuk cari log_pengobatan dengan gejala yang mirip
			$where_ = "gejala_log.id_gejala = ";
			// generate where parameter untuk dikirim ke join dan generate where_ parameter untuk cari log pengobatan dengan gejala yang mirip
			foreach ($gejalas as $key => $value) {
				if ($i < sizeof($gejalas)) {
					$where	.=	"'".$value."' OR id_tipe_master =";
					$where_	.=	"'".$value."' OR gejala_log.id_gejala=";
				}else{
					$where	.= "'".$value."')";
					$where_	.= "'".$value."'";
				}
				$i++;
			}

			// cari obat (id_obat dan nama obatnya nya) yang sesuai gejala
			$this->db->select('karakteristik_obat.id_obat , master_obat.nama_obat');
			$this->db->distinct();
			$this->db->where($where);
			$this->db->join('master_obat','karakteristik_obat.id_obat = master_obat.id_obat','inner');
			$querys = $this->db->get('karakteristik_obat');
			
			unset($where,$dataWhere);

			// cari log pengobatan dengan gejala yang mirip dengan masukan
			$this->db->select('gejala_log.id_log , log_pengobatan.tanggal');
			$this->db->where($where_);
			$this->db->order_by('tanggal', 'ASC');
			$this->db->join('log_pengobatan','gejala_log.id_log = log_pengobatan.id_log','inner');
			$query = $this->db->get('gejala_log')->result();

			// data log pengobatan ang mirip dengan gejala inputan
			$data['histori'] = array();
			foreach ($query as $key => $value) {
				if (!isset($data['histori'][$value->id_log])) {
					$data['histori'][$value->id_log] = array('banyak' => 1, 'tanggal' => $value->tanggal);
				}else{
					$data['histori'][$value->id_log]['banyak'] = $data['histori'][$value->id_log]['banyak'] + 1;
				}
			}

			unset($query);

			// masukkan data ke tabel wm_gejala
			for ($i=0; $i < sizeof($gejalas) ; $i++) { 
				$result = $this->SO_M->readCol('wm_gejala',array('id_gejala'=>$gejalas[$i],'id_user'=>$data['user'][0]->id_user),'id_wm_gejala');
				if ($result->num_rows() == 0) {
					$result = $this->SO_M->readCol('master_gejala',array('id_gejala'=>$gejalas[$i]),'detail_gejala')->result_array();
					$result = $this->SO_M->create('wm_gejala',array('id_user'=>$data['user'][0]->id_user,'id_gejala'=>$gejalas[$i],'detail_gejala'=>$result[0]['detail_gejala']));
				}
			}

			// cari apa saja kondisi (rekam medis) pasien
			$dataWhere = array(
								'id_user'	=>	$data['user'][0]->id_user,
								'status'	=>	'0'
							);
			$kondisiPasienMengidap = $this->SO_M->readCol('kondisi',$dataWhere,array('id_master_kondisi','id_user','detail_kondisi','status'))->result_array();
			$data['kondisiPasienMengidap'] = $kondisiPasienMengidap;
			
			$dataWhere['status'] = '1';
			$kondisiPasienAman = $this->SO_M->readCol('kondisi',$dataWhere,array('id_master_kondisi','id_user','detail_kondisi','status'))->result_array();
			unset($dataWhere);
			$data['kondisiPasienAman'] = $kondisiPasienAman;

			for ($i=0; $i < sizeof($kondisiPasienMengidap) ; $i++) { 
				$result = $this->SO_M->readCol('wm_kondisi',array('id_user'=>$data['user'][0]->id_user,'id_master_kondisi'=>$kondisiPasienMengidap[$i]['id_master_kondisi'],'detail_kondisi'=>$kondisiPasienMengidap[$i]['detail_kondisi']),'id_wm_kondisi');
				if ($result->num_rows()==0) {
					$result = $this->SO_M->create('wm_kondisi',$kondisiPasienMengidap[$i]);
				}
			}
			for ($i=0; $i < sizeof($kondisiPasienAman) ; $i++) { 
				$result = $this->SO_M->readCol('wm_kondisi',array('id_user'=>$data['user'][0]->id_user,'id_master_kondisi'=>$kondisiPasienAman[$i]['id_master_kondisi'],'detail_kondisi'=>$kondisiPasienAman[$i]['detail_kondisi']),'id_wm_kondisi');
				if ($result->num_rows()==0) {
					$result = $this->SO_M->create('wm_kondisi',$kondisiPasienAman[$i]);
				}
			}


			// result dari query cari obat yang sesuai gejala
			$query = $querys->result();
			$data['obat'] = $query;

			
			for ($i=0; $i < ($querys->num_rows()) ; $i++) {
				$dataWhere			=	array(	'tipe' => 'indikasi',	'id_obat' => $query[$i]->id_obat	);
				$dataIndikasi		=	$this->SO_M->read('karakteristik_obat',$dataWhere)->result();

				/*untuk sorting berdsarakan indikasi terbanyak*/
				$data['obat'][$i]->Iada = 0;
				$data['obat'][$i]->Itanya = 0;
				$data['obat'][$i]->Kada = 0;
				$data['obat'][$i]->Ktanya = 0;
				$data['obat'][$i]->Pada = 0;
				$data['obat'][$i]->Ptanya = 0;
				/*END inisialisasi untuk sorting berdsarakan indikasi terbanyak*/

				// kalau sudah ada di wm_obat, tombol masukkan wm diganti hapus, kalau belum diganti masukkan
				if ($this->SO_M->read('wm_obat',array('id_obat'=>$query[$i]->id_obat))->num_rows() == 0){
					$data['obat'][$i]->wm_obat = 'belum';
				}else{
					$data['obat'][$i]->wm_obat = 'sudah';
				}

				foreach ($dataIndikasi as $key => $value) {
					if (in_array($dataIndikasi[$key]->id_tipe_master,$gejalas)) {
						$data['obat'][$i]->karakteristik['indikasi']['ada'][] = array('id_karakteristik'=>	$dataIndikasi[$key]->id_karakteristik, 'id_tipe_master' => $dataIndikasi[$key]->id_tipe_master,'detail_tipe'		=>	$dataIndikasi[$key]->detail_tipe	);
						$data['obat'][$i]->Iada += 1;
					}else{
						$data['obat'][$i]->karakteristik['indikasi']['tanya'][] = array('id_karakteristik'=>	$dataIndikasi[$key]->id_karakteristik, 'id_tipe_master' => $dataIndikasi[$key]->id_tipe_master,'detail_tipe'		=>	$dataIndikasi[$key]->detail_tipe	);
						$data['obat'][$i]->Itanya += 1;
					}
				}
				
				$dataWhere			=	array('tipe' => 'peringatan','id_obat' => $query[$i]->id_obat);
				$dataPeringatan		= $this->SO_M->read('karakteristik_obat',$dataWhere)->result();

				foreach ($dataPeringatan as $key => $value) {
					if ($this->in_array_r($dataPeringatan[$key]->id_tipe_master,$kondisiPasienMengidap)) {
						$data['obat'][$i]->karakteristik['peringatan']['ada'][] = array('id_karakteristik'	=>	$dataPeringatan[$key]->id_karakteristik,'id_tipe_master' => $dataPeringatan[$key]->id_tipe_master,'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe);
						$data['obat'][$i]->Pada += 1;
					}elseif ($this->in_array_r($dataPeringatan[$key]->id_tipe_master,$kondisiPasienAman)) {
						$data['obat'][$i]->karakteristik['peringatan']['aman'][] = array('id_karakteristik'	=>	$dataPeringatan[$key]->id_karakteristik,'id_tipe_master' => $dataPeringatan[$key]->id_tipe_master,'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe);
					}
					else{
						$data['obat'][$i]->karakteristik['peringatan']['tanya'][] = array('id_karakteristik'=>	$dataPeringatan[$key]->id_karakteristik,'id_tipe_master' => $dataPeringatan[$key]->id_tipe_master,'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe);
						$data['obat'][$i]->Ptanya += 1;
					}
				}
				
				$dataWhere			= array(	'tipe' => 'kontraindikasi',	'id_obat' => $query[$i]->id_obat);
				$dataKontraindikasi	= $this->SO_M->read('karakteristik_obat',$dataWhere)->result();
				// var_dump($kondisiPasienMengidap);
				// var_dump($dataKontraindikasi);die();
				foreach ($dataKontraindikasi as $key => $value) {
					if ($this->in_array_r($dataKontraindikasi[$key]->id_tipe_master,$kondisiPasienMengidap)) {
						$data['obat'][$i]->karakteristik['kontraindikasi']['ada'][] = array(	'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,'id_tipe_master' => $dataKontraindikasi[$key]->id_tipe_master,'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe	);
						$data['obat'][$i]->Kada += 1;
					}elseif ($this->in_array_r($dataKontraindikasi[$key]->id_tipe_master,$kondisiPasienAman)) {
						$data['obat'][$i]->karakteristik['kontraindikasi']['aman'][] = array(	'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,'id_tipe_master' => $dataKontraindikasi[$key]->id_tipe_master,'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe	);
					}else{
						$data['obat'][$i]->karakteristik['kontraindikasi']['tanya'][] = array( 'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,'id_tipe_master' => $dataKontraindikasi[$key]->id_tipe_master,'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe);
						$data['obat'][$i]->Ktanya += 1;
					}
				}
				// dapatkan catatan obat yang terdapat pada database 
				$result = $this->SO_M->read('catatan_obat',array('id_obat'=>$query[$i]->id_obat))->result();
				$data['obat'][$i]->catatan_obat = $result[0]->catatan;
			}
			// var_dump($data);die();


			// sorting indikasi dari tinggi ke rendah
			$maxIfounded;
			for ($i=0; $i < sizeof($data['obat']); $i++) {
				for ($j=0; $j < sizeof($data['obat'])-1 ; $j++) {
					if ($data['obat'][$j]->Iada < $data['obat'][$j+1]->Iada) {
						// var_dump($data['obat'][$j]->Iada);
						$temp = $data['obat'][$j];
						$data['obat'][$j] = $data['obat'][$j+1];
						$data['obat'][$j+1] = $temp;
					}
				}
			}
			
			$maxIfounded = $data['obat'][0]->Iada;
			// echo $maxIfounded;
			for ($i=0; $i < sizeof($data['obat']); $i++) { 
				if ($data['obat'][$i]->Iada == $maxIfounded) {
					for ($j=0; $j < sizeof($data['obat'])-1 ; $j++) { 
						if ($data['obat'][$j]->Pada > $data['obat'][$j+1]->Pada ) {
							$temp = $data['obat'][$j];
							$data['obat'][$j] = $data['obat'][$j+1];
							$data['obat'][$j+1] = $temp;
						}
					}
				}
			}
			
			$minPfounded = $data['obat'][0]->Pada;
			for ($i=0; $i < sizeof($data['obat']); $i++) { 
				if ($data['obat'][$i]->Iada == $maxIfounded) {
					if ($data['obat'][$i]->Pada == $minPfounded) {
						for ($j=0; $j < sizeof($data['obat'])-1 ; $j++) { 
							if ($data['obat'][$j]->Kada > $data['obat'][$j+1]->Kada ) {
								// echo $data['obat'][$j]->Kada." | ";
								$temp = $data['obat'][$j];
								$data['obat'][$j] = $data['obat'][$j+1];
								$data['obat'][$j+1] = $temp;
							}
						}
					}
				}
			}
			echo json_encode($data);
		}else{
			$data = array('status' => false,'message' => 'tidak ada data yang di post');
			echo json_encode($data);
		}
	}

	// untuk koreksi inputan mana saja yang belum diobati
	public function koreksi_gejala($id_user)
	{
		$result = $this->SO_M->readCol('wm_obat',array('id_pasien'=>$id_user),'id_obat');
		if ($result->num_rows() != 0 ) {
			
			// dapatkan data dari tabel wm_gejala
			$gejala 		=	$this->SO_M->readCol('wm_gejala',array('id_user'=>$id_user),array('id_gejala','detail_gejala'))->result_array();
			$data['gejala'] = $gejala;
			foreach ($gejala as $key => $value) {
				$gejala[$key] = $gejala[$key]['id_gejala'];
			}

			// baca apa saja obat yang ada di daftar resep, baca idnya untuk mendapatkan karakteristiknya dan sekalian generate where untuk cari karakteristik tersebut
			$result = $result->result_array();
			$where = 'master_obat.id_obat = ';
			foreach ($result as $key => $value) {
				$result[$key] = $result[$key]['id_obat'];
				if ($key == (sizeof($result)-1)) {
					$where .= $result[$key];
				}else{
					$where .= $result[$key]." OR master_obat.id_obat = ";
				}
			}

			// cari obat (id_obat dan nama obatnya nya) yang sesuai id $where
			$this->db->select('karakteristik_obat.id_obat , master_obat.nama_obat');
			$this->db->distinct();
			$this->db->where($where);
			$this->db->join('master_obat','karakteristik_obat.id_obat = master_obat.id_obat','inner');
			$querys = $this->db->get('karakteristik_obat');
			
			// koreksi masing2 karakteristik obat pada wm_obat
			$data['obat'] = $querys->result();

			// manipulasi array
			for ($i=0; $i < $querys->num_rows() ; $i++){
				// $dataindikasi menyimpan apa saja indikasi yang dimilikisuatu obat
				$dataIndikasi		=	$this->SO_M->read('karakteristik_obat',array('tipe'=>'indikasi','id_obat'=>$data['obat'][$i]->id_obat))->result();
				foreach ($dataIndikasi as $key => $value) {
					
					// apakah sebuah indikasi ada pada array gejala
					if (in_array($dataIndikasi[$key]->id_tipe_master,$gejala)) {
						
						// return index dari sebuah pencarian elemen pada array gejala
						$key_search = array_search($dataIndikasi[$key]->id_tipe_master, $gejala);

						// kalau belum ada, buat index terobati dengan isi sudah
						// kalau sudah ada, pasti isi terobati adalah sudah, maka dari itu harus diganti ke ganda untuk pemeriksaan 2 obat untuk 1 penyakit
						if (!array_key_exists('terobati', $data['gejala'][$key_search])) {
							$data['gejala'][$key_search]['terobati'] = 'sudah';
						}else{
							if ($data['gejala'][$key_search]['terobati'] == 'sudah') {
								$data['gejala'][$key_search]['terobati'] = 'ganda';
							}
						}
					}
				}
			}
			echo json_encode($data);
		}
	}

	// // halaman untuk "checkout" keranjang obat
	// public function view_resep()
	// {
	// 	$this->load->view('html/header');
	// 	$this->load->view('ppk/resep');
	// 	$this->load->view('html/sidebar-kanan');
	// 	$this->load->view('html/footer');
	// }

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
			$today = new DateTime();
			$tanggal_lahir = new DateTime($data['user'][0]->tanggal_lahir);
			
			$data['umur'] = $today->diff($tanggal_lahir);

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

	// untuk handle kontraindikasi dan peringatan yang belum pernah diketeahui faktanya. ini dipanggil pada modal editkondisi. jadi tanpa masuk menu add kondisi terlebih dahulu
	public function cek_kondisi($id_master_kondisi)
	{
		$result 						=	$this->SO_M->readCol('master_kondisi',array('id_master_kondisi' => $id_master_kondisi),'detail_kondisi')->result();
		echo json_encode($result);	
	}

	// untuk handle delete log pengobatan seorang user pada halam log pengobatan setiap user. dipanggil oleh ajax pada halaman tersebut
	public function handle_delete_log()
	{
		$dataCondition['id_log'] 	= 	$this->input->post('id_log');
		$result						= 	$this->SO_M->delete('log_pengobatan',$dataCondition);
		$this->SO_M->delete('obat_log',array('id_log'=>$dataCondition['id_log']));
		$this->SO_M->delete('gejala_log',array('id_log'=>$dataCondition['id_log']));
		$this->SO_M->delete('kondisi_log',array('id_log'=>$dataCondition['id_log']));
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
			$results	=	json_decode($result);
			if ($results->status) {
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
		$dataUpdate			=	array(
										"id_master_kondisi" 	=>$this->input->post('id_master_kondisi'),
										"detail_kondisi"		=>$this->input->post('detail_kondisi'),
										"tanggal_ditambahkan"	=>$this->input->post("tanggal"),
										"status"				=>$this->input->post("status")
								);
		unset($dataCondition);
		$dataCondition['id_kondisi']	=	$this->input->post('id_kondisi');
		$result 		=	$this->SO_M->update('kondisi',$dataCondition,$dataUpdate);
		$results		=	json_decode($result);
		if ($results->status) {
			alert('','success','Berhasil','Data telah ditambahkan ke tabel kondisi',false);
		}
		else{
			alert('','danger','Gagal','Tidak ada data yang diperbarui pada tabel kondisi',false);
		}
	}

	// function untuk handle kondisi melalui hasil pencarian, agar tidak masuk ke menu add kondisi terlebih dahulu
	public function handle_add_kondisi_($ya_tidak,$alert = true)
	{
		$dataAdd		=	array(
									"id_user"				=>	$this->input->post('id_user'),
									"id_master_kondisi"		=>	$this->input->post('id_master_kondisi'),
									"detail_kondisi"		=>	$this->input->post('detail_kondisi'),
									"tanggal_ditambahkan"	=>	date('Y-m-d')
							);
		if ($ya_tidak == '1') {
			$dataAdd['status'] = 	1;
		}else{
			$dataAdd['status'] = 	0;
		}

		$result = $this->SO_M->read('kondisi',array('id_user'=>$dataAdd['id_user'],'id_master_kondisi'=>$dataAdd['id_master_kondisi']));
			if ($result->num_rows()==0) {
				
			$result 	=	$this->SO_M->create('kondisi',$dataAdd);
			$results	=	json_decode($result);
			if ($results->status) {
				if ($alert) {
					alert('','success','Berhasil','Data user telah dimasukkan ke tabel kondisi',false);
				}else{
					echo json_encode(array("id_user"=>$this->input->post('id_user'), "id_obat" => $this->input->post('id_obat')));
				}
			}
			else{
				if ($alert) {
					alert('','danger','Gagal','Tidak ada data user yang masuk pada tabel kondisi',false);
				}else{
					echo json_encode(array("id_user"=>$this->input->post('id_user'), "id_obat" => $this->input->post('id_obat')));
				}
			}
		}
	}

	// function ini digunakan untuk mendapatkan informasi kondisi seorang pasien. datanya ditampilkan pada sidebar kanan halaman hasil
	// true untuk return berupa json untuk ajax, false untuk return php array.
	public function get_col_kondisi($id_user,$type = true)
	{
		if ($type) {
			$result =  $this->SO_M->readCol('kondisi',array('id_user'=>$id_user),array('id_master_kondisi','detail_kondisi','status'))->result();
			echo json_encode($result);
		}else{
			$result =  $this->SO_M->readCol('kondisi',array('id_user'=>$id_user),array('id_master_kondisi','id_user','detail_kondisi','status'))->result_array();
			return $result;
		}
	}

	// function ini digunakan untuk mencari apa saja karakteristik suatu obat yang belum diketahui faktanya(kontraindikasi dan peringatan). daptkan karakteristik tanya.
	// trigger function ini ada di halaman hasil
	public function get_unknown_fact($id_user,$id_obat)
	{
		$data['kondisi']			= $this->SO_M->readCol('kondisi',array('id_user'=>$id_user),array('id_user','id_master_kondisi','detail_kondisi'))->result_array();
		$data['karakteristik_obat']	= $this->SO_M->readCol('karakteristik_obat',array('id_obat'=>$id_obat,'tipe !='=>'indikasi'),array('id_tipe_master','detail_tipe'))->result();

		// generate unknown_fact
		$data['unknown_fact'] = array();
		foreach ($data['karakteristik_obat'] as $key => $value) {
			if (!$this->in_array_r($data['karakteristik_obat'][$key]->id_tipe_master,$data['kondisi'])) {
				array_push($data['unknown_fact'], array( 'id_tipe_master'=>$value->id_tipe_master, 'detail_tipe'=>$value->detail_tipe));
			}
		}
		unset($data['kondisi'],$data['karakteristik_obat']);
		$data['id_user'] = array('id_user'=>$id_user);
		echo json_encode($data);
	}

	// finding values in multidimensional array. paste from https://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array
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

	// untuk masukkan data ke wm. function ini dipanggi lpada halaman hasi lsaat akan memberikan obat kedalam daftar peresepan obat.
	public function handle_insert_wm_obat()
	{
		if ($this->input->post() != null) {
			$id_obat		= $this->input->post('post_id_obat');
			$id_pasien		= $this->input->post('post_id_pasien');
			$id_dokter		= $this->input->post('post_id_dokter');
			$gejalas		= $this->input->post('post_gejala');

			$result = $this->SO_M->readCol('wm_obat',array('id_obat'=>$id_obat,'id_pasien'=>$id_pasien,'id_dokter'=>$id_dokter,'tanggal'=>date("Y-m-d")),'id_wm_obat');
			if ($result->num_rows() == 0) {
				$result = $this->SO_M->create('wm_obat',array('id_pasien'=>$id_pasien,'id_dokter'=>$id_dokter,'id_obat'=>$id_obat,'tanggal'=>date('Y-m-d')));
				$result = json_decode($result);
				if ($result->status) {
					alert('','success','Berhasil','Obat telah masuk dalam daftar peresepan',false);
				}else{
					alert('','warning','Peringatan','Obat telah masuk dalam daftar peresepan. Silahkan masuk ke daftar resep obat',false);
				}
			}else{
				alert('','warning','Peringatan','Obat telah masuk dalam daftar peresepan. Silahkan masuk ke daftar resep obat',false);
			}
			
			// masukkan data ke tabel wm_kondisi
			// $note_kondisi	= $this->get_col_kondisi($id_pasien,false);
			// for ($i=0; $i < sizeof($note_kondisi) ; $i++) { 
			// 	$result = $this->SO_M->readCol('wm_kondisi',array('id_user'=>$id_pasien,'id_master_kondisi'=>$note_kondisi[$i]['id_master_kondisi'],'detail_kondisi'=>$note_kondisi[$i]['detail_kondisi']),'id_wm_kondisi');
			// 	if ($result->num_rows()==0) {
			// 		$result = $this->SO_M->create('wm_kondisi',$note_kondisi[$i]);
			// 	}
			// }

			// var_dump($note_kondisi);
			// $this->SO_M->truncateTable('wm_kondisi');
			// var_dump($note_kondisi);
			// die();

			// masukkan data ke tabel wm_gejala
			// for ($i=0; $i < sizeof($gejalas) ; $i++) { 
			// 	$result = $this->SO_M->readCol('wm_gejala',array('id_gejala'=>$gejalas[$i],'id_user'=>$id_pasien),'id_wm_gejala');
			// 	if ($result->num_rows() == 0) {
			// 		$result = $this->SO_M->readCol('master_gejala',array('id_gejala'=>$gejalas[$i]),'detail_gejala')->result_array();
			// 		$result = $this->SO_M->create('wm_gejala',array('id_user'=>$id_pasien,'id_gejala'=>$gejalas[$i],'detail_gejala'=>$result[0]['detail_gejala']));
			// 	}
			// }

			// set gejala yang terobati dan belum terobati. saat ada gejala yang belum terobati, maka tombo peresepan akan didisable
			
		}else{
			alert('','warning','Peringatan','Nothing post',false);
		}
	}

	public function handle_delete_wm_obat()
	{
		if ($this->input->post() != null) {
			$id_obat		= $this->input->post('post_id_obat');
			$id_pasien		= $this->input->post('post_id_pasien');
			$id_dokter		= $this->input->post('post_id_dokter');
			if ($this->SO_M->delete('wm_obat',array('id_obat'=>$id_obat,'id_pasien'=>$id_pasien,'id_dokter'=>$id_dokter))) {
				alert('','success','Berhasil','Obat berhasi dihapus dari wm_obat',false);
			}
		}else{
			alert('','warning','Peringatan','Nothing post',false);
		}
	}

	public function view_resep_($nomor_identitas)
	{
		$dataWhere					=	array('nomor_identitas' =>$nomor_identitas);
		$dataCol					=	array('id_user','nama_user','nomor_identitas','tanggal_lahir','alamat','akses','no_hp','link_foto');
		$data['user']				=	$this->SO_M->readCol('user',$dataWhere,$dataCol);
		if ($data['user']->num_rows() == 1) {
			$data['user'] 			=	$data['user']->result();
			if ($this->SO_M->readCol('wm_obat',array('id_pasien'=>$data['user'][0]->id_user),'id_pasien')->num_rows() != 0) {
				$today 				=	new DateTime();
				$tanggal_lahir 		=	new DateTime($data['user'][0]->tanggal_lahir);
				$data['umur'] 		=	$today->diff($tanggal_lahir);
				$data['gejala']		=	$this->input->post('gejala[]');
				$kirim['data'] 		=	json_encode($data);
				$this->load->view('html/header');
				$this->load->view('ppk/resep',$kirim);
				$this->load->view('html/footer');
			}else{
				$this->SO_M->delete('wm_gejala',array('id_user'=>$data['user'][0]->id_user));
				$this->SO_M->delete('wm_kondisi',array('id_user'=>$data['user'][0]->id_user));
				$data['heading']	= "Data tidak ditemukan";
				$data['message']	= "<p>Belum ada obat yang diresepkan. Coba inputkan lagi gejala yang dirasakan pasien <a href='".base_url()."Ppk_C/view_gejala/".$data['user'][0]->nomor_identitas."'>disini</a> untuk memulai lagi alur pengobatan </p>";
				$this->load->view('errors/html/error_general',$data);
			}
		}else{
			$data['heading']	= "Data user tidak ditemukan";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Akun_C/view_registered_user'>Cari identitas pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}
	// untuk metode tapi yang dari halaman hasil ke halaman daftar peresepan obat
	public function cari_hasil_($nomor_identitas)
	{
		$dataWhere		=	array('nomor_identitas' => $nomor_identitas);
		$dataCol		=	array('id_user');
		$data['user']	=	$this->SO_M->readCol('user',$dataWhere,$dataCol);
		if ($data['user']->num_rows() == 1) {
			$data['user'] = $data['user']->result();
			if ($this->SO_M->readCol('wm_obat',array('id_pasien'=>$data['user'][0]->id_user),'id_pasien')->num_rows() != 0) {
				
				// dapatkan data dari tabel wm_gejala
				$gejala 		=	$this->SO_M->readCol('wm_gejala',array('id_user'=>$data['user'][0]->id_user),array('id_gejala','detail_gejala'))->result_array();
				$data['gejala'] = $gejala;
				foreach ($gejala as $key => $value) {
					$gejala[$key] = $gejala[$key]['id_gejala'];
				}

				// baca apa saja obat yang ada di daftar resep, baca idnya untuk mendapatkan karakteristiknya dan sekalian generate where untuk cari karakteristik tersebut
				$result = $this->SO_M->readCol('wm_obat',array('id_pasien'=>$data['user'][0]->id_user),'id_obat')->result_array();
				$where = 'master_obat.id_obat = ';
				foreach ($result as $key => $value) {
					$result[$key] = $result[$key]['id_obat'];
					if ($key == (sizeof($result)-1)) {
						$where .= $result[$key];
					}else{
						$where .= $result[$key]." OR master_obat.id_obat = ";
					}
				}

				// cari obat (id_obat dan nama obatnya nya) yang sesuai id $where
				$this->db->select('karakteristik_obat.id_obat , master_obat.nama_obat');
				$this->db->distinct();
				$this->db->where($where);
				$this->db->join('master_obat','karakteristik_obat.id_obat = master_obat.id_obat','inner');
				$querys = $this->db->get('karakteristik_obat');
				
				// dapatkan data kondisi pasien pada tabel wm_kondisi
				$kondisiPasienMengidap = $this->SO_M->readCol('wm_kondisi',array('id_user'=>$data['user'][0]->id_user,'status'=>0),'id_master_kondisi')->result_array();
				$data['kondisiPasienMengidap'] = $kondisiPasienMengidap;
				$kondisiPasienAman = $this->SO_M->readCol('wm_kondisi',array('id_user'=>$data['user'][0]->id_user,'status'=>1),'id_master_kondisi')->result_array();
				$data['kondisiPasienAman'] = $kondisiPasienAman;

				// koreksi masing2 karakteristik obat pada wm_obat
				$query = $querys->result();
				$data['obat'] = $query;

				// manipulasi array
				for ($i=0; $i < $querys->num_rows() ; $i++){
					// $dataindikasi menyimpan apa saja indikasi yang dimilikisuatu obat
					$dataWhere			=	array(	'tipe' => 'indikasi',	'id_obat' => $query[$i]->id_obat	);
					$dataIndikasi		=	$this->SO_M->read('karakteristik_obat',$dataWhere)->result();

					/*untuk sorting berdsarakan indikasi terbanyak*/
					$data['obat'][$i]->Iada = 0;
					$data['obat'][$i]->Itanya = 0;
					$data['obat'][$i]->Kada = 0;
					$data['obat'][$i]->Ktanya = 0;
					$data['obat'][$i]->Pada = 0;
					$data['obat'][$i]->Ptanya = 0;
					/*END untuk sorting berdsarakan indikasi terbanyak*/

					foreach ($dataIndikasi as $key => $value) {

						// jika suatu indikai obat cocok dengan gejala yang dirasakan pasien (ditemukan pada array $gejala), maka masukkan ke index ada
						// jika tidak ditemukan kecocokan gejala, masukkan ke index tanya
						if (in_array($dataIndikasi[$key]->id_tipe_master,$gejala)) {
							$data['obat'][$i]->karakteristik['indikasi']['ada'][] = array('id_karakteristik' => $dataIndikasi[$key]->id_karakteristik, 'id_tipe_master' => $dataIndikasi[$key]->id_tipe_master,'detail_tipe' => $dataIndikasi[$key]->detail_tipe);
							$data['obat'][$i]->Iada += 1;

							// return index dari sebuah pencarian elemen pada array
							$key_search = array_search($dataIndikasi[$key]->id_tipe_master, $gejala);

							// kalau belum ada, buat index terobati dengan isi sudah
							// kalau sudah ada, pasti isi terobati adalah sudah, maka dari itu harus diganti ke ganda untuk pemeriksaan 2 obat untuk 1 penyakit
							if (!array_key_exists('terobati', $data['gejala'][$key_search])) {
								$data['gejala'][$key_search]['terobati'] = 'sudah';
							}else{
								if ($data['gejala'][$key_search]['terobati'] == 'sudah') {
									$data['gejala'][$key_search]['terobati'] = 'ganda';
								}
							}
						}else{
							$data['obat'][$i]->karakteristik['indikasi']['tanya'][] = array('id_karakteristik' => $dataIndikasi[$key]->id_karakteristik, 'id_tipe_master' => $dataIndikasi[$key]->id_tipe_master,'detail_tipe' => $dataIndikasi[$key]->detail_tipe);
							$data['obat'][$i]->Itanya += 1;
						}
					}
					
					$dataWhere			=	array('tipe' => 'peringatan','id_obat' => $query[$i]->id_obat);
					$dataPeringatan		= $this->SO_M->read('karakteristik_obat',$dataWhere)->result();

					foreach ($dataPeringatan as $key => $value) {
						if ($this->in_array_r($dataPeringatan[$key]->id_tipe_master,$kondisiPasienMengidap)) {
							$data['obat'][$i]->karakteristik['peringatan']['ada'][] = array('id_karakteristik'	=>	$dataPeringatan[$key]->id_karakteristik,'id_tipe_master' => $dataPeringatan[$key]->id_tipe_master,'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe);
							$data['obat'][$i]->Pada += 1;
						}elseif ($this->in_array_r($dataPeringatan[$key]->id_tipe_master,$kondisiPasienAman)) {
							$data['obat'][$i]->karakteristik['peringatan']['aman'][] = array('id_karakteristik'	=>	$dataPeringatan[$key]->id_karakteristik,'id_tipe_master' => $dataPeringatan[$key]->id_tipe_master,'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe);
						}
						else{
							$data['obat'][$i]->karakteristik['peringatan']['tanya'][] = array('id_karakteristik'=>	$dataPeringatan[$key]->id_karakteristik,'id_tipe_master' => $dataPeringatan[$key]->id_tipe_master,'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe);
							$data['obat'][$i]->Ptanya += 1;
						}
					}
					
					$dataWhere			= array(	'tipe' => 'kontraindikasi',	'id_obat' => $query[$i]->id_obat);
					$dataKontraindikasi	= $this->SO_M->read('karakteristik_obat',$dataWhere)->result();
					// var_dump($kondisiPasienMengidap);
					// var_dump($dataKontraindikasi);die();
					foreach ($dataKontraindikasi as $key => $value) {
						if ($this->in_array_r($dataKontraindikasi[$key]->id_tipe_master,$kondisiPasienMengidap)) {
							$data['obat'][$i]->karakteristik['kontraindikasi']['ada'][] = array(	'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,'id_tipe_master' => $dataKontraindikasi[$key]->id_tipe_master,'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe	);
							$data['obat'][$i]->Kada += 1;
						}elseif ($this->in_array_r($dataKontraindikasi[$key]->id_tipe_master,$kondisiPasienAman)) {
							$data['obat'][$i]->karakteristik['kontraindikasi']['aman'][] = array(	'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,'id_tipe_master' => $dataKontraindikasi[$key]->id_tipe_master,'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe	);
						}else{
							$data['obat'][$i]->karakteristik['kontraindikasi']['tanya'][] = array( 'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,'id_tipe_master' => $dataKontraindikasi[$key]->id_tipe_master,'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe);
							$data['obat'][$i]->Ktanya += 1;
						}
					}
					// dapatkan catatan obat yang terdapat pada database 
					$result = $this->SO_M->read('catatan_obat',array('id_obat'=>$query[$i]->id_obat))->result();
					$data['obat'][$i]->catatan_obat = $result[0]->catatan;

				}
				// var_dump($data);die();

				// sorting indikasi dari tinggi ke rendah
				$maxIfounded;
				for ($i=0; $i < sizeof($data['obat']); $i++) {
					for ($j=0; $j < sizeof($data['obat'])-1 ; $j++) {
						if ($data['obat'][$j]->Iada < $data['obat'][$j+1]->Iada) {
							// var_dump($data['obat'][$j]->Iada);
							$temp = $data['obat'][$j];
							$data['obat'][$j] = $data['obat'][$j+1];
							$data['obat'][$j+1] = $temp;
						}
					}
				}
				
				$maxIfounded = $data['obat'][0]->Iada;
				// echo $maxIfounded;
				for ($i=0; $i < sizeof($data['obat']); $i++) { 
					if ($data['obat'][$i]->Iada == $maxIfounded) {
						for ($j=0; $j < sizeof($data['obat'])-1 ; $j++) { 
							if ($data['obat'][$j]->Pada > $data['obat'][$j+1]->Pada ) {
								$temp = $data['obat'][$j];
								$data['obat'][$j] = $data['obat'][$j+1];
								$data['obat'][$j+1] = $temp;
							}
						}
					}
				}
				
				$minPfounded = $data['obat'][0]->Pada;
				for ($i=0; $i < sizeof($data['obat']); $i++) { 
					if ($data['obat'][$i]->Iada == $maxIfounded) {
						if ($data['obat'][$i]->Pada == $minPfounded) {
							for ($j=0; $j < sizeof($data['obat'])-1 ; $j++) { 
								if ($data['obat'][$j]->Kada > $data['obat'][$j+1]->Kada ) {
									// echo $data['obat'][$j]->Kada." | ";
									$temp = $data['obat'][$j];
									$data['obat'][$j] = $data['obat'][$j+1];
									$data['obat'][$j+1] = $temp;
								}
							}
						}
					}
				}
				echo json_encode($data);
			}else{
				$dataeror = array('status' => false,'nomor_identitas' => $nomor_identitas);
				echo json_encode($dataeror);
				$this->SO_M->delete('wm_kondisi',array('id_user'=>$data['user'][0]->id_user));
				$this->SO_M->delete('wm_gejala',array('id_user'=>$data['user'][0]->id_user));
				$this->SO_M->delete('wm_obat',array('id_pasien'=>$data['user'][0]->id_user));

				// $data['heading']	= "Data tidak ditemukan";
				// $data['message']	= "<p>Belum ada obat yang diresepkan. Coba<a href='".base_url()."Ppk_C/view_id'> input identitas pasien</a>, kemudian mulai alur pengobatan </p>";
				// $this->load->view('errors/html/error_general',$data);
			}
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Data users tidak ditemukan. Coba<a href='".base_url()."Ppk_C/view_id'> input identitas pasien yang terdaftar</a>, kemudian mulai alur pengobatan </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	// untuk handle masukkan resep ke log pengobatan
	public function handle_insert_log_pengobatan()
	{
		// get data2 dari wm
		$pesan_resep = $this->input->post('pesan_resep');
		$id_user = $this->input->post('id_user');

		// get all wm_kondisi
		$data['wm_kondisi'] = $this->SO_M->read('wm_kondisi',array('id_user'=>$id_user))->result();
		
		// delete all data where id_user = $id_user
		$this->SO_M->delete('wm_kondisi',array('id_user'=>$id_user));
		
		// get all wm_gejala
		$data['wm_gejala'] = $this->SO_M->read('wm_gejala',array('id_user'=>$id_user))->result();
		
		// delete all data where id_user = $id_user
		$this->SO_M->delete('wm_gejala',array('id_user'=>$id_user));
		
		// get all wm_obat
		$data['wm_obat'] = $this->SO_M->read('wm_obat',array('id_pasien'=>$id_user))->result();
		
		// delete all data where id_user = $id_user
		$this->SO_M->delete('wm_obat',array('id_pasien'=>$id_user));

		// create data ke log_pengobatan, kemudian get idnya. idnya untuk memasukkan data log gejala, log kondisi, dan log obat
		$id_log_pengobatan = $this->SO_M->create_id('log_pengobatan',array('id_user' => $id_user, 'tanggal'=>date('Y-m-d')));
		$id_log_pengobatan = json_decode($id_log_pengobatan);
		$id_log_pengobatan = $id_log_pengobatan->message;
		// tambah element dengan index id_log pada array wmkondisi wmobat wmgejala
		foreach ($data['wm_gejala'] as $key => $value) {
			$data['wm_gejala'][$key]->id_log = $id_log_pengobatan;
			unset($data['wm_gejala'][$key]->id_wm_gejala);
		}
		foreach ($data['wm_kondisi'] as $key => $value) {
			$data['wm_kondisi'][$key]->id_log = $id_log_pengobatan;
			unset($data['wm_kondisi'][$key]->id_wm_kondisi);
		}
		foreach ($data['wm_obat'] as $key => $value) {
			$data['wm_obat'][$key]->id_log = $id_log_pengobatan;
			unset($data['wm_obat'][$key]->id_wm_obat,$data['wm_obat'][$key]->id_pasien,$data['wm_obat'][$key]->tanggal);
		}
		// masukkan gejala ke gejala_log
		$result = $this->SO_M->createS('gejala_log',$data['wm_gejala']);
		// var_dump($result);

		// masukkan kondisi ke kondisi_log
		$result = $this->SO_M->createS('kondisi_log',$data['wm_kondisi']);
		// var_dump($result);

		// masukkan obat ke obat_log
		$result = $this->SO_M->createS('obat_log',$data['wm_obat']);
		// var_dump($result);

		// masukkan pesan yang dimiliki sebuah log_pengobatan
		$result = $this->SO_M->create('pesan_log',array('id_log'=>$id_log_pengobatan,'pesan'=>$pesan_resep));
		// var_dump($result);

		$result = $this->SO_M->readCol('user',array('id_user'=>$id_user),'nomor_identitas')->result();
		redirect("Ppk_C/view_detail_per_log/".$result[0]->nomor_identitas."/".$id_log_pengobatan);
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