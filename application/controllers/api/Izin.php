<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class Izin extends REST_Controller {

	function __construct($config = 'rest') {
		parent::__construct($config);
		$this->load->database();
	}

	public function index_post() {
		
		$config = array(
			'upload_path' 	=> "./upload_izin/",
			'allowed_types' => "pdf|csv",
			'overwrite' 	=> TRUE,
			'max_size' 		=> "2048",
		);

		$this->load->library('upload', $config);

		$nim 		= $this->post('nim');
		$alasan 	= $this->post('alasan');
		$keterangan = $this->post('keterangan');
		$tgl_izin 	= $this->post('tglizin');

		date_default_timezone_set('Asia/Jakarta');
		$tanggal 	= '2018-09-04'; //date("Y-m-d"); UBAH TANGGALNYA
		$jam 		= '13:00:00'; //date("H:i:s");

		//Location
		$longitude 	= $this->post('longitude');
		$latitude 	= $this->post('latitude');

		//Get Data Jadwal
		$data_jadwal = $this->db->query('SELECT tb_jdwl_mhs.jadwal_id
			from tb_jdwl_mhs, tb_jadwal, tb_mahasiswa, tb_jam			where
			tb_jadwal.jdwl_id       = tb_jdwl_mhs.jadwal_id and
			tb_jam.jam_id 			= tb_jadwal.jam_id and
			tb_mahasiswa.nim 		= tb_jdwl_mhs.nim and
			tb_mahasiswa.nim 		= "' . $nim . '" and
			tanggal 				= "' . $tanggal . '" and
			"' . $jam . '" between tb_jam.jam_masuk and tb_jam.jam_keluar')->result();

		foreach ($data_jadwal as $value) {
		}

		if ($data_jadwal != NULL) {
			if ($this->upload->do_upload() == TRUE && $nim != NULL && $alasan != NULL && $keterangan != NULL) {
				// $data = array('upload_data' => $this->upload->data());
				$file_upload = $this->upload->data();

				$this->db->where('nim', $nim);
				// $this->db->where('tanggal', $tgl_izin); GUNAKAN INI UTK IZIN PER HARI
				$this->db->where('jadwal_id', (int) $value->jadwal_id);

				$data_absen = $this->db->get('tb_absen');
				if ($data_absen->num_rows() > 0) {
					$message = 'Anda sudah absen';
					$this->response(array('status' => 201, 'message' => $message));
				} else {
					$insert_absen = array(
						'nim' 			=> $nim,
						'jadwal_id' 	=> (int) $value->jadwal_id,
						'tanggal' 		=> $tanggal,
						'jam' 			=> $jam,
						'status_absen' 	=> $alasan,
					);
					$this->db->insert('tb_absen', $insert_absen);
					$last_id = $this->db->insert_id();

					$insert_izin = array(
						'nim' 			=> $nim,
						'absen_id' 		=> $last_id,
						'file_upload' 	=> $file_upload['file_name'],
						'alasan' 		=> $alasan,
						'keterangan' 	=> $keterangan,
						'tanggal' 		=> $tanggal,
						'jam' 			=> $jam,
						'longitude' 	=> $longitude,
						'latitude' 		
						=> $latitude,
					);
					$message = 'Berhasil menambahkan Izin';
					$this->db->insert('tb_izin', $insert_izin);
					$this->response(array('status' => 201, 'message' => $message));

					$this->notif();
				}
			} else {
				// $message = 'Data tidak boleh kosong';
				$message = 'Gagal menambahkan izin' . ' - ' . $this->upload->display_errors();
				$this->response(array('status' => 400, 'message' => $message));
			}
		} else {
			$message = 'Data jadwal tidak ditemukan';
			$this->response(array('status' => 400, 'message' => $message));
		}
	}

	public function cobaizin_post() {

		$tanggal = $this->post('tanggal_izin');
		$nim = $this->post('nim');
		$jam = '13:00:00';
		$status = $this->post('status');

		$data_izin = $this->db->query(
			'SELECT
			tb_jdwl_mhs.jadwal_id, tb_jadwal.tanggal
			FROM
			tb_jadwal,
			tb_jdwl_mhs,
			tb_mahasiswa
			WHERE
			tb_jadwal.jdwl_id = tb_jdwl_mhs.jadwal_id
			AND tb_mahasiswa.nim = tb_jdwl_mhs.nim
			AND tb_jadwal.tanggal = "' . $tanggal . '"
			AND tb_mahasiswa.nim = "' . $nim . '"'
		);

		if ($data_izin->num_rows() > 0) {

			$this->db->where('tb_absen.tanggal', $tanggal);
			$data_sudah_absen = $this->db->get('tb_absen');

			if ($data_sudah_absen->num_rows() > 0) {
				$this->response(array('status' => 403, 'message' => 'Anda Sudah Absen'));
			} else {

				$data_insert = array();
				foreach ($data_izin->result() as $value) {
					$data_insert[] = array(
						'nim' => $nim,
						'jadwal_id' => $value->jadwal_id,
						'tanggal' => $tanggal,
						'jam' => $jam,
						'status_absen' => $status,
					);
				}

				$this->db->insert_batch('tb_absen', $data_insert);

				$insert_id = array();
				$nilai_insert = $this->db->insert_id();
				for ($i = 0; $i < count($data_insert); $i++) {

					$insert_id[] = array(
						'id_inserted' => $nilai_insert,
					);
					$nilai_insert++;

				}

				$this->response(array('status' => 200, 'message' => $insert_id));

			}

		} else {

			$this->response(array('status' => 403, 'message' => 'Data jadwal tidak ditemukan'));

		}

		// $data_hapus = array();
		// foreach ($data_izin->result() as $value) {
		// 	$this->db->where('jadwal_id', $value->jadwal_id);
		// 	$this->db->delete('tb_absen');
		// }

	}
	public function notif() {
		 define( 'API_ACCESS_KEY', 'mykey');
		 $nim = $this->post('nim');
		 $token = $this->db->query("SELECT token FROM tb_token WHERE app='dosen'")->result_array();
		 $ids = [];
		 for ($i=0; $i <count($token)  ; $i++) { 
			array_push($ids, $token[$i]['token']);
		}
	     $msg = array
	          (
	            'body'  => $nim.' mengirim surat izin',
	            'title' => 'Surat izin Diterima ',

	          );
	    $fields = array
	            (
	                'registration_ids'        => $ids, 
	                'notification'  => $msg
	            );

	    $headers = array
	            (
	                'Authorization: key=AAAAiMCqAc4:APA91bFbp43J1ivSpRJuYTBOK7wkOcKb60Q-9qE1CPmYOfZZ5QNDyWs035p5Nsnt1PNDdymMJIdEqMLkO-Zl1fBggTgM2YyaQ0PBGdQKDuJs0elp8W_BryrTJKfdXEKVpXcMeDV5wgyc',
	                'Content-Type: application/json'
	            );
	        $ch = curl_init();
	        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	        curl_setopt( $ch,CURLOPT_POST, true );
	        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        $result = curl_exec($ch );
	        // echo $result;
	        $err = curl_error($ch);

	    // if ($err) {
	    //   echo "cURL Error #:" . $err;
	    // } else {
	    //   print_r($result) ;
	    // }
	  }

}
