<?php
$data = json_decode($data,false);
?>
<script type="text/javascript">
	update();
	function update() {
		var url = "<?=base_url('Ppk_C/cari_hasil_/'.$data->user[0]->nomor_identitas)?>";
		$.get(url,function(data){
			var response = JSON.parse(data);

			// parsing jumlah dan detail gejala pada wm_gejala
			document.getElementById('jumlah_wm_gejala').innerHTML = response.gejala.length;
			html = '';
			for(var i in response.gejala){
				html += "<a class='nav-link disabled badge badge-warning text-white'>"+response.gejala[i].detail_gejala+"</a> ";
			}
			document.getElementById('detail_wm_gejala').innerHTML = html;

			// parsing jumlah obat dan detailnya pada wm_obat
			document.getElementById('jumalh_wm_obat').innerHTML = response.obat.length;

			// parsing kondisi pada wm_kondisi
			
		});
	}
</script>

<div class="col-md-10 konten-kanan" id="style-1">
	<div class="col margin-top-15">
		<h2 class="text-center">Obat yang diresepkan</h2>
	</div>
	<div class="col margin-top-15">
		<h5>Gejala yang dimasukkan sejumlah <span class="badge badge-danger" id="jumlah_wm_gejala"></span></h5>
	</div>
	<div class="col">
		<h5 id="detail_wm_gejala">
			<!-- javascript generated content -->
		</h5>
	</div>
	<div class="col margin-top-15">
		<h5>List obat yang diberikan sejumlah <span class="badge badge-danger" id="jumalh_wm_obat"></span>
			<!-- javascript generated content -->
		</h5>
	</div>
	<div class="col">
		<div class="card">
			<div class="card-header" role="tab" id="headingOne">
				<div class="row">
					<div class="col">
						<h5><a class="collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne"> OBAT #1</a></h5>
					</div>
					<div class="col-3 ditemukan rounded">
						<h6 class="text-center">Indikasi/Obat ditemukan</h6>
						<h6 class="text-center">2/3</h6>
					</div>
					<div class="col-3 ditemukan rounded">
						<h6 class="text-center">Kontraindikasi/Obat ditemukan</h6>
						<h6 class="text-center">2/3</h6>
					</div>
					<div class="col-3 ditemukan rounded">
						<h6 class="text-center">Peringatan/Obat ditemukan</h6>
						<h6 class="text-center">2/3</h6>
					</div>
				</div>
			</div>
			<div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
				<div class="card-body">
					<div class="row">
						<div class="col">
							<div class="row">
								<div class="col informasi rounded hijau">
									<h6>Indikasi</h6>
									<ul>
										<li>demam <i class="icon ion-checkmark-circled text-success"></i> </li>
										<li>pusing <i class="icon ion-checkmark-circled text-success"></i></li>
										<li>mual</li>
										<li>mabuk perjalanan</li>
									</ul>
								</div>
								<div class="col informasi rounded merah">
									<h6>Kontraindikasi</h6>
									<ul>
										<li>hipertensi <i class="icon ion-android-alert text-danger"></i></li>
										<li>mabuk perjalanan <i class="icon ion-android-alert text-danger"></i></li>
									</ul>
								</div>
								<div class="col informasi rounded kuning">
									<h6>Peringatan</h6>
									<ul>
										<li>demam <i class="icon ion-android-alert text-warning"></i></li>
										<li>pusing <i class="icon ion-android-alert text-warning"></i></li>
										<li>mual</li>
										<li>mabuk perjalanan</li>
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
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header" role="tab" id="headingTwo">
				<div class="row">
					<div class="col">
						<h5><a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">OBAT #2</a></h5>
					</div>
					<div class="col-3 ditemukan rounded">
						<h6 class="text-center">Indikasi/Obat ditemukan</h6>
						<h6 class="text-center">2/3</h6>
					</div>
					<div class="col-3 ditemukan rounded">
						<h6 class="text-center">Kontraindikasi/Obat ditemukan</h6>
						<h6 class="text-center">2/3</h6>
					</div>
					<div class="col-3 ditemukan rounded">
						<h6 class="text-center">Peringatan/Obat ditemukan</h6>
						<h6 class="text-center">2/3</h6>
					</div>
				</div>

				
			</div>
			<div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
				<div class="card-body">
					<div class="row">
						<div class="col">
							<div class="row">
								<div class="col informasi rounded hijau">
									<h6>Indikasi</h6>
									<ul>
										<li>demam <i class="icon ion-checkmark-circled text-success"></i> </li>
										<li>pusing <i class="icon ion-checkmark-circled text-success"></i></li>
										<li>mual</li>
										<li>mabuk perjalanan</li>
									</ul>
								</div>
								<div class="col informasi rounded merah">
									<h6>Kontraindikasi</h6>
									<ul>
										<li>hipertensi <i class="icon ion-android-alert text-danger"></i></li>
										<li>mabuk perjalanan <i class="icon ion-android-alert text-danger"></i></li>
									</ul>
								</div>
								<div class="col informasi rounded kuning">
									<h6>Peringatan</h6>
									<ul>
										<li>demam <i class="icon ion-android-alert text-warning"></i></li>
										<li>pusing <i class="icon ion-android-alert text-warning"></i></li>
										<li>mual</li>
										<li>mabuk perjalanan</li>
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
				</div>
			</div>
		</div>
	</div>
	<div class="col margin-top-15">
		<h5>Tambahkan pesan</h5>
	</div>
	<div class="col margin-top-15">
		<textarea placeholder="tuliskan pesan disini" style="width: 100%"></textarea>
	</div>
	<div class="col margin-top-15">
		<button type="button" class="btn btn-primary btn-lg btn-block" title="Masukkan ke log pengobatan"> <i class="icon ion-ios-briefcase-outline"></i> Resepkan</button>		
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
			<span class="nav-link">Tanggal Lahir / Umur<i class="nav-link disabled hijau" href="#"> 19 Februari 1997 / 20Thn</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">No. KTP<i class="nav-link disabled"><?=$data->user[0]->nomor_identitas?></i></span>
		</li>
	</ul>
</nav>