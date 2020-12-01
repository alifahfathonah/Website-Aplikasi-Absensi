<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Data Management</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12 col-md-auto">
			<?php echo form_open_multipart('managing/add'); ?>
			<div class="form-group">
				<label>Nama</label>
				<input type="text" name="user_nama" class="form-control" value="" required="required" title="">
			</div>
			<div class="form-group">
				<label>Alamat</label>
				<input type="text" name="user_alamat" class="form-control" value="" required="required" title="">
			</div>
			<div class="form-group">
				<label>Deskripsi</label>
				<textarea name="user_deskripsi" class="form-control" rows="10"></textarea>
			</div>
			<!-- <div class="form-group">
				<label>Deskripsi 2</label>
				<textarea name="content" id="editor" rows="10"></textarea>
			</div> -->
			<div class="form-group">
				<label>Foto</label>
				<input type="file" name="userfile" class="form-control" required="required">
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit" name="tambah_data" value="true">Tambah</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>



	<h3>View Data</h3>
	<button class="btn btn-success refresh"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Refresh</button>
	<hr>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-4 col-md-auto">
			<?php echo form_open('',array('method'=>'get')) ?>
			<div class="form-group input-group">
				<input type="text" class="form-control" name="cari" id="input" value="<?php $this->input->get('cari') ?>">
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
				</span>
			</div>
			<?php echo form_close() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-auto">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Muatan</th>
						<th>Jumlah</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$mobil = 'mobil';  
					$this->db->where('jenis_kendaraan', $mobil);
					$data_muat = $this->db->get('tb_kendaraan');
					foreach ($data_muat->result() as $val) {
						?>
						<?php echo "<pre>";
						print_r ($val);
						echo "</pre>"; ?>
						<tr>
							<td></td>
							<td><?php echo $val->jenis_kendaraan ?></td>
							<td><?php echo $val->jumlah_kendaraan ?></td>
							<td></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<thead>
				<table class="table table-striped table-active table-bordered table-responsive">
					<tr>
						<th style="text-align: center;">No</th>
						<th style="text-align: center;">Nama</th>
						<th style="text-align: center;">Alamat</th>
						<th style="text-align: center;">Deskripsi</th>
						<th style="text-align: center;">Hash Code</th>
						<th style="text-align: center;">Kode QR</th>
						<th colspan="3" style="text-align: center;">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$limit = 5;
					$offset = 0;
					$no=1;

					if ($this->input->get_post('page')) {
						$offset = $this->input->get('page');
					} 

					$no = $no + $offset;

					if ( $this->input->get_post('cari') ) {
						$cari = $this->input->get_post('cari');
						$this->db->like('user_nama', $cari);
						$this->db->or_like('user_alamat', $cari);
					}

					$data_users = $this->db->get('tb_user', $limit, $offset);
					foreach ($data_users->result() as $data_user) {

						?>

						<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $data_user->user_nama ?></td>
							<td><?php echo $data_user->user_alamat ?></td>
							<td><?php echo $data_user->user_deskripsi ?></td>
							<td><?php echo $data_user->user_hash ?></td>

							<input type="hidden" name="" value="<?php echo $this->security->get_csrf_hash() ?>">

							<td><img style="max-width: 100px; max-width: 100px;" src="<?php echo base_url('/assets/images/'.$data_user->user_qrcode ) ?>"></td>							
							<!-- Detail Data -->
							<td style="text-align: center;"><a href="<?php echo site_url('page/back_view/edit-data/?id='.$data_user->user_id) ?>" class="btn btn-primary btn-xs edit_data" name="edit_data">Edit <li class="fa fa-edit fa-fw"></li></a></td>
							<td style="text-align: center;"><a href="<?php echo base_url('managing/delete/?user_id='.$data_user->user_id.'&'.'user_img='.$data_user->user_image.'&'.'user_qrcode='.$data_user->user_qrcode) ?>" class="btn btn-danger btn-xs del_data" onclick="return confirm('Data akan dihapus ? <?php echo $data_user->user_image ?> ')" name="del_data">Hapus <li class="fa fa-trash fa-fw"></li></a></td>
						</tr>
					</tbody>
				<?php } 
				$num_rows = $this->db->get('tb_user')->num_rows();
				?>
			</table>
			<tfoot>
				<td><?php echo $this->paginationmodel->paginate('data', $num_rows, $limit) ?></td>
			</tfoot>
		</div>
	</div>
	<!-- Row Close -->
	<h3>Data Lomba</h3>
	<table class="table table-bordered table-inverse table-hover">
		<thead>
			<tr class="ok">
				<th>Nama Peserta</th>
				<th>Lomba Diikuti</th>
				<th>Tahap 1</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$this->db->join('tb_lomba_peserta', 'tb_lomba_peserta.id_lomba_peserta = tb_tahap1.id_lomba_peserta');
			$this->db->join('tb_lomba', 'tb_lomba.id_lomba = tb_lomba_peserta.id_lomba');
			$this->db->join('tb_loginattempt', 'tb_loginattempt.user_id = tb_lomba_peserta.id_user');
			$data = $this->db->get('tb_tahap1');
			foreach ($data->result() as $key) { 
				echo "<pre>";
				print_r ($key);
				echo "</pre>";
				?>
				<tr>
					<td><?php echo $key->username ?></td>
					<td><?php echo $key->nama_lomba ?></td>
					<td><?php echo $key->nama_tahap ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<hr>

	<!-- Page Wrapper Close -->
</div>

<!-- id wrapper close -->
</div>

<!-- LOVE JAVASCRIPT -->

<script type="text/javascript">
	$('.refresh').click(function(event) {
		window.location.reload();
	});

	$('.swal').click(function(event) {
		$.ajax({
			url: '<?php echo base_url('page/postdata/tryswal') ?>',
		})
		.done(function(result) {
			swal(
				result.heading,
				result.message,
				result.type,
				).then( function(){
					
				})
				console.log("success");
			})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
	
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
			responsive: true
		});
	});

	jQuery(document).ready(function($) {
		$('#provinsi').change(function(event) {
			$.ajax({
				url: '<?php echo site_url('cekongkir/getKota') ?>',
				type: 'get',
				dataType: 'html',
				data: {
					provisi_id: $('#provinsi').val()
				},
			}) 
			.done(function(data) {
				$("#kota").html( data );
			});
		});
	}); 
</script>
