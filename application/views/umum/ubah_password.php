<main>
	<div class="col margin-top-15">
	<div class="jumbotron col-lg-6 offset-lg-3">
		<?=$this->session->flashdata("alert_ubah_password");?>
		<br>	
		<form action="<?=base_url()?>Akun_C/handle_ubah_password" method="POST">	
			<div class="col">
				<h3 class="text-center" >Ubah password</h3>
				<input type="hidden" class="form-control" id="id_user" name="id_user" value="<?=$id_user[0]->id_user?>">
				<div class="margin-top-15 form-group">
					<input type="password" class="form-control" id="current_password" placeholder="Masukkan password lama anda" name="current_password" required>
				</div>
				<div class="margin-top-15 form-group">
					<input type="password" class="form-control" id="new_password" placeholder="Masukkan password baru anda" name="new_password" required>
				</div>
				<div class="margin-top-15 form-group">
					<input type="password" class="form-control" id="verif_password" placeholder="Ketikkan lagi password baru anda" name="verif_password" required>
				</div>
			</div>

			<div class="col margin-top-15">
				<button type="submit" class="btn bg-dark btn-block text-white"> <i class="icons  ion-android-send"></i> Kirim</button>
			</div>
		</form>
	</div>
		<br>
	</div>
</main>