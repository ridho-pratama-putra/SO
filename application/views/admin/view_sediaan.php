<script type="text/javascript">
	$(document).ready(function() {
		$('#read_sediaan').DataTable({
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
		<?=$this->session->flashdata("alert_create_sediaan");?>
		<?=$this->session->flashdata("alert_delete_sediaan");?>
		<?=$this->session->flashdata("alert_rename_sediaan");?>
		<h3>Master sediaan</h3>
		<a class="btn btn-primary" href="" data-toggle="modal" data-target="#modalTambahSediaan">Tambah Master Sediaan</a>
	</div>
	<div class="col row margin-top-15">
		<table id="read_sediaan" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
				<th >Nama sediaan</th>
				<th class="text-center" width="10%">CRUD</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($master_sediaan as $key => $value) {?>
					<tr>
						<td><?=$value->sediaan ?></td>
						<td>
							<div class="btn btn-group btn-xs" role="group">
								<a href="" class="btn btn-secondary bg-dark" data-toggle="modal" data-target="#modalRenameSediaan" data-id="'+data+'" >Rename Sediaan</a>
							</div>
						</td>
					</tr>
				<?php		}		?>
			</tbody>
		</table>
	</div>
</div>
</main>

<!-- MODAL ADD SEDIAAN -->
<div class="modal fade" id="modalTambahSediaan" tabindex="-1" role="dialog" aria-labelledby="modalTambahSediaan" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah Master Sediaan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  		<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="<?=base_url('Admin_C/handle_add_sediaan')?>">
				<div class="modal-body">
						<div class="form-group">
							<label for="nama_jenis_sediaan">Nama Jenis Sediaan</label>
							<input type="text" class="form-control" id="nama_jenis_sediaan" name="nama_jenis_sediaan">
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary ">KIRIM</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL ADD SEDIAAN -->


<!-- MODAL RENAME NAMA SEDIAAN -->
<div class="modal fade" id="modalRenameSediaan" tabindex="-1" role="dialog" aria-labelledby="modalRenameSediaan" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Rename Master Sediaan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  		<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="<?=base_url('Admin_C/handle_rename_sediaan')?>">
				<div class="modal-body">
						<div class="form-group">
							<label for="nama_jenis_sediaan">Nama Jenis Sediaan</label>
							<input type="text" class="form-control" id="nama_master_jenis_sediaan" name="nama_master_jenis_sediaan">
							<input type="text" class="form-control" id="nama_jenis_sediaan" name="nama_jenis_sediaan">
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary ">KIRIM</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL RENAME NAMA SEDIAAN -->

<!-- JAVASCRIPT PENGARAH RENAME SEDIAAN -->
<script type="text/javascript">
<script type="text/javascript">
	$('#modalRenameSediaan').on('show.bs.modal', function(e) {
		$("#idLog").attr('value', $(e.relatedTarget).data('idlog'));
	});
</script>
</script>
<!-- END JAVASCRIPT PENGARAH RENAME SEDIAAN -->