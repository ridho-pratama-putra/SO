<!-- DATATABLE via JAVASCRIPT. menggunakan javascript karena hapus dan edit karakteristik dihandle oleh AJAX. biar live update. kalo PHP harus  refresh dulu -->
<script type="text/javascript">
	window.onload=show();
	
	var respon;
	
	function show(){
		$.get('<?php echo base_url('Admin_C/dataTable/indikasi/'.$master_obat[0]->id_obat)?>', function(html){
			respon = JSON.parse(html);	
			// destroy dulu datatable sebelumnya yang menggunakan json. 
			$('#indikasi').DataTable().destroy();

			// declare lagi datatable json
			$('#indikasi').DataTable({

				// ambil data yang dikirim dari kontroler. nama dikontroler data[$karakteristik]
				data : (respon.indikasi),

				// decalare isi format urutan kolom
				columns: [
					{ "data": "detail_tipe"},
					{ "data": "id_karakteristik" ,
						render: function ( data, type, full, meta ) {
							return	'<div class="btn-group" role="group">'+
								'<a href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalEditIndikasi" title="edit indikasi" data-idkarakteristik="'+data+'" data-detailtipe="'+full.detail_tipe+'" data-tipe="indikasi" data-idobat="<?=$master_obat[0]->id_obat ?>"">Edit Indikasi</a>'+

								'<a href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalDeleteIndikasi" title="hapus indikasi" data-idkarakteristik="'+data+'" >Hapus Indikasi</a>'+
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

<!-- JAVASKRIP TAMBAH FORM INPUT INDIKASI -->
<script type="text/javascript">
	// var jmlh_form_input = 0;
	// function addInput(divName){
	// 	jmlh_form_input++;
	// 	var newdiv = document.createElement('div');
	// 	newdiv.innerHTML ="<div class='margin-top-15'><input type='text' class='form-control' name='indikasi[]' required></div>";
	// 	document.getElementById(divName).appendChild(newdiv);
	// 	document.getElementById('jmlh-form-input').innerHTML = "<strong>Total form input yang akan dimasukkan sejumlah : " +jmlh_form_input+" input<strong>";
	// }
</script>
<!-- END JAVASKRIP TAMBA FORM INPUT INDIKASI -->

<!-- MODAL HAPUS INDIKASI OBAT-->
<div class="modal fade" id="ModalDeleteIndikasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formdeleteindikasi" method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Dibutuhkan aksi</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
					<input type="hidden" name="id_karakteristik" id="idKarakteristik">
					<div class="modal-body">
						Yakin ingin menghapus rule indikasi ini?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<a class="btn btn-primary" id="btn-hapus-indikasi" >Ya!</a>
					</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL HAPUS INDIKASI OBAT -->

<!-- JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->
<script type="text/javascript">
	$('#ModalDeleteIndikasi').on('show.bs.modal', function(e) {
		$("#idKarakteristik").attr('value', $(e.relatedTarget).data('idkarakteristik'));
	});
	$('#ModalDeleteIndikasi').on('hide.bs.modal', function(e) {
		$("#idKarakteristik").removeAttr('value');
	});
</script>
<!-- END JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->

<!-- HANDLING FORM HAPUS INDIKASI -->
<script type="text/javascript">	
	$("#btn-hapus-indikasi" ).click(function() {
		$('#btn-hapus-indikasi').text('Processing...'); //change button text
		$('#btn-hapus-indikasi').attr('disabled',true); //set button disable 
		
		var	url = "<?= base_url('Admin_C/handle_delete_karakteristik')?>";
		var formData = new FormData($('#formdeleteindikasi')[0]);
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
				$("#notif").html(data);

				// reset value form yang telah diset, agar tidak nyangkut di refresh
				$("#idKarakteristik").attr('value');
				
				// kembalikan elemen html modal ke default
				$('#btn-hapus-indikasi').text('Ya!'); //change button text
				$('#btn-hapus-indikasi').attr('disabled',false); //set button enable 
				$('#ModalDeleteIndikasi').modal('hide');
				show();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#btn-hapus-indikasi').text('Eror'); //change button text
				$('#btn-hapus-indikasi').attr('disabled',false); //set button enable 
			}
		});
	});
</script>
<!-- END HANDLING FORM HAPUS INDIKASI -->

<!-- MODAL EDIT INDIKASI -->
<div class="modal fade" id="ModalEditIndikasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formeditindikasi" method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Form Edit Indikasi</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
					<input type="hidden" name="id_karakteristik" id="idKarakteristike">
					<input type="hidden" name="tipe" id="tipee">
					<input type="hidden" name="id_obat" id="idObat">
					<div class="modal-body">
						<div class='form-group'>
							<label>Indikasi</label>
							<input type='text' class='form-control' name='detail_tipe' id='detailTipe'>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<a class="btn btn-primary focus" id="btn-edit-indikasi" >Ya!</a>
					</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL EDIT INDIKASI -->

<!-- AMBIL ELEMEN BUTTON EDIT INDIKASI SEBAGAI ACUAN -->
<script type="text/javascript">
	$('#ModalEditIndikasi').on('show.bs.modal', function(e) {
		$("#idKarakteristike").attr('value', $(e.relatedTarget).data('idkarakteristik'));
		$("#detailTipe").attr('value', $(e.relatedTarget).data('detailtipe'));
		$("#tipee").attr('value', $(e.relatedTarget).data('tipe'));
		$("#idObat").attr('value', $(e.relatedTarget).data('idobat'));
	});
	$('#ModalEditIndikasi').on('hide.bs.modal', function(e) {
		$("#idKarakteristike").removeAttr('value');
		$("#detailTipe").removeAttr('value');
		$("#tipee").removeAttr('value');
		$("#idObat").removeAttr('value');
	});
</script>
<!-- END AMBIL ELEMEN BUTTON EDIT INDIKASI SEBAGAI ACUAN -->

<!-- HANDLE FORM EDIT INDIKASI DARI MODAL EDIT INDIKASI -->
<script type="text/javascript">
	$('#btn-edit-indikasi').click(function() {
		// $('#btn-edit-indikasi').text('Processing...');
		// $('#btn-edit-indikasi').attr('disabled',true);
		var url;

		url = "<?=base_url('Admin_C/handle_edit_karakteristik/')?>";
		var formData = new FormData($('#formeditindikasi')[0]);
		// console.log(formData);
		$.ajax({
			url : url,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data)
			{
				
				$("#idKarakteristike").attr('value');
				$("#detailTipe").val();
				$("#notif").html(data);
				$('#btn-edit-indikasi').text('Ya!');
				$('#btn-edit-indikasi').attr('disabled',false);
				$('#ModalEditIndikasi').modal('hide');
				show();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#btn-edit-indikasi').text('eror');
				$('#btn-edit-indikasi').attr('disabled',false);
			}
		});
	});
</script>
<!-- END HANDLE FORM EDIT INDIKASI DARI MODAL EDIT INDIKASI -->


<!-- inisialisasi autocomplete -->
<script type="text/javascript">
	$.get('<?php echo base_url('Admin_C/autocomplete/master_gejala/detail_gejala')?>', function(html){
		respon = JSON.parse(html);
		data = new Array();
		for (var i in respon.master_data) {
			data.push(respon.master_data[i].detail_gejala);
		}

		$('#karakteristik_indikasi').autocomplete({
			lookup: data,
		});
	});
</script>
<!-- END inisialisasi autocomplete -->

<!-- CONTENT HTML -->
<main>
	<div style="border-radius: 5px; padding-bottom: 15px; background-color: #edefea;padding-top: 20px; ">
		<h3 class="text-center"> FORM add indikasi Obat : <?=$master_obat[0]->nama_obat?></h3>
		<div class="col">
			<form action="<?php echo base_url()?>Admin_C/handle_create_karakteristik/indikasi" method="POST" role="form">
				<div class="margin-top-15 form-group">
					<div class="col">
						<div id="dynamicInputIndikasi">
							<input type="hidden" name="id_obat" value="<?=$master_obat[0]->id_obat?>">
							<div class="row">
								<div class="margin-top-15 col">
									<input type="text" class="form-control" id="karakteristik_indikasi" name="indikasi" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col margin-top-15">
						<!-- <div id="jmlh-form-input"></div> -->
						<!-- <button type="button" class="btn btn-primary btn-block" onClick="addInput('dynamicInputIndikasi');"> <i class="icons ion-ios-plus-empty"></i> Add Input</button> -->
					</div>
				</div>	
				<div class="col margin-top-15">
					<button type="submit" class="btn btn-primary btn-block bg-dark" > <i class="icons ion-android-send"></i> Masukkan ke database</button>
				</div>
			</form>
		</div>
	</div>
	<hr>
	<div class="container" id="notif"><!-- id="notif digunakan untuk memuat alert sukses/ gagal dari aksi ajax" -->
		<?=$this->session->flashdata("alert_indikasi_obat");?>
		<?=$this->session->flashdata("alert_tipe_master");?>
		<?=$this->session->flashdata("alert_gejala");?>
	</div>
	<div class="container margin-top-15">
		<br>
		<!--  -->
		<br>
		<h3 class="text-center">Rule indikasi untuk obat <?=$master_obat[0]->nama_obat?></h3>
		<table id="indikasi" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
				<th width="75%">Indikasi</th>
				<th width="25%;" class="text-center">CRUD</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</main>
<!-- CONTENT HTML