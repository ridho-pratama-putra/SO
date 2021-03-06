<div class="col">
	<br>
	<div class="col-lg-6 offset-lg-3 center-block" id="alert">
	<?=$this->session->flashdata("alert_register_foto");?>
	<?=$this->session->flashdata("alert_register_user");?>
	<?php if (validation_errors()) { ?>
		<div class="alert alert-danger" alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		<?=validation_errors()?>
		</div>
	<?php }?>
	</div>
	<br>
	<div class="jumbotron col-lg-6 offset-lg-3">
		<div class="row">
			<div class="col-12">
				<h2 class="text-center">Register Pasien</h2>
			</div>	
		</div>
		<form class="form-horizontal" action="<?php echo site_url('/Akun_C/handle_register_user_umum/') ?>" method="POST" role="form" enctype="multipart/form-data">
			<div class="col-12 margin-top-15 form-group">
				<input type="text" class="form-control" id="nama_user" placeholder="Masukkan nama" title="masukkan nomor identitas" name="nama_user">
			</div>
			<div class="col-12 margin-top-15 form-group">
				<input type="text" class="form-control" id="nomor_identitas" placeholder="Masukkan nomor identitas" title="masukkan nomor identitas" name="nomor_identitas">
			</div>
			<div class="col-12 margin-top-15 form-group input-group">
				<div class="input-group-prepend">
					<div class="input-group-text">+62</div>
				</div>
				<input type="telephone" class="form-control" id="no_hp" placeholder="Masukkan nomor hp" title="masukkan nomor hp" name="no_hp">
			</div>
			<div class="col-12 margin-top-15 form-group">
				<input type="text" class="form-control" id="alamat" placeholder="Masukkan alamat" title="masukkan alamat" name="alamat">
			</div>
			<div class="col-12 margin-top-15 form-group">
				<input type="file" class="form-control-file" id="link_foto" title="Masukkan foto" name="link_foto">
			</div>
			<br>
			<div class="col-12">
				<button type="submit" class="btn btn-primary btn-block bg-dark">Kirim</button>
			</div>
		</form>
	</div>
</div>