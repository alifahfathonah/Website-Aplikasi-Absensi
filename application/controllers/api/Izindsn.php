<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class Izindsn extends REST_Controller {

	function __construct( $config = 'rest' ) {
		parent::__construct( $config );
		$this->load->database();
		$this->load->helper(['jwt', 'authorization']);
		
	}

	public function mahasiswa_get() {

		
	}

	public function index_get() 
	{
		$username = $this->get('username');

		$data_izin = $this->db->query('
			SELECT DISTINCT
			tb_mahasiswa.nama,
			tb_izin.nim, tb_kelas.kelas_nama as kelas,
			concat(date_format(tb_izin.tanggal, "%d-%m-%Y"), " - " , 
			date_format(tb_izin.jam, "%H:%i")) as tanggal,
			tb_matakuliah.matakuliah, tb_jadwal.minggu, tb_izin.file_upload,
			tb_izin.alasan,
			tb_izin.longitude, tb_izin.latitude, tb_izin.status
			FROM 
			tb_izin, tb_absen, tb_jadwal, tb_matakuliah, tb_kelas, tb_mahasiswa, tb_dosen
			WHERE
			tb_mahasiswa.nim   = tb_absen.nim AND
			tb_izin.absen_id   = tb_absen.absen_id AND
			tb_absen.jadwal_id = tb_jadwal.jdwl_id AND
			tb_jadwal.kode_mk  = tb_matakuliah.kode_mk AND
			tb_jadwal.kelas_id = tb_kelas.kelas_id AND
			tb_dosen.username = 201136079
			')->result();

		if( $data_izin != null ) {
			$this->response(array("status" => 200, "result" => $data_izin));
		} else {
			$message = "Jadwal perkuliahan kosong";
			$this->response(array("status" => 500, "message" => $message));	
		}
	}

}

/* End of file Mahasiswa.php */
/* Location: ./application/controllers/Mahasiswa.php */