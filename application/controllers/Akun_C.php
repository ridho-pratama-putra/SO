<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun_C extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('SO_M');
		date_default_timezone_set("Asia/Jakarta");
	}

	function view_login()
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
				redirect('Pasien_C/view_log_pengobatan/');
			}
		}
		// jika belum login / tidak ada sesion yang aktiv
		else{
			$this->load->view('html/header');
			$this->load->view('html/login');
			$this->load->view('html/footer');
		}
	}

	function view_register_user()
	{
		if($this->session->userdata('logged_in')['akses'] == 'admin'){
			$this->load->view('html/header');
			$this->load->view('admin/register_user');
			$this->load->view('html/footer');
		}
		elseif($this->session->userdata('logged_in')['akses'] == 'ppk'){
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

	function view_registered_user()
	{
		/*tampilkan data-data siapa saja pasien yang telah terdaftar*/
		if($this->session->userdata['logged_in']['akses'] == 'admin'){
			$dataCondition				= array('akses !='=>'admin');
			$data['registered_user']	=	$this->SO_M->read('user',$dataCondition)->result();
			$this->load->view('html/header');
			$this->load->view('admin/registered_user',$data);
			$this->load->view('html/footer');
		}
		elseif($this->session->userdata['logged_in']['akses'] == 'ppk'){
			$dataCondition				=	array('akses '=>'pasien');
			$data['registered_user']	=	$this->SO_M->read('user',$dataCondition)->result();
			$this->load->view('html/header');
			$this->load->view('ppk/registered_user',$data);
			$this->load->view('html/footer');
		}
		else{
			redirect();
		}
	}

	function handle_login()
	{
		$this->form_validation->set_rules('nomor_identitas', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		// jika form validation gagal
		if ($this->form_validation->run() == FALSE) { 
			// buat alert eror login pada bagian form validation. beritahu pengguna format inputan yang benar
			alert('alert_login','danger','Gagal','Cek inputan form login');
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
	
	function handle_logout() 
	{
		// hapus apa saja session yang akan direset
		$sess_array = array(
							'akses'		=>	'',
							'id_user'	=>	'',
							'nama_user'	=>	'',
							'foto'		=>	''
		);

		// hapus session
		$hapus_session = $this->session->unset_userdata('logged_in', $sess_array);
		alert('alert_login','success','Berhasil','Anda berhasil logout');
		// arahkan ke halaman login lagi
		redirect();
	}

	function view_ubah_password($id_user)
	{
		$result = $this->SO_M->readCol('user',array('id_user'=>$id_user),array('id_user','nama_user'));
		if ($result->num_rows() == 1) {
			$data['id_user'] = $result->result();
			$this->load->view('html/header');
			$this->load->view('umum/ubah_password',$data);
			$this->load->view('html/footer');
		}else{
			$data['heading']		=	"id user tidak terdaftar";
			$data['message']		=	"";
			$this->load->view('errors/html/error_404',$data);
		}
	}

	/*
	function dibawah ini digunakan oleh admin saat akan mendaftarkan pengguna baru.
	bisa admin, ppk, atau pengguna
	*/
	function handle_register_user()
	{
		$this->form_validation->set_rules('nama_user','Nama','trim|required');
		$this->form_validation->set_rules('nomor_identitas','No identitas','trim|required|is_unique[user.nomor_identitas]');
		$this->form_validation->set_rules('no_hp','No HP','trim|required|min_length[12]');
		$this->form_validation->set_rules('alamat','Alamat','trim|required');

		if ($this->form_validation->run() == FALSE) {
			alert('alert_register_user','danger','Gagal','Kesalahan pada form validation');
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
	function handle_register_user_umum()
	{
		$this->form_validation->set_rules('nama_user','Nama','trim|required');
		$this->form_validation->set_rules('nomor_identitas','No identitas','trim|required|is_unique[user.nomor_identitas]');
		$this->form_validation->set_rules('no_hp','No HP','trim|required|min_length[10]');
		$this->form_validation->set_rules('alamat','Alamat','trim|required');
		if ($this->form_validation->run() == FALSE) {
			alert('alert_register_user','danger','Gagal','Cek lagi form inputan');
			if (isset($this->session->userdata['logged_in'])) {
				if ($this->session->userdata['logged_in']['akses'] == 'ppk') {
					redirect('Akun_C/view_register_user_ppk');
				}else{
					redirect('Akun_C/view_register_user');
				}
			}else{
				redirect('Akun_C/view_register_user');
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
			if (isset($this->session->userdata['logged_in'])) {
				if ($this->session->userdata['logged_in']['akses'] == 'ppk') {
					redirect('Akun_C/view_register_user_ppk');
				}else{
					redirect('Akun_C/view_register_user');
				}
			}
			else{
				redirect('Akun_C/view_register_user');
			}
		}
	}

	function reset_password($id_user)
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

	function handle_ubah_password()
	{
		if ($this->input->post()!= null) {
			$id_user = $this->input->post('id_user');
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');
			$verif_password = $this->input->post('verif_password');
			$encrypted_current = hash("sha256",$current_password);
			$cek_user_dan_password = $this->SO_M->readCol('user',array('id_user'=>$id_user,'password'=>$encrypted_current),array('id_user'));
			if ($cek_user_dan_password->num_rows() == 1) {
				$encrypted_new = hash('sha256',$new_password);
				$encrypted_verif = hash('sha256',$verif_password);
				if ($encrypted_new == $encrypted_verif) {
					$result = $this->SO_M->update('user',array('id_user'=>$id_user),array('password'=>$encrypted_verif));
					$results = json_decode($result);
					if ($results->status) {
						alert('alert_ubah_password','success','Berhasil','Ubah password berhasil');
					}
					else{
						alert('alert_ubah_password','danger','Gagal','Ubah password gagal');
					}
				}else{
					alert('alert_ubah_password','danger','Gagal','password baru dengan password verifikasi tidak sama');
				}
			}else{
				alert('alert_ubah_password','danger','Gagal','data user tidak ditemukan');
			}
		}else{
			alert('alert_ubah_password','danger','Gagal','tidak ada data yang di post');
		}
		redirect('Akun_C/view_ubah_password/'.$id_user);
	}
	function view_edit_identitas($id_user)
	{
		if ($id_user == $this->session->userdata['logged_in']['id_user']) {
			$data['user'] = $this->SO_M->read('user',array('id_user'=>$id_user))->result();
			$this->load->view('html/header');
			$this->load->view('umum/edit_identitas',$data);
			$this->load->view('html/footer');
		}else{
			redirect('Akun_C/view_edit_identitas/'.$this->session->userdata['logged_in']['id_user']);
		}
	}
	function handle_edit_identitas()
	{
		$update = $this->SO_M->update('user',array('id_user'=>$this->input->post('id_user')),array('nomor_identitas'=>$this->input->post('nomor_identitas'),'tanggal_lahir'=>$this->input->post('tanggal_lahir')));
		$update = json_decode($update);
		if ($update->status) {
			alert('alert_edit_identitas','success','Berhasil','Perubahan telah masuk database');
		}else{
			alert('alert_edit_identitas','danger','Gagal','Perubahan tidak masuk database');
		}
		redirect('Akun_C/view_edit_identitas/'.$this->input->post('id_user'));
	}
}
