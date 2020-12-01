<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class Histori extends REST_Controller {

	function __construct( $config = 'rest' ) {
		parent::__construct( $config );
		$this->load->database();
	}

	public function mahasiswa_get() {

		$nim 			= $this->get('nim');
		$matakuliah		= $this->get('matakuliah');
		$tanggalsatu 	= $this->get('tanggalsatu');
		$tanggaldua		= $this->get('tanggaldua');

		$q_matakuliah = '';
		if( isset($matakuliah) ) {
			$q_matakuliah = " and tb_matakuliah.matakuliah = '$matakuliah' ";
		}

		// Tanggal 1
		$q_tanggal = '';
		// Tanggal 2
		if( isset($tanggalsatu)) {
			$q_tanggal = " and tb_absen.tanggal = '$tanggalsatu' ";
		}

		if( isset($tanggalsatu) && isset($tanggaldua) ) {
			$q_tanggal = " and tb_absen.tanggal between '$tanggalsatu' and '$tanggaldua' ";
		}


		$data_histori = $this->db->query('
			SELECT
			tb_absen.nim, 
			tb_mahasiswa.nama,
			tb_absen.status_absen AS status, 
			tb_matakuliah.matakuliah, 
			concat(tb_jadwal.hari,", ", date_format(tb_jadwal.tanggal, "%d-%m-%Y")) AS hari,
			tb_absen.jam 

			FROM
			tb_absen, tb_jadwal, tb_matakuliah, tb_mahasiswa

			WHERE
			tb_absen.nim		= tb_mahasiswa.nim AND
			tb_absen.jadwal_id 	= tb_jadwal.jdwl_id AND
			tb_jadwal.kode_mk 	= tb_matakuliah.kode_mk AND
			tb_absen.nim 		= '. $nim .' '. $q_matakuliah .' '. $q_tanggal .' 
			order by tb_absen.tanggal desc')->result();

		$this->response(array("status" => 200, "result" => $data_histori));	
	}

}
