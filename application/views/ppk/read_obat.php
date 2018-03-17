<script type="text/javascript">
	$(document).ready(function() {
		$('#read_obat').DataTable({
			"columnDefs": [{
			"targets": [1],
			"orderable": false
		}]
		});
	});
</script>
<main>
<div class="container-fluid margin-top-15  padding-bottom-15">
	<div class="col">
		<?=$this->session->flashdata("alert_create_obat");?>
		<?=$this->session->flashdata("alert_delete_obat");?>
		<?=$this->session->flashdata("alert_rename_obat");?>
		<h3>Daftar KB Obat</h3>
	</div>
	<div class="col row margin-top-15">
		<table id="read_obat" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
				<th >Nama Obat</th>
				<th width="100px" class="text-center"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($result as $key => $value) {?>
					<tr>
						<td><?=$value->nama_obat?></td>
						<td class="text-center">
							<div class="btn-group" role="group">
								<a href="<?=base_url()?>Ppk_C/view_karakteristik_obat/<?=$value->id_obat?>" class="btn btn-secondary bg-dark">Detail</a>
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