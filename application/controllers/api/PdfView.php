<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class PdfView extends REST_Controller {

	function __construct( $config = 'rest' ) {
		parent::__construct( $config );
		$this->load->database();
	}

	public function index_get() {
		$nim =  $this->uri->segment('3');
		$query = $this->db->query('SELECT file_upload FROM tb_izin WHERE nim = "'.$nim.'"')->result();
		$file_name = $query[0]->file_upload;
		$file_path = './upload_izin/';
		
		$file = $file_path.$file_name;
		header('Content-type:application/pdf');
		header('Content-Description:inline;;filename="'.$file.'"');
		header('Content-Transfer-Encoding:binary');
		header('Accept-Range:bytes');
		@readfile($file);
	}

	public function change_status_put() {
		$nim 	= $this->put('nim');
		$status 	= array(
			"status" => $this->put('status')
		);
		$this->db->where('nim', $nim);
		$change_status = $this->db->update('tb_izin', $status);

		if( $change_status ) {

			$message = 'Success';
			$this->response( array('status'=>200, 'message'=>$message) );
		} else {

			$message = 'Update Failed';
			$this->response( array('status'=>502, 'message'=>$message) );
		}
	}
}