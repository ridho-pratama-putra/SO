<style type="text/css">
	.konten-karakteristik{
		background-color: #d2d4d8;
		padding-bottom: 15px;
		padding-top: 15px;
		margin-bottom: 15px;
	}
</style>
<div class="col margin-top-15">
	<h2>OBAT <?=$obat[0]->nama_obat?></h2>
	<div class="col-12 rounded konten-karakteristik">
		<h3>INDIKASI</h3>
		<ul>
		<?php
		foreach ($indikasi_obat as $key => $value) {
			?>
			<li><?=$value->detail_tipe?></li>
			<?php
		}
		?>
		</ul>
	</div>
	<div class="col-12 rounded konten-karakteristik">
		<h3>KONTRAINDIKASI</h3>
		<ul>
		<?php
		foreach ($kontraindikasi_obat as $key => $value) {
			?>
			<li><?=$value->detail_tipe?></li>
			<?php
		}
		?>
		</ul>
	</div>
	<div class="col-12 rounded konten-karakteristik">
		<h3>PERINGATAN</h3>
		<ul>
		<?php
		foreach ($peringatan_obat as $key => $value) {
			?>
			<li><?=$value->detail_tipe?></li>
			<?php
		}
		?>
		</ul>
	</div>
	<div class="col-12 rounded konten-karakteristik">
		<h3>CATATAN OBAT</h3>
		<?php
		foreach ($catatan_obat as $key => $value) {
			
			echo $value->catatan;
			
		}
		?>
	</div>
</div>

<?php
// echo "<pre>";
// var_dump($obat);
// var_dump($kontraindikasi_obat);
// var_dump($indikasi_obat);
// var_dump($peringatan_obat);
// echo "</pre>";