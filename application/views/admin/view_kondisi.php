<script type="text/javascript">
	$(document).ready(function() {
		$('#kondisi').DataTable();
	});
	// datatable untuk tabel kondisi
</script>
<main>
	<div class="container margin-top-15" id="notif"><!-- id="notif digunakan untuk memuat alert sukses/ gagal dari aksi ajax" -->
		<?=$this->session->flashdata("alert_CRUD_kondisi");?>
	</div>
	<div class="container margin-top-15">
		<br>
		<br>
		<h3 class="text-center">DAFTAR KONDISI (REKAM MEDIS CUSTOM) YANG ADA DI DB</h3>
		<h6 class="text-center text-danger"> Data rekam medis yang ditampilkan pada halaman ini adalah data krusial. Data ini ditambahkan via penambahan kontraindikasi maupun peringatan pada suatu obat. Melakukan pengeditan terlebih menghapus data kondisi akan mengakibatkan tidak dapat ditemukannya suatu kecocokan antara kontraindikasi maupun peringatan suatu obat dengan seorang pasien</h6><br>
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