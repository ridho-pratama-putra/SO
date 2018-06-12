<script type="text/javascript">
	$(document).ready(function() {
		$('#read_obat').DataTable({
			"columnDefs": [{
				"targets": [1],
				"orderable": false
			}],
			"paging": false
		});
	});
</script>
<main>
<div class="container-fluid margin-top-15  padding-bottom-15">
	<div class="col">
		<?=$this->session->flashdata("alert_create_obat");?>
		<?=$this->session->flashdata("alert_delete_obat");?>
		<?=$this->session->flashdata("alert_rename_obat");?>
		<h3>Daftar Pengetahuan Obat</h3>
		<a class="btn btn-primary" href="<?=base_url()?>Admin_C/view_create_obat">Tambah Pengetahuan Obat</a>
	</div>
	<div class="col row margin-top-15">
		<table id="read_obat" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
				<th width="44%">Nama Obat</th>
				<th class="text-center">CRUD</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($result as $key => $value) {?>
					<tr>
						<td><?=$value->nama_obat?></td>
						<td class="text-center">
							<div class="btn btn-group btn-xs" role="group" >
								<a href="<?=base_url()?>Admin_C/view_karakteristik/indikasi/<?=$value->id_obat?>" class="btn btn-secondary bg-dark" target="_blank">Indikasi</a>
								<a href="<?=base_url()?>Admin_C/view_karakteristik/kontraindikasi/<?=$value->id_obat?>" class="btn btn-secondary bg-dark" target="_blank">Kontraindikasi</a>
								<a href="<?=base_url()?>Admin_C/view_karakteristik/peringatan/<?=$value->id_obat?>" class="btn btn-secondary bg-dark" target="_blank">Peringatan</a>
								<a href="<?=base_url()?>Admin_C/view_catatan/<?=$value->id_obat?>" class="btn btn-secondary bg-dark" target="_blank">Catatan Obat</a>
							</div>
							<div class="btn btn-group btn-xs" role="group">
								<a href="<?=base_url()?>Admin_C/view_rename_obat/<?=$value->id_obat?>" class="btn btn-secondary bg-dark" target="_blank">Rename Obat</a>
								<a href="<?php echo base_url()?>Admin_C/handle_delete_obat/<?=$value->id_obat?>" class="btn btn-secondary bg-dark" >Hapus</a>
							</div>
						</td>
					</tr>
				<?php		}		?>
			</tbody>
		</table>
	</div>
</div>
</main>


<!-- MODAL UNTUK DELETE OBAT -->
<!-- <div class="modal fade" id="deleteobatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="formdeleteobat">      
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Delete obat</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
					<input type="hidden" name="id_obat" id="idDeleteobat">
				<div class="modal-body ">
					Hapus obat?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batalkan</button>
					<button class="btn btn-primary" id="btn-delete-obat">OKE!</button>
				</div>
			</div>
		</form>
	</div>
</div>

	<script type="text/javascript">
	$('#deleteobatModal').on('show.bs.modal', function(e) {
		$("#idDeleteobat").attr('value', $(e.relatedTarget).data('idhapus'));
	});
	</script>


	<script type="text/javascript">
		$("#btn-delete-obat" ).click(function() {
		$('#btn-delete-obat').text('Menghapus...');
		$('#btn-delete-obat').attr('disabled',true);
		var url;

		url = "<?php echo base_url('Admin_C/handle_delete_obat/')?>";
		var formData = new FormData($('#formdeleteobat')[0]);
		$.ajax({
			url : url,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data)
			{
				// var response = JSON.parse(data);
				// $.each(response , function(index,item){
				//  console.log(item.tanggal);
				// });
				$("#notif").html(data);
				// console.log(response);
				$('#btn-delete-obat').text('Menghapus'); //change button text
				$('#btn-delete-obat').attr('disabled',false); //set button enable 
				$('#deleteobatModal').modal('hide');
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR, textStatus, errorThrown);
				$('#btn-delete-obat').text('eror'); //change button text
				$('#btn-delete-obat').attr('disabled',false); //set button enable 
			}
		});
	});
	</script>
END UNTUK MODAL DELETE OBAT -->