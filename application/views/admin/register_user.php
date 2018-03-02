<div class="col">
	<br>
	<div class="col-lg-6 offset-lg-3 center-block" id="alert">
	<?=$this->session->flashdata("alert_register_foto");?>
	<?=$this->session->flashdata("alert_register_user");?>
	</div>
	<br>
	<div class="jumbotron col-lg-6 offset-lg-3">
		<div class="row">
			<div class="col-12">
				<h2 class="text-center">Register User</h2>
			</div>	
		</div>
		<form class="form-horizontal" action="<?php echo site_url('/Akun_C/handle_register_user/') ?>" method="POST" role="form" enctype="multipart/form-data">
			<div class="col-12 margin-top-15 form-group">
				<input type="text" class="form-control" id="nama_user" placeholder="Masukkan nama" title="masukkan nomor identitas" name="nama_user">
			</div>
			<div class="col-12 margin-top-15 form-group">
				<input type="text" class="form-control" id="nomor_identitas" placeholder="Masukkan nomor identitas" title="masukkan nomor identitas" name="nomor_identitas">
			</div>
			<div class="col-12 margin-top-15 form-group">
				<input type="telephone" class="form-control" id="no_hp" placeholder="Masukkan nomor hp" title="masukkan nomor hp" name="no_hp">
			</div>
			<div class="col-12 margin-top-15 form-group">
				<input type="text" class="form-control" id="alamat" placeholder="Masukkan alamat" title="masukkan alamat" name="alamat">
			</div>
			<div class="col-12 margin-top-15">
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input class="form-check-input" type="radio" name="akses" id="akses1" value="admin">admin
					</label>
				</div>
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input class="form-check-input" type="radio" name="akses" id="akses2" value="ppk" checked>ppk
					</label>
				</div>
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input class="form-check-input" type="radio" name="akses" id="akses3" value="pasien">pasien
					</label>
				</div>
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