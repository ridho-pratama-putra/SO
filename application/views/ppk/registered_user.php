<script type="text/javascript">
	$(document).ready(function() {
		$('#registered_user').DataTable({
			"columnDefs": [{
			"targets": [1,2,3],
			"orderable": false
		}]
		});
	});
</script>

<div class="container-fluid margin-top-15  padding-bottom-15">
	<div class="col">
		<?=$this->session->flashdata("alert_rename_obat");?>
		<h3>Daftar Pasien yang Terdaftar</h3>
		<a class="btn btn-primary" href="<?=base_url()?>Akun_C/view_register_user">Register Pasien</a>
	</div>
	<div class="col row margin-top-15">
		<table id="registered_user" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
				<th>Nama User</th>
				<th>Akses</th>
				<th>Nomor Identitas</th>
				<th>No HP</th>
				<th class="text-center" width="10px"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($registered_user as $key => $value) {?>
					<tr>
						<td><?=$value->nama_user?></td>
						<td><?=$value->akses?></td>
						<td><?=$value->nomor_identitas?></td>
						<td><?=$value->no_hp?></td>
						<td class="text-center">
							<div class="btn-group" role="group">
								<a href="<?=base_url()?>Ppk_C/view_detail_user/<?=$value->nomor_identitas?>" class="btn btn-secondary bg-dark">Detail User</a>
								<!-- <a href="" class="btn btn-secondary bg-dark">Reset Password</a> -->
								<!-- <a href="" class="btn btn-secondary bg-dark">Hapus</a> -->
							</div>
						</td>
					</tr>
				<?php		}		?>
			</tbody>
		</table>
	</div>
</div>
<!-- 
BUTTON MASING2 USER. DROPDON
<div class="btn-group">
<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
CRUD
</button>
<div class="dropdown-menu dropdown-menu-right">
<button class="dropdown-item" type="button">Action</button>
<button class="dropdown-item" type="button">Another action</button>
<button class="dropdown-item" type="button">Something else here</button>
</div>
</div> -->


<!-- 

<pre>
<?php
// var_dump($registered_user);?>
</pre> -->