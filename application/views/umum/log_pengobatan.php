	<div class="col-md-10 konten-kanan" id="style-1">
		<script type="text/javascript">
			$(document).ready(function() {
				$('#log_pengobatan').DataTable({
					"columnDefs": [{
					"targets": [1],
					"orderable": false
				}]
				});
			});

			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			});
			$('#tooltip-gejala').tooltip();
		</script>
		<div class="row">
			<main role="main" class="col-12">
				<br>
				<h1 class="text-center">Log Pengobatan</h1>
				<a class="btn btn-primary float-right" href="#" role="button">Ke Menu Pemeriksaan</a>
				<br>
				<br>
				<table id="log_pengobatan" class="table table-striped table-hover" cellspacing="0" width="100%" style="width: 100%">
					<thead class="thead-dark">
						<tr>
						<th>Tanggal</th>
						<th width="50px;"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($log_pengobatan as $key => $value) {	?>
						<tr>
							<td><?= $value->tanggal ?></td>
							<td>
								<div class="btn-group" role="group">
									<a href="<?=base_url()?>Ppk_C/view_detail_per_log/<?=$value->id_log?>/<?=$user[0]->id_user?>" class="btn btn-secondary" style="text-decoration: none;" data-toggle="tooltip" title="lihat lebih detail apa saja gejala yang dicatat pada pengobatan di tanggal ini">Detail Pengobatan</a>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</main>





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