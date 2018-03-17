<!-- colapsible belum ajax -->
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
<!-- colapsible belum ajax -->