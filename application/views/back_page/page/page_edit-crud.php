<?php  
if ( $this->input->get('id') != '' ) {
	$data_background = $this->db->get_where('tb_background', array( 'id_background' => $this->input->get('id')))->row();
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
					Edit Data Background
				</div>
				<div class="panel-body">
					<?php echo form_open('crud_data/edit_data'); ?>
					<div class="form-group">
						<label>Id Background</label>
						<input type="text" name="id" id="input" class="form-control" value="<?php echo $data_background->id_background ?>" required="required" title="">
					</div>
					<div class="form-group">
						<label>Warna Background</label>
						<input type="text" name="color_background" id="input" class="form-control" value="<?php echo $data_background->background_color ?>" required="required" title="">
					</div>
					<div class="form-group">
						<label>Pilih Kategori</label>
						<select class="form-control">
							<?php  
							$data_kat = $this->db->get('tb_kategori_bg');
							foreach ($data_kat->result() as $datas) {
								?>
								<option><?php echo $datas->nama_kategori ?></option>
							<?php } ?>
							<input type="hidden" name="kat_id" id="inputKat_id" class="form-control" value="">
						</select>
					</div>
					<div class="form-group">
						<button class="btn btn-primary pull-left" type="submit" name="edit_data" value="true">Simpan</button>
					</div>
					<div class="form-group">
						<a onclick="window.history.go(-1)" class="btn btn-default pull-right">Cancel</a>
					</div>
					<input type="hidden" name="id_background" id="inputUser_id" class="form-control" value="<?php echo $data_background->id_background ?>">
					<?php echo form_close(); ?>
				</div>
			</div>			
		</div>
	</div>

</div>
<!-- id wrapper close -->
</div>
