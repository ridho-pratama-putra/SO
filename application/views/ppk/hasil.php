<?php
$data = json_decode($data,false);
?>

<!-- funstion tampilkan hasil collapsible -->
<script type="text/javascript">
	
	$(document).ready(function(){

		// assign gejala dari database ke plugin select2
		var selected_gejala = <?php echo $data->gejala_pasien?>;
		$('#select_gejala').val(selected_gejala).select2();

		// seperti "onload". update itu untuk tampilkan hasil pencarian. show_kondisi itu untuk menampilkan apa saja kondisi (rekam medis) seorang pasien.
		update();
		// show_kondisi();
		
		$('#ModalEditKondisi').on('show.bs.modal', function(e) {
			$("#idMasterKondisiE").attr('value', $(e.relatedTarget).data('idtipemaster'));
			$("#idUser").attr('value', $(e.relatedTarget).data('iduser'));
			$.get('<?=base_url()?>Ppk_C/cek_kondisi/'+$(e.relatedTarget).data('idtipemaster'),function(html){
				var responE = JSON.parse(html);
				document.getElementById('apakah').innerHTML = "Apakah pasien <h5 class='text-danger'>"+responE[0].detail_kondisi+"</h6>";
				$("#detailKondisi").attr('value',responE[0].detail_kondisi);
			});
		});

		// untuk handle disaat tombol mulai masukkan fakta yang seharusnya dari awal sampai akhir fakta tapi di interupt oleh user agar berhenti sampai situ saja
		$('#ModalUnknownFact').on('hidden.bs.modal', function (e) {
			// console.log('onhide');
			update();
		});

		// untuk handle disaat modal tambah obat ditutup
		$('#LihatWmObat').on('hidden.bs.modal', function (e) {
			// console.log('onhide');
			update();
		});

		// $('#LihatWmGejala').on('hidden.bs.modal', function (e) {
		// 	// console.log('onhide');
		// 	update();
		// });

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
					$('#btn-ya-kondisi').text('ULANG'); //change button text
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
					$('#btn-tidak-kondisi').text('ULANG'); //change button text
					$('#btn-tidak-kondisi').attr('disabled',false); //set button enable 
				}
			});
		});
	});

	// ambil kondisi untuk ditampilkan pada side menu kanan 
	var note_kondisi ='';
	function show_kondisi() {
		// console.log('show');
		$("#note-kondisi").empty();
		// dapatkan kondisi seorang users
		$.get("<?=base_url("Ppk_C/get_col_kondisi/").$data->user[0]->id_user?>",function(html){
			note_kondisi = JSON.parse(html);
			// reset variabel html
			html_aman = '';
			html_hindari = '';
			for(var i in note_kondisi){
				if (note_kondisi[i].status == 0) {
					html_hindari += "<a class='nav-link disabled text-white badge badge-danger'>"+note_kondisi[i].detail_kondisi+"</a> ";
				}else{
					html_aman += "<a class='nav-link disabled text-white badge badge-success'>"+note_kondisi[i].detail_kondisi+"</a> ";
				}
			}
			document.getElementById('note-kondisi-aman').innerHTML = html_aman;	
			document.getElementById('note-kondisi-hindari').innerHTML = html_hindari;	
		});
	}
	
	// reload hasi pencarian obat yang sesuai dan menampilkan log pengobatan dengan gejala yang mirip sebelumnya
	function update(){
		// console.log('update');
		show_kondisi();
		koreksi_gejala();
		cekAvailableWmObat_();
		$('#kirim-ulang').text('MOHON TUNGGU..');

		// cari obat ang relevan, cari histori gejala, cari kondiisi pasien. hasi lpencarian disimpan pada json
		var url = "<?=base_url("Ppk_C/cari_hasil/").$data->user[0]->nomor_identitas?>";
		var id_dokter = "<?=$this->session->userdata('logged_in')['id_user']?>";
		var formData = new FormData($('#cari_gejala')[0]);

		// untuk generate elemen tombol resep saat sudah ada obat di wm_pbat
		var tombolresep = '';

		$.ajax({
			url : url,
			type: "POST", 
			data: formData,
			contentType: false,
			processData: false,
			success: function(data){
				// console.log(data);
				// $("#notif").html(data);	
				response = JSON.parse(data);

				if (typeof response.obat == 'undefined') {
					$('#hasil').empty();
					$('#kirim-ulang').text('KIRIM ULANG');
				}else{
					console.log(response);
					document.getElementById("obat_ditemukan").innerHTML = response.obat.length + ' Obat ditemukan';
					
					// apakah di wmobat sudah ada obat?
					var boolwmobat = false;

					var html = "<div class='row padding-top-10'>";
					html +=	"<div class='col'>";
					html +=	"<div id='accordion' class='margin-top-20'>";
					
					// fetch data obat yang ditemukan
					for(var k in response.obat){
						
						html 		+=	"<div class='card margin-top-5'>";
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
						
						html 		+=	"<i class='icon ion-ios-help float-right' data-toggle='tooltip' data-placement='top' title='Informasi mengenai berapa karakteristik indikasi pada obat ini yang cocok dengan gejala yang dirasakan pasien'>";
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
							html +=	"<ol>";
							
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
						html += "<div class='row margin-top-10'>";
						if (response.obat[k].wm_obat == 'belum') {
							html += "<div class= 'col' id='wm_obat"+response.obat[k].id_obat+"'>";
							html += "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='masukkan_wm("+response.user[0].id_user+","+id_dokter+","+response.obat[k].id_obat+")' title='Masukkan obat ke peresepan'><i class='icon ion-ios-plus-outline'></i> Masukkan ke daftar resep</button> ";
							html+="</div>";
							// boolwmobat = false;
						}else{
							html += "<div class= 'col' id='wm_obat"+response.obat[k].id_obat+"'>";
							html += "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='hapus_wm("+response.user[0].id_user+","+id_dokter+","+response.obat[k].id_obat+")' title='Obat telah masuk kedalam peresepan. Kunjungi halaman peresepan melalui tombol daftar resep di ujung akhir halaman ini'><i class='icon ion-android-delete'></i> Hapus dari daftar resep</button> ";
							html+="</div>";

							boolwmobat = true;
						}
							
						if (bisa_diberikan == false) {
							html += "<div class= 'col' id='wm_obat"+response.obat[k].id_obat+"'>";
							html += "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='masukkan_fakta("+response.user[0].id_user+","+response.obat[k].id_obat+")'><i class='icon ion-ios-plus-outline'></i>Mulai masukkan fakta</button> ";
							html += "</div></div>";
						}else{
							html += "<div class= 'col'>";
							html += "<button type='button' class='btn disabled btn-lg btn-block'><i class='icon ion-ios-plus-outline'></i>Mulai masukkan fakta</button> ";
							html += "</div></div>";
						}
						html +=	"</div>";
						html +=	"</div>";
						html +=	"</div>";
					}
					html +=	"</div>";
					html +=	"</div>";
					html +=	"</div>";

					document.getElementById("hasil").innerHTML = html;
					// console.log(response.histori);
					html ='';
					if (response.histori.length != 0) {
						// fetch data histori log pengobatan yang ditemukan
						html = '<a class="btn btn-primary btn-block" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"> DITEMUKAN LOG PENGOBATAN YANG MIRIP, KLIK UNTUK MELIHAT</a> <div class="collapse" id="collapseExample"> <div class="card card-body">';

						for(var k in response.histori){
							html += "<a href='<?=base_url("Ppk_C/view_detail_per_log/").$data->user[0]->nomor_identitas."/"?>"+response.histori[k].id_log+"' class='btn btn-primary btn-block margin-top-5' target='_blank'> TANGGAL : "+response.histori[k]['tanggal']+" SEBANYAK : "+response.histori[k]['jumlah']+" GEJALA </a>";
						}
						html += '</div>';
						html += '</div>';
					}

					currentDiv = document.getElementById("histori_ditemukan");
					currentDiv.innerHTML = html;

					$('#kirim-ulang').text('KIRIM ULANG');
					if (boolwmobat) {
						tombolresep = "<a href='<?=base_url('Ppk_C/view_resep_/'.$data->user[0]->nomor_identitas)?>' class='btn btn-dark btn-block'><i class='icon ion-clipboard'></i> KE DAFTAR RESEP</a>";
						document.getElementById("tombolResep").className = "col";
						document.getElementById('tombolResep').innerHTML = tombolresep;
					}else{
						document.getElementById('tombolResep').innerHTML = '';
					}
					// console.log('tombolResep '+ tombolresep);
				}

			},error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#kirim-ulang').text('KIRIM ULANG');
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
				$('#btn-unknown-ya-kondisi').text('ULANG'); //change button text
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
				$('#btn-unknown-tidak-kondisi').text('ULANG'); //change button text
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
				// console.log(response.unknown_fact.length);
				$('#ModalUnknownFact').modal('hide');
				update();
			}
		});
	}

	// untuk masukkan obat ke wm_obat
	function masukkan_wm(id_pasien,id_dokter,id_obat){
		$.post("<?=base_url('Ppk_C/handle_insert_wm_obat')?>",
			{
				post_id_pasien		: id_pasien,
				post_id_dokter		: id_dokter,
				post_gejala			: $("#select_gejala").val(),
				post_id_obat		: id_obat
			},function (data) {
				// $("#notif").html(data);	
				// update();
				document.getElementById('wm_obat'+id_obat).innerHTML = "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='hapus_wm("+id_pasien+","+id_dokter+","+id_obat+")' title='Obat telah masuk kedalam peresepan. Kunjungi halaman peresepan melalui tombol daftar resep di ujung akhir halaman ini'><i class='icon ion-android-delete'></i> Hapus dari daftar resep</button> ";
				
				cekAvailableWmObat_();
				document.getElementById('notif').innerHTML = data;
				koreksi_gejala();
				
			}
		);

		// $.ajax({
		// 	type: 'POST',
		// 	url: "<?=base_url('Ppk_C/handle_insert_wm_obat')?>",
		// 	data: {
		// 		post_id_pasien		: id_pasien,
		// 		post_id_dokter		: id_dokter,
		// 		post_gejala			: $("#select_gejala").val(),
		// 		post_id_obat		: id_obat
		// 	},
		// 	dataType: "text",
		// 	success: function(resultData) {
		// 		document.getElementById('wm_obat'+id_obat).innerHTML = "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='hapus_wm("+id_pasien+","+id_dokter+","+id_obat+")' title='Obat telah masuk kedalam peresepan. Kunjungi halaman peresepan melalui tombol daftar resep di ujung akhir halaman ini'><i class='icon ion-android-delete'></i> Hapus dari daftar resep</button> ";
				
		// 		cekAvailableWmObat_();
		// 		document.getElementById('notif').innerHTML = resultData;
		// 		koreksi_gejala();
		// 	},
		// 	error: function (jqXHR, textStatus, errorThrown)
		// 		{
		// 			console.log(jqXHR, textStatus, errorThrown);
		// 			document.getElementById('wm_obat'+id_obat).innerHTML = "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='masukkan_wm("+id_pasien+","+id_dokter+","+id_obat+")' title='Masukkan obat ke peresepan'><i class='icon ion-ios-plus-outline'></i> Masukkan ke daftar resep</button> ";
		// 		}
		// });
	}
	
	// untuk hapus suatu obat dari wm_obat // hanya untuk tombol setiap obat. 
	function hapus_wm(id_pasien,id_dokter,id_obat){
		$.post("<?=base_url('Ppk_C/handle_delete_wm_obat')?>",
			{
				post_id_pasien		: id_pasien,
				post_id_dokter		: id_dokter,
				post_id_obat		: id_obat
			},function(data){
				// update();
				// console.log(data);
				document.getElementById('wm_obat'+id_obat).innerHTML = "<button type='button' class='btn btn-primary btn-lg btn-block' onclick='masukkan_wm("+id_pasien+","+id_dokter+","+id_obat+")' title='Masukkan obat ke peresepan'><i class='icon ion-ios-plus-outline'></i> Masukkan ke daftar resep</button> ";
				document.getElementById('notif').innerHTML = data;
				cekAvailableWmObat_();
			}
		);
		koreksi_gejala();
	}

	// untuk cek adakah gejala yang belum terobati, jika ada maka tampilkan alert, jika tidak ada(semua gejala telah terobati) maka redirect ke halaman view_resep_
	function redirect_resep() {
		// jika semua gejala sudah terobati
		if (true) {
			document.location.href = "<?=base_url('Ppk_C/view_resep_/'.$data->user[0]->nomor_identitas)?>";
		}else{
			
		}
	}

	function koreksi_gejala() {
		// console.log('koreksigejala');
		// cek gejala. cek mana saja yang sudah terobati dan mana saja yang belum terobati
		url = "<?=base_url("Ppk_C/koreksi_gejala/").$data->user[0]->id_user?>";
		$.get(url,function(data){
			// console.log(data);
			if (data != 'empty') {
			var response = JSON.parse(data);
			// parsing gejala yang belum terobati dan gejala yang diobati lebih dari 1 obat untuk dijadikan alert
			var html = '';
			for (var i in response.gejala) {
				// console.log(response.gejala[i].terobati);
				if (typeof response.gejala[i].terobati == 'undefined') {
					html += "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Peringatan</strong> "+response.gejala[i].detail_gejala+" belum terobati.</div>";
				}else if (response.gejala[i].terobati == 'ganda') {
					html += "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Peringatan</strong> "+response.gejala[i].detail_gejala+" diobati dengan obat ganda.</div>";
				}else if (response.gejala[i].terobati == 'sudah') {
						html += "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Berhasil</strong> Gejala "+response.gejala[i].detail_gejala+" telah diberi obat.</div>";
				}
			}
			document.getElementById('notif').innerHTML += html;
		}
		});
	}

	function cekAvailableWmGejala(id_user = <?=$data->user[0]->id_user?>){
		document.getElementById('tutupLihatWmGejala').innerHTML = 'MOHON TUNGGU..';
		document.getElementById('availableWmGejala').innerHTML ='';
		var url ="<?=base_url('Ppk_C/get_wm_gejala/')?>"+id_user;
		$.get(url,function(data){
			var response = JSON.parse(data);
			if (response.length == 0) {
				document.getElementById('availableWmGejala').innerHTML = '<h6>Tutup jendela ini, kemudian masukkan beberapa obat ke peresepan melalui form pencarian indikasi</h6>';
				document.getElementById('tutupLihatWmGejala').setAttribute("href","<?=base_url('Ppk_C/view_gejala/').$data->user[0]->nomor_identitas?>");
				document.getElementById('tutupLihatWmGejala').innerHTML = 'TUTUP';
				document.getElementById('tutupLihatWmGejala').removeAttribute("data-dismiss");
			}else{
				var html = '';
				// console.log(response.length);
				for(var i in response) {
				html += "<div class='row margin-top-5'>";
					html += "<div class='col'>";
						html += response[i].detail_gejala;
					html += "</div>";
					html += "<div class='col'>";
						html += '<button type="button" class="btn btn-primary float-right" onclick="HapusWmGejala('+response[i].id_wm_gejala+','+response[i].id_gejala+')"><i class="icon ion-android-delete"></i></button>';
						// html += response[i].id_user;
					html += "</div>";
				html += "</div>";
				}
				document.getElementById('availableWmGejala').innerHTML = html;
				document.getElementById('tutupLihatWmGejala').innerHTML = 'TUTUP';
				document.getElementById('tutupLihatWmGejala').setAttribute("data-dismiss","modal");
			}
			koreksi_gejala();
		});
	}

	// function unutk tombol hapus suatu gejala pada wm obat
	function HapusWmGejala(id_wm_gejala,id_gejala) {
		
		$.post(
			"<?=base_url('Ppk_C/handle_delete_wm_gejala')?>",{
				post_id_wm_gejala : id_wm_gejala
			},function(){
				cekAvailableWmGejala();
				$("#select_gejala option[value="+id_gejala+"]").prop("selected",false).parent().trigger("change");
			}
		);
	}

	// cek apakah ada obat di wmobat
	function cekAvailableWmObat(){
		// console.log('cekAvailableWmObat');
		document.getElementById('tutupLihatWmObat').innerHTML = 'MOHON TUNGGU..';
		document.getElementById('availableWmObat').innerHTML ='';
		var id_user = <?=$data->user[0]->id_user?>;
		var url ="<?=base_url('Ppk_C/get_wm_obat/')?>"+id_user;
		$.get(url,function(data){
			// console.log(data.length);
			var response = JSON.parse(data);
			// console.log(response);
			if (response.length == 0) {
				// return response;
				document.getElementById('availableWmObat').innerHTML = '<h6>Belum ada obat yang diresepkan. Obat yang telah diresepkan akan tampil disini.</h6>';
					// document.getElementById('tutupLihatWmObat').setAttribute("href","<?=base_url('Ppk_C/view_gejala/').$data->user[0]->nomor_identitas?>");
				document.getElementById('tutupLihatWmObat').innerHTML = 'TUTUP';
					// document.getElementById('tutupLihatWmObat').removeAttribute("data-dismiss");
			}else{
				// return data;
				var html = '';
				// // console.log(response);
				for(var i in response) {
				html += "<div class='row margin-top-5'>";
					html += "<div class='col'>";
						html += response[i].nama_obat;
					html += "</div>";
					html += "<div class='col'>";
						html += '<button type="button" class="btn btn-primary float-right" onclick="hapusWmObat('+response[i].id_wm_obat+')"><i class="icon ion-android-delete"></i></button>';
				// 		// html += response[i].id_user;
					html += "</div>";
				html += "</div>";
				}
				document.getElementById('availableWmObat').innerHTML = html;
				document.getElementById('tutupLihatWmObat').innerHTML = 'TUTUP';
				document.getElementById('tutupLihatWmObat').setAttribute("data-dismiss","modal");
			}
			// koreksi_gejala();
			// panggil update saat modal lihat wmobat ditutup 
		});
	}

	// untuk cek apakah ada obat pada wmobat
	function cekAvailableWmObat_(){
		// console.log('cekAvailableWmObat_');
		var id_user = <?=$data->user[0]->id_user?>;
		var url ="<?=base_url('Ppk_C/get_wm_obat/')?>"+id_user;
		var dataGet;
		$.get(url,function(data){
			// console.log(data);
			var response = JSON.parse(data);
			// console.log(response);
			if (response.length == 0) {
				document.getElementById('tombolResep').innerHTML = "";
				document.getElementById('tombolResep').className = '';
			}else{
				document.getElementById("tombolResep").className = "col";
				document.getElementById('tombolResep').innerHTML = "<a href='<?=base_url('Ppk_C/view_resep_/'.$data->user[0]->nomor_identitas)?>' class='btn btn-dark btn-block'><i class='icon ion-clipboard'></i> KE DAFTAR RESEP</a>";
			}
		});
	}


	function hapusWmObat(id_wm_obat){
		// console.log('hapusWmObat');
		$.post(
			// false karena bersahal dari halaman hasil, bukan resep
			"<?=base_url('Ppk_C/handle_delete_wm_obat/0')?>",{
				post_id_wm_obat : id_wm_obat
			},function(){
				// console.log(data);
				cekAvailableWmObat();
				// ModalAvailableObat();
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

<!-- MODAL UNTUK HAPUS BEBERAPA GEJALA PADA WM -->
<div class="modal fade hide" id="LihatWmGejala" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<form  method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel_">Berikut ini gejala yang telah masuk kedalam database</h4>
					
				</div>
				<div class="modal-body">
					<div id="availableWmGejala">
						
					</div>
				</div>
				<div class="modal-footer">
					<a class="btn btn-secondary text-white" data-dismiss="modal" id="tutupLihatWmGejala" role="button">TUTUP</a>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL UNTUK HAPUS BEBERAPA GEJALA PADA WM -->

<!-- MODAL UNTUK HAPUS BEBERAPA obat PADA WM -->
<div class="modal fade hide" id="LihatWmObat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<form  method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel_">Berikut ini obat yang telah masuk kedalam database</h4>
					
				</div>
				<div class="modal-body">
					<div id="availableWmObat">
						
					</div>
				</div>
				<div class="modal-footer">
					<a class="btn btn-secondary text-white" data-dismiss="modal" id="tutupLihatWmObat" role="button">TUTUP</a>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL UNTUK HAPUS BEBERAPA obat PADA WM -->

<!-- konten kanan -->
<div class="col-md-10 konten-kanan" id="style-1">
	<form method="POST" id="cari_gejala" action="<?=base_url('Ppk_C/view_resep_/'.$data->user[0]->nomor_identitas)?>">	
		<div class="row" id="indikasi-yang-dicari">
			<div class="col">
				<h3>Indikasi yang dicari:</h3>
					<select class="js-example-basic-multiple col" id="select_gejala" name="gejala[]" multiple title="klik untuk menambah atau mengganti gejala">
						<?php
							foreach ($data->gejala_master as $key => $value) {
								echo "<option value='$value->id_gejala'>$value->detail_gejala</option>";
							}
						?>
					</select>
					<input type="hidden" name="nomor_identitas" value="<?=$data->user[0]->nomor_identitas?>">
				<br>
				<br>
				<span class="badge badge-success"id="obat_ditemukan"></span>
				<div class="row margin-top-5">
					<div class="col">
						<a class="btn btn-primary btn-block bg-dark" href="#" role="button" id="kirim-ulang" onclick="update()">KIRIM ULANG</a>
					</div>
					
				</div>
				<div class="row margin-top-10">
					<div class="col">
						<div id="histori_ditemukan"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="margin-top-5" id="notif"></div>
		<!-- collapsible ajax hasil pencarian obat HERE-->
		<div id="hasil">
		</div>
		<!-- END collapsible ajax hasil pencarian obat HERE-->
		<div class="row margin-top-10">
		<div class="col">
						<a class="btn btn-primary btn-block bg-dark" href="#" role="button" data-toggle="modal" data-target="#LihatWmGejala" onclick="cekAvailableWmGejala()">LIHAT DIAGNOSA</a>
					</div>
					<div class="col">
						<a class="btn btn-primary btn-block bg-dark" href="#" role="button" data-toggle="modal" data-target="#LihatWmObat" onclick="cekAvailableWmObat()">LIHAT OBAT DIRESEPKAN</a>
					</div>
		<div id="tombolResep">
			<!-- <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="icon ion-clipboard"></i> KE DAFTAR RESEP</button> -->
			<!-- <a href="<?=base_url('Ppk_C/view_resep_/'.$data->user[0]->nomor_identitas)?>" class="btn btn-primary btn-lg btn-block"><i class="icon ion-clipboard"></i> KE DAFTAR RESEP</a> -->
			<!-- <a class="btn btn-primary btn-lg btn-block" onclick="redirect_resep()"><i class="icon ion-clipboard"></i> KE DAFTAR RESEP</a> -->
		</div>
		</div>
		<div class="margin-top-5" id='ke-resep-obat'></div>
	</form>
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
			<span class="nav-link"><h6>Nama : </h6>
				<i class="nav-link disabled" href="#"><?=$data->user[0]->nama_user?><a href="<?=base_url('Ppk_C/view_detail_user/').$data->user[0]->nomor_identitas?>" target="_blank"><i class="icon ion-arrow-right-c float-right"></i></a></i>
			</span>
		</li>
		<li class="nav-item">
			<span class="nav-link"><h6>Tanggal Lahir / Umur </h6><i class="nav-link disabled" href="#"> <?=$data->user[0]->tanggal_lahir != '' ? tgl_indo($data->user[0]->tanggal_lahir) : 'YYYY-mm-dd' ?> / <?=$data->umur->y?> Thn</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link"><h6>Nomor Identitas</h6><i class="nav-link disabled"><?=$data->user[0]->nomor_identitas?></i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link"><h6>Note Kondisi</h6> 
				<div class="row margin-top-5">
					<div class="col">
						<h6>Aman : </h6>
						<div id='note-kondisi-aman'></div>
					</div>
				</div>
				<div class="row margin-top-10">
					<div class="col">
						<h6>Hindari : </h6>
						<div id='note-kondisi-hindari'></div>
					</div>
				</div>
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