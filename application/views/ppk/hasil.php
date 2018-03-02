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
			<!-- <div id="accordion">

				<div class="card">

					<div class="card-header" id="head1">
						<div class="row">
							<div class="col">
								<h5 class="tombol-collapse">
									<button class="btn btn-link" data-toggle="collapse" data-target="#1" aria-expanded="true" aria-controls="1">OBAT Z</button>
								</h5>
							</div>
							<div class="col-3 ditemukan hijau">
								<h6 class="text-center">Indikasi/Obat ditemukan</h6>
								<h4 class="text-center">2/3</h4>
							</div>
							<div class="col-3 ditemukan merah">
								<h6 class="text-center">Kontraindikasi/Obat ditemukan</h6>
								<h4 class="text-center">2/3</h4>
							</div>
							<div class="col-3 ditemukan kuning">
								<h6 class="text-center">Peringatan/Obat ditemukan</h6>
								<h4 class="text-center">2/3</h4>
							</div>
						</div>
					</div>

					<div id="1" class="collapse show" aria-labelledby="head1" data-parent="#accordion">
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
			</div> -->

			<div id="accordion" role="tablist">
				
				<div class="card">
					<div class="card-header" role="tab" id="headingOne">
						<div class="row">
							<div class="col">
								<h5><a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> OBAT #1</a></h5>
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
					<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
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
							<div class="row padding-top-10">
								<button type="button" class="btn btn-primary btn-lg btn-block" title="Jangan lupa masuk ke menu peresepan obat melalui tombol 'ke daftar resep obat' agar data tersimpan pada log pengobatan"><i class="icon ion-ios-plus-outline"></i> Masukkan obat ini ke daftar obat yang akan diberikan</button>
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
							<div class="row padding-top-10">
								<button type="button" class="btn btn-primary btn-lg btn-block" title="Jangan lupa masuk ke menu peresepan obat melalui tombol 'ke daftar resep obat' agar data tersimpan pada log pengobatan"><i class="icon ion-ios-plus-outline"></i> Masukkan obat ini ke daftar obat yang akan diberikan</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header" role="tab" id="headingThree">
						<div class="row">
							<div class="col">
								<h5><a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">OBAT #3</a></h5>
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
					<div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
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
							<div class="row padding-top-10">
								<button type="button" class="btn btn-primary btn-lg btn-block" title="Jangan lupa masuk ke menu peresepan obat melalui tombol 'ke daftar resep obat' agar data tersimpan pada log pengobatan"><i class="icon ion-ios-plus-outline"></i> Masukkan obat ini ke daftar obat yang akan diberikan</button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>


	</div>
	<div class="margin-top-15">
		<button type="button" class="btn btn-primary btn-lg btn-block"><i class="icon ion-clipboard"></i> Ke daftar resep obat</button>
	</div>
</div>
<!-- 
ion-ios-help TANYA
ion-social-whatsapp-outline WA

#95ff93 hijau
#c1fff9 biru
#ffc1c1 merah
#fffba0 kuning
 -->