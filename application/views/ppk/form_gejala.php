<div class="col-md-10">
	<br>
	<div class="row">
		<div class="col-sm-12 text-center">
			<h2 class="text-center">Form Input gejala / keluhan pasien</h2>
		</div>	
	 	<br>
	 	<br>
	 	<br>
	 	<div class="col">
			<form method="POST" class="form-group" action="<?=base_url()?>Ppk_C/view_hasil/<?=$user[0]->nomor_identitas?>">
				<div class="col-12">
					<!-- <div class="row">
						<div class="col-3 offset-2 bg-primary rounded">
							<div class="col">
								<h5 class="text-center text-white">ID</h5>
							</div>
							<div class="col">
								<h3 class="text-center text-white">4</h3>
							</div>
						</div>
						<div class="col-2">
						</div>
						<div class="col-3 bg-primary rounded">
							<div class="col">
								<h5 class="text-center text-white">Tanggal</h5>
							</div>
							<div class="col">
								<h3 class="text-center text-white">12-02-2018</h3>
							</div>
						</div>
					</div> -->
					<div class="row">
						<input name="id_diagnosa" type="hidden">
						<input name="tanggal" type="hidden">
					</div>
					<br>
					<br>
					<div class="row">
						<div class="col">
							<h4 class="text-center">Gejala (multiple)</h4>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<script type="text/javascript">
								$(document).ready(function() {
									$('#select_gejala').select2({
										placeholder: 'ketikkan gejala-gejala'
									});
								});
							</script>
							<select class="js-example-basic-multiple col" id="select_gejala" name="gejala[]" multiple="multiple" title="masukkan gejala-gejala yang dirasakan pasien" required>
								<?php
								foreach ($gejala as $key => $value) {
								?>
									<option value="<?=$value->id_gejala?>"><?=$value->detail_gejala?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<br>
				</div>
				<div class="col-12">
					<button type="submit" class="btn btn-primary btn-block bg-dark"> KIRIM </button>
				</div>
			</form>
	 	</div>
	</div>
</div>

<!-- SIDE NAAV HERE -->
<nav class="col-md-2 d-none d-sm-block bg-light sidebar" id="style-1">
	<ul class="nav nav-pills flex-column">
		<li class="nav-item">
			<div>
				<img src="<?php echo base_url().$user[0]->link_foto?>" alt="foto-profil" class="img-thumbnail rounded">
			</div>
		</li>

		<li class="nav-item">
			<span class="nav-link">Nama : <i class="nav-link disabled" href="#"><?=$user[0]->nama_user?></i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Tanggal Lahir / Umur<i class="nav-link disabled" href="#"><?=$user[0]->tanggal_lahir != '' ? tgl_indo($user[0]->tanggal_lahir) : 'YYYY-mm-dd' ?> / <?=$umur->y?> Thn</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Nomor Identitas<i class="nav-link disabled"><?=$user[0]->nomor_identitas?></i></span>
		</li>
	</ul>
</nav>