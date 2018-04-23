<script type="text/javascript">
$(document).ready(function(){
	$("#files").on('change', function () {

	    var reader = new FileReader();

	    reader.onload = function (e) {
	        // get loaded data and render thumbnail.
	        document.getElementById("image").src = e.target.result;
	    };

	    // read the image file as a data URL.
	    reader.readAsDataURL(this.files[0]);
	});	
});	
</script>
<main>
	<div class="col margin-top-15">
	<div class="jumbotron col-lg-6 offset-lg-3">
		<?=$this->session->flashdata("alert_edit_identitas");?>
		<form action="<?=base_url()?>Akun_C/handle_edit_identitas" method="POST">	
			<div class="col margin-top-15">
				<h3 class="text-center" >Edit Identitas</h3>
				<input type="hidden" class="form-control" id="id_user" name="id_user" value="<?=$user[0]->id_user?>" readonly>
				
				<div class="form-group margin-top-15">
					<label for="nomorIdentitas">Nomor Identitas</label>
					<input type="text" class="form-control" id="nomorIdentitas" aria-describedby="nomorIdentitas" value="<?=$user[0]->nomor_identitas?>" name="nomor_identitas">
					<small id="nomorIdentitas" class="form-text text-muted">Masukkan nomor identitas KTP/KTM/Kartu Pelajar anda.</small>
				</div>

				<div class="form-group margin-top-15">
					<label for="tanggalLahir">Tanggal Lahir</label>
					<input type="date" class="form-control" id="tanggalLahir" aria-describedby="tanggalLahir" value="<?=$user[0]->tanggal_lahir?>" name="tanggal_lahir">
					<small id="tanggalLahir" class="form-text text-muted">Masukkan tanggal lahir anda.</small>
				</div>

				<!-- <div class="form-group margin-top-15">
					<label for="fotoProfil">Foto Profil</label><br>
					<img src="<?=base_url($user[0]->link_foto)?>" alt='foto profil yang telah ada' title='foto profil yang telah ada' width="200px" class="img-thumbnail" id="image">
					<input type="text" class="form-control" id="fotoProfil" value="<?=$user[0]->link_foto?>" name="link_foto">
					<input type="file" name="link_foto_baru" id="files">
				</div> -->
			</div>
			<div class="col margin-top-15">
				<button type="submit" class="btn bg-dark btn-block text-white"> <i class="icons  ion-android-send"></i> Kirim</button>
			</div>
		</form>
	</div>
		<br>
	</div>
</main>