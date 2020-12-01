<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Pilihmatkul extends REST_Controller {

	function __construct($config = 'rest') {
		parent::__construct($config);
		$this->load->database();
		$this->load->helper(['jwt', 'authorization']); 
	}

	public function index_get() {
		
		// Untuk menampilkan matakuliah hari ini
		$nim 	 = $this->get('nim');
		$tanggal = '2018-09-05'; //date('Y-m-d'); set date manual

		$data_pilih = $this->db->query('
			SELECT
			tb_matakuliah.matakuliah, tb_jadwal.jdwl_id
			FROM 
			tb_matakuliah, tb_jadwal, tb_jdwl_mhs, tb_mahasiswa
			WHERE 
			tb_matakuliah.kode_mk = tb_jadwal.kode_mk AND
			tb_jadwal.jdwl_id = tb_jdwl_mhs.jadwal_id AND
			tb_jdwl_mhs.nim = tb_mahasiswa.nim AND
			tb_mahasiswa.nim = "'.$nim.'" AND
			tb_jadwal.tanggal = "'.$tanggal.'"
			')->result();
		$this->response( array( 'status'=>200, 'result'=>$data_pilih ) );

	}
}