<!-- DATATABLE via JAVASCRIPT. menggunakan javascript karena hapus dan edit gejala dihandle oleh AJAX. biar live update. kalo PHP harus  refresh dulu-->
<script type="text/javascript">
	window.onload=show();
	var respon;
	function show(){
		$.get('<?php echo base_url('Admin_C/dataTable_/master_kondisi/')?>', function(html){
			respon = JSON.parse(html);
			$('#master_kondisi').DataTable().destroy();
			$('#master_kondisi').DataTable({
				data : (respon.master_data),
				columns: [
					{ "data": "detail_kondisi"},
					{ "data": "id_master_kondisi" ,
						render: function ( data, type, full, meta ) {
							return '<div class="btn-group" role="group">'+
									'<a href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalDeleteKondisi" title="hapus gejala" data-idkondisi="'+data+'" data-detailkondisi="'+full.detail_kondisi+'">Hapus Kondisi</a>'+
								'</div>';
						}
					}
				],
				"columnDefs": [{"targets": [1],"orderable": false}]
				});
		});
	}
</script>
<!-- END DATATABLE AJAX -->

<!-- MODAL HAPUS DATA KONDISI-->
<div class="modal fade" id="ModalDeleteKondisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formdeletekondisi" method="POST">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Dibutuhkan aksi</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
					<input type="hidden" name="id_master_kondisi" id="idMasterKondisi">
					<input type="hidden" name="detail_kondisi" id="detailKondisi">
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
<!-- END MODAL HAPUS DATA KONDISI -->

<!-- JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->
<script type="text/javascript">
	$('#ModalDeleteKondisi').on('show.bs.modal', function(e) {
		$("#idMasterKondisi").attr('value', $(e.relatedTarget).data('idkondisi'));
		$("#detailKondisi").attr('value', $(e.relatedTarget).data('detailkondisi'));
	});
	$('#ModalDeleteKondisi').on('hide.bs.modal', function(e) {
		$("#idMasterKondisi").removeAttr('value');
		$("#detailKondisi").removeAttr('value');
	});
</script>
<!-- END JAVASKRIP UNTUK AMBIL ELEMEN a SEBAGAI ACUAN MODAL -->

<!-- HANDLING FORM HAPUS INDIKASI -->
<script type="text/javascript">	
	$("#btn-hapus-kondisi" ).click(function() {
		$('#btn-hapus-kondisi').text('Processing...');
		$('#btn-hapus-kondisi').attr('disabled',true);
		
		var	url = "<?= base_url('Admin_C/handle_delete_kondisi')?>";
		var formData = new FormData($('#formdeletekondisi')[0]);
		$.ajax({
			url : url,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data)
			{
				$("#notif").html(data);
				$('#btn-hapus-kondisi').text('Ya!');
				$('#btn-hapus-kondisi').attr('disabled',false);
				$('#ModalDeleteKondisi').modal('hide');
				show();
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
<!-- END HANDLING FORM HAPUS INDIKASI -->

<main>
	<div class="container margin-top-15" id="notif"><!-- id="notif digunakan untuk memuat alert sukses/ gagal dari aksi ajax" -->
		<?=$this->session->flashdata("alert_CRUD_kondisi");?>
	</div>
	<div class="container margin-top-15">
		<br>
		<br>
		<h3 class="text-center">DAFTAR KONDISI (REKAM MEDIS CUSTOM) YANG ADA DI DB</h3>
		<h6 class="text-center text-danger"> Data rekam medis yang ditampilkan pada halaman ini adalah data krusial. Data ini ditambahkan via penambahan kontraindikasi maupun peringatan pada suatu obat. Melakukan pengeditan terlebih menghapus data kondisi akan mengakibatkan tidak dapat ditemukannya suatu kecocokan antara kontraindikasi maupun peringatan suatu obat dengan seorang pasien</h6><br>
		<table id="master_kondisi" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
				<th width="95%;" class="text-center">Detail Kondisi</th>
				<th width="5%" class="text-center">ACTION</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</main>