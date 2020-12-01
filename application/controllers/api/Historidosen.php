<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Historidosen extends REST_Controller {

	function __construct($config = 'rest') {
		parent::__construct($config);
		$this->load->database();
		$this->load->helper(['jwt', 'authorization']); 
	}

	public function kehadiran_get() {

		$username 	= $this->get('username');
		$matakuliah = $this->get('matakuliah');
		$kelas 		= $this->get('kelas');
		$minggu 	= $this->get('minggu');

		$username = "'$username'";

		$q_matakuliah = '';
		if( isset($matakuliah) ) {
			$q_matakuliah = " and tb_matakuliah.matakuliah = '$matakuliah' ";
		}

		$q_kelas = '';
		if( isset($kelas) ) {
			$q_kelas = " and tb_kelas.kelas_nama = '$kelas' ";
		}

		$q_minggu = '';
		if( isset($minggu) ) {
			$q_minggu = " and tb_jadwal.minggu = '$minggu' ";
		}

		$data_histori = $this->db->query('
			SELECT
			tb_absen.nim,
			tb_absen.absen_id,
			tb_jadwal.minggu as pertemuan,
			tb_kelas.kelas_nama as kelas,
			tb_mahasiswa.nama, CONCAT(date_format
			(tb_absen.tanggal, "%d-%m-%Y")," ",date_format(tb_absen.jam,"%H:%i")) AS waktu,
			tb_absen.status_absen AS status
			FROM
			tb_mahasiswa, tb_absen, tb_jadwal, tb_dosen, tb_matakuliah, tb_kelas
			WHERE
			tb_mahasiswa.nim 		= tb_absen.nim AND
			tb_absen.jadwal_id 		= tb_jadwal.jdwl_id AND
			tb_jadwal.dosen_id 		= tb_dosen.dsn_id AND
			tb_matakuliah.kode_mk 	= tb_jadwal.kode_mk AND
			tb_kelas.kelas_id 		= tb_jadwal.kelas_id AND

			tb_dosen.username = '.$username.' '.$q_matakuliah.' '.$q_kelas.' '.$q_minggu.'
			')->result();
		$this->response( array( 'status'=>200, 'result'=>$data_histori ) );
		
	}

	public function ubahkehadiranmhs_put() 
	{

		$absen_id 		= $this->put('absen_id');
		$status_absen 	= $this->put('status_absen');
		$catatan		= $this->put('catatan');

		if( strlen($catatan) == null || '' ) {
			$catatan = null;
		}

		if( $status_absen == "Alfa" ) {

			$this->db->where('absen_id', $absen_id);
			$data_izin = $this->db->get('tb_izin');
			if( $data_izin->num_rows() > 0 ) {

				$this->db->where('absen_id', $absen_id);
				$this->db->delete('tb_izin');

			}

			$this->db->where('absen_id', $absen_id);
			$this->db->delete('tb_absen');
			$this->response( array('status' => 200, 'message' => 'Data kehadiran berhasil dihapus') );

		} else {

			$data_update = array(
				'status_absen' 	=> $status_absen,
				'catatan'		=> $catatan
			);

			$this->db->where('absen_id', $absen_id);
			$this->db->update('tb_absen', $data_update);
			$this->response( array('status' => 200, 'message' => 'Berhasil ubah data kehadiran ke ' . $status_absen) );
		}

	}

	public function matkul_get() {

		$username = $this->get('username');

		$username = "'$username'";

		$data_matkul = $this->db->query('
			SELECT DISTINCT
			tb_matakuliah.matakuliah as matakuliah
			FROM
			tb_matakuliah, tb_jadwal, tb_dosen
			WHERE
			tb_matakuliah.kode_mk 	= tb_jadwal.kode_mk AND
			tb_jadwal.dosen_id 		= tb_dosen.dsn_id AND
			tb_dosen.username		= '.$username.'
			')->result();

		$this->response( array('status' => 200, 'result'=>$data_matkul ) );			
	}

	public function kelas_get() {

		$username = $this->get('username');

		$username = "'$username'";

		$data_kelas = $this->db->query('
			SELECT DISTINCT
			tb_kelas.kelas_nama as kelas
			FROM
			tb_kelas, tb_jadwal, tb_dosen
			WHERE
			tb_kelas.kelas_id 	= tb_jadwal.kelas_id AND
			tb_jadwal.dosen_id 	= tb_dosen.dsn_id AND
			tb_dosen.username	= '.$username.'
			')->result();
		$this->response( array('status'=>200, 'result'=>$data_kelas) );

	}

	public function minggu_get() {

		$username = $this->get('username');

		$username = "'$username'";

		$data_minggu = $this->db->query('
			SELECT DISTINCT
			tb_jadwal.minggu as minggu
			FROM
			tb_jadwal, tb_dosen
			WHERE
			tb_jadwal.dosen_id = tb_dosen.dsn_id AND
			tb_dosen.username = '.$username.'
			')->result();

		$this->response( array('status'=>200, 'result'=>$data_minggu) );
	}

}