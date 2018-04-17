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
				document.getElementById('apakah').innerHTML = "Apakah pasien <h5 class='text-danger'>"+responE[0].detail_kondisi+"</h6>";
				$("#detailKondisi").attr('value',responE[0].detail_kondisi);
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
					$('#btn-tidak-kondisi').text('TIDAK');
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					console.log(jqXHR, textStatus, errorThrown);
					$('#btn-tidak-kondisi').text('Eror'); //change button text
					$('#btn-tidak-kondisi').attr('disabled',false); //set button enable 
				}
			});
		});
	});

	// ambil kondisi untuk ditampilkan pada side menu kanan 
	var note_kondisi ='';
	function show_kondisi() {
		$("#note-kondisi").empty();
		// dapatkan kondisi seorang users
		$.get("<?=base_url("Ppk_C/get_col_kondisi/").$data->user[0]->id_user?>",function(html){
			note_kondisi = JSON.parse(html);
			// reset variabel html
			html = '';
			for(var i in note_kondisi){
				if (note_kondisi[i].status == 0) {
					html += "<a class='nav-link disabled text-white badge badge-danger'>"+note_kondisi[i].detail_kondisi+"</a> ";
				}else{
					html += "<a class='nav-link disabled text-white badge badge-success'>"+note_kondisi[i].detail_kondisi+"</a> ";
				}
			}
			document.getElementById('note-kondisi').innerHTML = html;	
		});
	}
	
	// reload hasi pencarian obat yang sesuai dan menampilkan log pengobatan dengan gejala yang mirip sebelumnya
	function update(){
		show_kondisi();
		$('#kirim-ulang').text('MOHON TUNGGU..');

		var url = "<?=base_url("Ppk_C/cari_hasil/").$data->user[0]->nomor_identitas?>";
		var id_dokter = "<?=$this->session->userdata('logged_in')['id_user']?>";
		var formData = new FormData($('#cari_gejala')[0])
		$.ajax({
			url : url,
			type: "POST", 
			data: formData,
			contentType: false,
			processData: false,
			success: function(data){
				// console.log(data);
				response = JSON.parse(data);
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
						html +=	"<ul>";
						
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
										bisa_diberikan = false;
									}
								}else{
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
						html +=	"</ul>";
						html +=	"</div>";
					}
					html +=	"</div>";
					html +=	"</div>";
					html +=	"</div>";
					if (bisa_diberikan) {
						html += "<div class='row margin-top-10'>";
						html += "<button type='button' class='btn btn-primary btn-lg col-4' onclick='masukkan_wm("+response.user[0].id_user+","+id_dokter+","+response.obat[k].id_obat+")'><i class='icon ion-ios-plus-outline'></i> Masukkan ke daftar resep</button> ";
						html += "<button type='button' class='btn btn-primary btn-lg offset-lg-4 col-4' onclick='masukkan_fakta("+response.user[0].id_user+","+response.obat[k].id_obat+")'><i class='icon ion-ios-plus-outline'></i>Mulai masukkan fakta</button> ";
						html += "</div><div class='row margin-top-10'>"
						html += "<button type='button' class='btn btn-primary btn-lg btn-block' title='Jangan lupa masuk ke menu peresepan obat melalui tombol 'ke daftar resep obat' agar data tersimpan pada log pengobatan'><i class='icon ion-ios-plus-outline'></i> Masukkan obat ini ke daftar obat yang akan diberikan</button></div>";
					}else{
						html += "<div class='row margin-top-10'>"
						html += "<button type='button' class='btn btn-primary btn-lg col-4' onclick='masukkan_wm("+response.user[0].id_user+","+id_dokter+","+response.obat[k].id_obat+")'><i class='icon ion-ios-plus-outline'></i> Masukkan ke daftar resep</button> ";
						html += "<button type='button' class='btn btn-primary btn-lg offset-lg-4 col-4' onclick='masukkan_fakta("+response.user[0].id_user+","+response.obat[k].id_obat+")'><i class='icon ion-ios-plus-outline'></i>Mulai masukkan fakta</button> ";
						html += "</div><div class='row margin-top-10'>"
						html += "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='masukkan_fakta("+response.user[0].id_user+","+response.obat[k].id_obat+")'><i class='icon ion-ios-plus-outline'></i> Ada beberapa fakta yang belum diketahui. Mulai masukkan fakta</button></div>";
					}
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
					html += "<a href='<?=base_url("Ppk_C/view_detail_per_log/").$data->user[0]->nomor_identitas."/"?>"+k+"' class='btn btn-primary btn-block margin-top-5' target='_blank'> Ditemukan Log pengobatan yang mirip pada tanggal : "+response.histori[k]['tanggal']+" sebanyak : "+response.histori[k]['banyak']+" gejala </a>";
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

	// button saat seorang pasien menderita penyakit tersebut
	function unknown_ya() {
		var	url = "<?= base_url('Ppk_C/handle_add_kondisi_/0/0')?>";
		var formData = new FormData($('#formunknownfact')[0]);
		document.getElementById("btn-unknown-ya-kondisi").innerHTML="Mohon Tunggu..";
		$.ajax({
			url : url,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data)
			{
				document.getElementById("btn-unknown-ya-kondisi").innerHTML="Ya";
				data = JSON.parse(data);
				masukkan_fakta(data.id_user,data.id_obat);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#btn-unknown-ya-kondisi').text('Eror'); //change button text
				$('#btn-unknown-ya-kondisi').attr('disabled',false); //set button enable 
			}
		});
	};

	// button saat seorang pasien aman dari penyakit tesebut
	function unknown_tidak() {
		var	url = "<?= base_url('Ppk_C/handle_add_kondisi_/1/0')?>";
		var formData = new FormData($('#formunknownfact')[0]);
		document.getElementById("btn-unknown-tidak-kondisi").innerHTML="Mohon Tunggu..";
		$.ajax({
			url : url,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data)
			{
				document.getElementById("btn-unknown-tidak-kondisi").innerHTML="Tidak";
				data = JSON.parse(data);
				masukkan_fakta(data.id_user,data.id_obat);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#btn-unknown-tidak-kondisi').text('Eror'); //change button text
				$('#btn-unknown-tidak-kondisi').attr('disabled',false); //set button enable 
			}
		});
	};

	// untuk masukkan fakta. function ini triggernya ada di button mulai masukkan fakta pada setiap obat
	function masukkan_fakta(id_user,id_obat) {
		var url = "<?=base_url("Ppk_C/get_unknown_fact/")?>"+id_user+"/"+id_obat;
		$.get(url,function(data){
			var response = JSON.parse(data);
			$('#ModalUnknownFact').find('#idUser_').val(response.id_user.id_user);
			if (response.unknown_fact.length != 0) {
				for (var i = 0; i < 1; i++) {
					$('#ModalUnknownFact').modal('show');
					document.getElementById('apakah_').innerHTML = "Apakah pasien <h5 class='text-danger'>"+response.unknown_fact[i].detail_tipe+"</h6>";
					$('#ModalUnknownFact').find('#idTipeMaster_').val(response.unknown_fact[i].id_tipe_master);
					$('#ModalUnknownFact').find('#detailKondisi_').val(response.unknown_fact[i].detail_tipe);
					$('#ModalUnknownFact').find('#idObat_').val(id_obat);
				}
			}else{
				$('#ModalUnknownFact').modal('hide');
				update();show_kondisi();
			}
		});
	}

	function masukkan_wm(id_pasien,id_dokter,id_obat){

		$.post("<?=base_url('Ppk_C/handle_insert_wm_obat')?>",
			{
				post_id_pasien		: id_pasien,
				post_id_dokter		: id_dokter,
				post_gejala			: $("#select_gejala").val(),
				post_id_obat		: id_obat
			},function (data) {
				$("#notif").html(data);	
			}
		);
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
					<input type="hidden" name="detail_kondisi" id="detailKondisi">
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


<!-- MODAL UNTUK UNKNOWN FACT -->
<div class="modal fade" id="ModalUnknownFact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formunknownfact" method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel_">Form Backward Chaining:  </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<p id="apakah_"></p>
					<input type="hidden" name="id_master_kondisi" id="idTipeMaster_">
					<input type="hidden" name="id_user" id="idUser_">
					<input type="hidden" name="detail_kondisi" id="detailKondisi_">
					<input type="hidden" name="id_obat" id="idObat_">
				</div>
				<div class="modal-footer">
					<a class="btn btn-primary mr-auto text-white" onclick="unknown_tidak()" id="btn-unknown-tidak-kondisi">Tidak</a>
					<!-- <a class="btn btn-primary mr-auto text-white" id="btn-unknown-tidak-kondisi">TIDAK</a> -->
					<a class="btn btn-primary text-white" onclick="unknown_ya()" id="btn-unknown-ya-kondisi">Ya</a>
					<!-- <a class="btn btn-primary text-white" id="btn-unknown-ya-kondisi" >YA</a> -->
				</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL UNTUK UNKNOWN FACT -->


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
			<span class="badge badge-success margin-top-5"id="obat_ditemukan"></span>
			<div id="histori_ditemukan"></div>
		</div>
	</div>
	<div class="margin-top-5" id="notif"></div>
	<!-- collapsible ajax HERE-->
	<div id="hasil">
		
	</div>
	<div class="margin-top-15">
		<a href="<?=base_url('Ppk_C/cari_hasil_/'.$data->user[0]->nomor_identitas)?>" role='button' class="btn btn-primary btn-lg btn-block"><i class="icon ion-clipboard"></i> Ke daftar resep obat</a>
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
		<!--<li class="nav-item">
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