<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pemberian Saran Obat</title>
</head>
<link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/sidebar-kanan.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/custom.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/select2/css/select2.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/ionicons-2.0.1/css/ionicons.css"/>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/sweetalert/src/sweetalert.css"/> -->

<script type="text/javascript" src="<?php echo base_url()?>assets/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/DataTables/DataTables-1.10.16/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/DataTables/DataTables-1.10.16/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/select2/js/select2.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url()?>assets/sweetalert/src/sweetalert.js"></script> -->

<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
			<a class="navbar-brand text-white">Sistem Pemberian Saran Obat</a>
		  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<!-- <ul class="navbar-nav mr-auto">
					<li class="nav-item active">
			        	<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#">Sign Out</a>
							<a class="dropdown-item" href="#">Setting</a>
						</div>
					</li>
				</ul> -->
				<?php if ($this->session->userdata('logged_in') != NULL) { ?>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown" style="margin-right: 150px;">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<?php if ($this->session->userdata('logged_in')['akses'] == 'admin') { ?>
								<a class="dropdown-item" href="<?=base_url()?>Admin_C/view_read_obat">Lihat KB Obat</a>
								<!-- <a class="dropdown-item" href="<?=base_url()?>Admin_C/view_CRUD_gejala">CRUD Gejala</a> -->
								<a class="dropdown-item" href="<?=base_url()?>Admin_C/view_CRUD_gejala">Lihat Gejala</a>
								<a class="dropdown-item" href="<?=base_url()?>Admin_C/view_kondisi">Lihat Kondisi</a>
								<a class="dropdown-item" href="<?=base_url()?>Akun_C/view_registered_user">Registered User</a>
								<!-- <a class="dropdown-item" href="#" title="DORONG MARI">Lihat Rekam Medis Pasien</a> -->
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" title="DORONG MARI">Setting</a>
								<a class="dropdown-item" href="<?=base_url()?>Akun_C/handle_logout">Sign Out : <?=$this->session->userdata('logged_in')['akses']?> <?=$this->session->userdata('logged_in')['nama_user']?></a>
							<?php }
							elseif ($this->session->userdata('logged_in')['akses'] == 'ppk') {?>
								<a class="dropdown-item" href="<?=base_url()?>Ppk_C/view_read_obat">Lihat KB Obat</a>
								<a class="dropdown-item" href="<?=base_url()?>Akun_C/view_registered_user">Registered user</a>
								<!-- <a class="dropdown-item" href="<?=base_url()?>Akun_C/view_form_kondisi_user">Input kondisi Pasien</a> -->
								<!-- <a class="dropdown-item" href="#">Lihat kondisi Pasien</a> -->
								<a class="dropdown-item" href="<?=base_url()?>Ppk_C/view_id">Pemeriksaan</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" title="DORONG MARI">Setting</a>
								<a class="dropdown-item" href="<?=base_url()?>Akun_C/handle_logout">Sign Out : <?=$this->session->userdata('logged_in')['akses']?> <?=$this->session->userdata('logged_in')['nama_user']?></a>
							<?php } else{ ?>
								<a class="dropdown-item" href="<?=base_url()?>Pasien_C/view_log_pengobatan/">Log Pengobatan</a>
								<a class="dropdown-item" href="<?=base_url()?>Pasien_C/view_lihat_data_rekam_medis/">Lihat Rekam Medis Pasien</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" title="DORONG MARI">Setting</a>
								<a class="dropdown-item" href="<?=base_url()?>Akun_C/handle_logout">Sign Out : <?=$this->session->userdata('logged_in')['akses']?> <?=$this->session->userdata('logged_in')['nama_user']?></a>
							<?php } ?>

						</div>
					</li>
				</ul>
				<?php } ?>
			</div>
		</nav>
	</header>


