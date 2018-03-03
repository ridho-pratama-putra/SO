<!-- DATATABLE via JAVASCRIPT. menggunakan javascript karena hapus dan edit gejala dihandle oleh AJAX. biar live update. kalo PHP harus  refresh dulu-->
<script type="text/javascript">
	window.onload=show();
	var respon;
	function show(){
		$.get('<?php echo base_url('Admin_C/dataTable_gejala/')?>', function(html){
			respon = JSON.parse(html);
			// console.log('data in : '+window.respon.indikasi);
			// destroy dulu datatable sebelumnya yang menggunakan json. 
			$('#master-gejala').DataTable().destroy();

			// declare lagi datatable json
			$('#master-gejala').DataTable({

				// ambil data yang dikirim dari kontroler. nama dikontroler data[$master_gejala]
				data : (respon.master_gejala),

				// decalare isi format urutan kolom
				columns: [
					{ "data": "detail_gejala"},

					{ "data": "id_gejala" ,
						render: function ( data, type, full, meta ) {
							return '<div class="btn-group" role="group">'+
									'<a href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalEditGejala" title="edit gejala" data-idgejala="'+data+'" >Edit Indikasi</a>'+
									'<a href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalDeleteGejala" title="hapus gejala" data-idgejala="'+data+'" >Hapus Gejala</a>'+
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
	var jmlh_form_input = 0;
	function addInput(divName){
		jmlh_form_input++;
		// console.log(jmlh_form_input);
		var newdiv = document.createElement('div');
		newdiv.innerHTML ="<div class='margin-top-15'><input type='text' class='form-control' name='gejala[]' required></div>";
		document.getElementById(divName).appendChild(newdiv);
		document.getElementById('jmlh-form-input').innerHTML = "<strong>Total form input yang akan dimasukkan sejumlah : " +jmlh_form_input+" input<strong>";
	}
</script>
<!-- END JAVASKRIP TAMBA FORM INPUT INDIKASI -->

<!-- MODAL HAPUS INDIKASI OBAT-->
<div class="modal fade" id="ModalDeleteGejala" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formdeletegejala" method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Dibutuhkan aksi</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
					<input type="hidden" name="id_gejala" id="idGejala">
					<div class="modal-body">
						Yakin ingin menghapus gejala ini?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<a class="btn btn-primary" id="btn-hapus-gejala" >Ya!</a>
					</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL HAPUS INDIKASI OBAT -->

<!-- JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->
<script type="text/javascript">
	$('#ModalDeleteGejala').on('show.bs.modal', function(e) {
		$("#idGejala").attr('value', $(e.relatedTarget).data('idgejala'));
	});
</script>
<!-- END JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->

<!-- HANDLING FORM HAPUS INDIKASI -->
<script type="text/javascript">	
	$("#btn-hapus-gejala" ).click(function() {
		$('#btn-hapus-gejala').text('Processing...'); //change button text
		$('#btn-hapus-gejala').attr('disabled',true); //set button disable 
		
		var	url = "<?= base_url('Admin_C/handle_delete_gejala')?>";
		var formData = new FormData($('#formdeletegejala')[0]);
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
				$("#idGejala").attr('value');
				
				// kembalikan elemen html modal ke default
				$('#btn-hapus-gejala').text('Ya!'); //change button text
				$('#btn-hapus-gejala').attr('disabled',false); //set button enable 
				$('#ModalDeleteGejala').modal('hide');
				show();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#btn-hapus-gejala').text('Eror'); //change button text
				$('#btn-hapus-gejala').attr('disabled',false); //set button enable 
			}
		});
	});
</script>
<!-- END HANDLING FORM HAPUS INDIKASI -->

<!-- MODAL EDIT INDIKASI -->
<div class="modal fade" id="ModalEditGejala" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formeditgejala" method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Form Edit Gejala</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
					<input type="hidden" name="id_gejala" id="idGejalae">
					<div class="modal-body">
						<div class='form-group'>
							<label>Gejala</label>
							<input type='text' class='form-control' name='nama_gejala' id='namaGejalae'>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<a class="btn btn-primary focus" id="btn-edit-gejala" >Ya!</a>
					</div>
			</div>
		</form>
	</div>
</div>
<!-- END MODAL EDIT INDIKASI -->

<!-- AMBIL ELEMEN BUTTON EDIT INDIKASI SEBAGAI ACUAN -->
<!-- masih mubazir. data gejala sudah dikirim dalam json. tapi tidak bisa dibuat global. json dipakai oleh datatable terlebih dahulu. json nya sulit diakses -->
<script type="text/javascript">
	$('#ModalEditGejala').on('show.bs.modal', function(e) {
		$("#idGejalae").attr('value', $(e.relatedTarget).data('idgejala'));

		var url_nama_gejala = '<?php echo base_url('Admin_C/handle_nama_gejala/')?>'+$(e.relatedTarget).data('idgejala');
		$.get(url_nama_gejala, function(html){
			var respon_nama_gejala = JSON.parse(html);
			// console.log(respon_nama_gejala);
			// $("#detailTipe").attr('value', respon_detail_tipe[0].detail_tipe);
			$("#namaGejalae").val(respon_nama_gejala[0].nama_gejala);
		});
	});
</script>
<!-- END AMBIL ELEMEN BUTTON EDIT INDIKASI SEBAGAI ACUAN -->

<!-- HANDLE FORM EDIT INDIKASI DARI MODAL EDIT INDIKASI -->
<script type="text/javascript">
	$('#btn-edit-gejala').click(function() {
		// $('#btn-edit-gejala').text('Processing...');
		// $('#btn-edit-gejala').attr('disabled',true);
		var url;

		url = "<?=base_url('Admin_C/handle_edit_gejala/')?>";
		var formData = new FormData($('#formeditgejala')[0]);
		// console.log(formData);
		$.ajax({
			url : url,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data)
			{
				
				$("#idGejalae").attr('value');
				$("#nama_gejala").val();
				$("#notif").html(data);
				$('#btn-edit-gejala').text('Ya!');
				$('#btn-edit-gejala').attr('disabled',false);
				$('#ModalEditGejala').modal('hide');
				show();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#btn-edit-gejala').text('eror');
				$('#btn-edit-gejala').attr('disabled',false);
			}
		});
	});
</script>
<!-- END HANDLE FORM EDIT INDIKASI DARI MODAL EDIT INDIKASI -->

<!-- CONTENT HTML -->
<main>
	<div style="border-radius: 5px; padding-bottom: 15px; background-color: #edefea;padding-top: 20px; ">
		<h3 class="text-center"> FORM ADD Gejala</h3>
		<div class="col">
			<form action="<?php echo base_url()?>Admin_C/handle_create_gejala" method="POST" role="form">
				<div class="margin-top-15 form-group">
					<div class="col">
						<div id="dynamicInputGejala">
							<div class="row">
								<!-- <div class="margin-top-15 col">
									<input type="text" class="form-control" id="indikasi" name="indikasi[]">
								</div> -->
							</div>
						</div>
					</div>
					<div class="col margin-top-15">
						<div id="jmlh-form-input"></div>
						<button type="button" class="btn btn-primary btn-block" onClick="addInput('dynamicInputGejala');"> <i class="icons ion-ios-plus-empty"></i> Add Input</button>
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
		<?=$this->session->flashdata("alert_CRUD_gejala");?>
	</div>
	<div class="container margin-top-15">
		<br>
		<!--  -->
		<br>
		<h3 class="text-center">DAFTAR GEJALA YANG ADA DI DB</h3>
		<table id="master-gejala" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
				<th >Gejala</th>
				<th width="50px;" class="text-center"></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</main>
<!-- CONTENT HTML