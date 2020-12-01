<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://192.168.43.153:8000/ambildataalfa",
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
<!-- <?php 
function curl($url){
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch); 
    curl_close($ch);      
    return $output;
}

$send = curl("https://sandbox.rachmat.id/curl/get/");

// mengubah JSON menjadi array
$data = json_decode($send, TRUE);
?> -->

<?php 
if( ! $this->session->userdata('user_login') ) {
	redirect('login','refresh');
}
?>
<div id="page-wrapper">
	<div class="col-lg-12">
		<h3 class="page-header">Data Prosentase Kehadiran</h3>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Data Kehadiran Mahasiswa di bawah 80%</strong>
				</div>
				<div class="table-responsive">
					<div class="panel-body">
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>No</th>
									<th>NIM</th>
									<th>Nama</th>
									<th>Kelas</th>
									<th>Matakuliah</th>
									<th>Prosentase</th>
									<th>Dosen</th>
									<th>Kehadiran Mhs</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								foreach ($result as $r) {
								?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $r['data'][0]['nrp'] ?></td>
											<td><?php echo $r['data'][0]['nama'] ?></td>
											<td><?php echo $r['data'][0]['kelas'] ?></td>
											<td><?php echo $r['data'][0]['matakuliah'] ?></td>
											<td style="font-size: 16px; text-align: center;"><?php echo '<label class="label label-warning"> '. $r['prosentase'].' %</label>' ?></td>
											<td><?php echo $r['dosen'] ?></td>
											<td><strong><?php echo $r['kehadiran'] ?> dari 14</strong></td>
										</tr>
										<?php 
									$no++; }
									if ($result == null ) {
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
			responsive: true
		});
	});
</script>