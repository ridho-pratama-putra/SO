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
	<div class="margin-top-15">
		<div class="col-12 rounded-bottom" style="background-color: #cfd1d3">
			<br>
			<h4 class="text-center">Detail gejala untuk pemeriksaan pada <?=$log_pengobatan[0]->tanggal?></h4>
			<div class="margin-top-15 padding-bottom-10">
				<h3>
					<?php foreach ($gejala_per_log as $key => $value) {	?>
						<span class="badge badge-primary"><?= $value->detail_gejala ?></span>
					<?php } ?>
				</h3>
			</div>
		</div>
		<div class="col-12 margin-top-15 rounded" style="background-color: #cfd1d3">
			<br>
			<h4 class="text-center">Daftar obat yang diberikan untuk pemeriksaan pada <?=$log_pengobatan[0]->tanggal?></h4>
			<div class="margin-top-15 padding-bottom-10">
				<h3>
					<?php foreach ($obat_per_log as $key => $value) {	?>
						<a class="btn text-white badge badge-primary" href="<?=base_url()?>Pasien_C/view_karakteristik_obat/<?=$log_pengobatan[0]->id_log?>/<?=$value->id_obat?>/<?=$this->session->userdata('logged_in')['id_user']?>" role='button'><?= $value->nama_obat ?></a>
					<?php } ?>
				</h3>
			</div>
		</div>
		<div class="col-12 margin-top-15 rounded" style="background-color: #cfd1d3">
			<br>
			<h4 class="text-center">Kondisi pasien saat pemeriksaan pada <?=$log_pengobatan[0]->tanggal?></h4>
			<div class="margin-top-15 padding-bottom-10">
				<h3> Mengalami : 
					<?php foreach ($kondisi_per_log as $key => $value) {	?>
						<a class="text-white badge badge-danger" ><?= $value->detail_kondisi ?></a>
					<?php } ?>
				</h3>
			</div>
		</div>

		<div class="col-12 margin-top-15 rounded" style="background-color: #cfd1d3">
			<br>
			<h4 class="text-center">Pesan untuk pasien saat pemeriksaan pada <?=$log_pengobatan[0]->tanggal?></h4>
			<div class="margin-top-15 padding-bottom-10">
				<h5>
					<?=$pesan_per_log[0]->pesan?>
				</h5>
			</div>
		</div>
		
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
	</ul>
</nav>

<?php

// echo "<pre>";
// var_dump($gejala_per_log);
// echo "</pre>";