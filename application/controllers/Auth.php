<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		
	}

	public function doLogin()
	{
		$message = '<div class="alert closealert alert-info alert-dismissable">Anda Berhasil login<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>';

		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$data_login = $this->db->get('tb_loginattempt');

		if ( $data_login->num_rows() > 0 ) {
			$datas = $data_login->row();
			$data = array(
				'username' => $datas->username,
				'password' => $datas->password
			);

			$this->session->set_userdata( 'user_login', $data);
			$this->session->set_flashdata('login', $message);
			redirect('page/back_view/index','refresh');
		}
		else {
			$message = '<div class="alert closealert alert-danger alert-dismissable">Password dan Username tidak valid<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>';
			$this->session->set_flashdata('login', $message);
			redirect('page/back_view/login','refresh');
		}
	}

	public function doLogout()
	{
		$message = '<div class="alert closealert alert-info alert-dismissable">Anda Berhasil Logout<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>';

		$this->session->set_flashdata('logout_ok', $message);
		$this->session->unset_userdata('user_login');
		redirect('page/back_view/login','refresh');
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */