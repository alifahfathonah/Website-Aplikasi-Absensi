<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://192.168.43.153:8000/ambildatamhs",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));
$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);
?>

<?php 
if( ! $this->session->userdata('user_login') ) {
	redirect('login','refresh');
}
?>
<style type="text/css">
	.swal2-popup {
		font-size: 1.6rem !important;
	}

</style>
<div id="page-wrapper">
	<div class="col-lg-12">
		<h3 class="page-header">Data Mahasiswa</h3>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-auto col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Data Mahasiswa</strong>
				</div>

				<div class="table-responsive">
					<div class="panel-body">
						<table class="table table-responsive table-bordered table-striped table-hover" id="dataTables-example"> 
							<thead>
								<tr>
									<th>No</th>
									<th>NIM</th>
									<th>Nama</th>
									<th>Kelas</th>
									<th>Jurusan</th>
									<!-- <th style="text-align: center;">Action</th> -->
								</tr>
							</thead>
							<tbody>	
								<?php 
								$no=1; 
								foreach ($result as $r) {
									?>		
									<tr>
										<td><?php echo $no ?></td>
										<td><?php echo $r["nrp"] ?></td>
										<td><?php echo $r["nama"] ?></td>
										<td><?php echo $r["kelas"] ?></td>
										<td><?php echo $r["jurusan"] ?></td>
									</tr>

									<!-- Edit data imei pada modal -->
									<!-- Telah Dihapus -->

									<?php $no++;  } 
									?>
								</tbody>	
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<br>
		<br>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
			responsive: true
		});

		$('.update_imei').click(function(event) {
			var imei = $("input[name=imei]").val();
			var nim  = $("input[name=nim").val();

			$.ajax({
				url: '<?php echo base_url('mahasiswa/editimei') ?>',
				type: 'POST',
				data: {
					imei : imei,
					nim : nim
				},
			})
			.done(function() {
				console.log("success");
				$('.modal').modal( 'hide' );
				Swal.fire("Data Updated!", "Data imei berhasil diupdate", "success").then(function(){
					location.reload();
				});
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		});

	});
</script>