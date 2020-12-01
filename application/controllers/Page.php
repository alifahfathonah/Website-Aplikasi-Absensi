<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	// Login Admin

	// Halaman Awal
	public function front_view( $filename = 'index' )
	{ 

		if( ! file_exists( VIEWPATH . '/front_page/page/page_' . $filename . '.php' ) ){
			show_404();
			exit;
		} 
		
		# MEMBER AREA
		# HALAMAN DASHBOARD
		$this->template->content->view('front_page/page/page_' .$filename, FALSE );
		$this->template->publish('front_page/front_template');

	}

	public function back_view( $filename = 'absensi' )
	{ 

		if( ! file_exists( VIEWPATH . '/back_page/page/page_' . $filename . '.php' ) ){
			show_404();
			exit;
		} 
		
		# ADMIN AREA
		# HALAMAN DASHBOARD
		$this->template->content->view('back_page/page/page_' .$filename, FALSE );
		$this->template->publish('back_page/back_template');

	}

	// Convert Data to JSON
	public function postdata( $function_name = 'null' )
	{
		
		$this->output->set_content_type('application/json');

		$this->load->model('postusermodel');
		$get_data 	= $this->postusermodel->$function_name();
		echo json_encode( $get_data );

	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */

