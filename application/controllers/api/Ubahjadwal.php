<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Ubahjadwal extends REST_Controller {

	function __construct($config = 'rest') {
		parent::__construct($config);
		$this->load->database();
		$this->load->helper(['jwt', 'authorization']); 
	}

	public function matakuliah_get() {

		$username 	= $this->get('username');
		$matakuliah = $this->get('matakuliah');
		$kelas 		= $this->get('kelas');
		$minggu 	= $this->get('minggu');

		$username = "'$username'";

		$q_matakuliah = '';
		if( isset($matakuliah) ) {
			$q_matakuliah = " and tb_matakuliah.matakuliah = '$matakuliah'";
		}

		$q_kelas = '';
		if( isset($kelas) ) {
			$q_kelas = " and tb_kelas.kelas_nama = '$kelas'";
		}

		$q_minggu = '';
		if( isset($minggu) ) {
			$q_minggu = " and tb_jadwal.minggu = '$minggu'";
		}

		$data_matakuliah = $this->db->query('
			SELECT
			tb_jadwal.jdwl_id AS id, tb_matakuliah.matakuliah, date_format(tb_jadwal.tanggal, "%d-%m-%Y") AS tanggal,
			tb_jadwal.minggu as minggu, 
			tb_jadwal.status as status,
			tb_ruang.nama AS ruangan, tb_kelas.kelas_nama AS kelas
			FROM
			tb_matakuliah, tb_jadwal, tb_ruang, tb_kelas, tb_dosen
			WHERE
			tb_matakuliah.kode_mk 	= tb_jadwal.kode_mk  AND
			tb_kelas.kelas_id 		= tb_jadwal.kelas_id AND
			tb_dosen.dsn_id			= tb_jadwal.dosen_id AND
			tb_ruang.rg_id			= tb_jadwal.ruang_id AND

			tb_dosen.username = '.$username.' '.$q_matakuliah.' '.$q_kelas.' '.$q_minggu.'
			ORDER BY tb_jadwal.tanggal ASC
			')->result();
		$this->response( array('status'=>200, 'result'=>$data_matakuliah) );
		
	}

	public function pertemuan_put() {
		$id_jadwal 	= $this->put('id_jadwal');
		$tanggal 	= $this->put('tanggal');
		$dosen 	= $this->put('dosen');

		// $hari = date('D', strtotime($tanggal));

		// $var = '20-04-2012';
		$date = str_replace( '-', '-', $tanggal );
		$hari = date('D', strtotime( $date ) );
		$v_tanggal = date('Y-m-d', strtotime( $date ) );

		switch ($hari) {
			case 'Sun':
			$nama_hari = "Minggu";
			break;
			case 'Mon':			
			$nama_hari = "Senin";
			break;
			case 'Tue':
			$nama_hari = "Selasa";
			break;
			case 'Wed':
			$nama_hari = "Rabu";
			break;
			case 'Thu':
			$nama_hari = "Kamis";
			break;
			case 'Fri':
			$nama_hari = "Jumat";
			break;
			case 'Sat':
			$nama_hari = "Sabtu";
			break;
			default:
			$nama_hari = "";		
			break;
		}

		/** Format tanggal 0000-00-00 set dari Client, dan value btn untuk UI 00-00-0000 **/
		$status_edit = 'Pengganti';
		$data = array(
			'tanggal' => $v_tanggal,
			'hari'	  => $nama_hari,	
			'status'  => $status_edit
		);

		$this->db->where('jdwl_id', $id_jadwal);
		$ubah_pertemuan = $this->db->update('tb_jadwal', $data);

		if( $ubah_pertemuan ) {

			$message = 'Berhasil mengupdate data';
			$this->response( array('status'=>200, 'message'=>$message, 'result'=>$data) );
			$this->notif($dosen);
		} else {

			$message = 'Gagal update';
			$this->response( array('status'=>502, 'message'=>$message) );
		}
	}

	public function notif($dosen) {
		 define( 'API_ACCESS_KEY', 'mykey');
		 $token = $this->db->query("SELECT token FROM tb_token WHERE app='mahasiswa'")->result_array();
		 $ids = [];
		 for ($i=0; $i <count($token)  ; $i++) { 
			array_push($ids, $token[$i]['token']);
		}
	     $msg = array
	          (
	            'body'  => 'jadwal pertemuan diubah',
	            'title' => 'Dosen '.$dosen.'',

	          );
	    $fields = array
	            (
	                'registration_ids'        => $ids, 
	                'notification'  => $msg
	            );

	    $headers = array
	            (
	                'Authorization: key=AAAACvL1XDA:APA91bEAnqsNEDB-YLC38EfvYQS7vyuZlxJpo7rgMUHokJzjVo7wYVaXPbtnlJdz1KsXJSI47VOxehslCytkx9R9yKBl_Uz59Ko-Gbx2_bzjA78p6QJRiFOWCsgzDYCwZOFRrAk62H04',
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