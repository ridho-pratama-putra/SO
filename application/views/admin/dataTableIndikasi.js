
	// window.onload=show();
	var respon;
	function show(){
		$.get('<?php echo base_url('Admin_C/dataTable/indikasi/'.$master_obat[0]->id_obat)?>', function(html){
			window.respon = JSON.parse(html);
			// console.log('data in : '+window.respon.indikasi);
			// destroy dulu datatable sebelumnya yang menggunakan json. 
			$('#indikasi').DataTable().destroy();

			// declare lagi datatable json
			$('#indikasi').DataTable({

				// ambil data yang dikirim dari kontroler. nama dikontroler data[$karakteristik]
				data : (respon.indikasi),

				// decalare isi format urutan kolom
				columns: [
					{ "data": "detail_tipe" },
					{ "data": "id_karakteristik" ,
						render: function ( data, type, full, meta ) {
							return '<div class="btn-group" role="group">'+
								'<a href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark">Edit Indikasi</a>'+
								'<a href="#modal" role="button" data-toggle="modal" class="btn btn-secondary bg-dark" data-target="#ModalDeleteIndikasi" title="hapus indikasi" data-idkarakteristik="'+data+'" >Hapus Indikasi</a>'+
							'</div>';
						}
					}
				],

				// disable sort pada kolom CRUD yang berisi buton edit dan hapus. nilai target dimulai dari 0
				"columnDefs": [{
									"targets": [1],
									"orderable": false
								}]
				});
		});
	}
