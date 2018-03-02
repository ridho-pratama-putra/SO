	<div class="col-md-10">
		<br>
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2 class="text-center">Form Input gejala / keluhan pasien</h2>
				</div>	
			 	<br>
			 	<br>
			 	<br>
				<div class="col-sm-12">
					<form method="" class="form-group">
						<div class="row">
							<div class="col-3 offset-2 bg-primary rounded">
								<div class="col">
									<h5 class="text-center text-white">ID</h5>
								</div>
								<div class="col">
									<h3 class="text-center text-white">4</h3>
								</div>
							</div>
							<div class="col-2">
							</div>
							<div class="col-3 bg-primary rounded">
								<div class="col">
									<h5 class="text-center text-white">Tanggal</h5>
								</div>
								<div class="col">
									<h3 class="text-center text-white">12-02-2018</h3>
								</div>
							</div>
						</div>
						<div class="row">
							<input name="id_diagnosa" type="hidden">
							<input name="tanggal" type="hidden">
						</div>
						<br>
						<br>
						<div class="row">
							<div class="col">
								<h4 class="text-center">Gejala (multiple)</h4>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<script type="text/javascript">
									$(document).ready(function() {
										$('#gejala_id').select2({
											placeholder: 'ketikkan gejala-gejala'
										});
									});
								</script>
								<select class="js-example-basic-multiple col" id="gejala_id" name="gejala[]" multiple="multiple" title="masukkan gejala-gejala yang dirasakan pasien">
									<option>gatal</option>	
									<option>pusing</option>	
									<option>nyeri otot</option>	
									<option>pilek</option>	
									<option>sesak nafas</option>	
									<option>demam</option>	
									<option>mual</option>	
								</select>
							</div>
						</div>
					</form>
					<br>
				</div>
				<div class="col-sm-12">
					<a class="btn btn-primary btn-block bg-dark" href="#" role="button">Kirim</a>
				</div>
			</div>
	</div>
