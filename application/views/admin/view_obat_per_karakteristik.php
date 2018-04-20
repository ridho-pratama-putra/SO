<main>
	<div class="container margin-top-15" id="notif">
	</div>
	<div class="container margin-top-15">
		<br>
		<br>
		<h3 class="text-center">DAFTAR OBAT</h3>
		<table id="daftar_obat" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
			<thead class="thead-dark">
				<tr>
					<th class="text-center">id_obat</th>
					<th class="text-center" width="30px"></th>
				</tr>
			</thead>
				<?php foreach ($result as $key => $value) {	?>
				<tr>
					<td><?=$value->id_obat?></td>
					<td><a href="<?=base_url('Admin_C/view_karakteristik/').$value->tipe.'/'.$value->id_obat?>" class="btn btn-secondary" target='_blank'>Lihat Detail</a></td>
				</tr>
				<?php } ?>
			<tbody>
			</tbody>
		</table>
	</div>
</main>