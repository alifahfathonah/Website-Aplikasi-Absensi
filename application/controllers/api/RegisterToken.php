<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class RegisterToken extends REST_Controller {

	function __construct( $config = 'rest' ) {
		parent::__construct( $config );
		$this->load->database();
		$this->load->helper(['jwt', 'authorization']);
		
	}

	public function index_post() 
	{
		$token = $this->post("token");
		$app = $this->post("app");

		$insert_token = array(
						'token' 			=> $token,
						'app' 			=> $app,
					);
		$message = 'Berhasil menambahkan Token';
		$this->db->insert('tb_token', $insert_token);
		$this->response(array('status' => 201, 'message' => $message));
	}

}