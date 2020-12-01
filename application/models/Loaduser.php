<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loaduser extends CI_Model {

	public function add_data( $data, $table )
	{

		$this->db->insert( $table, $data );
		redirect('page/back_view/data','refresh');

	}	

}

/* End of file Loaduser.php */
/* Location: ./application/models/Loaduser.php */