	<div class="col-md-10 konten-kanan" id="style-1">
		<script type="text/javascript">
			$(document).ready(function() {
				$('#log_pengobatan').DataTable({
					"columnDefs": [{
					"targets": [1],
					"orderable": false
					}]
				});

				$('#kondisi_pasien').DataTable();
				
			});

			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			});
			$('#tooltip-gejala').tooltip();
		</script>
		<div class="row">
			<div class="col-12">
				<br>
				<h1 class="text-center">Log Pengobatan</h1>
				<br>
				<br>
				<table id="log_pengobatan" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
					<thead class="thead-dark">
						<tr>
						<th>Tanggal</th>
						<th width="50px;" class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($log_pengobatan as $key => $value) {	?>
						<tr>
							<td><?= $value->tanggal ?></td>
							<td>
								<div class="btn-group" role="group">
									<a href="<?=base_url()?>Pasien_C/view_detail_per_log/<?=$value->id_log?>/<?=$this->session->userdata('logged_in')['id_user']?>" class="btn btn-secondary" style="text-decoration: none;" data-toggle="tooltip" title="lihat lebih detail apa saja gejala yang dicatat pada pengobatan di tanggal ini">Detail Pengobatan</a>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="col-12">
				<br>
				<h1 class="text-center">Kondisi Pasien</h1>
				<br>
				<br>
				<table id="kondisi_pasien" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
					<thead class="thead-dark">
						<tr>
						<th>Kondisi</th>
						<th>Ditambahkan</th>
						<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($kondisi as $key => $value) {	?>
						<tr>
							<td><?= $value->detail_kondisi?></td>
							<td><?= $value->tanggal_ditambahkan?></td>
							<td><?= $value->status?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>





			<!-- SIDE NAAV HERE -->
		</div>
	</div>
<nav class="col-md-2 d-none d-sm-block bg-light sidebar" id="style-1">
	<ul class="nav nav-pills flex-column">
		<li class="nav-item">
			<div>
				<img src="<?php echo base_url().$user[0]->link_foto?>" alt="foto-profil" class="img-thumbnail rounded">
			</div>
		</li>

		<li class="nav-item">
			<span class="nav-link">Nama : <i class="nav-link disabled" href="#"><?=$user[0]->nama_user?></i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Tanggal Lahir / Umur<i class="nav-link disabled" href="#"> 19 Februari 1997 / 20Thn</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">No. KTP<i class="nav-link disabled"><?=$user[0]->nomor_identitas?></i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Note Kondisi
				<a class="nav-link disabled text-white badge badge-danger">Hipertensi</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">Hipertensi</a>
				<a class="nav-link disabled text-white badge badge-danger">Lansia</a>
				<a class="nav-link disabled text-white badge badge-danger">...</a>
			</span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Dummy<i class="nav-link disabled" href="#">iajkhdbjhagdsjd haskjdnas</i></span>
		</li>
		<li class="nav-item">
			<span class="nav-link">Dummy<i class="nav-link disabled" href="#">iajkhdbjhagdsjdha skjdnas</i></span>
		</li>
	</ul>
</nav>