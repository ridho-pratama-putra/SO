<?php
$data = json_decode($data,false);
?>
<script type="text/javascript">
	$(document).ready(function(){
		update();
		var response;
	});
	function update() {
		var url = "<?=base_url('Ppk_C/cari_hasil_/'.$data->user[0]->nomor_identitas)?>";
		var id_dokter = "<?=$this->session->userdata('logged_in')['id_user']?>";
		$.get(url,function(data){
			// console.log(data);
			response = JSON.parse(data);
			console.log(response);
			if (response.status == false) {
				document.getElementById('resep').innerHTML = "";
				$('#ModalRedirect').modal('show');
				// window.alert("Anda akan dialihkan menuju halaman input identitas pasien");
				// window.location.href = "<?=base_url('Ppk_C/view_gejala/')?>"+response.nomor_identitas;
			}else{
				// parsing jumlah dan detail gejala pada wm_gejala
				document.getElementById('jumlah_wm_gejala').innerHTML = response.gejala.length;

				// parsing detail gejala
				html = '';
				for(var i in response.gejala){
					html += "<a class='nav-link disabled badge badge-warning text-white'>"+response.gejala[i].detail_gejala+"</a> ";
				}
				document.getElementById('detail_wm_gejala').innerHTML = html;

				// parsing gejala yang belum terobati dan gejala yang diobati lebih dari 1 obat untuk dijadikan alert
				html = '';
				for (var i in response.gejala) {
					// console.log(response.gejala[i].terobati);
					if (typeof response.gejala[i].terobati == 'undefined') {
						html += "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Peringatan</strong> "+response.gejala[i].detail_gejala+" belum terobati.</div>";
					}else{
						if (response.gejala[i].terobati == 'ganda') {
							html += "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Peringatan</strong> "+response.gejala[i].detail_gejala+" diobati dengan obat ganda.</div>";
						}
					}
				}
				document.getElementById('notif').innerHTML = html;

				// parsing jumlah obat dan detailnya pada wm_obat
				document.getElementById('jumlah_wm_obat').innerHTML = response.obat.length;

				// parsing kondisi pada wm_obat
				var html = "<div id='accordion'>";
				for(var k in response.obat){
							
							html 		+=	"<div class='card margin-top-20'>";
							html 		+=	"<div class='card-header' id='heading"+response.obat[k].id_obat+"' role='tab'>";
							html 		+=	"<div class='row'>";
							html 		+=	"<div class='col'>";
							html 		+=	"<h5>";
							// class="collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne"
							html 		+=	"<a href='#collapse"+response.obat[k].id_obat+"' class='collapsed' data-toggle='collapse' aria-expanded='false' aria-controls='collapse"+response.obat[k].id_obat+"'>"+response.obat[k].nama_obat;
							html 		+=	"<i class='icon ion-chevron-down float-right'>";
							html 		+=	"</i>";
							html 		+=	"</a>";
							html 		+=	"</h5>";
							html 		+=	"</div>";
							
							html 		+=	"<div class='col-3 ditemukan rounded'>";
							
							html 		+=	"<i class='icon ion-ios-help float-right' data-toggle='tooltip' data-placement='top' title='Informasi mengenai berapa karakteristik indikasi pada obat ini yang cocok dengan gejala yang dirasakan pasien'>";
							html 		+=	"</i>";
							
							html 		+=	"<h6 class='text-center'>Indikasi Cocok";
							html 		+=	"</h6>";
							html 		+=	"<h6 class='text-center'>"+response.obat[k].Iada;
							html 		+=	"</h6>";
							html 		+=	"</div>";
							
							html 		+=	"<div class='col-3 ditemukan rounded'>";
							html 		+=	"<i class='icon ion-ios-help float-right' data-toggle='tooltip' data-placement='top' title='Informasi mengenai berapa karakteristik peringatan pada obat ini yang harus dihindari oleh pasien sesuai dengan rekam medis'>";
							html 		+=	"</i>";
							html 		+=	"<h6 class='text-center'>Kandungan Peringatan";
							html 		+=	"</h6>";
							if (typeof response.obat[k].karakteristik.peringatan != 'undefined') {
								if (typeof response.obat[k].karakteristik.peringatan.ada != 'undefined') {
									html +=	"<h6 class='text-center'>"+response.obat[k].Pada;
								}else{
									html +=	"<h6 class='text-center'>0 / "+ response.obat.length;
								}
							}else{
								html +=	"<h6 class='text-center'>0 / "+ response.obat.length;
							}
							html +=	"</h6>";
							html +=	"</div>";
							
							html 		+=	"<div class='col-3 ditemukan rounded'>";
							html 		+=	"<i class='icon ion-ios-help float-right' data-toggle='tooltip' data-placement='top' title='Informasi mengenai berapa karakteristik kontraindikasi pada obat ini yang harus dihindari oleh pasien sesuai dengan rekam medis'>";
							html 		+=	"</i>";
							html 		+=	"<h6 class='text-center'>Kandungan Kontra";
							html 		+=	"</h6>";
							if (typeof response.obat[k].karakteristik.kontraindikasi != 'undefined') {
								if (typeof response.obat[k].karakteristik.kontraindikasi.ada != 'undefined') {
									html +=	"<h6 class='text-center'>"+response.obat[k].Kada;
								}else{
									html +=	"<h6 class='text-center'>0 / "+ response.obat.length;
								}
							}else{
								html 	+=	"<h6 class='text-center'>0 / "+ response.obat.length;
							}
							html 		+=	"</h6>";
							html 		+=	"</div>";


							html +=	"</div>";
							html +=	"</div>";
							// id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion"
							html +=	"<div id='collapse"+response.obat[k].id_obat+"' class='collapse' role='tabpanel' aria-labelledby='heading"+response.obat[k].id_obat+"' data-parent='#accordion'>";
							html +=	"<div class='card-body'>";
							html +=	"<div class='row'>";
							html +=	"<div class='col'>";
							html +=	"<div class='row'>";

							var bisa_diberikan = true;
							for(var l in response.obat[k].karakteristik){
								
								html +=	"<div ";
								if (l == 'indikasi') {
									html +=	"class='col informasi hijau rounded'>";
								}else if (l == 'kontraindikasi') {
									html +=	"class='col informasi merah rounded'>";
								}else{
									html +=	"class='col informasi kuning rounded'>";
								}
								
								html +=	"<h6>"+l;
								html +=	"</h6>";
								html +=	"<ol>";
								
								// ada dan tanya
								for(var m in response.obat[k].karakteristik[l]){
									// console.log(response.obat[k].karakteristik[l]);
									// console.log('M : '+m);
									/*	obat[k]				=	index obat yang didapat
										karakteristik[l]	=	index karakteristik yang didapat
									*/
									
									for(var n in response.obat[k].karakteristik[l][m]){
										// console.log(response.obat[k].karakteristik[l][m][n].id_karakteristik);			
										// console.log('N : '+n);

										// '<a href="" data-toggle="modal" data-target="#ModalEditKondisi" data-idkondisi="'+data+'" ><i class="icon ion-edit"></i></a>'

										html +=	"<li>"+response.obat[k].karakteristik[l][m][n].detail_tipe;
										
										if (l == 'indikasi') {
											if (m == 'ada') {
												html +=	"<i class='icon ion-checkmark-circled text-success'></i>";
											}
										}else if (l =='kontraindikasi') {
											if (m == 'ada') {
												html +=	"<i class='icon ion-android-alert text-danger'></i>";
											}
											else if(m =='tanya'){
												html +=	"<a data-toggle='modal' data-target='#ModalEditKondisi' data-idtipemaster='"+response.obat[k].karakteristik[l][m][n].id_tipe_master+"' data-iduser='"+response.user[0].id_user+"'>";
												html +=	"<i class='icon ion-help-circled text-primary'></i>";
												html +=	"</a>";
												bisa_diberikan = false;
											}
										}else if (l == 'peringatan'){
											if (m == 'ada') {
												html +=	"<i class='icon ion-android-alert text-warning'></i>";
											}else if( m == 'tanya'){
												html +=	"<a data-toggle='modal' data-target='#ModalEditKondisi' data-idtipemaster='"+response.obat[k].karakteristik[l][m][n].id_tipe_master+"' data-iduser='"+response.user[0].id_user+"'>";
												html +=	"<i class='icon ion-help-circled text-primary'></i>";
												html +=	"</a>";
												bisa_diberikan = false;
											}
										}
										html +=	"</li>";
									}
								}
								html +=	"</ol>";
								html +=	"</div>";
							}
							html +=	"</div>";


							
							html +=	"<div class='row'>";
							html +=	"<div class='col  margin-top-10'>";
							html += "<a data-toggle='collapse' href='#collapse-catatan-"+response.obat[k].id_obat+"' aria-expanded='false' aria-controls='collapse-catatan-"+response.obat[k].id_obat+"'> Catatan Obat </a>";
							
							html += "<div class='collapse' id='collapse-catatan-"+response.obat[k].id_obat+"'>";
							html += "<div class='card card-body'>"
							html +=	response.obat[k].catatan_obat;
							html += "</div>";
							html += "</div>";
							
							html +=	"</div>";
							html +=	"</div>";

							html +=	"</div>";
							html +=	"</div>";
							bisa_diberikan = 1;
							if (bisa_diberikan) {
								html += "<div class='row margin-top-10'>";
								
								html += "<div class= 'col' id='wm_obat"+response.obat[k].id_obat+"'>";
								html += "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='hapus_wm_obat("+response.user[0].id_user+","+id_dokter+","+response.obat[k].id_obat+")'><i class='icon ion-android-delete'></i> Hapus dari daftar resep</button> ";
								html+="</div>"
								
								html += "</div>";
							}else{
								html += "<div class='row margin-top-10'>";
								
								html += "<div class= 'col' id='wm_obat"+response.obat[k].id_obat+"'>";
								html += "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='hapus_wm_obat("+response.user[0].id_user+","+id_dokter+","+response.obat[k].id_obat+")'><i class='icon ion-android-delete'></i> Hapus dari daftar resep</button> ";
								html+="</div>"
								
								html += "</div>";
							}
							html +=	"</div>";
							html +=	"</div>";
							html +=	"</div>";
						}
				html +=	"</div>";
				document.getElementById('resep').innerHTML = html;
				
			}
		});
	}

	function hapus_wm_obat(id_pasien,id_dokter,id_obat){
		$.post("<?=base_url('Ppk_C/handle_delete_wm_obat')?>",
			{
				post_id_pasien		: id_pasien,
				post_id_dokter		: id_dokter,
				post_id_obat		: id_obat
			},function(data){
				$("#notif").html(data);	
				update();
			}
		);
	}

	function redirect_view_gejala(){
		window.location.href = "<?=base_url('Ppk_C/view_gejala/')?>"+response.nomor_identitas;
	}
</script>

<div class="col-md-10 konten-kanan" id="style-1">
	<div class="col margin-top-15">
		<h2 class="text-center">Obat yang diresepkan</h2>
		<div id="notif"></div>
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
		<h5>List obat yang diberikan sejumlah <span class="badge badge-danger" id="jumlah_wm_obat"></span>
			<!-- javascript generated content -->
		</h5>
	</div>

	<div class="col" id="resep">
		<!-- <div class="card">
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
		</div> -->
	</div>
	<form method="POST" action="<?=base_url('Ppk_C/handle_insert_log_pengobatan')?>">
		<div class="col margin-top-15">
			<h5>Tambahkan pesan</h5>
		</div>
		<div class="col margin-top-15">
			<input type="hidden" name="id_user" value="<?=$data->user[0]->id_user?>">
			<textarea placeholder="tuliskan pesan disini" style="width: 100%" name="pesan_resep"></textarea>
		</div>
		<div class="col margin-top-15">
			<button type="submit" class="btn btn-primary btn-lg btn-block" title="Masukkan ke log pengobatan"> <i class="icon ion-ios-briefcase-outline"></i> Resepkan</button>		
		</div>
	</form>
</div>

<!-- MODAL UNTUK REDIRECT KE VIEW_GEJALA -->
<div class="modal fade" id="ModalRedirect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel_">Perhatian</h4>
			</div>
			<div class="modal-body">
				<p>Form resep Kosong. Redirect ke halaman input gejala</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary text-white" onclick="redirect_view_gejala()">Ya</a>
			</div>
		</div>
	</div>
</div>
<!-- END MODAL UNTUK REDIRECT KE VIEW_GEJALA -->


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
			<span class="nav-link">Tanggal Lahir / Umur<i class="nav-link disabled hijau" href="#"><?=$data->user[0]->tanggal_lahir != '' ? tgl_indo($data->user[0]->tanggal_lahir) : 'YYYY-mm-dd' ?> / <?=$data->umur->y?> Thn</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">No. Identitas<i class="nav-link disabled"><?=$data->user[0]->nomor_identitas?></i></span>
		</li>
	</ul>
</nav>