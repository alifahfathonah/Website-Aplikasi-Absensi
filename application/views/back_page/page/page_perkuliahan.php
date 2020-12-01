<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://192.168.43.153:8000/ambildatajadwal",
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
<div id="page-wrapper">
	<div class="col-lg-12">
		<h3 class="page-header">Data Jadwal Perkuliahan</h3>
	</div>

	<div class="row">
		<div class="col-lg-4 col-md-4 col-md-auto">
			<?php echo form_open('perkuliahan/cari_jadwal'); ?>
			<div class="form-group">
				<label for="sel1">Pilih kelas :</label>
				<select name="kelas" class="form-control" id="kelas">
					<option selected="" disabled="">--Pilih Kelas--</option>
					<?php
					
					$data_kelas = $this->db->query('SELECT kelas FROM kelas')->result();
					foreach ($data_kelas as $value) {
						echo '<option value="'.$value->kelas.'">'.$value->kelas.'</option>';
					}	
					?>
				</select>
			</div>
			<!-- Auto Complete Select -->
			<div class="form-group">
				<label>Pilih Matakuliah :</label>
				<select name="matakuliah" class="form-control" id="matkul">
					<option selected="" disabled="">--Pilih Matakuliah--</option>
					<?php  
					
					?>
				</select>
			</div>
			<div class="form-group">
				<label>Pilih pertemuan :</label>
				<select name="pertemuan" class="form-control" id="sel1">
					<option disabled="" selected="">--Pilih Pertemuan--</option>
					<?php 
					for( $i=1; $i<=14; $i++) {
						echo '<option>'.$i.'</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<button type="submit" value="true" class="btn btn-primary">Cari</button>
			</div>
			
			<?php echo form_close(); ?>
		</div>
		<div class="col-lg-10 col-md-10 col-md-auto">
			<div class="form-group">
				<?php 
				$kelas = $this->input->post('kelas');
				$matkul = $this->input->post('matakuliah');
				$minggu = $this->input->post('pertemuan');

				if($kelas || $matkul || $minggu != null) {
					echo 'Pencarian : <br>Kelas : <strong>'.$kelas. ', </strong> Matakuliah : <strong>' . $matkul. ', </strong> Minggu ke : <strong>' .$minggu.'</strong>';
				}
				?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Data Jadwal Perkuliahan</strong>
				</div>
				<div class="table-responsive">
					<div class="panel-body">
						<table class="table table-responsive table-bordered table-striped table-hover" id="dataTables-example"> 
							<thead>
								<tr>
									<th>No</th>
									<th>Dosen</th>
									<th>NIP</th>
									<th>Matakuliah</th>
									<th>Kelas</th>
									<th>Ruangan</th>
									<th>Jurusan</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$no=1;
								foreach ($result as $r) {
									?>
									<tr>
										<td><?php echo $no; ?></td>
										<td><?php echo $r["dosen"] ?></td>
										<td><?php echo $r["nip"] ?></td>
										<td><?php echo $r["matakuliah"] ?></td>
										<td><?php echo $r["kelas"] ?></td>
										<td><?php echo $r["ruangan"] ?></td>
										<td><?php echo $r["jurusan"] ?></td>
									</tr>
									<?php  
									$no++;
								} 
								if ($jadwals == null ) {
									echo '<tr >
									<td style="text-align:center" colspan="8"><label class="label label-danger">Data Kosong</label></td>
									</tr>';
								}
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
			responsive: true,
			"lengthMenu": [[8,20,50,-1],[8,20,50,"All"]],
		});
	});


	$('#kelas').change(function(event) {
		kelas = $(this).val();
		$.ajax({
			url: '<?php echo base_url('kehadiranmhs/list_matkul') ?>',
			type: 'get',
			dataType: 'html',
			data: {
				kelas: kelas
			},
		})
		.done(function(data) {
			console.log("success");
			$('#matkul').html( data );
		})
		.always(function() {
			console.log("complete");
		});
	});

</script>