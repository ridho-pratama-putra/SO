<div class="col">
	<br>
	<div class="col-lg-6 offset-lg-3 center-block" id="alert">
	<?=$this->session->flashdata("alert_login");?>
	<?=$this->session->flashdata("alert_register_user");?>
	<?=$this->session->flashdata("alert_register_foto");?>
	</div>
	<br>
	<div class="jumbotron col-lg-6 offset-lg-3">
		<div class="row">
			<div class="col-12">
				<h2 class="text-center">Login</h2>
			</div>	
		</div>
		<form class="form-horizontal" action="<?php echo site_url('/Akun_C/handle_login/') ?>" method="POST" role="form">
			<div class="col-12">
		  		<input type="text" class="form-control" id="nomor_identitas" placeholder="Masukkan nomor identitas anda" title="masukkan nomor identitas pasien yang terdaftar" name="nomor_identitas">
		  	</div>
			<div class="col-12 margin-top-15">
		  		<input type="password" class="form-control" id="password" placeholder="Password" name="password">
			<br>
			</div>
			<div class="col-12">
				<button type="submit" class="btn btn-primary btn-block bg-dark">Kirim</button>
			</div>
		</form>
		<div class=" col-12 margin-top-15">
			<a href="<?=base_url()?>Akun_C/view_register_user_umum" class="btn btn-primary btn-block bg-dark" role='button'>Register</a>
		</div>
	</div>
</div>