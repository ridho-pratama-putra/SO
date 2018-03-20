<?php
$data = json_decode($data,false);
?>
<script type="text/javascript">
	$(document).ready(function(){
		var selected_gejala = <?php echo $data->gejala_pasien?>;
		console.log('ready');
		$('#select_gejala').val(selected_gejala).select2();
		update();
	});
	function update(){
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
				console.log(response);
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
					<div class="col">
						<a class="btn btn-primary btn-block bg-dark" href="#" role="button" id="kirim-ulang" onclick="update()">Kirim ulang</a>
					</div>
				</div>
			</form>
			<span class="badge badge-success" style="margin-top: 15px;"><?=isset($data->obat)? sizeof($data->obat) : '0'?> Obat ditemukan</span>
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