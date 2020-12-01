<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('back_page/v_login');		
	}

	public function doLogin() 
	{

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->db->select('username, password');
		$this->db->from('admin');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$data_admin = $this->db->get();

		if( $data_admin->num_rows() > 0 ) {
			$datas = $data_admin->row();
			$data = array(
				'username' => $datas->username,
				'password' => $datas->password
			);

			$this->session->set_userdata( 'user_login', $data);

			$pesan = '<div class="alert closealert alert-info alert-dismissable">Selamat datang Admin<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>';
			$this->session->set_flashdata('login_admin', $pesan);

			redirect('kehadiranmhs','refresh');

		} else {

			$pesan = '<div class="alert closealert alert-danger alert-dismissable">Password dan Username tidak valid<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>';
			$this->session->set_flashdata('login_admin', $pesan);

			redirect('login','refresh');

		}

	}

	public function doLogout()
	{

		$pesan = '<div class="alert closealert alert-info alert-dismissable">Anda Berhasil Logout<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>';

		$this->session->set_flashdata('logout_admin', $pesan);
		$this->session->unset_userdata('user_login');

		redirect('login','refresh');

	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */