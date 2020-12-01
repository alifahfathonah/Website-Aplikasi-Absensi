<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class Jadwal extends REST_Controller {

	function __construct( $config = 'rest' ) {
		parent::__construct( $config );
		$this->load->database();
		$this->load->helper(['jwt', 'authorization']);
		
	}

	public function mahasiswa_get() {

		$nim = $this->get('nim');

		date_default_timezone_set('Asia/Jakarta');
		$tanggal_skrg = date("Y-m-d");

		/**
		AND tb_jadwal.tanggal BETWEEN DATE_SUB($tanggal_skrg, INTERVAL 3) AND 
		DATE_ADD($tanggal_skrg, INTERVAL 7);

		BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)

		Work : AND tb_jadwal.tanggal  BETWEEN CURDATE() AND DATE_ADD(CURDATE(),INTERVAL 7 DAY)
		**/
		$data_jdwl = $this->db->query('
			SELECT 
			tb_dosen.nama as dosen, tb_matakuliah.matakuliah, tb_ruang.nama as ruangan, 
			concat(tb_jadwal.hari, ", " ,date_format(tb_jadwal.tanggal,"%d-%m-%Y")) as hari,
			tb_jadwal.tanggal as today,
			tb_jadwal.status as status,
			concat(date_format(tb_jam.jam_masuk, "%H:%i"), " - " , date_format(tb_jam.jam_keluar, "%H:%i")) as jam

			from 
			tb_mahasiswa, tb_jdwl_mhs, tb_jadwal, tb_matakuliah, tb_ruang, tb_jam, tb_dosen

			where 
			tb_jdwl_mhs.nim 		= tb_mahasiswa.nim and 
			tb_jdwl_mhs.jadwal_id 	= tb_jadwal.jdwl_id and 
			tb_jadwal.kode_mk 		= tb_matakuliah.kode_mk and 
			tb_jadwal.dosen_id 		= tb_dosen.dsn_id and
			tb_jadwal.jam_id 		= tb_jam.jam_id and 
			tb_jadwal.ruang_id 		= tb_ruang.rg_id and 
			tb_mahasiswa.nim 		= "'.$nim.'" 
			order by tb_jadwal.tanggal asc')->result();
		if( $data_jdwl != null ) {
			$this->response(array("status" => 200, "result" => $data_jdwl));
		} else {
			$message = "Jadwal perkuliahan kosong";
			$this->response(array("status" => 500, "message" => $message));	
		}
	}

	public function dosen_get() 
	{
		$username = $this->get('username');

		$data_jadwal = $this->db->query('
			SELECT
			tb_dosen.nama AS dosen,
			tb_matakuliah.matakuliah,
			tb_ruang.nama AS ruangan,
			tb_kelas.kelas_nama AS kelas,
			tb_jadwal.status as status,
			concat( tb_jadwal.hari, ", ", date_format( tb_jadwal.tanggal, "%d-%m-%Y" ) ) AS hari,
			tb_jadwal.tanggal AS today,
			concat( date_format( tb_jam.jam_masuk, "%H:%i" ), " - ", date_format( tb_jam.jam_keluar, "%H:%i" ) ) AS jam
			FROM
			tb_jadwal,tb_matakuliah,tb_jam,tb_ruang,tb_dosen, tb_kelas
			WHERE
			tb_jadwal.dosen_id = tb_dosen.dsn_id 
			AND tb_jadwal.kode_mk = tb_matakuliah.kode_mk 
			AND tb_jadwal.jam_id = tb_jam.jam_id
			AND tb_jadwal.kelas_id = tb_kelas.kelas_id
			AND tb_jadwal.ruang_id = tb_ruang.rg_id
			and tb_dosen.username = "'.$username.'"
			')->result();
		if( $data_jadwal != null ) {
			$this->response(array("status" => 200, "result" => $data_jadwal));
		} else {
			$message = "Jadwal perkuliahan kosong";
			$this->response(array("status" => 500, "message" => $message));	
		}
	}

}

/* End of file Mahasiswa.php */
/* Location: ./application/controllers/Mahasiswa.php */