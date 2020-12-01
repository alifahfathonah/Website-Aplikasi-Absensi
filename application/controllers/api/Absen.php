<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class Absen extends REST_Controller {

	function __construct( $config = 'rest' ) {
		parent::__construct( $config );
		$this->load->database();
	}

	public function index_post() {
		
		$nim 	   	= $this->post('nim');
		$data_scan 	= $this->post('dataqr');
		
		date_default_timezone_set('Asia/Jakarta');
		
		$tanggal	=  '2018-09-04'; // date("Y-m-d"); 
		$jam		=  '16:00:00';   // date("H:i:s");

		$data_jadwal = $this->db->query('SELECT
			tb_jdwl_mhs.jadwal_id
			FROM
			tb_jdwl_mhs, tb_jadwal, tb_jam, tb_mahasiswa, tb_ruang
			WHERE 
			tb_jadwal.jdwl_id   = tb_jdwl_mhs.jadwal_id AND 
			tb_jam.jam_id 		= tb_jadwal.jam_id AND
			tb_ruang.rg_id		= tb_jadwal.ruang_id AND 
			tb_mahasiswa.nim 	= tb_jdwl_mhs.nim AND
			tb_ruang.kode_ruang	= "'.$data_scan.'" AND
			tb_mahasiswa.nim 	= "'.$nim.'" AND
			tanggal 			= "'.$tanggal.'" AND
			"'.$jam.'" BETWEEN tb_jam.jam_masuk AND tb_jam.jam_keluar')->result();
		
		foreach ($data_jadwal as $value) {
		}

		if ( $data_jadwal != NULL ) {

			$this->db->where('nim', $nim);
			$this->db->where('jadwal_id', (int)$value->jadwal_id);	
			$data_absen = $this->db->get('tb_absen')->result();

			if ( $data_absen != NULL ) {
				$message = 'Anda sudah absen';
				$this->response(array('status' => 403,'message' => $message));	

			} else {

				$status = 'Hadir';
				$data = array(
					"nim" 		=> $nim,
					"jadwal_id" => (int)$value->jadwal_id,
					"tanggal"	=> $tanggal,
					"jam"		=> $jam,
					"status_absen"	=> $status,
				);

				$this->db->insert('tb_absen', $data);
				$message = 'Absensi berhasil';
				$last_id = $this->db->insert_id();
				$this->response(array('status' => 200,'message' => $message, 'result' => $data, 'id' => $last_id));
			}
		} else {
			$message = 'Absensi Gagal';
			$this->response(array('status' => 500,'message' => $message));
		}
	}
}