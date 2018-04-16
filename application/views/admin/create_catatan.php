<script type="text/javascript">
	$(document).ready(function(){
		$('#catatan_obat').wysihtml5();
	});
</script>
<main>
<div class="container-fluid margin-top-15  padding-bottom-15">
	<div class="row">
		<div class="col-12">
			<?=$this->session->flashdata("alert_catatan");?>
			<h3>Catatan Obat <?=$nama_obat[0]->nama_obat?></h3>
		</div>
	</div>
	<div class="row margin-top-15">
		<div class="col-12">
			<form action="<?=base_url("Admin_C/handle_create_catatan")?>" method="POST">
				<button type="submit" class="btn btn-primary btn-xs ml-auto float-right">Create Catatan Obat <i class="icon ion-android-create"></i> </button>
				<div class="form-group">
					<input type="hidden" name="id_obat" value="<?=$id_obat?>">
					<textarea class="form-control col-12" id="catatan_obat" name="catatan_obat" rows="16"></textarea>
				</div>
			</form>
		</div>
	</div>
</div>
</main>
