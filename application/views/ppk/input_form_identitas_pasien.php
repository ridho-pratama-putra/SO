<div class="col">
	<br>
	<div class="col-lg-6 offset-lg-3 center-block" id="alert">
	<?=$this->session->flashdata("alert_login");?>
	<?=$this->session->flashdata("alert_register_user");?>
	</div>
	<br>
	<div class="jumbotron col-lg-6 offset-lg-3">
		<form action="<?=base_url()?>Ppk_C/handle_view_id" method="GET">
			<div class="row">
				<div class="col-sm-12">
					<h2 class="text-center">Form Identitas Pasien</h2>
				</div>	
				<div class="col-sm-12 text-center">
				  	Nomor Identitas/KTP	:
			 	<br>
			 	<br>
			 	</div>
				<div class="col-sm-12">
			  		<input type="text" class="form-control" id="nomor_identitas" placeholder="masukkan nomor identitas pasien yang terdaftar" title="masukkan nomor identitas pasien yang terdaftar" name="nomor_identitas">
				<br>
				</div>
				<div class="col-sm-12">
					<button class="btn btn-primary btn-block bg-dark" type="submit">Kirim</button>
				</div>
			</div>
		</form>
	</div>
</div>
