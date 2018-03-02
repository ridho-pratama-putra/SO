<div class="container">
	<div class="jumbotron col-lg-6 offset-lg-3">
		<h3 class="text-center">Rename Obat : <?=$nama_obat[0]->nama_obat?></h3>
		<form action="<?=base_url()?>Admin_C/handle_rename_obat" method="POST">
			<div class="col">
				<div class="margin-top-15 form-group">
					<div class="">
						<input type="hidden" class="form-control" name="id_obat" value="<?=$nama_obat[0]->id_obat?>">
						<input type="hidden" class="form-control" name="nama_obat_old" value="<?=$nama_obat[0]->nama_obat?>">
						<input type="text" class="form-control" placeholder="Masukkan nama baru untuk obat <?=$nama_obat[0]->nama_obat?>" name="nama_obat_new">
					</div>
				</div>
			</div>
			<div class="col margin-top-15">
				<button type="submit" class="btn bg-dark btn-block text-white"> <i class="icons  ion-android-send"></i> Masukkan DB</button>
			</div>
		</form>
	</div>
</div>