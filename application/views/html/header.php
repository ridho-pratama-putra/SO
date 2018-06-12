<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem pemberian saran obat menggunakan metode Forward Chaining dan Backward Chaining oleh ridho pratama putra">
    <meta name="author" content="mandor: M. Zainal Arifin, analis: Agusta Rakhmat Taufani, kuli : Ridho Pratama Putra">
    <meta property="og:title" content="Sistem Pemberian Saran Obat" />
    <meta property="og:description" content="Sistem Pemberian Saran Obat menggunakan metode Forward Chaining dan Backward Chaining" />
    <meta property="og:image" content="<?=base_url('assets/images/1.jpg')?>" />
    <title> Sistem Pemberian Saran Obat</title>
</head>

<link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/jQuery-Autocomplete-devbridge/content/styles.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">

<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/sidebar-kanan.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/custom.css">

<!-- SELECT2 -->
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

<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/wysihtml5/bootstrap-wysihtml5-0.0.2.css"/>
<script type="text/javascript" src="<?php echo base_url()?>assets/wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/wysihtml5/bootstrap-wysihtml5-0.0.2.min.js"></script>
 -->

<!-- WYSI ADMIN PINTER -->
<link rel="stylesheet" href="<?=base_url('assets/wysihtml/')?>examples/css/stylesheet.css" type="text/css" media="screen" title="no title" charset="utf-8">
<script src="<?=base_url('assets/wysihtml/')?>dist/wysihtml.js"></script>
<script src="<?=base_url('assets/wysihtml/')?>dist/wysihtml.all-commands.js"></script>
<script src="<?=base_url('assets/wysihtml/')?>dist/wysihtml.table_editing.js"></script>
<script src="<?=base_url('assets/wysihtml/')?>dist/wysihtml.toolbar.js"></script>
<script src="<?=base_url('assets/wysihtml/')?>parser_rules/advanced_and_extended.js"></script>


<!-- autocomlete -->
<script type="text/javascript" src="<?php echo base_url()?>assets/jQuery-Autocomplete-devbridge/dist/jquery.autocomplete.min.js"></script>

<body>
	<header>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
			<a href="<?=base_url()?>" class="navbar-brand text-white"><h6 style="margin-top: 5px;">Sistem Pemberian Saran Obat</h6></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<?php if ($this->session->userdata('logged_in') != NULL) { ?>
					<ul class="navbar-nav ml-auto">
						<?php
						$method = $this->router->fetch_method();
						if ($this->session->userdata('logged_in')['akses'] == 'admin') { ?>
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_read_obat') ? 'active' : ''?>" href="<?=base_url()?>Admin_C/view_read_obat">Master Obat</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_gejala') ? 'active' : ''?>" href="<?=base_url()?>Admin_C/view_gejala">Master Gejala</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_kondisi') ? 'active' : ''?>" href="<?=base_url()?>Admin_C/view_kondisi">Master Kondisi</a>
							</li>
							<!-- <li class="nav-item">
								<a class="nav-link <?=($method == 'view_sediaan') ? 'active' : ''?>" href="<?=base_url()?>Admin_C/view_read_sediaan">Master Sediaan</a>
							</li> -->
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_registered_user') ? 'active' : ''?>" href="<?=base_url()?>Akun_C/view_registered_user">Registered User</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_ubah_password') ? 'active' : ''?>" href="<?=base_url('Akun_C/view_ubah_password/'.$this->session->userdata('logged_in')['id_user'])?>">Ubah Password</a>
							</li>
							<div class="dropdown-divider"></div>
							<li class="nav-item">
								<a class="nav-link " href="<?=base_url()?>Akun_C/handle_logout">Sign Out : <?=$this->session->userdata('logged_in')['akses']?> <?=$this->session->userdata('logged_in')['nama_user']?></a>
							</li>
						<?php }
							elseif ($this->session->userdata('logged_in')['akses'] == 'ppk') {?>
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_read_obat') ? 'active' : ''?>" href="<?=base_url()?>Ppk_C/view_read_obat">Pengetahuan Obat</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_registered_user') ? 'active' : ''?>" href="<?=base_url()?>Akun_C/view_registered_user">Registered user</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_id') ? 'active' : ''?>" href="<?=base_url()?>Ppk_C/view_id">Pemeriksaan</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_ubah_password') ? 'active' : ''?>" href="<?=base_url('Akun_C/view_ubah_password/'.$this->session->userdata('logged_in')['id_user'])?>" >Ubah Password</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=base_url('Akun_C/view_edit_identitas/'.$this->session->userdata('logged_in')['id_user'])?>" >Edit Identitas</a>
							</li>
							<div class="dropdown-divider"></div>
							<li class="nav-item">
								<a class="nav-link" href="<?=base_url()?>Akun_C/handle_logout">Sign Out : <?=$this->session->userdata('logged_in')['akses']?> <?=$this->session->userdata('logged_in')['nama_user']?></a>
							</li>
						<?php } else{ ?>
							<li class="nav-item">
								<a class="nav-link <?=($method == 'view_ubah_password') ? 'active' : ''?>" href="<?=base_url('Akun_C/view_ubah_password/'.$this->session->userdata('logged_in')['id_user'])?>">Ubah Password</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=base_url('Akun_C/view_edit_identitas/'.$this->session->userdata('logged_in')['id_user'])?>" >Edit Identitas</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=base_url()?>Akun_C/handle_logout">Sign Out : <?=$this->session->userdata('logged_in')['akses']?> <?=$this->session->userdata('logged_in')['nama_user']?></a>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
		</nav>
	</header>