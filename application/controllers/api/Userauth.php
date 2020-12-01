<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Userauth extends REST_Controller {

	function __construct($config = 'rest') {
		parent::__construct($config);
		$this->load->database();
		$this->load->helper(['jwt', 'authorization']); 
	}

	public function index_get() {

		$mhs = $this->db->get('tb_mahasiswa')->result();
		$this->response(array("status" => 200, 'result' => $mhs));
	}

	public function mahasiswa_post() {

		$nim 		= $this->post('nim');
		$password 	= $this->post('password');
		$imei 		= $this->post('imei');

		if ( $nim != null && $password != null ) {	

			$this->db->select('imei');
			$this->db->where('nim', $nim);
			$this->db->where('imei');
			$first_imei = $this->db->get('tb_mahasiswa')->result();

			/** CEK UNIK IMEI DI SINI **/

			if ( $first_imei != NULL ) {

				$imei_sama = $this->db->query('SELECT imei from tb_mahasiswa WHERE imei = '.$imei);
				if( $imei_sama->num_rows() > 0) {
					$message = "IMEI Telah digunakan";
					$this->response( array( "status" => 403, "message" => $message, ) );
				} 

				else {
					$data = array('imei' => $imei);
					$this->db->where('nim', $nim);
					$this->db->update('tb_mahasiswa', $data);
				}
			}

			$this->db->select('imei');
			$this->db->where('nim', $nim);
			$this->db->where('imei', $imei);
			$data_imei = $this->db->get('tb_mahasiswa')->result();

			if ( $data_imei == NULL ) {
				$message = "IMEI tidak cocok / telah digunakan";
				$this->response( array( "status" => 403, "message" => $message) );
			} 
			else {

				/** CEK LOGIN DI SINI **/

				$this->db->where('nim', $nim);
				$this->db->where('password', $password);
				$data_user = $this->db->get('tb_mahasiswa');

				if($data_user->num_rows() > 0) {

					$data = $data_user->result();
					$message = 'Login Berhasil';
					$this->response(array("status" => 200,'message' => $message, 'result' => $data));
				} else {
					$message = 'Nim atau Password salah';
					$this->response(array( "status" => 500, 'message' => $message ));
				}	
			} 
		}
		else {
			$message = 'Data tidak boleh kosong';
			$this->response(array( "status" => 500, 'message' => $message ));
		}
	}

	public function dosen_post() {

		$username = $this->post('username');
		$password = $this->post('password');

		if( isset( $username ) && isset( $password ) ) {

			$this->db->where('username', $username);
			$this->db->where('password', $password);
			$data_dosen = $this->db->get('tb_dosen');

			if( $data_dosen->num_rows() > 0 ) {
				$data = $data_dosen->result();
				$message = "Berhasil Login";
				$this->response(array('status' => 200, 'message' => $message, 'result' => $data));
			} else {
				$message = "Gagal Login";
				$this->response(array('status' => 400, 'message' => $message));
			}
		} else {
			$message = "Data tidak boleh kosong";
			$this->response(array('status' => 400, 'message' => $message));
		}
	}
}