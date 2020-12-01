<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	public function index() 
	{
		//DB LUMEN_ABSENSI VERSION
		$data_mhs = $this->db->query('
			SELECT DISTINCT 
			datamahasiswa.nrp, datamahasiswa.nama, 
			kelas.kelas, kelas.paralel
			FROM
			datamahasiswa, kuliah, kelas
			WHERE
			datamahasiswa.kelas = kelas.nomor AND
			kuliah.kelas 		= kelas.nomor
			')->result();

		$data['mhss'] = $data_mhs;

		$this->template->content->view('back_page/page/page_mahasiswa', $data, FALSE );
		$this->template->publish('back_page/back_template');

	}

	public function editimei()
	{
		
		$imei = $this->input->post('imei');
		$nim = $this->input->post('nim');

		if ( strlen( $imei ) == 0 || '' ) {
			$data = array(
				'imei' => NULL
			);
		} else {

			$data = array(
				'imei' => $imei
			);
		}

		$this->db->where('nim', $nim);
		$this->db->update('tb_mahasiswa', $data);

		// redirect('page/back_view/mahasiswa','refresh');
	}

}

/* End of file Mahasiswa.php */
/* Location: ./application/controllers/Mahasiswa.php */