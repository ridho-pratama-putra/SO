<?php
$data = json_decode($data,false);
?>
<style type="text/css">
/*chevron onok animasine*/
.card-header .icon {
  transition: .3s transform ease-in-out;
}
.card-header .collapsed .icon {
  transform: rotate(90deg);
}
</style>
<!-- funstion tampilkan hasil collapsible -->
<script type="text/javascript">
	
	$(document).ready(function(){

		// assign gejala dari database ke plugin select2
		var selected_gejala = <?php echo $data->gejala_pasien?>;
		$('#select_gejala').val(selected_gejala).select2();
		
		// seperti "onload"..hehe. update itu untuk tampilkan hasil pencarian. show_kondisi itu untuk menampilkan apa saja kondisi (rekam medis) seorang pasien.
		update();
		show_kondisi();
		
		$('#ModalEditKondisi').on('show.bs.modal', function(e) {
			$("#idMasterKondisiE").attr('value', $(e.relatedTarget).data('idtipemaster'));
			$("#idUser").attr('value', $(e.relatedTarget).data('iduser'));
			$.get('<?=base_url()?>Ppk_C/cek_kondisi/'+$(e.relatedTarget).data('idtipemaster'),function(html){
				var responE = JSON.parse(html);
				document.getElementById('apakah').innerHTML = "Apakah pasien mengalami <h5 class='text-danger'>"+responE[0].detail_kondisi+"</h6>";
				$("#idKondisi").attr('value',responE[0].detail_kondisi);
			});
		});

		// button saat seorang pasien menderita penyakit tersebut
		$("#btn-ya-kondisi" ).click(function() {
			var	url = "<?= base_url('Ppk_C/handle_add_kondisi_/0')?>";
			var formData = new FormData($('#formeditkondisi')[0]);
			$('#btn-ya-kondisi').text('MOHON TUNGGU..');
			$.ajax({
				url : url,
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(data)
				{
					$("#notif").html(data);
					update();
					show_kondisi();
					$('#ModalEditKondisi').modal('hide');
					$('#btn-ya-kondisi').text('YA');
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					console.log(jqXHR, textStatus, errorThrown);
					$('#btn-ya-kondisi').text('Eror'); //change button text
					$('#btn-ya-kondisi').attr('disabled',false); //set button enable 
				}
			});
		});

		// button saat seorang pasien aman dari penyakit tesebut
		$("#btn-tidak-kondisi" ).click(function() {
			var	url = "<?= base_url('Ppk_C/handle_add_kondisi_/1')?>";
			var formData = new FormData($('#formeditkondisi')[0]);
			$('#btn-tidak-kondisi').text('MOHON TUNGGU..');
			$.ajax({
				url : url,
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(data)
				{
					$("#notif").html(data);
					update();
					show_kondisi();
					$('#ModalEditKondisi').modal('hide');
					$('#btn-ya-kondisi').text('TIDAK');
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					console.log(jqXHR, textStatus, errorThrown);
					$('#btn-tidak-kondisi').text('Eror'); //change button text
					$('#btn-tidak-kondisi').attr('disabled',false); //set button enable 
				}
			});
		});

		// untuk masukkan obat yang dipilih ke tabel wm_obat
		$("#masukkan-obat").click(function() {
			
		});

		// untuk masuk ke menu peresepan obat
		$("#ke-resep-obat").click(function () {
			
		});
	});

	// ambil kondisi untuk ditampilkan pada side menu kanan 
	function show_kondisi() {
		$("#note-kondisi").empty();

		var url = "<?=base_url("Ppk_C/get_col_kondisi/").$data->user[0]->id_user?>";
		$.get(url,function(html){
			var responE = JSON.parse(html);
			var html = '';
			for(var i in responE){
				if (responE[i].status == 0) {
					html += "<a class='nav-link disabled text-white badge badge-danger'>"+responE[i].detail_kondisi+"</a> ";
				}else{
					html += "<a class='nav-link disabled text-white badge badge-success'>"+responE[i].detail_kondisi+"</a> ";
				}
			}
			document.getElementById('note-kondisi').innerHTML = html;	
		});
	}

	// reload hasi pencarian obat yang sesuai dan menampilkan log pengobatan dengan gejala yang mirip sebelumnya
	function update(){
		// $("#hasil").empty();
		$('#kirim-ulang').text('MOHON TUNGGU..');

		var url = "<?=base_url("Ppk_C/cari_hasil/").$data->user[0]->nomor_identitas?>";
		var formData = new FormData($('#cari_gejala')[0])
		$.ajax({
			url : url,
			type: "POST", 
			data: formData,
			contentType: false,
			processData: false,
			success: function(data){
				// console.log(data);

				window.response = JSON.parse(data);

				// console.log(response);
				document.getElementById("obat_ditemukan").innerHTML = response.obat.length + ' Obat ditemukan';
				
				var html	=	"<div class='row padding-top-10'>";
				html 		+=	"<div class='col'>";
				html 		+=	"<div class='margin-top-20'>";
				html 		+=	"</div>";
				html 		+=	"<div id='accordion'>";
				
				// fetch data obat yang ditemukan
				for(var k in response.obat){
					
					html 		+=	"<div class='card margin-top-20'>";
					html 		+=	"<div class='card-header' id='heading"+response.obat[k].id_obat+"'>";
					html 		+=	"<div class='row'>";
					html 		+=	"<div class='col'>";
					html 		+=	"<h5>";
					html 		+=	"<a href='#collapse"+response.obat[k].id_obat+"' class='collapsed' data-toggle='collapse' aria-expanded='false' aria-controls='collapse"+response.obat[k].id_obat+"'>"+response.obat[k].nama_obat;
					html 		+=	"<i class='icon ion-chevron-down float-right'>";
					html 		+=	"</i>";
					html 		+=	"</a>";
					html 		+=	"</h5>";
					html 		+=	"</div>";
					
					html 		+=	"<div class='col-3 ditemukan rounded'>";
					
					html 		+=	"<i class='icon ion-ios-help float-right' data-toggle='tooltip' data-placement='top' title='Informasi mengenai berapa karakteristik indikasi pada obat ini yang cocok dengan gejala yang dirasakan pasien' onclick='dobol()'>";
					html 		+=	"</i>";
					
					html 		+=	"<h6 class='text-center'>Indikasi Cocok/Obat ditemukan";
					html 		+=	"</h6>";
					html 		+=	"<h6 class='text-center'>"+response.obat[k].Iada+ " / " + response.obat.length;
					html 		+=	"</h6>";
					html 		+=	"</div>";
					
					html 		+=	"<div class='col-3 ditemukan rounded'>";
					html 		+=	"<i class='icon ion-ios-help float-right' data-toggle='tooltip' data-placement='top' title='Informasi mengenai berapa karakteristik peringatan pada obat ini yang harus dihindari oleh pasien sesuai dengan rekam medis'>";
					html 		+=	"</i>";
					html 		+=	"<h6 class='text-center'>Kandungan Peringatan/Obat ditemukan";
					html 		+=	"</h6>";
					if (typeof response.obat[k].karakteristik.peringatan != 'undefined') {
						if (typeof response.obat[k].karakteristik.peringatan.ada != 'undefined') {
							html +=	"<h6 class='text-center'>"+response.obat[k].Pada+ "/" + response.obat.length;
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
					html 		+=	"<h6 class='text-center'>Kandungan Kontra/Obat ditemukan";
					html 		+=	"</h6>";
					if (typeof response.obat[k].karakteristik.kontraindikasi != 'undefined') {
						if (typeof response.obat[k].karakteristik.kontraindikasi.ada != 'undefined') {
							html +=	"<h6 class='text-center'>"+response.obat[k].Kada+ " / " + response.obat.length;
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

					html +=	"<div id='collapse"+response.obat[k].id_obat+"' class='collapse' role='tabpanel' aria-labelledby='heading"+response.obat[k].id_obat+"' data-parent='#accordion'>";
					html +=	"<div class='card-body'>";
					html +=	"<div class='row'>";
					html +=		"<div class='col'>";
					html +=			"<div class='row'>";

					for(var l in response.obat[k].karakteristik){
						
						html +=			"<div ";
						if (l == 'indikasi') {
							html +=			"class='col informasi hijau rounded'>";
						}else if (l == 'kontraindikasi') {
							html +=			"class='col informasi merah rounded'>";
						}else{
							html +=			"class='col informasi kuning rounded'>";
						}
						
						html +=				"<h6>"+l;
						html +=				"</h6>";
						html +=				"<ul>";
						
						// ada dan tanya
						for(var m in response.obat[k].karakteristik[l]){
							// console.log(response.obat[k].karakteristik[l]);
							// console.log(m);
							/*	obat[k]				=	index obat yang didapat
								karakteristik[l]	=	index karakteristik yang didapat
							*/
							for(var n in response.obat[k].karakteristik[l][m]){
								// console.log(response.obat[k].karakteristik[l][m][n].id_karakteristik);			// console.log(n);

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
									}
								}else{
									if (m == 'ada') {
										html +=	"<i class='icon ion-android-alert text-warning'></i>";
									}else if( m == 'tanya'){
										html +=	"<a data-toggle='modal' data-target='#ModalEditKondisi' data-idtipemaster='"+response.obat[k].karakteristik[l][m][n].id_tipe_master+"' data-iduser='"+response.user[0].id_user+"'>";
										html +=	"<i class='icon ion-help-circled text-primary'></i>";
										html +=	"</a>";
									}
								}
								html +=	"</li>";
							}
						}
						html +=				"</ul>";
						html +=			"</div>";
					}
					html +=			"</div>";
					html +=		"</div>";
					html +=	"</div>";
					html += "<div class='row margin-top-10'><button type='button' class='btn btn-primary btn-lg btn-block' title='Jangan lupa masuk ke menu peresepan obat melalui tombol 'ke daftar resep obat' agar data tersimpan pada log pengobatan'><i class='icon ion-ios-plus-outline'></i> Masukkan obat ini ke daftar obat yang akan diberikan</button></div>";
					html +=	"</div>";
					html +=	"</div>";
					html +=	"</div>";
				}
				html +=	"</div>";
				html +=	"</div>";
				html +=	"</div>";

				var currentDiv = document.getElementById("hasil"); 
				currentDiv.innerHTML = html;

				// fetch data histori log pengobatan yang ditemukan
				html = '';
				for(var k in response.histori){
					html += " <button type='button' class='btn btn-primary'>"+response.histori[k]['tanggal']+" <span class='badge badge-light'>"+response.histori[k]['banyak']+"</span></button> ";
				}

				currentDiv = document.getElementById("histori_ditemukan");
				currentDiv.innerHTML = html;

				$('#kirim-ulang').text('KIRIM ULANG');

			},error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#kirim-ulang').text('eror');
				$('#kirim-ulang').attr('disabled',false);
			}
		});
	}

</script>
<!-- funstion tampilkan hasil collapsible -->

<!-- MODAL UNTUK UPDATE KONDISI SEORANG PASIEN -->
<div class="modal fade" id="ModalEditKondisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formeditkondisi" method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Form edit kondisi pasien :  </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<p id="apakah"></p>
					<input type="hidden" name="id_master_kondisi" id="idMasterKondisiE">
					<input type="hidden" name="id_user" id="idUser">
					<input type="hidden" name="detail_kondisi" id="idKondisi">
				</div>
				<div class="modal-footer">
					<a class="btn btn-primary mr-auto text-white" id="btn-tidak-kondisi">TIDAK</a>
					<a class="btn btn-primary text-white" id="btn-ya-kondisi" >YA</a>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL UNTUK UPDATE KONDISI SEORANG PASIEN -->


<div class="col-md-10 konten-kanan" id="style-1">
	<div class="row" id="indikasi-yang-dicari">
		<div class="col">
			<h3>Indikasi yang dicari:</h3>
			<form method="POST" id="cari_gejala">	
					<select class="js-example-basic-multiple col" id="select_gejala" name="gejala[]" multiple title="klik untuk menambah atau mengganti gejala">
						<?php
							foreach ($data->gejala_master as $key => $value) {
								echo "<option value='$value->id_gejala'>$value->detail_gejala</option>";
							}
						?>
					</select>
				<br>
				<br>
				<div class="row">
					<div class="col">
						<a class="btn btn-primary btn-block bg-dark" href="#" role="button" id="kirim-ulang" onclick="update()">Kirim ulang</a>
					</div>
				</div>
			</form>
			<span class="badge badge-success" style="margin-top: 15px;" id="obat_ditemukan"></span>
			<div id="histori_ditemukan"></div>
		</div>
	</div>
	<div class="margin-top-5" id="notif"></div>
	<!-- collapsible ajax HERE-->
	<div id="hasil">
		
	</div>
	<div class="margin-top-15">
		<button type="button" class="btn btn-primary btn-lg btn-block"><i class="icon ion-clipboard"></i> Ke daftar resep obat</button>
	</div>
	<div class="margin-top-15" id='ke-resep-obat'></div>
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
			<span class="nav-link">Nama : 
				<i class="nav-link disabled" href="#"><?=$data->user[0]->nama_user?><a href="<?=base_url('Ppk_C/view_detail_user/').$data->user[0]->nomor_identitas?>" target="_blank"><i class="icon ion-arrow-right-c float-right"></i></a></i>
			</span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Tanggal Lahir / Umur<i class="nav-link disabled" href="#"> <?=$data->user[0]->tanggal_lahir?></i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Nomor Identitas<i class="nav-link disabled"><?=$data->user[0]->nomor_identitas?></i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Note Kondisi
				<div id='note-kondisi'></div>
			</span>
		</li>
<!-- 		<li class="nav-item">
			<span class="nav-link">Dummy<i class="nav-link disabled" href="#">iajkhdbjhagdsjdha skjdnas</i></span>
		</li> -->
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