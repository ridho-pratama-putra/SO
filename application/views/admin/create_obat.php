<main>
	<div class="col margin-top-15">
	<div class="jumbotron col-lg-6 offset-lg-3">	
		<form action="<?=base_url()?>Admin_C/handle_create_obat" method="POST">
			
			<div class="col">
				<h3 class="text-center" >Create KB obat</h3>
				<div class="margin-top-15 form-group">
					<div class="">
						<input type="text" class="form-control" id="nama_obat" placeholder="Masukkan Nama Obat" name="nama_obat" required>
					</div>
				</div>
				<div class="margin-top-15 form-group">
					<div class="">
						<select class="form-control" name="sediaan_obat" required>
							
						</select>
					</div>
				</div>
			</div>

			<div class="col margin-top-15">
				<button type="submit" class="btn bg-dark btn-block text-white"><i class="icons  ion-android-send"></i> Masukkan DB</button>
			</div>
		</form>
	</div>
		<br>
	</div>
</main>