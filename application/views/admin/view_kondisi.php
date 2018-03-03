<script type="text/javascript">
	$(document).ready(function() {
		$('#kondisi').DataTable();
	});
	// datatable untuk tabel kondisi
</script>
<main>
	<br>
	<div class="col">
		<table id="kondisi" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
				<th width="15%">ID kondisi</th>
				<th width="85%;" class="text-center">Detail Kondisi</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($master_kondisi as $key => $value) {
					?>
					<tr>
						<td><?=$value->id_master_kondisi?></td>
						<td><?=$value->detail_kondisi?></td>
					</tr>
					<?php
				} ?>
			</tbody>
		</table>
	</div>
</main>