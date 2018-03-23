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
<script type="text/javascript">
	$('.ditemukan').tooltip();
	$(document).ready(function(){
		var selected_gejala = <?php echo $data->gejala_pasien?>;
		$('#select_gejala').val(selected_gejala).select2();
		update();
	});

	$(function () {
	  $('[data-toggle="tooltip"]').tooltip();
	})

	function update(){
		$("#hasil").empty();
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
				var response = JSON.parse(data);

					// console.log(response);
				document.getElementById("obat_ditemukan").innerHTML = response.obat.length + ' Obat ditemukan';
				
				var each_obat = document.createElement('div');
				each_obat.setAttribute("class","row padding-top-10");

				var col = document.createElement('div');
				col.setAttribute('class', 'col');

				var margin_top_20 = document.createElement('div');
				margin_top_20.setAttribute('class','margin-top-20');

				var accordion = document.createElement('div');
				accordion.setAttribute('id','accordion');
				// accordion.setAttribute('role','tablist');

				// console.log(response.obat);
				for(var k in response.obat){

					var card = document.createElement('div');
					card.setAttribute('class', 'card margin-top-20');

					var card_header = document.createElement('div');
					card_header.setAttribute('class', 'card-header');
					// card_header.setAttribute('role', 'tab');
					card_header.setAttribute('id', 'heading'+response.obat[k].id_obat);

					var row = document.createElement('div');
					row.setAttribute('class', 'row');

					var col1 = document.createElement('div');
					col1.setAttribute('class','col');

					var h5 = document.createElement('h5');

					var link = document.createElement('a');
					link.setAttribute('data-toggle', 'collapse');
					link.setAttribute('href', '#collapse'+response.obat[k].id_obat);
					link.setAttribute('class', 'collapsed');
					link.setAttribute('aria-expanded', 'false');
					link.setAttribute('aria-controls', 'collapse'+response.obat[k].id_obat);

					var chevron = document. createElement('i');
					chevron.setAttribute('class','icon ion-chevron-down float-right');

					var nama_obat = document.createTextNode(response.obat[k].nama_obat);

					var Ifound = document.createElement('div');
					Ifound.setAttribute('class', 'col-3 ditemukan rounded');

					var Icontainer = document.createElement('h6');
					Icontainer.setAttribute('class', 'text-center');

					var Itext = document.createTextNode('Indikasi Cocok/Obat ditemukan');

					// data-toggle="tooltip" data-placement="left" title="Tooltip on left"
					var ItextHelp = document.createElement('i');
					ItextHelp.setAttribute('class', 'icon ion-ios-help float-right');
					ItextHelp.setAttribute('style', 'padding-bottom:0px;');
					ItextHelp.setAttribute('title', 'Informasi mengenai berapa karakteristik indikasi pada obat ini yang cocok dengan gejala yang dirasakan pasien');

					var Ijml = document.createElement('h6');
					Ijml.setAttribute('class', 'text-center');

					var IjmlText = document.createTextNode(response.obat[k].karakteristik.indikasi.ada.length+ " / " + response.obat.length);

					var Kfound = document.createElement('div');
					Kfound.setAttribute('class', 'col-3 ditemukan rounded');


					var Kcontainer = document.createElement('h6');
					Kcontainer.setAttribute('class', 'text-center');

					var Ktext = document.createTextNode('Kandungan Kontraindikasi/Obat ditemukan');

					var KtextHelp = document.createElement('i');
					KtextHelp.setAttribute('class', 'icon ion-ios-help float-right');
					KtextHelp.setAttribute('title', 'Informasi mengenai berapa karakteristik kontraindikasi pada obat ini yang harus dihindari oleh pasien sesuai dengan rekam medis');

					var Kjml = document.createElement('h6');
					Kjml.setAttribute('class', 'text-center');

					if (typeof response.obat[k].karakteristik.kontraindikasi != 'undefined') {
						if (typeof response.obat[k].karakteristik.kontraindikasi.ada != 'undefined') {
							var KjmlText = document.createTextNode(response.obat[k].karakteristik.kontraindikasi.ada.length+ "/" + response.obat.length);
						}else{
							var KjmlText = document.createTextNode("0 / " + response.obat.length);
						}
					}else{
						var KjmlText = document.createTextNode("0 / " + response.obat.length);
					}

					var Pfound = document.createElement('div');
					Pfound.setAttribute('class', 'col-3 ditemukan rounded');

					var Pcontainer = document.createElement('h6');
					Pcontainer.setAttribute('class', 'text-center');

					var Ptext = document.createTextNode('Kandungan Peringatan/Obat ditemukan');

					var PtextHelp = document.createElement('i');
					PtextHelp.setAttribute('class', 'icon ion-ios-help float-right');
					PtextHelp.setAttribute('title', 'Informasi mengenai berapa karakteristik peringatan pada obat ini yang harus dihindari oleh pasien sesuai dengan rekam medis');

					var Pjml = document.createElement('h6');
					Pjml.setAttribute('class', 'text-center');
					if (typeof response.obat[k].karakteristik.peringatan != 'undefined') {
						if (typeof response.obat[k].karakteristik.peringatan.ada != 'undefined') {
							var PjmlText = document.createTextNode(response.obat[k].karakteristik.peringatan.ada.length+ "/" + response.obat.length);
						}else{
							var PjmlText = document.createTextNode("0 / " + response.obat.length);
						}
					}else{
						var PjmlText = document.createTextNode("0 / " + response.obat.length);
					}

					var collapse = document.createElement('div');
					collapse.setAttribute('id', 'collapse'+response.obat[k].id_obat);
					collapse.setAttribute('class', 'collapse');
					collapse.setAttribute('role', 'tabpanel');
					collapse.setAttribute('aria-labelledby', 'heading'+ response.obat[k].id_obat);
					collapse.setAttribute('data-parent', '#accordion');

					var card_body = document.createElement('div');
					card_body.setAttribute('class', 'card-body');

					var row1 = document.createElement('div');
					row1.setAttribute('class', 'row');

					var col2 = document.createElement('div');
					col2.setAttribute('class', 'col');

					var row2 = document.createElement('div');
					row2.setAttribute('class', 'row');


					for(var l in response.obat[k].karakteristik){
						
						var col3 = document.createElement('div');
						if (l == 'indikasi') {
							col3.setAttribute('class', 'col informasi hijau rounded');

						}else if (l == 'kontraindikasi') {
							col3.setAttribute('class', 'col informasi merah rounded');
						}else{
							col3.setAttribute('class', 'col informasi kuning rounded');
						}

						var h6_karakter = document.createElement('h6');

						// karakteristik
						var h6text = document.createTextNode(l);

						var ul = document.createElement('ul');

						// ada dan tanya
						for(var m in response.obat[k].karakteristik[l]){
							// console.log(response.obat[k].karakteristik[l]);
							// console.log(m);

							/*
							obat[k]				=	index obat yang didapat
							karakteristik[l]	=	index karakteristik yang didapat

							*/
							for(var n in response.obat[k].karakteristik[l][m]){
								// console.log(response.obat[k].karakteristik[l][m][n].id_karakteristik);
								// console.log(m);

								var li = document.createElement('li');
								var li_text = document.createTextNode(response.obat[k].karakteristik[l][m][n].detail_tipe);

								var li_icons = document.createElement('i');
								if (l == 'indikasi') {
									if (m == 'ada') {
										li_icons.setAttribute('class', 'icon ion-checkmark-circled text-success');
									}
									else{
										li_icons.setAttribute('class', 'icon ion-help-circled text-primary');
									}
								}else if (l =='kontraindikasi') {
									if (m == 'ada') {
										li_icons.setAttribute('class', 'icon ion-android-alert text-danger');
									}else{
										li_icons.setAttribute('class', 'icon ion-help-circled text-primary');
									}
								}else{
									if (m == 'ada') {
										li_icons.setAttribute('class', 'icon ion-android-alert text-warning');
									}else{
										li_icons.setAttribute('class', 'icon ion-help-circled text-primary');
									}
								}

								ul.appendChild(li);
								li.appendChild(li_text);
								li.appendChild(li_icons);
							}
						}

						row2.appendChild(col3);
						col3.appendChild(h6_karakter);
						h6_karakter.appendChild(h6text);
						col3.appendChild(ul);
					}

					card.appendChild(card_header);
					accordion.appendChild(card);
					card_header.appendChild(row);

					row.appendChild(col1);
					col1.appendChild(h5);
					h5.appendChild(link);
					link.appendChild(nama_obat);
					link.appendChild(chevron);
					
					row.appendChild(Ifound);
					Ifound.appendChild(ItextHelp);
					Ifound.appendChild(Icontainer);
					Icontainer.appendChild(Itext);
					Ifound.appendChild(Ijml);
					Ijml.appendChild(IjmlText);


					row.appendChild(Kfound);
					Kfound.appendChild(KtextHelp);
					Kfound.appendChild(Kcontainer);
					Kcontainer.appendChild(Ktext);
					Kfound.appendChild(Kjml);
					Kjml.appendChild(KjmlText);

					row.appendChild(Pfound);
					Pfound.appendChild(PtextHelp);
					Pfound.appendChild(Pcontainer);
					Pcontainer.appendChild(Ptext);
					Pfound.appendChild(Pjml);
					Pjml.appendChild(PjmlText);

					card.appendChild(collapse);
					collapse.appendChild(card_body);
					card_body.appendChild(row1);
					row1.appendChild(col2);
					col2.appendChild(row2);
				}

				col.appendChild(margin_top_20);
				col.appendChild(accordion);
				each_obat.appendChild(col);

				var currentDiv = document.getElementById("hasil"); 
				currentDiv.appendChild(each_obat);
			},error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#kirim-ulang').text('eror');
				$('#kirim-ulang').attr('disabled',false);
			}
		});
	}


</script>

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
					<div class="col" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
						<a class="btn btn-primary btn-block bg-dark" href="#" role="button" id="kirim-ulang" onclick="update()">Kirim ulang</a>
					</div>
				</div>
			</form>					
			<span class="badge badge-success" style="margin-top: 15px;" id="obat_ditemukan" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>
		</div>
	</div>
	<!-- collapsible ajax HERE-->
	<div id="hasil">
		
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