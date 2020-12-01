<?php  
if ( $this->input->get('id') != '' ) {
	$user_data = $this->db->get_where('tb_user', array( 'user_id' => $this->input->get('id')))->row();
}
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Data</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-8 col-md-auto col-lg-auto">
			<div class="panel panel-default">
				<div class="panel-heading" style="text-align: center;">
					Basic panel example
				</div>
				<div class="panel-body">
					<?php echo form_open('managing/update'); ?>
					<div class="form-group">
						<label>Foto</label>
						<div id="thumb_img" class="thumbnail">
							<img class="img-responsive" src="<?php echo base_url('assets/images/'.$user_data->user_image) ?>">
						</div>
						<a style="color: black;">NB : -,</a>
					</div>
					<div class="form-group">
						<label>Data nama</label>
						<input type="text" name="data_nama" id="input" class="form-control" value="<?php echo $user_data->user_nama ?>" required="required" title="">
					</div>
					<div class="form-group">
						<label>Data alamat</label>
						<input type="text" name="data_alamat" id="input" class="form-control" value="<?php echo $user_data->user_alamat ?>" required="required" title="">
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea class="form-control" name="user_deskripsi" rows="10"><?php echo $user_data->user_deskripsi ?></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit" name="edit_data" value="true">Simpan</button>
					</div>
					<input type="hidden" name="user_id" id="inputUser_id" class="form-control" value="<?php echo $user_data->user_id ?>">
					<?php echo form_close(); ?>
				</div>
			</div>			
		</div>
	</div>
</div>
<!-- id wrapper close -->
</div>
