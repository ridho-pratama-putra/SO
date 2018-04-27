<!-- DATATABLE via JAVASCRIPT. menggunakan javascript karena hapus dan edit karakteristik dihandle oleh AJAX. biar live update. kalo PHP harus  refresh dulu-->
<script type="text/javascript">

	window.onload=show_kondisi();
	var respon;

	function show_kondisi(){
		$.get('<?php echo base_url('Ppk_C/dataTable_kondisi/'.$user[0]->id_user)?>', function(html){
			respon = JSON.parse(html);
			// console.log('data in : '+window.respon.kondisi);
			// destroy dulu datatable sebelumnya yang menggunakan json. 
			$('#kondisi_pasien').DataTable().destroy();

			// declare lagi datatable json
			$('#kondisi_pasien').DataTable({

				// ambil data yang dikirim dari kontroler. nama dikontroler data[$karakteristik]
				data : (respon.kondisi),

				// decalare isi format urutan kolom
				columns: [
					{ "data": "detail_kondisi"},
					{ "data": "tanggal_ditambahkan"},
					{ "data": "status",
						render: function ( data, type, full, meta ) {
							if (data == 1) {
								return 'Aman';
							}else{
								return 'Hindari';
							}
						}
					},
					{ "data": "id_kondisi" ,
						render: function ( data, type, full, meta ) {
							return '<div class="btn-group" role="group">'+
								'<a href="" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalEditKondisi" title="edit kondisi" data-idkondisi="'+data+'" ><i class="icon ion-edit"></i></a>'+
								'<a href="" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalDeleteKondisi" title="hapus kondisi" data-idkondisik="'+data+'" ><i class="icon ion-android-delete"></i></a>'+
							'</div>';
						}
					}
				],

				// disable sort pada kolom CRUD yang berisi buton edit dan hapus. nilai target dimulai dari 0
				"columnDefs": [{
									"targets": [3],
									"orderable": false
								}],
				"paging": false
				});
		});
	}

	window.onload=show_log();
	function show_log(){
		$.get('<?php echo base_url('Ppk_C/dataTable_log/'.$user[0]->id_user)?>', function(html){
			respon = JSON.parse(html);
			// console.log('data in : '+window.respon.kondisi);
			// destroy dulu datatable sebelumnya yang menggunakan json. 
			$('#log_pengobatan').DataTable().destroy();

			// declare lagi datatable json
			$('#log_pengobatan').DataTable({

				// ambil data yang dikirim dari kontroler. nama dikontroler data[$karakteristik]
				data : (respon.log_pengobatan),

				// decalare isi format urutan kolom
				columns: [
					{ "data": "tanggal"},
					{ "data": "id_log" ,
						render: function ( data, type, full, meta ) {
							return '<div class="btn-group" role="group">'+
								'<a href="<?=base_url()?>Ppk_C/view_detail_per_log/<?=$user[0]->nomor_identitas?>/'+data+'" class="btn btn-primary" style="text-decoration: none;" data-toggle="tooltip" title="lihat lebih detail apa saja gejala yang dicatat pada pengobatan di tanggal ini">Detail Pengobatan</a>'+
								'<a href="#modal" role="button" data-toggle="modal" data-target="#ModalDeleteLog" title="hapus log pengobatan ini" data-idlog="'+data+'"  class="btn btn-danger" data-toggle="tooltip" title="hapus log pengobatan di tanggal ini"><i class="icon ion-android-delete"></i> </a>'+
							'</div>';
						}
					}
				],

				// disable sort pada kolom CRUD yang berisi buton edit dan hapus. nilai target dimulai dari 0
				"columnDefs": [{
									"targets": [1],
									"orderable": false
								}]
				});
		});
	}
</script>
<!-- END DATATABLE AJAX -->

<!-- JAVASCRIP TOOLTIP -->
<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
	$('#tooltip-gejala').tooltip();
</script>
<!-- JAVASCRIP TOOLTIP -->

<!-- KONTEN KANAN -->
<div class="col-md-10 konten-kanan" id="style-1">
	<div class="row">

		<!-- DATATABLE LOG PENGOBATAN -->
		<div class="col-12">
			<div id="notif_log"></div>
			<?= $this->session->flashdata('alert_log_pengobatan'); ?>
			<br>
			<h1 class="text-center">Log Pemberian Obat</h1>
			<a class="btn btn-primary float-right" href="<?=base_url()?>Ppk_C/view_gejala/<?=$user[0]->nomor_identitas?>" role="button">Ke Menu Pemeriksaan</a>
			<br>
			<br>
			<table id="log_pengobatan" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
				<thead class="thead-dark">
					<tr>
					<th>Tanggal</th>
					<th width="50px;"></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
		<!-- END DATATABLE LOG PENGOBATAN -->
		
	</div>

	<!-- MODAL HAPUS LOG PENGOBATAN PASIEN-->
	<div class="modal fade" id="ModalDeleteLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<form id="formdeletelog" method="POST">      
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Dibutuhkan aksi</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
						<input type="hidden" name="id_log" id="idLog">
						<div class="modal-body">
							Yakin ingin menghapus log pengobatan ini?
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
							<a class="btn btn-primary" id="btn-hapus-log" >Ya!</a>
						</div>
				</div>
			</form>
		</div>
	</div>
	<!-- END MODAL HAPUS LOG PENGOBATAN PASIEN -->

	<!-- JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL HAPUS LOG PENGOBATAN PASIEN -->
	<script type="text/javascript">
		$('#ModalDeleteLog').on('show.bs.modal', function(e) {
			$("#idLog").attr('value', $(e.relatedTarget).data('idlog'));
		});
	</script>
	<!-- END JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL HAPUS LOG PENGOBATAN PASIEN -->

	<!-- HANDLING HAPUS LOG PENGOBATAN PASIEN-->
	<script type="text/javascript">	
		$("#btn-hapus-log" ).click(function() {
			$('#btn-hapus-log').text('Processing...'); //change button text
			$('#btn-hapus-log').attr('disabled',true); //set button disable 
			
			var	url = "<?= base_url('Ppk_C/handle_delete_log/')?>";
			var formData = new FormData($('#formdeletelog')[0]);
			// console.log(formData);
			$.ajax({
				url : url,
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(data)
				{
					// buat notif sukses
					$("#notif_log").html(data);
					
					// kembalikan elemen html modal ke default
					$('#btn-hapus-log').text('Ya!'); //change button text
					$('#btn-hapus-log').attr('disabled',false); //set button enable 
					$('#ModalDeleteLog').modal('hide');
					show_log();
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					console.log(jqXHR, textStatus, errorThrown);
					$('#btn-hapus-log').text('Eror'); //change button text
					$('#btn-hapus-log').attr('disabled',false); //set button enable 
				}
			});
		});
	</script>
	<!-- END HANDLING HAPUS LOG PENGOBATAN PASIEN-->

	<div class="row">
		<!-- DATATABLE KONDISI PASIEN-->
		<div class="col-12">
			<br>
			<div id="notif_kondisi"></div>
			<?= $this->session->flashdata('alert_kondisi'); ?>
			<br>
			<h1 class="text-center">Kondisi Pasien</h1>
			<a class="btn btn-primary float-right" href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalTambahKondisi" title="tambahkan kondisi pasien (rekam medis)" data-iduser="<?=$user[0]->id_user?>">Tambahkan kondisi pasien</a>
			<br>
			<br>
			<table id="kondisi_pasien" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
				<thead class="thead-dark">
					<tr>
					<th>Kondisi</th>
					<th>Tanggal ditambahkan</th>
					<th>Status</th>
					<th width="10px;"></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<!-- END DATATABLE KONDISI PASIEN-->

		<!-- MODAL ADD KONDISI PASIEN-->
		<div class="modal fade" id="ModalTambahKondisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<form id="formtambahkondisi" method="POST">      
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Form tambah kondisi pasien : <?=$user[0]->nama_user?> </h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
							<input type="hidden" name="id_user" id="idUser">
							<div class="modal-body">
								<div class="form-group">
									<label>Kondisi</label>
									<select class="form-control" name="id_master_kondisi" onChange="assignDetailKondisi()" id="selectedidkondisi">
										<option selected="" disabled="">Pilih Kondisi</option>
									</select>
								</div>
								<input type="hidden" name="detail_kondisi" id="detailKondisi">
								<div class="form-group">
									<label>Tanggal</label>
									<input type="date" class="form-control" title="tanggal sekarang" name="tanggal" value="<?= date('Y-m-d')?>" readonly="" id="tanggal">
								</div>
								<div class="form-group">
									<label>Status</label>
									<select class="form-control" name="status" id="status">
										<option selected disabled>Pilih Status</option>
										<option value="1">Aman</option>
										<option value="0">Mengidap</option>
									</select>
								</div>
							</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
							<a class="btn btn-primary" id="btn-tambah-kondisi" >Ya!</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END MODAL ADD KONDISI PASIEN -->
		
		<!-- JAVASCRIPT UNTUK SELECT KONDISI. MEMANFAATKAN DATA BIAR NGGK MUBADZIR -->
		<script type="text/javascript">
				// convert array to json biar mudah assignnya dari id_kondisi ke detail kondisi
				var json_select = <?=json_encode($master_kondisi)?>;
				$('#selectedidkondisi').select2({
					dropdownParent	:	$('#ModalTambahKondisi'),
					data 			:	json_select,
					width			:	'100%',
					placeholder		:	'Pilih Kondisi'
				});

				var convert_json_select = new Array();
				for (var i = 0; i < json_select.length; i++) {
					convert_json_select[json_select[i]['id']]	=	json_select[i]['text'];
				}
		</script>
		<!-- END JAVASCRIPT UNTUK SELECT KONDISI. MEMANFAATKAN DATA BIAR NGGK MUBADZIR -->


		<!-- JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->
		<script type="text/javascript">
			$('#ModalTambahKondisi').on('show.bs.modal', function(e) {
				$("#idUser").attr('value', $(e.relatedTarget).data('iduser'));
			});
			$('#ModalTambahKondisi').on('hidden.bs.modal', function (e) {
				$("#selectedidkondisi").val('').trigger('change');

			});
		</script>
		<!-- END JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->

		<!-- JAVASKRIP UNTUK ASSIGN HIDDEN VALUE DETAIL KONDISI SETELAH MEMILIH KONDISI YANG PADA DASARNYA MEMILIH ID KONDISI, BUKAN DETAIL_KONDISI -->
		<script type="text/javascript">
			// var untuk simpan getelemen id
			var getidkondisi;
			var assigndetailkondisi;

			// function onChane pada select kondisi
			function assignDetailKondisi() {
				getidkondisi 				=	$("#selectedidkondisi").select2("val");
				assigndetailkondisi 		= 	document.getElementById('detailKondisi');
				assigndetailkondisi.value 	= 	window.convert_json_select[getidkondisi];
			}

			// var untuk simpan getelemen id
			var getidkondisiE;
			var assigndetailkondisiE;

			// function onChane pada select kondisi
			function assignDetailKondisiE() {
				getidkondisiE 				=	$("#selectedidkondisiE").select2("val");
				assigndetailkondisiE 		= 	document.getElementById('detailKondisiE');
				assigndetailkondisiE.value 	= 	window.convert_json_select[getidkondisiE];
			}
		</script>
		<!-- END JAVASKRIP UNTUK ASSIGN HIDDEN VALUE DETAIL KONDISI SETELAH MEMILIH KONDISI YANG PADA DASARNYA MEMILIH ID KONDISI, BUKAN DETAIL_KONDISI -->

		<!-- AJAX HANDLE ADD KONDISI PASIEN -->
		<script type="text/javascript">
			$("#btn-tambah-kondisi" ).click(function() {
				$('#btn-tambah-kondisi').text('Processing...'); //change button text
				$('#btn-tambah-kondisi').attr('disabled',true); //set button disable 
				
				var	url = "<?= base_url('Ppk_C/handle_add_kondisi/'.$user[0]->id_user)?>";
				var formData = new FormData($('#formtambahkondisi')[0]);
				// console.log(formData);
				$.ajax({
					url : url,
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success: function(data)
					{
						// buat notif sukses
						$("#notif_kondisi").html(data);

						// reset value form yang telah diset, agar tidak nyangkut di refresh dan klik modal baru
						$("#selectedidkondisi").select2("val","");
						$("#selectedidkondisi").select2("val", "");
						$('#selectedidkondisi').val('').trigger('change'); //set button enable 
						
						// kembalikan elemen html modal ke default
						$('#btn-tambah-kondisi').text('Ya!'); //change button text
						$('#btn-tambah-kondisi').attr('disabled',false); //set button enable 
						$('#ModalTambahKondisi').modal('hide');
						show_kondisi();
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						console.log(jqXHR, textStatus, errorThrown);
						$('#btn-tambah-kondisi').text('Eror'); //change button text
						$('#btn-tambah-kondisi').attr('disabled',false); //set button enable 
					}
				});
			});
		</script>
		<!-- END AJAX HANDLE ADD KONDISI PASIEN -->

		<!-- MODAL HAPUS KONDISI PASIEN-->
		<div class="modal fade" id="ModalDeleteKondisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<form id="formdeletekondisi" method="POST">      
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Dibutuhkan aksi</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
							<input type="hidden" name="id_kondisi" id="idKondisi">
							<div class="modal-body">
								Yakin ingin menghapus kondisi ini?
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
								<a class="btn btn-primary" id="btn-hapus-kondisi" >Ya!</a>
							</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END MODAL HAPUS KONDISI PASIEN -->

		<!-- JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL HAPUS KONDISI PASIEN -->
		<script type="text/javascript">
			$('#ModalDeleteKondisi').on('show.bs.modal', function(e) {
				$("#idKondisi").attr('value', $(e.relatedTarget).data('idkondisik'));
			});
		</script>
		<!-- END JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL HAPUS KONDISI PASIEN -->

		<!-- HANDLING HAPUS KONDISI PASIEN-->
		<script type="text/javascript">	
			$("#btn-hapus-kondisi" ).click(function() {
				$('#btn-hapus-kondisi').text('Processing...'); //change button text
				$('#btn-hapus-kondisi').attr('disabled',true); //set button disable 
				
				var	url = "<?= base_url('Ppk_C/handle_delete_kondisi/')?>";
				var formData = new FormData($('#formdeletekondisi')[0]);
				// console.log(formData);
				$.ajax({
					url : url,
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success: function(data)
					{
						// buat notif sukses
						$("#notif_kondisi").html(data);

						// reset value form yang telah diset, agar tidak nyangkut di refresh
						document.getElementById('formdeletekondisi').reset();
						
						// kembalikan elemen html modal ke default
						$('#btn-hapus-kondisi').text('Ya!'); //change button text
						$('#btn-hapus-kondisi').attr('disabled',false); //set button enable 
						$('#ModalDeleteKondisi').modal('hide');
						show_kondisi();
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						console.log(jqXHR, textStatus, errorThrown);
						$('#btn-hapus-kondisi').text('Eror'); //change button text
						$('#btn-hapus-kondisi').attr('disabled',false); //set button enable 
					}
				});
			});
		</script>
		<!-- END HANDLING HAPUS KONDISI PASIEN-->

		<!-- MODAL UNTUK UPDATE KONDISI SEORANG PASIEN -->
		<div class="modal fade" id="ModalEditKondisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<form id="formeditkondisi" method="POST">      
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Form edit kondisi pasien : <?=$user[0]->nama_user?> </h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
							<input type="hidden" name="id_user" value="<?=$user[0]->id_user?>">
							<input type="hidden" name="id_kondisi" id="idKondisiE">
							<input type="hidden" name="id_master_kondisi" id="idMasterKondisiE">
							<div class="modal-body">
								<div class="form-group">
									<label>Kondisi</label>
									<input type="text" class="form-control" name="detail_kondisi" id="detailKondisiE" readonly>
								</div>
								<div class="form-group">
									<label>Tanggal</label>
									<input type="date" class="form-control" title="tanggal sekarang" name="tanggal" id="tanggalE" readonly>
								</div>
								<div class="form-group">
									<label>Status</label>
									<select class="form-control" name="status" id="statusE">
										<option value="1">Aman</option>
										<option value="0">Hindari</option>
									</select>
								</div>
							</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
							<a class="btn btn-primary" id="btn-edit-kondisi" >Ya!</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END MODAL UNTUK UPDATE KONDISI SEORANG PASIEN -->

		<!-- JAVASCRIPT UNTUK SELECT KONDISI. MEMANFAATKAN DATA BIAR NGGK MUBADZIR -->
		<script type="text/javascript">
			$(document).ready(function() {
				// convert array to json biar mudah assignnya dari id_kondisi  ke detail kondisi
				$('#selectedidkondisiE').select2({
					data 	: 	json_select,
					width	: 	'100%'
				});
			});

			var convert_json_select = new Array();
			for (var i = 0; i < json_select.length; i++) {
				convert_json_select[json_select[i]['id']]	=	json_select[i]['text'];
			}
		</script>
		<!-- END JAVASCRIPT UNTUK SELECT KONDISI. MEMANFAATKAN DATA BIAR NGGK MUBADZIR -->

		<!-- JAVASCRIPT UNTUK AMBIL ELEMEN SEBAGAI ACUAN MODAL UPDATE KONDISI SEORANG PASIEN -->
		<script type="text/javascript">
			$('#ModalEditKondisi').on('show.bs.modal', function(e) {
				$("#idKondisiE").attr('value', $(e.relatedTarget).data('idkondisi'));
				$.get('<?=base_url()?>Ppk_C/get_kondisi/' + $(e.relatedTarget).data('idkondisi'),function(html){
					var responE = JSON.parse(html);
					// console.log(responE[0].id_master_kondisi);
					// $("#selectedidkondisiE").val(responE[0].id_master_kondisi).trigger('change');
					$("#idMasterKondisiE").val(responE[0].id_master_kondisi);
					$("#detailKondisiE").val(responE[0].detail_kondisi);
					$("#tanggalE").val(responE[0].tanggal_ditambahkan);
					$("#statusE").val(responE[0].status);
				});
			});
		</script>
		<!-- END JAVASCRIPT UNTUK AMBIL ELEMEN SEBAGAI ACUAN MODAL UPDATE KONDISI SEORANG PASIEN -->

		<!-- HANDLE UPDATE KONDISI -->
		<script type="text/javascript">
			$("#btn-edit-kondisi" ).click(function() {
				$('#btn-edit-kondisi').text('Processing...'); //change button text
				$('#btn-edit-kondisi').attr('disabled',true); //set button disable 
				
				var	url = "<?= base_url('Ppk_C/handle_update_kondisi/')?>";
				var formData = new FormData($('#formeditkondisi')[0]);
				// console.log(formData);
				$.ajax({
					url : url,
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success: function(data)
					{
						// buat notif sukses
						$("#notif_kondisi").html(data);

						// kembalikan elemen html modal ke default
						$('#btn-edit-kondisi').text('Ya!'); //change button text
						$('#btn-edit-kondisi').attr('disabled',false); //set button enable 
						$('#ModalEditKondisi').modal('hide');
						show_kondisi();
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						console.log(jqXHR, textStatus, errorThrown);
						$('#btn-edit-kondisi').text('Eror'); //change button text
						$('#btn-edit-kondisi').attr('disabled',false); //set button enable 
					}
				});
			});
		</script>
		<!-- END HANDLE UPDATE KONDISI -->

	</div>
</div>
<!-- END KONTEN KANAN -->


<!-- SIDE NAAV HERE -->
<nav class="col-md-2 d-none d-sm-block bg-light sidebar" id="style-1">
	<ul class="nav nav-pills flex-column">
		<li class="nav-item">
			<div>
				<img src="<?php echo base_url().$user[0]->link_foto?>" alt="foto-profil" class="img-thumbnail rounded">
			</div>
		</li>

		<li class="nav-item">
			<span class="nav-link">Nama : <i class="nav-link disabled" href="#"><?=$user[0]->nama_user?></i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Tanggal Lahir / Umur<i class="nav-link disabled" href="#"> <?=$user[0]->tanggal_lahir != '' ? $user[0]->tanggal_lahir : 'YYYY-mm-dd' ?> / <?=$umur->y?> Thn</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Nomor Identitas<i class="nav-link disabled"><?=$user[0]->nomor_identitas?></i></span>
		</li>
		<!-- <li class="nav-item">
			<span class="nav-link">Dummy<i class="nav-link disabled" href="#">iajkhdbjhagdsjdha skjdnas</i></span>
		</li> -->
	</ul>
</nav>