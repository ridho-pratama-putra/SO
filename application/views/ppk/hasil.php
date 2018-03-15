<?php
// tangkap data dari kontrol
$data = json_decode($data,false);
?>
<div class="col-md-10 konten-kanan" id="style-1">
	<div class="row" id="indikasi-yang-dicari">
		<div class="col">
			<h3>Indikasi yang dicari:</h3>
			<form method="POST" action="">
				<script type="text/javascript">
					$(document).ready(function() {
						$('#gejala_id').select2({
							placeholder: 'ketikkan gejala-gejala'
						});
					});
				</script>
					<select class="js-example-basic-multiple col" id="gejala_id" name="gejala[]" multiple="multiple" title="klik untuk menambah atau mengganti gejala">
						<option>gatal</option>	
						<option>pusing</option>	
						<option>nyeri otot</option>	
						<option>pilek</option>	
						<option>sesak nafas</option>	
						<option>demam</option>	
						<option>mual</option>	
					</select>
				<br>
				<br>
				<div class="row">
					<div class="col">
						<a class="btn btn-primary btn-block bg-dark" href="#" role="button">Kirim ulang</a>
					</div>
				</div>
			</form>
			<span class="badge badge-success" style="margin-top: 15px;"> 3 Obat ditemukan</span>
		</div>
	</div>
	<div class="row padding-top-10" >
		<div class="col">
			<div class="margin-top-20"></div>
			<div id="accordion" role="tablist">
				<?php foreach ($data->obat as $key => $value) { /*var_dump($value->id_obat);*/?>
					<div class="card">
						<div class="card-header" role="tab" id="heading<?= $value->id_obat?>">
							<div class="row">
								<div class="col">
									<h5><a data-toggle="collapse" href="#collapse<?= $value->id_obat?>" aria-expanded="true" aria-controls="collapse<?= $value->id_obat?>"><?= $value->nama_obat?></a></h5>
								</div>
								<div class="col-3 ditemukan rounded">
									<h6 class="text-center">Indikasi/Obat ditemukan</h6>
									<h6 class="text-center"><?php echo sizeof($value->karakteristik->indikasi->ada)."/".sizeof($data->obat)?></h6>
								</div>
								<div class="col-3 ditemukan rounded">
									<h6 class="text-center">Kontraindikasi/Obat ditemukan</h6>
									<h6 class="text-center"><?=sizeof($value->karakteristik->kontraindikasi->ada)."/".sizeof($data->obat)?></h6>
								</div>
								<div class="col-3 ditemukan rounded">
									<h6 class="text-center">Peringatan/Obat ditemukan</h6>
									<h6 class="text-center"><?=sizeof($value->karakteristik->peringatan->ada)."/".sizeof($data->obat)?></h6>
								</div>
							</div>
						</div>
						<div id="collapse<?= $value->id_obat?>" class="collapse show" role="tabpanel" aria-labelledby="heading<?= $value->id_obat?>" data-parent="#accordion">
							<div class="card-body">
								<div class="row">
									<div class="col">
										<div class="row">
											<div class="col informasi rounded hijau">
												<h6>Indikasi</h6>
												<ul>
													<?php 
													if (isset($value->karakteristik->indikasi->ada)) {
														foreach ($value->karakteristik->indikasi->ada as $keyK => $valueK) { ?>
															<li><?=$valueK->detail_tipe?> <i class="icon ion-checkmark-circled text-success"></i></li>
													<?php 
														}
													}
													if (isset($value->karakteristik->indikasi->tanya)) {
														foreach ($value->karakteristik->indikasi->tanya as $keyK => $valueK) { ?>
															<li><?=$valueK->detail_tipe?> <i class="icon ion-help-circled text-primary"></i></li>
													<?php 
														}
													}?>
												</ul>
											</div>
											<div class="col informasi rounded merah">
												<h6>Kontraindikasi</h6>
												<ul>
													<?php 
													if (isset($value->karakteristik->kontraindikasi->ada)) {
														foreach ($value->karakteristik->kontraindikasi->ada as $keyK => $valueK) { ?>
															<li><?=$valueK->detail_tipe?> <i class="icon ion-android-alert text-danger"></i></li>												
													<?php 
														}
													}
													if (isset($value->karakteristik->kontraindikasi->tanya)) {
														foreach ($value->karakteristik->kontraindikasi->tanya as $keyK => $valueK) { ?>
															<li><?=$valueK->detail_tipe?> <i class="icon ion-help-circled text-primary"></i></li>
													<?php 
														}
													}?>
												</ul>
											</div>
											<div class="col informasi rounded kuning">
												<h6>Peringatan</h6>
												<ul>
													<?php 
													if (isset($value->karakteristik->peringatan->ada)) {
														foreach ($value->karakteristik->peringatan->ada as $keyK => $valueK) { ?>
															<li><?=$valueK->detail_tipe?> <i class="icon ion-android-alert text-warning"></i></li>
													<?php }
													}
													if (isset($value->karakteristik->peringatan->tanya)) {
														foreach ($value->karakteristik->peringatan->tanya as $keyK => $valueK) { ?>
															<li><?=$valueK->detail_tipe?> <i class="icon ion-help-circled text-primary"></i></li>
													<?php }
													}?>
												</ul>
											</div>
										</div>
										<div class="row margin-top-5">
											<div class="col informasi rounded biru">
												<h6>Dosis</h6>
												<ul>
													<li>demam</li>
													<li>pusing</li>
													<li>mual</li>
													<li>mabuk perjalanan</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="row padding-top-10">
									<button type="button" class="btn btn-primary btn-lg btn-block" title="Jangan lupa masuk ke menu peresepan obat melalui tombol 'ke daftar resep obat' agar data tersimpan pada log pengobatan"><i class="icon ion-ios-plus-outline"></i> Masukkan obat ini ke daftar obat yang akan diberikan</button>
								</div>

							</div>
						</div>
					</div>
				<?php }	?>
			</div>
		</div>
	</div>
	<div class="margin-top-15">
		<button type="button" class="btn btn-primary btn-lg btn-block"><i class="icon ion-clipboard"></i> Ke daftar resep obat</button>
	</div>
</div>


<!-- SIDE NAAV HERE -->
<nav class="col-md-2 d-none d-sm-block bg-light sidebar" id="style-1">
	<ul class="nav nav-pills flex-column">
		<li class="nav-item">
			<div>
				<img src="<?php echo base_url().$data->user[0]->link_foto?>" alt="foto-profil" class="img-thumbnail rounded">
			</div>
		</li>

		<li class="nav-item">
			<span class="nav-link">Nama : <i class="nav-link disabled" href="#"><?=$data->user[0]->nama_user?></i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Tanggal Lahir / Umur<i class="nav-link disabled" href="#"> 19 Februari 1997 / 20Thn</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">No. KTP<i class="nav-link disabled"><?=$data->user[0]->nomor_identitas?></i></span>
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


<!-- 
ion-ios-help TANYA
ion-social-whatsapp-outline WA

#95ff93 hijau
#c1fff9 biru
#ffc1c1 merah
#fffba0 kuning
 -->