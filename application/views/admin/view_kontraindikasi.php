<!-- DATATABLE via JAVASCRIPT. menggunakan javascript karena hapus dan edit karakteristik dihandle oleh AJAX. biar live update. kalo PHP harus  refresh dulu-->
<script type="text/javascript">
	window.onload=show();
	var respon;
	function show(){
		$.get('<?php echo base_url('Admin_C/dataTable/kontraindikasi/'.$master_obat[0]->id_obat)?>', function(html){
			window.respon = JSON.parse(html);
			// destroy dulu datatable sebelumnya yang menggunakan json. 
			$('#kontraindikasi').DataTable().destroy();

			// declare lagi datatable json
			$('#kontraindikasi').DataTable({

				// ambil data yang dikirim dari kontroler. nama dikontroler data[$karakteristik]
				data : (respon.kontraindikasi),

				// decalare isi format urutan kolom
				columns: [
					{ "data": "detail_tipe"},
					{ "data": "id_karakteristik" ,
						render: function ( data, type, full, meta ) {
							return '<div class="btn-group" role="group">'+
								'<a href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalEditKontraindikasi" title="edit kontraindikasi" data-idkarakteristik="'+data+'" data-detailtipe="'+full.detail_tipe+'" data-tipe="kontraindikasi" data-idobat="<?=$master_obat[0]->id_obat?>">Edit kontraindikasi</a>'+
								'<a href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalDeleteKontraindikasi" title="hapus kontraindikasi" data-idkarakteristik="'+data+'" >Hapus kontraindikasi</a>'+
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

<!-- JAVASKRIP TAMBAH ELEMEN INPUT PADA FORM -->
<script type="text/javascript">
	var jmlh_form_input = 0;
	function addInput(divName){
		jmlh_form_input++;
		var newdiv = document.createElement('div');
		newdiv.innerHTML ="<div class='margin-top-15'><input type='text' class='form-control' name='kontraindikasi[]' required></div>";
		document.getElementById(divName).appendChild(newdiv);
		document.getElementById('jmlh-form-input').innerHTML = "<strong>Total form input yang akan dimasukkan sejumlah : " +jmlh_form_input+" input<strong>";
	}
</script>
<!-- END JAVASKRIP TAMBAH ELEMEN INPUT PADA FORM -->

<!-- MODAL HAPUS KONTRAINDIKASI -->
<div class="modal fade" id="ModalDeleteKontraindikasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formdeletekontraindikasi" method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Dibutuhkan aksi</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
					<input type="hidden" name="id_karakteristik" id="idKarakteristik">
					<div class="modal-body">
						Yakin ingin menghapus rule kontraindikasi ini?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<a class="btn btn-primary" id="btn-hapus-kontraindikasi" >Ya!</a>
					</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL HAPUS KONTRAINDIKASI -->

<!-- JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->
<script type="text/javascript">
	$('#ModalDeleteKontraindikasi').on('show.bs.modal', function(e) {
		$("#idKarakteristik").attr('value', $(e.relatedTarget).data('idkarakteristik'));
	});
	$('#ModalDeleteKontraindikasi').on('hide.bs.modal', function(e) {
		$("#idKarakteristik").removeAttr('value');
	});
</script>
<!-- END JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->

<!-- HANDLING FORM HAPUS KONTRAINDIKASI -->
<script type="text/javascript">
	$("#btn-hapus-kontraindikasi" ).click(function() {
		$('#btn-hapus-kontraindikasi').text('Processing...'); //change button text
		$('#btn-hapus-kontraindikasi').attr('disabled',true); //set button disable 
		
		var	url = "<?= base_url('Admin_C/handle_delete_karakteristik')?>";
		var formData = new FormData($('#formdeletekontraindikasi')[0]);
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
				$('#btn-hapus-kontraindikasi').text('Ya!'); //change button text
				$('#btn-hapus-kontraindikasi').attr('disabled',false); //set button enable 
				$('#ModalDeleteKontraindikasi').modal('hide');
				show();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#btn-hapus-kontraindikasi').text('Eror'); //change button text
				$('#btn-hapus-kontraindikasi').attr('disabled',false); //set button enable 
			}
		});
	});
</script>
<!-- END HANDLING FORM HAPUS KONTRAINDIKASI -->

<!-- MODAL EDIT KONTRAINDIKASI -->
<div class="modal fade" id="ModalEditKontraindikasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formeditkontraindikasi" method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Form Edit Kontraindikasi</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
					<input type="hidden" name="id_karakteristik" id="idKarakteristike">
					<input type="hidden" name="tipe" id="tipee">
					<input type="hidden" name="id_obat" id="idObat">
					<div class="modal-body">
						<div class='form-group'>
							<label>Kontraindikasi</label>
							<input type='text' class='form-control' name='detail_tipe' id='detailTipek'>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<a class="btn btn-primary focus" id="btn-edit-kontraindikasi" >Ya!</a>
					</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL EDIT KONTRAINDIKASI -->

<!-- AMBIL ELEMEN BUTTON EDIT KONTRAINDIKASI SEBAGAI ACUAN -->
<script type="text/javascript">
	$('#ModalEditKontraindikasi').on('show.bs.modal', function(e) {
		$("#idKarakteristike").attr('value', $(e.relatedTarget).data('idkarakteristik'));
		$("#detailTipek").attr('value', $(e.relatedTarget).data('detailtipe'));
		$("#tipee").attr('value', $(e.relatedTarget).data('tipe'));
		$("#idObat").attr('value', $(e.relatedTarget).data('idobat'));
	});
	$('#ModalEditKontraindikasi').on('hidden.bs.modal', function(e) {
		$("#idKarakteristike").removeAttr('value');
		$("#detailTipek").removeAttr('value');
		$("#tipee").removeAttr('value');
		$("#idObat").removeAttr('value');
	});

</script>
<!-- END AMBIL ELEMEN BUTTON EDIT KONTRAINDIKASI SEBAGAI ACUAN -->

<!-- HANDLE FORM EDIT INDIKASI DARI MODAL EDIT INDIKASI -->
<script type="text/javascript">
	$('#btn-edit-kontraindikasi').click(function() {
		// $('#btn-edit-indikasi').text('Processing...');
		// $('#btn-edit-indikasi').attr('disabled',true);
		var url;

		url = "<?=base_url('Admin_C/handle_edit_karakteristik/')?>";
		var formData = new FormData($('#formeditkontraindikasi')[0]);
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
				$('#btn-edit-kontraindikasi').text('Ya!');
				$('#btn-edit-kontraindikasi').attr('disabled',false);
				$('#ModalEditKontraindikasi').modal('hide');
				show();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#btn-edit-kontraindikasi').text('eror');
				$('#btn-edit-kontraindikasi').attr('disabled',false);
			}
		});
	});
</script>
<!-- END HANDLE FORM EDIT INDIKASI DARI MODAL EDIT INDIKASI -->

<!-- CONTENT HTML FORM -->
<main>
	<div style="border-radius: 5px; padding-bottom: 15px; background-color: #edefea;padding-top: 20px; ">
		<h3 class="text-center"> FORM add kontraindikasi Obat : <?=$master_obat[0]->nama_obat?> </h3>
		<div class="col">
			<form action="<?php echo base_url()?>Admin_C/handle_create_karakteristik/kontraindikasi" method="POST" role="form">
				<div class="margin-top-15 form-group">
					<div class="col">
						<div id="dynamicInputkontraIndikasi">
							<input type="hidden" name="id_obat" value="<?=$master_obat[0]->id_obat?>" >
							<div class="row">
								<!-- <div class="margin-top-15 col">
									<input type="text" class="form-control" id="kontraindikasi" name="kontraindikasi[]">
								</div> -->
							</div>
						</div>
					</div>
					<div class="col margin-top-15">
						<div id="jmlh-form-input"></div>
						<button type="button" class="btn btn-primary btn-block" onClick="addInput('dynamicInputkontraIndikasi');"> <i class="icons ion-ios-plus-empty"></i> Add Input</button>
					</div>
				</div>	
				<div class="col margin-top-15">
					<button type="submit" class="btn btn-primary btn-block bg-dark" > <i class="icons ion-android-send"></i> Masukkan ke database</button>
				</div>
			</form>
		</div>
	</div>
	<hr>

	<div class="container" id="notif">
		<?=$this->session->flashdata("alert_kontraindikasi_obat");?>
		<?=$this->session->flashdata("alert_kondisi");?>
	</div>
	<div class="container margin-top-15">
		<br>
		<!--  -->
		<br>
		<h3 class="text-center">Rule kontraindikasi untuk obat <?=$master_obat[0]->nama_obat?></h3>
		<table id="kontraindikasi" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
				<th width="75%">kontraIndikasi</th>
				<th width="25%;" class="text-center">CRUD</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		
	</div>
</main>
<!-- END CONTENT HTML FORM -->