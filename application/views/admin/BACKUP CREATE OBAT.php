<main>
	<div class="container-fluid margin-top-15  padding-bottom-15">
		
		<form action="<?=base_url()?>Admin_C/handle_create_obat" method="POST">
			
			<div class="col">
				<h3>Create KB Obat</h3>
				<div class="margin-top-15 form-group row">
					<label for="nama_obat" class="col-2 col-form-label"><h5>Nama Obat</h5></label>
					<div class="col">
						<input type="text" class="form-control" id="nama_obat" placeholder="Nama Obat" name="nama_obat">
					</div>
				</div>
			</div>
<!-- INPUT INDIKASI SECTION -->
			
			<script type="text/javascript">
				function addInput(divName){
					var newdiv = document.createElement('div');
					if (divName == 'dynamicInputIndikasi') {
						newdiv.innerHTML ="<div class='margin-top-15'><input type='text' class='form-control' name='indikasi[]'></div>";
					}
					else if(divName =='dynamicInputKontraindikasi'){
						newdiv.innerHTML ="<div class='margin-top-15'><input type='text' class='form-control' name='peringatan[]'></div>";
					}
					else if(divName =='dynamicInputPeringatan'){
						newdiv.innerHTML ="<div class='margin-top-15'><input type='text' class='form-control' name='peringatan[]'></div>";
					}
					document.getElementById(divName).appendChild(newdiv);
				}
			</script>
			
			<div class="col">
				<div class="margin-top-15 form-group" style="border-radius: 5px; padding-bottom: 15px; background-color: #edefea">
					<div class="col-2">
						<label for="indikasi" class="col-form-label margin-top-15"><h5>Indikasi</h5></label>
					</div>
					<div class="col">
						<div id="dynamicInputIndikasi">
							<div class="margin-top-15">
								<input type="text" class="form-control" id="indikasi" name="indikasi[]">
							</div>
						</div>
					</div>
					<div class="col margin-top-15">
						<button type="button" class="btn btn-primary btn-block" onClick="addInput('dynamicInputIndikasi');"> <i class="icons ion-ios-plus-empty"></i> Add Input</button>
					</div>
				</div>
<!-- END INDIKASI SECTION -->


<!-- INPUT KONTRAINDIKASI SECTION -->
				<div class="margin-top-15 form-group" style="border-radius: 5px; padding-bottom: 15px; background-color: #edefea">
					<div class="col-2">
						<label for="kontraindikasi" class="col-form-label margin-top-15"><h5>Kontraindikasi</h5></label>
					</div>
					<div class="col">
						<div id="dynamicInputKontraindikasi">
							<div class="margin-top-15">
								<input type="text" class="form-control" id="kontraindikasi" name="kontraindikasi[]">
							</div>
						</div>
					</div>
					<div class="col margin-top-15">
						<button type="button" class="btn btn-primary btn-block" onClick="addInput('dynamicInputKontraindikasi');""> <i class="icons ion-ios-plus-empty"></i> Add Input</button>
					</div>
				</div>
<!-- END KONTRAINDIKASI SECTION -->


<!-- INPUT PERINGATAN SECTION -->
				<div class="margin-top-15 form-group" style="border-radius: 5px; padding-bottom: 15px; background-color: #edefea">
					<div class="col-2">
						<label for="peringatan" class="col-form-label margin-top-15"><h5>Peringatan</h5></label>
					</div>
					<div class="col">
						<div id="dynamicInputPeringatan">
							<div class="margin-top-15">
								<input type="text" class="form-control" id="peringatan" name="peringatan[]">
							</div>
						</div>
					</div>
					<div class="col margin-top-15">
						<button type="button" class="btn btn-primary btn-block" onClick="addInput('dynamicInputPeringatan');""> <i class="icons ion-ios-plus-empty"></i> Add Input</button>
					</div>
				</div>

			</div>

			<div class="col margin-top-15">
				<button type="submit" class="btn btn-danger btn-block"> <i class="icons  ion-android-send"></i> Masukkan DB</button>
			</div>
			
		</form>
		<br>
	</div>
</main>

<!-- END PERINGATAN SECTION -->



<!-- <script type="text/javascript">
	function addInput(divName){
		var newdiv = document.createElement('div');
		newdiv.innerHTML = "Entry " + (counter + 1) + " <br><input type='text' name='myInputs[]'>";
		document.getElementById(divName).appendChild(newdiv);
		counter++;
	}

</script> -->


<!-- 

<script src="/wp-includes/js/addInput.js" language="Javascript" type="text/javascript"></script>
<form method="POST">
     <div id="dynamicInput">
          Entry 1<br><input type="text" name="myInputs[]">
     </div>
     <input type="button" value="Add another text input" onClick="addInput('dynamicInput');">
</form>

 -->
