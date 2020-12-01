<div class="form-group">
	<label>Pilih Foto Produk | <strong>Foto 1</strong> </label> <span class="pull-right"><strong>Gambar Pertama yang ditampilkan</strong></span>
	<input type="file" class="form-control" name="userfile[]" accept="image/*"> 
</div>
<div class="form-group">
	<label>Pilih Foto Produk | <strong>Foto 2</strong> | </label>
	<input type="file" class="form-control" name="userfile[]" accept="image/*"> 
</div>
<?php  
$data = array(
	'nik' => '361655401073',
	'nama' => 'Pambudi'
);    

//insert ini
echo $siap =  json_encode( $data );
//tampilkan ini
echo '<br>'. json_decode( $siap )->nama .' '. json_decode( $siap )->nik;

?>