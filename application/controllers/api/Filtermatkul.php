<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class Filtermatkul extends REST_Controller {

	function __construct( $config = 'rest' ) {
		parent::__construct( $config );
		$this->load->database();
	}

	public function index_get() {

		$nim = $this->get('nim');
		$data_matkul = $this->db->query('
			SELECT DISTINCT
			tb_matakuliah.kode_mk as kodemk, tb_matakuliah.matakuliah
			FROM
			tb_matakuliah,tb_jadwal, tb_jdwl_mhs
			WHERE
			tb_jdwl_mhs.nim = "'.$nim.'" and
			tb_jdwl_mhs.jadwal_id = tb_jadwal.jdwl_id and
			tb_matakuliah.kode_mk = tb_jadwal.kode_mk')->result();
		$this->response(array("status" => 200, "result" => $data_matkul));

	}
}