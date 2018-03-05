<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_C extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('SO_M');
		if ($this->session->userdata('logged_in')['akses'] != 'admin' ){
			redirect();
		}
	}

	// tampikan seluruh obat yang ada di database
	public function view_read_obat()
	{
		/*baca semua obat yang pada pada database, kemudian render*/
		$data['result'] = $this->SO_M->readS('master_obat')->result();
		$this->load->view('html/header');
		$this->load->view('admin/read_obat',$data);
		$this->load->view('html/footer');	
	}

	// halaman untuk membuat obat baru. inputan beripa nama obat pada form
	public function view_create_obat()
	{
		/*tampilkan form untuk bisa menambhakan obat*/
		$this->load->view('html/header');
		$this->load->view('admin/create_obat');
		$this->load->view('html/footer');
	}

	// melihat informasi masing-masing karakteristik yang dimiliki suatu obat
	public function view_karakteristik($karakteristik,$id_obat)
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

	// untuk view apa saja kondisi yang ada dalam database
	public function view_kondisi()
	{
		// tampilkan isi tabel kondisi
		$data['master_kondisi'] 	=	$this->SO_M->readS('master_kondisi')->result();

		$this->load->view('html/header');
		$this->load->view('admin/view_kondisi',$data);
		$this->load->view('html/footer');
	}

	/*digunakan oleh datatable untuk menampilkan data pada view_$karakteristik*/
	public function dataTable($karakteristik,$id_obat)
	{
		$dataCondition 				= 	array(
												'id_obat'	=>	$id_obat,
												'tipe'		=>	$karakteristik
										);
		$dataCol					= 	array(
												'id_karakteristik',
												'detail_tipe'
										);
		$data[$karakteristik]		=	$this->SO_M->readCol('karakteristik_obat',$dataCondition,$dataCol)->result();
		echo json_encode($data);
	}

	// halaman menampilkan dan CRUD gejala yang ada. nantinya inputan nini akan dijadikan prameter dropdown
	public function view_CRUD_gejala()
	{
		$this->load->view('html/header');
		$this->load->view('admin/view_CRUD_gejala');
		$this->load->view('html/footer');
	}

	// halaman tampilkan informasi seorang pasien
	public function view_detail_user($id_user)
	{
		/*dapatkan informasi identitas*/
		$dataCondition['id_user'] 	=	$id_user;
		$dataCol					=	array('id_user','nama_user', 'nomor_identitas','alamat','akses','no_hp','link_foto');
		$data['detailed_user'] 		=	$this->SO_M->read('user',$dataCondition)->result();
		unset($dataCondition,$dataCol);

		/*dapatkan informasi rekam medis(kondisi) dapatkan informasi log pemberian obat*/
		$this->load->view('html/header');
		$this->load->view('admin/detailed_user',$data);
		$this->load->view('html/footer');
	}

	// sebagai action="" pada form create obat
	public function handle_create_gejala()
	{
		if ($this->input->post() != NULL) {
			// ambil array gejala
			$gejala_dari_form 	=$this->input->post('gejala[]');

			// array kosong untuk masuk db
			$gejala_db = array();

			foreach ($gejala_dari_form as $key => $value) {
				$gejala_db[$key] = array('detail_gejala' => $gejala_dari_form[$key]);
			}

			$result 	= 	$this->SO_M->createS('master_gejala',$gejala_db);
			$results	=	json_decode($result,true);

			if ($results['status'] != false) {
				$this->session->set_flashdata(
												"alert_CRUD_gejala",
												"<div class='alert alert-success alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Berhasil!</strong>Insert gejala</div>"
				);
			}
			else{
				$this->session->set_flashdata(
												"alert_CRUD_gejala",
												"<div class='alert alert-danger alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Gagal!</strong> Tidak ada data yang di Insert ke master_gejala</div>"
				);
			}
			redirect('Admin_C/view_CRUD_gejala');
		}else{
			$data['heading']= "Tidak ada form data yang di POST";
			$data['message']= "<p>Coba lagi <a href='".base_url()."Admin_C/view_create_gejala'>Create gejala</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}

	/*digunakan oleh datatable untuk menampilkan data pada view_CRUD gejala*/
	public function dataTable_gejala()
	{
		$data['master_gejala']	=	$this->SO_M->readS('master_gejala')->result();
		echo json_encode($data);
	}

	// dari ajax untuk gdelete gejala
	public function handle_delete_gejala()
	{
		// cek apakah data gejala tersebut dimiliiki oleh suatu obat. jika iya maka jangan dihapus. jika tidak ada satupun obat yang memmilki gejal tersebut maka penghapusan dapat dilakukan
		$dataCondition['tipe'] = 'indikasi';
		$dataCondition['detail_tipe'] = $this->input->post('detail_gejala');
		$result = $this->SO_M->read('karakteristik_obat',$dataCondition);

		// jika data gejala dimilki suatu obat
		if ($result->num_rows() != null) {
			echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Gagal! </strong>Data tersebut dimiliki oleh suatu obat!</div>";
		}
		else{
			unset($dataCondition);
			$dataCondition['id_gejala'] = $this->input->post('id_gejala');
			$dataCondition['detail_gejala'] = $this->input->post('detail_gejala');
			$result = $this->SO_M->delete('master_gejala',$dataCondition);
			if ($result) {
				echo "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> Hapus gejala  <strong>berhasil!</strong></div>";
			}else{
				echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> Hapus gejala <strong> gagal! </strong></div>";
			}
		}
	}

	// dari ajax untuk gdelete gejala
	public function handle_delete_kondisi()
	{
		$dataCondition['id_master_kondisi'] = $this->input->post('id_master_kondisi');
		$result = $this->SO_M->read('master_kondisi',$dataCondition)->result();
		var_dump("<pre>".$result."</pre>");
		// $result = $this->SO_M->delete('master_kondisi',$dataCondition);
		// if ($result) {
		// 	$alert_CRUD_kondisi = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> Hapus kondisi<strong>berhasil!</strong></div>";
		// }else{
		// 	$alert_CRUD_kondisi = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> Hapus kondisi <strong> gagal! </strong></div>";
		// }
		// echo $alert_CRUD_kondisi;
	}

	// dari javaskrip untuk get data nama karakteristik obat melalui id_gejala pada halaman view_crud_gejala (MODAL)
	public function handle_nama_gejala($id_gejala)
	{
		$dataCol['detail_gejala']		=	'detail_gejala';
		$dataCondition['id_gejala'] 	= 	$id_gejala;
		$result 						= 	$this->SO_M->readCol('master_gejala',$dataCondition,$dataCol)->result();
		echo json_encode($result);
	}
 
	// rename obat 
	public function view_rename_obat($id_obat)
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
	public function handle_rename_obat()
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
					$this->session->set_flashdata(
													"alert_rename_obat",
													"<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Rename obat ke master_obat<strong> berhasil!</strong></div>"
					);
				}
				else{
					if ($results['error_message']['code'] == 1062) {
						$this->session->set_flashdata(
														"alert_rename_obat",
														"<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Nama obat sudah ada.<strong> Harus unik!</strong></div>"
						);	
					}
					else{
						$this->session->set_flashdata(
														"alert_rename_obat",
														"<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Rename obat ke master_obat <strong>gagal!</strong></div>"
						);	
					}
				}
			}else{
				$this->session->set_flashdata(
											"alert_rename_obat",
											"<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Nama obat tidak diubah !</div>"
			);
			}
			redirect("Admin_C/view_read_obat");
		}
	}

	/* delete suatu obat dalam database	*/
	public function handle_delete_obat($id_obat)
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

	// sebagai action="" pada form create obat
	public function handle_create_obat()
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
				$this->session->set_flashdata(
												"alert_create_obat",
												"<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Create obat ke master_obat<strong> berhasil!</strong></div>"
				);
			}
			else{
				if ($results['error_message']['code'] == 1062) {
					$this->session->set_flashdata(
													"alert_create_obat",
													"<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Nama obat sudah ada.<strong> Harus unik!</strong></div>"
					);	
				}
				else{$this->session->set_flashdata(
													"alert_create_obat",
													"<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Create obat ke master_obat <strong>gagal!</strong></div>"
					);	
				}
			}

			redirect("Admin_C/view_read_obat");
		}
	}

	// untuk handle multipile input form
	public function handle_create_karakteristik($karakteristik)
	{
		// echo $karakteristik;
		if ($this->input->post() == null) {
			$data['heading']= "Tidak ada form data yang di POST";
			$data['message']= "<p>Coba lagi <a href='".base_url()."Admin_C/view_create_obat'>Create obat</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
		else{

			// dapatkan dulu id obat yang akan ditambahkan karakteristiknya
			$id_obat			=	$this->input->post('id_obat');

			// ambil apa saja karakteristik yang telah diinputkan di form
			$karakteristik_dari_form	=	$this->input->post($karakteristik.'[]');

			// definisikan array kosong untuk disiapkan masuk ke database, karena batch input tidak bisa menerima $karakteristik_dari_form. harus ada array di dalam ARRAY sebanyak jumlah input form
			$karakteristik_db 			=	array();

			// golongakan karakteristik yang akan masuk
			if (($karakteristik == 'kontraindikasi') OR ($karakteristik == 'peringatan')) {
				// definisikan array kosong untuk masuk ke dalam database kondisi, ini sebagai duplikat untuk dropdown input kondisi
				$kondisi_db		 			=	array();

				// manipulasi array yang akan masuk ke database melalui karakteristik dari form
				foreach ($karakteristik_dari_form as $key => $value) {
					$karakteristik_db[$key]	=	array(
														"id_obat"		=>	$id_obat,
														"tipe"			=>	$karakteristik,
														'detail_tipe'	=>	$karakteristik_dari_form[$key]
					);
					$kondisi_db[$key]		=	array(	'detail_kondisi'=>	$karakteristik_dari_form[$key]);

					$result = $this->SO_M->read('karakteristik_obat',$karakteristik_db[$key]['detail_tipe']);
					if ($result->num_rows() != 0) {
						unset($karakteristik_db[$key],$kondisi_db[$key]);
					}
				}
			}
			// jika karakterisitk yang masuk adalah indikasi
			else{
				$gejala_db					=	array();

				foreach ($karakteristik_dari_form as $key => $value) {
					$karakteristik_db[$key]	=	array(
														"id_obat"		=>	$id_obat,
														"tipe"			=>	$karakteristik,
														'detail_tipe'	=>	$karakteristik_dari_form[$key]
					);
					$gejala_db[$key]		=	array(	'detail_gejala' =>	$karakteristik_dari_form[$key]);

					$where = array('detail_tipe' => $karakteristik_dari_form[$key]);

					$result = $this->SO_M->read('karakteristik_obat',$where);
					if ($result->num_rows() != 0) {
						unset($karakteristik_db[$key],$gejala_db[$key]);
					}
				}
			}

			// kuerikan batch input
			$result 	= $this->SO_M->createS('karakteristik_obat',$karakteristik_db);
			$results	=	json_decode($result,true);

			if ($results['status'] != false) {
				$this->session->set_flashdata(
												"alert_".$karakteristik."_obat",
												"<div class='alert alert-success alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Insert ".$karakteristik." ke karakteristik_obat<strong> berhasil!</strong></div>"
				);

				// hanya karakteristik kontra dan peringatan yang masuk ke tabel master_kondisi
				if (($karakteristik == 'kontraindikasi') OR ($karakteristik == 'peringatan')) {
					$resultkondisi	= 	$this->SO_M->createS('master_kondisi',$kondisi_db);
					$resultskondisi	=	json_decode($resultkondisi,true);

					if ($resultskondisi['status'] == 'true') {
						$this->session->set_flashdata(
												"alert_kondisi",
												"<div class='alert alert-success alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Berhasil!</strong> Data masuk ke master_kondisi </div>"
						);
					}
					else{
						if ($resultskondisi['error_message']['code'] == 1062) {
							$this->session->set_flashdata(
												"alert_kondisi",
												"<div class='alert alert-warning alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> Duplikasi!</strong> Tidak ada data yang di Insert ke master_kondisi.</div>"
							);
						}else{
							$this->session->set_flashdata(
												"alert_kondisi",
												"<div class='alert alert-danger alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> Tidak ada data </strong>yang di Insert ke master_kondisi. Another eror message</div>"
							);
						}
					}
				}
				// hanya karakteristik indikasi yang masuk ke tabel gejala
				else{
					$resultgejala = $this->SO_M->createS('master_gejala',$gejala_db);
					$resultsgejala = json_decode($resultgejala,true);

					if ($resultsgejala['status']) {
						$this->session->set_flashdata(
												"alert_gejala",
												"<div class='alert alert-success alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Berhasil!</strong> Data masuk ke master_gejala </div>"
						);
					}else{
						if ($resultsgejala['error_message']['code'] == 1062) {
							$this->session->set_flashdata(
												"alert_gejala",
												"<div class='alert alert-warning alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> Duplikasi!</strong> Tidak ada data yang di Insert ke master_gejala.</div>"
							);
						}else{
							$this->session->set_flashdata(
												"alert_gejala",
												"<div class='alert alert-danger alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> Tidak ada data </strong>yang di Insert ke master_gejala. Error code ".$resultsgejala['error_message']['code']."</div>"
							);
						}
					}
					
				}
			}
			else{
				$this->session->set_flashdata(
										"alert_".$karakteristik."_obat",
										"<div class='alert alert-danger alert-dismissible margin-top-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Insert ".$karakteristik." ke karakteristik_obat<strong> gagal!</strong></div>"
				);
			}
			
			if (($karakteristik == 'indikasi') OR ($karakteristik == 'kontraindikasi') OR ($karakteristik == 'peringatan')) {
				redirect('Admin_C/view_karakteristik/'.$karakteristik.'/'.$id_obat);
			}
			else{
				$data['heading']= "Karakteristik tidak didefinisikan";
				$data['message']= "<p>Coba lihat <a href='".base_url()."Admin_C/view_create_obat'>Create obat</a> </p>";
				$this->load->view('errors/html/error_general',$data);
			}
		}
	}

	/*untuk merespon panggilan AJAX pada halaman view $karakteristik*/
	public function handle_delete_karakteristik()
	{
    	$dataCondition['id_karakteristik'] = $this->input->post('id_karakteristik');
    	$result = $this->SO_M->delete('karakteristik_obat',$dataCondition);
    	if ($result) {
			$alert_delete_indikasi = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> Hapus indikasi  <strong>berhasil!</strong></div>";
    	}else{
			$alert_delete_indikasi = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> Hapus indikasi <strong> gagal! </strong></div>";
		}
        echo $alert_delete_indikasi;
	}

	/*dipanggil via get pada view indikasi untuk button edit indikasi*/
	public function handle_detail_tipe($id_karakteristik)
	{
		$dataCondition 		=	array('id_karakteristik'=>$id_karakteristik);
		$dataCol			= 	array('detail_tipe');
		$detail_tipe 		=	$this->SO_M->readCol('karakteristik_obat',$dataCondition,$dataCol)->result();
		echo json_encode($detail_tipe);
	}

	/*dipanggil oleh AJAX untuk melakukan edit pada karakteristik*/
	public function handle_edit_karakteristik()
	{
		$dataCondition 	=	array(	'id_karakteristik'	=>	$this->input->post('id_karakteristik'));
		$dataUpdate		= 	array(	'detail_tipe'		=>	$this->input->post('detail_tipe'));

		$result 		=	$this->SO_M->read('karakteristik_obat',$dataUpdate);

		// akan diupdate jika data tidak mengalami duplikasi
		if ($result->num_rows() == 0) {
			$result 		=	$this->SO_M->update('karakteristik_obat',$dataCondition,$dataUpdate);
			// var_dump($result);
			$results 		=	json_decode($result, true);
			if ($results['status']) {
				echo "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Edit karakteristik obat ke tabel karakteristik_obat<strong> berhasil!</strong></div>";
			}
			else{
				echo "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Edit karakteristik obat ke tabel karakteristik_obat<strong> gagal!</strong></div>";
			}
		}
		else{
			echo "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Edit karakteristik obat ke tabel karakteristik_obat<strong> gagal!</strong></div>";
		}
	}
}