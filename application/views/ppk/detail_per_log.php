<div class="col-md-10 konten-kanan" id="style-1">
	<script type="text/javascript">
		$(document).ready(function() {
			$('#detail_gejala_per_user').DataTable({
				"columnDefs": [{
				"targets": [1],
				"orderable": false
			}]
			});
		});

		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});
		$('#tooltip-gejala').tooltip();
	</script>
	<div class="row">
		<div class="col-12 rounded-bottom" style="background-color: #cfd1d3">
			<br>
			<h4 class="text-center">Detail gejala untuk pemeriksaan pada <?=$log_pengobatan[0]->tanggal?></h4>
			<br>
			<br>
			<h3>
				<?php foreach ($gejala_per_log as $key => $value) {	?>
					<span class="badge badge-primary"><?= $value->nama_gejala ?></span>
				<?php } ?>
			</h3>
		</div>
		<div class="col-12 margin-top-15 rounded" style="background-color: #cfd1d3">
			<br>
			<h4 class="text-center">Daftar obat yang diberikan untuk pemeriksaan pada <?=$log_pengobatan[0]->tanggal?></h4>
			<br>
			<br>
			<h3>
				<?php foreach ($obat_per_log as $key => $value) {	?>
					<a class="btn text-white badge badge-primary" href="<?=base_url()?>Ppk_C/view_karakteristik_obat/<?=$value->id_obat?>" role='button'><?= $value->nama_obat ?></a>
				<?php } ?>
			</h3>
		</div>
		<!-- SIDE NAAV HERE -->
	</div>
</div>

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
			<span class="nav-link">Tanggal Lahir / Umur<i class="nav-link disabled" href="#"> 19 Februari 1997 / 20Thn</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">No. KTP<i class="nav-link disabled"><?=$user[0]->nomor_identitas?></i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Note Kondisi
				<a class="nav-link disabled text-white badge badge-danger">Hipertensi</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Hipertensi</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">...</a>
			</span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Dummy<i class="nav-link disabled" href="#">iajkhdbjhagdsjd haskjdnas</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Dummy<i class="nav-link disabled" href="#">iajkhdbjhagdsjdha skjdnas</i></span>
		</li>
	</ul>
</nav>

<?php

// echo "<pre>";
// var_dump($gejala_per_log);
// echo "</pre>";