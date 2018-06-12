<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_C extends CI_Controller {	
	function __construct(){
		parent::__construct();
		$this->load->model('SO_M');
		date_default_timezone_set("Asia/Jakarta");
		
		if ($this->session->userdata('logged_in')['akses'] != 'admin' ){
			redirect();
		}
	}

	// tampikan seluruh obat yang ada di database
	function view_read_obat()
	{
		/*baca semua obat yang pada pada database, kemudian render*/
		$data['result'] = $this->SO_M->readS('master_obat')->result();
		$this->load->view('html/header');
		$this->load->view('admin/read_obat',$data);
		$this->load->view('html/footer');	
	}

	// halaman untuk membuat obat baru. inputan beripa nama obat pada form
	function view_create_obat()
	{
		/*tampilkan form untuk bisa menambhakan obat*/
		$this->load->view('html/header');
		$this->load->view('admin/create_obat');
		$this->load->view('html/footer');
	}

	// melihat informasi masing-masing karakteristik yang dimiliki suatu obat
	function view_karakteristik($karakteristik,$id_obat)
	{
		/*tampilkan satu jenis karakteristik (indikasi|kontraindikasi|peringatan) yang ada pada suatu obat*/
		
		// deklarasi datacondition
		$dataCondition = array('id_obat'	=>	$id_obat);

		// cari di database where id obat
		$cari = $this->SO_M->read("master_obat",$dataCondition);

		// cek adakah di db
		if ($cari->num_rows() == 0) {
			// info kenapa eror nya
			$data['heading']	=	"Data tidak ditemukan";
			$data['message']	=	"<p>ID obat tidak ditemukan. Coba lihat <a href='".base_url()."Admin_C/view_read_obat'>daftar obat</a>.</p>";

			$this->load->view('errors/html/error_404',$data);
		}
		else{
			if (($karakteristik == 'indikasi') OR ($karakteristik == 'kontraindikasi') OR ($karakteristik == 'peringatan')) {
				$data['master_obat']	=	$this->SO_M->read("master_obat",$dataCondition)->result();
				$this->load->view('html/header');
				$this->load->view('admin/view_'.$karakteristik,$data);
				$this->load->view('html/footer');
			}
			else{
				$data['heading']		=	"Karakteristik tidak didefinisikan atau tidak masuk pada kategori karakteristik";
				$data['message']		=	"<p>kategori yang ada yakni : indikasi / kontraindikasi / peringatan.</p>";
				$this->load->view('errors/html/error_404',$data);
			}
		}
	}

	// untuk crud catatan yang dimiliki suatu obat
	function view_catatan($id_obat)
	{	
		$result = $this->SO_M->readCol('catatan_obat',array('id_obat'=>$id_obat),'id_obat');
		if ($result->num_rows() != 0) {
			$data['result'] = $this->SO_M->read('catatan_obat',array('id_obat'=>$id_obat))->result();
			$data['nama_obat'] = $this->SO_M->readCol('master_obat',array('id_obat'=>$id_obat),array('nama_obat'))->result();
			$this->load->view('html/header');
			$this->load->view('admin/view_catatan',$data);
			$this->load->view('html/footer');
		}else{
			$data['nama_obat'] = $this->SO_M->readCol('master_obat',array('id_obat'=>$id_obat),array('nama_obat'));
			if ($data['nama_obat']->num_rows()==0) {
				$data['heading']		=	"Data tidak ditemukan";
				$data['message']		=	"<p>ID obat tidak ditemukan. Coba lihat <a href='".base_url()."Admin_C/view_read_obat'>daftar obat</a></p>";
				$this->load->view('errors/html/error_404',$data);
			}else{
				$data['nama_obat']=	$data['nama_obat']->result();
				$data['id_obat'] = $id_obat;
				$this->load->view('html/header');
				$this->load->view('admin/create_catatan',$data);
				$this->load->view('html/footer');
			}
		}
	}

	// untuk view apa saja kondisi yang ada dalam database
	function view_kondisi()
	{
		$this->load->view('html/header');
		$this->load->view('admin/view_kondisi');
		$this->load->view('html/footer');
	}

	// untuk view apa saja sediaan yang ada di database
	function view_read_sediaan(){
		$data['master_sediaan'] = $this->SO_M->readS('master_sediaan')->result();
		$this->load->view('html/header');
		$this->load->view('admin/view_sediaan',$data);
		$this->load->view('html/footer');
	}
	/*digunakan oleh datatable untuk menampilkan data pada view_$karakteristik*/
	function dataTable($karakteristik,$id_obat)
	{
		$dataCondition 				= 	array(
												'id_obat'	=>	$id_obat,
												'tipe'		=>	$karakteristik
										);
		$dataCol					= 	array(
												'id_karakteristik',
												'id_obat',
												'id_tipe_master',
												'detail_tipe'
										);
		$data[$karakteristik]		=	$this->SO_M->readCol('karakteristik_obat',$dataCondition,$dataCol)->result();
		echo json_encode($data);
	}

	// halaman menampilkan dan CRUD gejala yang ada. nantinya inputan nini akan dijadikan prameter dropdown
	function view_gejala()
	{
		$this->load->view('html/header');
		$this->load->view('admin/view_gejala');
		$this->load->view('html/footer');
	}

	// halaman tampilkan informasi seorang pasien
	function view_detail_user($nomor_identitas)
	{
		/*dapatkan informasi identitas*/
		$dataCondition['nomor_identitas'] 	=	$nomor_identitas;
		$dataCol							=	array('id_user','nama_user', 'nomor_identitas','alamat','akses','no_hp','link_foto');
		$data['detailed_user'] 				=	$this->SO_M->read('user',$dataCondition)->result();
		unset($dataCondition,$dataCol);

		/*dapatkan informasi rekam medis(kondisi) dapatkan informasi log pemberian obat*/
		$this->load->view('html/header');
		$this->load->view('admin/detailed_user',$data);
		$this->load->view('html/footer');
	}

	// digunakan oleh datatable untuk menampilkan data pada view_CRUD gejala dan kondisi
	function dataTable_($tabel)
	{
		$data['master_data']	=	$this->SO_M->readS($tabel)->result();
		echo json_encode($data);
	}

	// get data untuk dijadikan autocomplte
	function autocomplete($table,$col){
		$data['master_data'] = $this->SO_M->readSCol($table,$col)->result();
		echo json_encode($data);
	}

	// insert data sediaan ke master sediaan
	function handle_add_sediaan(){
		if ($this->input->post() != null) {
			$result 	= 	$this->SO_M->create('master_sediaan',array('sediaan'=>$this->input->post('nama_jenis_sediaan')));
			$results	=	json_decode($result,true);
			if ($results['status']) {
				alert('alert_create_sediaan','success','Berhasil','Create sediaan ke master_sediaan berhasil');
			}
			else{
				if ($results['error_message']['code'] == 1062) {
					alert('alert_create_sediaan','warning','Gagal','Nama sediaan sudah ada');
				}
				else{
					alert('alert_create_sediaan','warning','Gagal','Create sediaan ke master_sediaan gagal');
				}
			}
			redirect("Admin_C/view_read_sediaan");
		}else{
			$datae['heading']	=	"Tidak ada data yang di post";
			$datae['message']	=	"<p>Kembali ke halaman <a href='".base_url()."Admin_C/view_read_sediaan'>Master Sediaan</a>.</p>";
			$this->load->view('errors/html/error_404',$datae);
		}
	}
	// dari ajax untuk delete gejala
	function handle_delete_gejala()
	{
		// cek apakah data gejala tersebut dimiliiki oleh suatu obat. jika iya maka jangan dihapus. jika tidak ada satupun obat yang memmilki gejal tersebut maka penghapusan dapat dilakukan
		$dataCondition['tipe'] = 'indikasi';
		$dataCondition['detail_tipe'] = $this->input->post('detail_gejala');
		$result = $this->SO_M->read('karakteristik_obat',$dataCondition);

		// jika data gejala dimilki suatu obat
		if ($result->num_rows() != null) {
			alert('','danger','Gagal','Data tersebut dimiliki oleh suatu obat',false);
		}
		else{
			unset($dataCondition);
			$dataCondition['id_gejala'] = $this->input->post('id_gejala');
			// $dataCondition['detail_gejala'] = $this->input->post('detail_gejala');
			$result = $this->SO_M->delete('master_gejala',$dataCondition);
			if ($result) {
				alert('','success','Berhasil','Data telah dihapus',false);
			}else{
				alert('','danger','Gagal','Data tidak terhapus',false);
			}
		}
	}

	// dari ajax untuk delete kondisi
	function handle_delete_kondisi()
	{
		// cek apakah data gejala tersebut dimiliiki oleh suatu obat. jika iya maka jangan dihapus. jika tidak ada satupun obat yang memmilki gejal tersebut maka penghapusan dapat dilakukan

		// ambil yang isinya perongatan dan kontraindikasi
		$dataCondition['tipe !='] = 'indikasi';
		$dataCondition['detail_tipe'] = $this->input->post('detail_kondisi');
		$result = $this->SO_M->read('karakteristik_obat',$dataCondition);
		// jika data gejala dimilki suatu obat
		if ($result->num_rows() != null) {
			alert('','danger','Gagal','Data tersebut dimiliki oleh suatu obat',false);
		}
		else{
			unset($dataCondition);
			$dataCondition['id_master_kondisi'] =	$this->input->post('id_master_kondisi');
			$result = $this->SO_M->read('kondisi',$dataCondition);
			if ($result->num_rows() != 0) {
				alert('','danger','Gagal','Data tersebut dimiliki oleh seorang pasien',false);
			}
			else{
				// $dataCondition['detail_gejala'] 	=	$this->input->post('detail_gejala');
				$result = $this->SO_M->delete('master_kondisi',$dataCondition);
				if ($result == true) {
					alert('','success','Berhasil','Data telah dihapus',false);
				}else{
					alert('','danger','Gagal','Data tersebut dimiliki oleh suatu obat',false);
				}
			}
		}
	}

	// rename obat 
	function view_rename_obat($id_obat)
	{
		// deklarasi datacondition
		$dataCondition = array('id_obat'	=>	$id_obat);

		// cari di database where id obat
		$cari = $this->SO_M->read("master_obat",$dataCondition);

		// cek adakah di db
		if ($cari->num_rows() == 0) {
			// info kenapa eror nya
			$data['heading']		=	"Data tidak ditemukan";
			$data['message']		=	"<p>ID obat tidak ditemukan. Coba lihat <a href='".base_url()."Admin_C/view_read_obat'>daftar obat</a>.</p>";

			$this->load->view('errors/html/error_404',$data);
		}else{

			$data['nama_obat']		=	$this->SO_M->read("master_obat",$dataCondition)->result();
				
			$this->load->view('html/header');
			$this->load->view('admin/view_rename_obat',$data);
			$this->load->view('html/footer');
		}
	}

	// sebagai action="" pada form rename obat
	function handle_rename_obat()
	{
		/* function untuk form pada view_rename dan nama obat harus unik */
		if ($this->input->post() == null) {
			$data['heading']	= 	"Tidak ada form data yang di POST";
			$data['message']	= 	"<p>Coba lagi <a href='".base_url()."Admin_C/view_create_obat'>Create obat</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
		else{
			$nama_obat_old		= 	$this->input->post('nama_obat_old');
			$nama_obat_new		= 	$this->input->post('nama_obat_new');
			
			if ($nama_obat_new != 	$nama_obat_old) {
				$dataCondition	=	array('id_obat'=>$this->input->post('id_obat'));
				$dataUpdate		= 	array('nama_obat'		=>	$nama_obat_new);
				$result 		=	$this->SO_M->update('master_obat',$dataCondition, $dataUpdate);
				$results		=	json_decode($result,true);

				if ($results['status']) {
					alert('alert_rename_obat','success','Berhasil','Rename obat ke master_obat berhasil');
				}
				else{
					if ($results['error_message']['code'] == 1062) {
						alert('alert_rename_obat','warning','Gagal','Nama obat sudah ada.');
					}
					else{
						alert('alert_rename_obat','warning','Gagal','Rename obat ke master_obat gagal');
					}
				}
			}else{
				alert('alert_rename_obat','warning','Gagal','Nama Obat tidak diubah');
			}
			redirect("Admin_C/view_read_obat");
		}
	}

	/* delete suatu obat dalam database	*/
	function handle_delete_obat($id_obat)
	{
		/*hapus suatu obat*/
		$dataCondition = array('id_obat' => $id_obat);

		// cari di database where id obat
		$data = $this->SO_M->read("master_obat",$dataCondition);

		// jika, tidak ada di database
		if ($data->num_rows() == 0) {
			$datae['heading']	=	"Data tidak ditemukan";
			$datae['message']	=	"<p>ID obat tidak ditemukan. Coba lihat <a href='".base_url()."Admin_C/view_read_obat'>daftar obat</a>.</p>";
			$this->load->view('errors/html/error_404',$datae);
		}

		// jika ada di database, maka hapus
		else{
			$result = $this->SO_M->delete("master_obat",$dataCondition);
			if ($result ) {
				alert('alert_delete_obat','success','Berhasil','Delete Berhasil ');
			}
			else{
				alert('alert_delete_obat','warning','Gagal','Delete Berhasil ');
			}
			redirect('Admin_C/view_read_obat/');
		}
	}

	// sebagai action="" pada form create obat
	function handle_create_obat()
	{
		/*		nama obat harus unik		*/
		if ($this->input->post() == null) {
			$data['heading']= "Tidak ada form data yang di POST";
			$data['message']= "<p>Coba lagi <a href='".base_url()."Admin_C/view_create_obat'>Create obat</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
		else{		
			
			$data 		=	array('nama_obat' => $this->input->post('nama_obat'));
			$result		=	$this->SO_M->create('master_obat',$data);
			$results	=	json_decode($result,true);
			if ($results['status']) {
				alert('alert_create_obat','success','Berhasil','Create obat ke master_obat berhasil');
			}
			else{
				if ($results['error_message']['code'] == 1062) {
					alert('alert_create_obat','warning','Gagal','Nama obat sudah ada');
				}
				else{
					alert('alert_create_obat','warning','Gagal','Create obat ke master_obat gagal');
				}
			}

			redirect("Admin_C/view_read_obat");
		}
	}

	// handling form create catatan obat
	function handle_create_catatan()
	{
		$result = $this->SO_M->create('catatan_obat',array('id_obat'=>$this->input->post('id_obat'),'catatan'=>$this->input->post('catatan_obat')));
		$result = json_decode($result);
		if ($result->status) {
			alert('alert_catatan','success','Berhasil','Create catatan ke catatan_obat berhasil');
		}else{
			alert('alert_catatan','warning','Gagal','Create catatan ke catatan_obat gagal');
		}
		redirect("Admin_C/view_catatan/".$this->input->post('id_obat'));
	}

	// handling form update catatan obat
	function handle_update_catatan()
	{
		$result = $this->SO_M->update('catatan_obat',array('id_catatan'=>$this->input->post('id_catatan')),array('catatan'=>$this->input->post('catatan_obat')));
		$result = json_decode($result);

		if ($result->status == true) {
			alert('alert_catatan','success','Berhasil','Update catatan ke catatan_obat berhasil');
		}else{
			alert('alert_catatan','warning','Gagal','Update catatan ke catatan_obat gagal.');
		}
		redirect("Admin_C/view_catatan/".$this->input->post('id_obat'));
	}

	// untuk handle multipile input form
	function handle_create_karakteristik($karakteristik)
	{
		// echo $karakteristik;
		if ($this->input->post() == null) {
			$data['heading']= "Tidak ada form data yang di POST";
			$data['message']= "<p>Coba lagi <a href='".base_url()."Admin_C/view_create_obat'>Create obat</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
		else{
			$this->form_validation->set_rules($karakteristik,'', 'required|xss_clean');
			$id_obat			=	$this->input->post('id_obat');
			if ($this->form_validation->run() == TRUE) {	
				// dapatkan dulu id obat yang akan ditambahkan karakteristiknya

				// ambil apa saja karakteristik yang telah diinputkan di form
				$karakteristik_dari_form	=	$this->input->post($karakteristik);

				// definisikan array kosong untuk disiapkan masuk ke database, karena batch input tidak bisa menerima $karakteristik_dari_form. harus ada array di dalam ARRAY sebanyak jumlah input form
				$karakteristik_db 			=	array();

				
				// manipulasi array yang akan masuk ke database melalui karakteristik dari form
				$karakteristik_db	=	array(
													"id_obat"		=>	$id_obat,
													"tipe"			=>	$karakteristik,
													"id_tipe_master"=>	'',
													"detail_tipe"	=>	$karakteristik_dari_form
				);
				
				// cek apakah data detail tipe tersebut sudah ada pada obat tersebut
				$where			=	array(	'id_obat'=>$id_obat,
											'tipe'=> $karakteristik,
											'detail_tipe' => $karakteristik_dari_form
									);
				$result = $this->SO_M->read('karakteristik_obat',$where);
				if ($result->num_rows() == 0) {

					// golongakan karakteristik yang akan masuk
					if (($karakteristik == 'kontraindikasi') OR ($karakteristik == 'peringatan')) {
						// jika belum ada di tabel master kondisi, maka buat, kemudian ambil idnya untuk dijadikan nilai pada kolom id_tipe_master
						$result = $this->SO_M->read('master_kondisi',array('detail_kondisi' => $karakteristik_db['detail_tipe']));
						if ($result->num_rows() == 0) {
							// definisikan array kosong untuk masuk ke dalam database kondisi, ini sebagai duplikat dan pengisi elemen dropdown input kondisi
							$kondisi_db		 			=	array();
							// siapkan data untuk masuk ke tabel master_kondisi
							$kondisi_db		=	array(	'detail_kondisi'=>	$karakteristik_dari_form);
							$result = $this->SO_M->create_id('master_kondisi',$kondisi_db);
							$results = json_decode($result);
							$karakteristik_db['id_tipe_master'] = $results->message;
						}
						else{
							$result = $result->result();
							$karakteristik_db['id_tipe_master'] = $result[0]->id_master_kondisi;
						}

						

					}elseif ($karakteristik =='indikasi') {
						
						// jika belum ada di tabel master gejala, maka buat, kemudian ambil idnya untuk dijadikan nilai pada kolom id_tipe_master
						$result = $this->SO_M->read('master_gejala',array('detail_gejala' => $karakteristik_db['detail_tipe']));
						if ($result->num_rows() == 0) {
							// definisikan array kosong untuk masuk ke dalam database kondisi, ini sebagai duplikat dan pengisi elemen dropdown input gejala
							$gejala_db		 			=	array();
							// siapkan data untuk masuk ke tabel master_gejala
							$gejala_db		=	array(	'detail_gejala'=>	$karakteristik_dari_form);
							$result = $this->SO_M->create_id('master_gejala',$gejala_db);
							$results = json_decode($result);
							$karakteristik_db['id_tipe_master'] = $results->message;
						}else{
							$result = $result->result();
							$karakteristik_db['id_tipe_master'] = $result[0]->id_gejala;
						}
					}

					// masukkan data yang sudah disusun ke tabel karakteristik obat
					$result = $this->SO_M->create('karakteristik_obat',$karakteristik_db);
					$results = json_decode($result);

					if ($results->status) {
						alert('alert_'.$karakteristik.'_obat','success','Berhasil','Insert '.$karakteristik.'ke karakteristik_obat');
					}
					else{
						alert('alert_'.$karakteristik.'_obat','danger','Gagal','Tidak dapat memasukkan data ke karakteristik_obat');
					}
				}else{
					alert('alert_tipe_master','warning','Duplikasi','Tidak ada data yang di Insert ke gejala|kondisi_master dan karakteristik_obat');
				}
				// jika karakterisitk yang masuk adalah indikasi
				redirect('Admin_C/view_karakteristik/'.$karakteristik.'/'.$id_obat);
			}else{
				alert('alert_tipe_master','danger','Gagal','Form yang disubmit berisi whitespace');
				redirect('Admin_C/view_karakteristik/'.$karakteristik.'/'.$id_obat);
			}
		}
	}

	/*untuk merespon panggilan AJAX pada halaman view $karakteristik*/
	function handle_delete_karakteristik()
	{
		$dataCondition['id_karakteristik'] = $this->input->post('id_karakteristik');
		$result = $this->SO_M->delete('karakteristik_obat',$dataCondition);
		if ($result) {
			alert('','success','Berhasil','Data tersebut telah dihapus',false);
		}else{
			alert('','danger','Gagal','Data tidak terhapus',false);
		}
		
	}

	/*dipanggil via get pada view indikasi untuk button edit indikasi*/
	function handle_detail_tipe($id_karakteristik)
	{
		$dataCondition 		=	array('id_karakteristik'=>$id_karakteristik);
		$dataCol			= 	array('detail_tipe');
		$detail_tipe 		=	$this->SO_M->readCol('karakteristik_obat',$dataCondition,$dataCol)->result();
		echo json_encode($detail_tipe);
	}

	/*dipanggil oleh AJAX untuk melakukan edit pada karakteristik*/
	function handle_edit_karakteristik()
	{
		$this->form_validation->set_rules('detail_tipe','', 'required|xss_clean');
		if ($this->form_validation->run() == TRUE) {

			$dataCondition 		=	array(	'id_karakteristik'	=>	$this->input->post('id_karakteristik'));
			$dataUpdate			= 	array(	'id_obat'			=>	$this->input->post('id_obat'),
											'tipe'				=>	$this->input->post('tipe'),
											'detail_tipe'		=>	$this->input->post('detail_tipe')
								);
			$dataKarakteristik	=	$this->input->post('tipe');

			// baca data di karakteristik apakah inputan baru ini sudah ada di tabel karakterisstik obat
			$result 			=	$this->SO_M->read('karakteristik_obat',$dataUpdate);

			// jika belum ada
			if ($result->num_rows() == 0) {
				
				// jika kontraindikasi atau peringatan, maka cek di tabel master_kondisi
				if ($dataKarakteristik == 'kontraindikasi' || $dataKarakteristik == 'peringatan') {
					
					// cek di master_tipe, apakah data sudah ada atau belum.jika belum maka insert master_tipe baru dan ambil idnya. jika sudah, ambil idnya. kemudian persiapan untuk masuk ke karakteristik obat
					$result = $this->SO_M->readCol('master_kondisi',array('detail_kondisi' => $dataUpdate['detail_tipe']),'id_master_kondisi');

					// jika belum ada di master kondisi, insert kemudian ambil id nya
					if ($result->num_rows() == 0) {
						$result = $this->SO_M->create_id('master_kondisi',array('detail_kondisi' => $dataUpdate['detail_tipe']));
						$results = json_decode($result);
						
						// jika berhasil insert di master_kondisi
						if ($results->status) {

							// ambil idnya
							$dataupdate['id_tipe_master'] = $results->message;
						}

						// jika gagal insert di master_kondisi
						else{
							alert('','danger','Gagal','Tidak ada data yag masuk pada master_kondisi',false);
						}
					}

					// jika sudah ada di master_kondisi, maka ambil idnya dan jadikan id_master_kondisi pada dataUpdate
					else{
						$id_master_kondisi = $result->result();
						$dataUpdate['id_tipe_master'] =$id_master_kondisi[0]->id_master_kondisi;
					}
				}

				// jika indikasi, maka cek di tabel master_gejala
				else{
					$result = $this->SO_M->readCol('master_gejala',array('detail_gejala' => $dataUpdate['detail_tipe']),'id_gejala');
					if ($result->num_rows() == 0) {
						$result = $this->SO_M->create_id('master_gejala',array('detail_gejala' => $dataUpdate['detail_tipe']));
						$results = json_decode($result);
						
						// jika berhasil insert di master_kondisi
						if ($results->status) {

							// ambil idnya
							$dataupdate['id_tipe_master'] = $results->message;
						}

						// jika gagal insert di master_kondisi
						else{
							alert('','danger','Gagal','Tidak ada data yag masuk pada master_gejala',false);
						}
					}
					// jika sudah ada di master_kondisi, maka ambil idnya dan jadikan id_master_kondisi pada dataUpdate
					else{
						$id_gejala = $result->result();
						$dataUpdate['id_tipe_master'] = $id_gejala[0]->id_gejala;
					}

				}

				// masukkan data update ke karakteristik obat
				$result = $this->SO_M->update('karakteristik_obat',$dataCondition,$dataUpdate);
				$results = json_decode($result);
				if ($results->status) {
					alert('','success','Berhasil','Data karakteristik_obat telah di edit',false);
				}else{
					alert('','danger','Gagal','Tidak ada data karakteristik obat yang diedit',false);
				}
			}
			// jika sudah ada karakteristik tersebut di tabel karakteristik_obat
			else{
				alert('','danger','Gagal','Duplikasi pada data karakteristik obat yang diedit',false);
			}
		}else{
			alert('','danger','Gagal','Form berisi whitespace',false);
		}
	}

	// untuk ambil daftar obat yang  memiliki sutu nilai pada tabel gejala / kondisi
	function get_obat($tipe,$id_tipe_master)
	{
		$this->db->select(array('karakteristik_obat.id_obat','master_obat.nama_obat','tipe'));
		$this->db->distinct();
		if ($tipe == 'kondisi') {
			$this->db->where(array('id_tipe_master'=>$id_tipe_master,'tipe !=' => 'indikasi'));
		}else{
			$this->db->where(array('id_tipe_master'=>$id_tipe_master,'tipe' => 'indikasi'));
		}
		$this->db->join('master_obat','master_obat.id_obat = karakteristik_obat.id_obat');
		$data['result'] = $this->db->get('karakteristik_obat')->result();
		$this->load->view('html/header');
		$this->load->view('admin/view_obat_per_karakteristik',$data);
		$this->load->view('html/footer');	
	}
}



	// // dari javaskrip untuk get data nama karakteristik obat melalui id_gejala pada halaman view_gejala (MODAL)
	// function handle_nama_gejala($id_gejala)
	// {
	// 	$dataCol['detail_gejala']		=	'detail_gejala';
	// 	$dataCondition['id_gejala'] 	= 	$id_gejala;
	// 	$result 						= 	$this->SO_M->readCol('master_gejala',$dataCondition,$dataCol)->result();
	// 	echo json_encode($result);
	// }
 