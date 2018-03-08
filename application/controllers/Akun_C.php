<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun_C extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('SO_M');
		// date_default_timezone_set("Asia/Jakarta");
	}

	public function view_login()
	{
		if(isset($this->session->userdata['logged_in'])){
			alert('alert_login','warning','Warning','Sudah Login');
			if ($this->session->userdata['logged_in']['akses'] == 'admin') {
				redirect('Admin_C/view_read_obat');
			}
			elseif ($this->session->userdata['logged_in']['akses'] == 'ppk') {
				redirect('Ppk_C/view_id');
			}
			else if ($this->session->userdata['logged_in']['akses'] == 'pasien') {
				redirect('Pasien_C/view_log_pengobatan/'.$this->session->userdata['logged_in']['id_user']);
			}
		}
		// jika belum login / tidak ada sesion yang aktiv
		else{
			$this->load->view('html/header');
			$this->load->view('html/login');
			$this->load->view('html/footer');
		}
	}

	public function view_register_user()
	{
		if($this->session->userdata['logged_in']['akses'] == 'admin'){
			$this->load->view('html/header');
			$this->load->view('admin/register_user');
			$this->load->view('html/footer');
		}
		elseif($this->session->userdata['logged_in']['akses'] == 'ppk'){
			$this->load->view('html/header');
			$this->load->view('ppk/register_user_ppk');
			$this->load->view('html/footer');
		}
		else{
			$this->load->view('html/header');
			$this->load->view('umum/register_user_umum');
			$this->load->view('html/footer');
		}
	}

	public function view_registered_user()
	{
		/*tampilkan data-data siapa saja pasien yang telah terdaftar*/
		$dataCol						= array('id_user','nama_user', 'akses', 'no_hp');
		
		if($this->session->userdata['logged_in']['akses'] == 'admin'){
			$dataCondition				= array('akses !='=>'admin');
			$data['registered_user']	=	$this->SO_M->readCol('user',$dataCondition,$dataCol)->result();
			$this->load->view('html/header');
			$this->load->view('admin/registered_user',$data);
			$this->load->view('html/footer');
		}
		elseif($this->session->userdata['logged_in']['akses'] == 'ppk'){
			$dataCondition				= array('akses '=>'pasien');
			$data['registered_user']	=	$this->SO_M->readCol('user',$dataCondition,$dataCol)->result();
			$this->load->view('html/header');
			$this->load->view('ppk/registered_user',$data);
			$this->load->view('html/footer');
		}
		else{
			redirect();
		}
	}

	public function handle_login()
	{
		$this->form_validation->set_rules('nomor_identitas', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		// jika form validation gagal
		if ($this->form_validation->run() == FALSE) { 
			
			// buat alert eror login pada bagian form validation. beritahu pengguna format inputan yang benar
			alert('alert_login','danger','Gagal','Cek inputan form login');
			// arahkan ke halaman login lagi
			redirect();
		}

		// jika form validation sukses
		else {
			// dapatkan input dari form
			$data = array(	
							'nomor_identitas'	=>	$this->input->post('nomor_identitas'),
							'password'			=>	hash("sha256", $this->input->post('password'))
			);

			// cari where nomor dan pass ada di db
			$result = $this->SO_M->read('user',$data)->result();
			
			// saat record ditemukan
			if ($result != array()) {
				
				// fetch data dari database
				$data_user['id_user']		= $result[0]->id_user;
				$data_user['nama_user']		= $result[0]->nama_user;
				$data_user['akses']			= $result[0]->akses;
				$data_user['foto']			= $result[0]->link_foto;

				// set variabel session_data yang akan dijadikan session user yang ditemukan di db
				$session_data = array(
											'akses'		=>	$result[0]->akses,
											'id_user'	=>	$result[0]->id_user,
											'nama_user'	=>	$result[0]->nama_user,
											'foto'		=>	$result[0]->link_foto
				);
				
				// buat pesan sukses login
				alert('alert_login','success','Berhasil','Selamat datang '.$session_data['akses'].' '.$session_data['nama_user']);
				// set session user berdasarkan variabel session_data
				$this->session->set_userdata('logged_in', $session_data);

				// arahkan pada halaman input identitas pasien
				if ($data_user['akses'] == 'admin') {
					redirect('Admin_C/view_read_obat');
				}
				elseif ($data_user['akses'] == 'ppk') {
					redirect('Ppk_C/view_id');
				}
				elseif($data_user['akses'] == 'pasien'){
					redirect("Pasien_C/view_log_pengobatan/".$data_user['id_user']);
				}
			}

			//username password tidak ditemukan
			else {
				// set alert not found
				alert('alert_login','danger','Gagal','Akun anda tidak terdaftar');
				// arahkan ke login lagi
				redirect();
			}
		}
	}
	
	public function handle_logout() 
	{
		// hapus apa saja session yang akan direset
		$sess_array = array(
							'nama_user' => '',
							'akses' =>''
		);

		// hapus session
		$hapus_session = $this->session->unset_userdata('logged_in', $sess_array);
		alert('alert_login','success','Berhasil','Anda berhasil logout');
		// arahkan ke halaman login lagi
		redirect();
	}

	
	/*
	function dibawah ini digunakan oleh admin saat akan mendaftarkan pengguna baru.
	bisa admin, ppk, atau pengguna
	*/
	public function handle_register_user()
	{
		$this->form_validation->set_rules('nama_user','Nama','trim|required');
		$this->form_validation->set_rules('nomor_identitas','No identitas','trim|required|is_unique[user.nomor_identitas]');
		$this->form_validation->set_rules('no_hp','No HP','trim|required|min_length[12]');
		$this->form_validation->set_rules('alamat','Alamat','trim|required');

		if ($this->form_validation->run() == FALSE) {
			alert('alert_register_user','danger','Gagal','Kesalahan pada form validation codeigniter');
			redirect('Akun_C/view_register_user');
		}
		else {

			// settingan uplod gambar
			$config['upload_path']          = FCPATH."assets/images/users_photo/";
			$config['allowed_types']        = 'jpg|png|jpeg';
			$this->load->library('upload',$config);
			
			// coba upload foto
			if($this->upload->do_upload('link_foto')){
				// dapatkan informasi gambar yang diupload. datax digunakan untuk ambil nama foto biar disimpan di database
				$datax = $this->upload->data();	

				// buat alert kalau insert pp di direktori berhasil (link belum masuk db)
				alert('alert_register_foto','success','Berhasil','Foto profil telah ditambahkan');

				// setelah upload foto ke direktori berhasil, ambil semua inputan pengguna
				$data = array(	
								'nama_user'			=>	$this->input->post('nama_user'),
								'password'			=>	hash("sha256", "SO"),
								'nomor_identitas'	=>	$this->input->post('nomor_identitas'),
								'no_hp'				=>	$this->input->post('no_hp'),
								'alamat'			=>	$this->input->post('alamat'),
								'akses'				=>	$this->input->post('akses'),
								'link_foto'			=>	"assets/images/users_photo/".$datax['file_name']
				);

				// masukkan data ke database
				$result = $this->SO_M->create('user',$data);
				$results	=	json_decode($result,true);
				// jika berhasil memasukkan ke database
				if ($results['status']) {
					alert('alert_register_user','success','Berhasil','Registrasi berhasil');
				}

				// jika gagal masuk ke database
				else{
					alert('alert_register_user','success','Gagal','Kegagalan database');
				}
			}
			else{
				alert('alert_register_foto','warning','Gagal','Upload foto profil gagal');
			}

			redirect('Akun_C/view_register_user');
		}
	}

	/*function dobawah ini digunakan saat ppk ingin mendaftarkan pasien baru*/
	public function handle_register_user_umum()
	{
		$this->form_validation->set_rules('nama_user','Nama','trim|required');
		$this->form_validation->set_rules('nomor_identitas','No identitas','trim|required|is_unique[user.nomor_identitas]');
		$this->form_validation->set_rules('no_hp','No HP','trim|required|min_length[12]');
		$this->form_validation->set_rules('alamat','Alamat','trim|required');
		if ($this->form_validation->run() == FALSE) {
			alert('alert_register_user','danger','Gagal','Cek lagi form inputan');
			if ($this->session->userdata['logged_in']['akses'] == 'ppk') {
				redirect('Akun_C/view_register_user_ppk');
			}else{
				redirect('');
			}
		}
		else {
			// settingan uplod gambar
			$config['upload_path']          = FCPATH."assets/images/users_photo/";
			$config['allowed_types']        = 'jpg|png|jpeg';
			$this->load->library('upload',$config);
			// coba upload foto
			if($this->upload->do_upload('link_foto')){
				// dapatkan informasi gambar yang diupload. datax digunakan untuk ambil nama foto biar disimpan di database
				$datax = $this->upload->data();	
				// buat alert kalau insert pp di direktori berhasil (link belum masuk db)
				alert('alert_register_foto','success','Berhasil','Upload foto profil berhasil');
				
				// setelah upload foto ke direktori berhasil, ambil semua inputan pengguna
				$data = array(	
								'nama_user'			=>	$this->input->post('nama_user'),
								'password'			=>	hash("sha256", "SO"),
								'nomor_identitas'	=>	$this->input->post('nomor_identitas'),
								'no_hp'				=>	$this->input->post('no_hp'),
								'alamat'			=>	$this->input->post('alamat'),
								'akses'				=>	'pasien',
								'link_foto'			=>	"assets/images/users_photo/".$datax['file_name']
				);

				// masukkan data ke database
				$result = $this->SO_M->create('user',$data);

				// jika berhasil memasukkan ke database
				if ($result) {
					alert('alert_register_user','success','Berhasil','Registrasi berhasil');
				}

				// jika gagal masuk ke database
				else{
					alert('alert_register_user','warning','Gagal','Kesalahan kueri');
				}
			}
			else{
				// alert gagal upload foto ke direktori
				alert('alert_register_foto','warning','Gagal','upload foto profil gagal');
			}
			if ($this->session->userdata['logged_in']['akses'] == 'ppk') {
				redirect('Akun_C/view_register_user_ppk');
			}else{
				redirect('');
			}
		}
	}

	public function reset_password($id_user)
	{
		if ($this->session->userdata['logged_in']['akses'] == 'admin') {
			$dataWhere	=	array("id_user" => $id_user);
			$dataUpdate =	array("password" => hash("sha256", "SO"));

			$result = $this->SO_M->update('user',$dataWhere,$dataUpdate);
			$results = json_decode($result);
			if ($results->status) {
				alert('alert_reset_password','success','Berhasil','Reset password berhasil');
			}
			else{
				alert('alert_reset_password','danger','Gagal','Reset password gagal');
			}
			redirect('Akun_C/view_registered_user');
		}
	}
}
