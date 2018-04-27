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
	<div class="margin-top-15 col-12">
		<h2 class="text-center">Detail Log Pengobatan Pada <?=tgl_indo($log_pengobatan[0]->tanggal)?></h2>
		
			<br>
			<h4>Detail gejala </h4>
			<ol>
			<?php foreach ($gejala_per_log as $key => $value) {	?>
				<li> <?= $value->detail_gejala ?></li>
			<?php } ?>
			</ol>
	</div>
	<div class="col-12">
		<br>
		<h4>Daftar obat yang diberikan</h4>
		<ol>
			<?php foreach ($obat_per_log as $key => $value) {	?>
				<li><a class="btn text-white badge badge-primary" href="<?=base_url()?>Ppk_C/view_karakteristik_obat/<?=$value->id_obat?>" role='button'><?= $value->nama_obat ?></a></li>
			<?php } ?>
		</ol>
	</div>
 	<div class="col-12">
		<br>
		<h4>Kondisi pasien saat pemeriksaan</h4>
		<div class="margin-top-15 padding-bottom-10">
			<ul>
			<h6> Mengalami : </h6>
				<ol>
				<?php foreach ($kondisi_per_log as $key => $value) {	?>
					<li><?= $value->detail_kondisi ?></li>
				<?php } ?>
				</ol>
			</ul>
		</div>
	</div>

	<div class="col-12">
		<br>
		<h4>Pesan untuk pasien saat pemeriksaan</h4>
		<div class="margin-top-15 padding-bottom-10">
			<h6>
				<li><?=$pesan_per_log[0]->pesan?></li>
			</h6>
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
			<span class="nav-link">Tanggal Lahir / Umur<i class="nav-link disabled" href="#"> <?=$user[0]->tanggal_lahir != '' ? tgl_indo($user[0]->tanggal_lahir) : 'YYYY-mm-dd' ?> / <?=$umur->y?> Thn</i></span>
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