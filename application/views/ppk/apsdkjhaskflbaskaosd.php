<?php
	
/*get hasil rijik 17 maret*/
	public function get_hasil($nomor_identitas)
	{
		$dataWhere	=	array('nomor_identitas' => $nomor_identitas);
		$query		=	$this->SO_M->read('user',$dataWhere);
		if ($query->num_rows() != 0) {
			$data['user']	=	$query->result();
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
				$kirim['data'] = json_encode($data);
				$this->load->view('html/header');
				$this->load->view('ppk/hasil',$kirim);
				$this->load->view('html/footer');
			}else{
				$data['heading']	= "Data tidak ditemukan";
				$data['message']	= "<p>Coba lagi <a href='".base_url()."Ppk_C/view_gejala/".$data['user'][0]->nomor_identitas."'>Masukkan gejala yang dirasakan pasien</a> </p>";
				$this->load->view('errors/html/error_general',$data);
			}
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Akun_C/view_registered_user'>Cari identitas pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}
/*get hasil rijik 17 maret*/


/*get hasil komen2*/
// halaman untuk menampilkan hasil inputan gejala. disini ditampilkan obat-obat beserta karakteristiknya dan kecocokannya dengan seorang pasien
	public function get_hasil($nomor_identitas)
	{
		$dataWhere	=	array('nomor_identitas' => $nomor_identitas);
		$query		=	$this->SO_M->read('user',$dataWhere);
		if ($query->num_rows() != 0) {
			$data['user']	=	$query->result();
			if ($this->input->post() != null) {
				
				/*FORWARD CHAINING*/
				/*1 buat query obat id berapa saja yang mengandung gejala yang sesuai dengan gejala inputan*/
				/*dapatkan gejala yang diinputkan*/
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
				// cari obat (id_obat dan nama obatnya nya) yang sesuai gejala
				$this->db->select('karakteristik_obat.id_obat , master_obat.nama_obat');
				$this->db->distinct();
				$this->db->where($where);
				$this->db->join('master_obat','karakteristik_obat.id_obat = master_obat.id_obat','inner');
				$querys = $this->db->get('karakteristik_obat');
				// $querys = $this->db->get_compiled_select('karakteristik_obat');
				// var_dump($querys);
				// var_dump($querys->result());
				unset($where);
				// die();
				/*END OF FORWARD CHAINING*/

				/*dapatkan kondisi user*/
				$dataWhere = array('id_user' => $data['user'][0]->id_user);
				$kondisiPasien = $this->SO_M->read('kondisi',$dataWhere)->result_array();
				unset($dataWhere);


				/*BACKWARD CHAINING*/
				$query = $querys->result();
				$data['obat'] = $query;
				// echo "<pre>";
				// var_dump($data);
				// var_dump($data['obat'][0]->karakteristik = 'rusa');
				// die();
				/*2 dari id obat diatas, koreksi karakteristik yang dikandung*/
				for ($i=0; $i < ($querys->num_rows()) ; $i++) { 

					/*2.1 koreksi indikasi*/
					/*2.1.1 daptkan indikasi pada masing2 obat*/
					$dataWhere			=	array(
													'tipe' => 'indikasi',
													'id_obat' => $query[$i]->id_obat
											);
					$dataIndikasi		=	$this->SO_M->read('karakteristik_obat',$dataWhere)->result();

					/*buat array untuk memetakan masing2 karakteristik*/
					
					foreach ($dataIndikasi as $key => $value) {
						if (in_array($dataIndikasi[$key]->detail_tipe,$gejalas)) {
							$data['obat'][$i]->karakteristik['indikasi']['ada'][] = array(	
																								'id_karakteristik'	=>	$dataIndikasi[$key]->id_karakteristik,
																								'detail_tipe'		=>	$dataIndikasi[$key]->detail_tipe
																							);
						}else{
							$data['obat'][$i]->karakteristik['indikasi']['tanya'][] = array(	
																								'id_karakteristik'	=>	$dataIndikasi[$key]->id_karakteristik,
																								'detail_tipe'		=>	$dataIndikasi[$key]->detail_tipe
																							);
						}
					}

					/*2.2 koreksi kontraindikasi*/
					/*2.2.1 daptkan indikasi pada masing2 obat*/
					$dataWhere			=	array(
													'tipe' => 'kontraindikasi',
													'id_obat' => $query[$i]->id_obat
											);
					$dataKontraindikasi	= $this->SO_M->read('karakteristik_obat',$dataWhere)->result();

					/*buat array untuk memetakan masing2 karakteristik*/
					foreach ($dataKontraindikasi as $key => $value) {
						if ($this->in_array_r($dataKontraindikasi[$key]->detail_tipe,$kondisiPasien)) {
							$data['obat'][$i]->karakteristik['kontraindikasi']['ada'][] = array(	
																								'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,
																								'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe
																							);
						}else{
							$data['obat'][$i]->karakteristik['kontraindikasi']['tanya'][] = array(	
																								'id_karakteristik'	=>	$dataKontraindikasi[$key]->id_karakteristik,
																								'detail_tipe'		=>	$dataKontraindikasi[$key]->detail_tipe
																							);
						}
					}


					/*2.3 koreksi peringatan*/
					/*2.3.1 daptkan indikasi pada masing2 obat*/
					$dataWhere			=	array(
													'tipe' => 'peringatan',
													'id_obat' => $query[$i]->id_obat
											);
					$dataPeringatan		= $this->SO_M->read('karakteristik_obat',$dataWhere)->result();

					/*buat array untuk memetakan masing2 karakteristik*/
					foreach ($dataPeringatan as $key => $value) {
						if ($this->in_array_r($dataPeringatan[$key]->detail_tipe,$kondisiPasien)) {
							$data['obat'][$i]->karakteristik['peringatan']['ada'][] = array(	
																								'id_karakteristik'	=>	$dataPeringatan[$key]->id_karakteristik,
																								'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe
																							);
						}else{
							$data['obat'][$i]->karakteristik['peringatan']['tanya'][] = array(	
																								'id_karakteristik'	=>	$dataPeringatan[$key]->id_karakteristik,
																								'detail_tipe'		=>	$dataPeringatan[$key]->detail_tipe
																							);
						}
					}

				}
				/*END OF BACKWARD CHAINING*/


				/*3 kirimkan hasil koreksi*/
				// echo "<pre>";
				// $data = json_encode($data,JSON_PRETTY_PRINT);
				$kirim['data'] = json_encode($data);
				// var_dump($data);
				// die();
				$this->load->view('html/header');
				$this->load->view('ppk/hasil',$kirim);
				$this->load->view('html/footer');
			}else{
				$data['heading']	= "Data tidak ditemukan";
				$data['message']	= "<p>Coba lagi <a href='".base_url()."Ppk_C/view_gejala/".$data['user'][0]->nomor_identitas."'>Masukkan gejala yang dirasakan pasien</a> </p>";
				$this->load->view('errors/html/error_general',$data);
			}
		}else{
			$data['heading']	= "Data tidak ditemukan";
			$data['message']	= "<p>Coba lagi <a href='".base_url()."Akun_C/view_registered_user'>Cari identitas pasien</a> </p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}
/*get hasil komen2*/