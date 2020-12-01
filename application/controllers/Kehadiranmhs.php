<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kehadiranmhs extends CI_Controller {

	public function index()
	{	
		//DB lUMEN_ABSENSI VERSION
		$data_absensi = $this->db->query('
			SELECT datamahasiswa.nrp, 
			concat(date_format(absensi_mahasiswa.tanggal, "%d-%m-%Y")) as tanggal,
			kelas.kelas as kelas,
			matakuliah.matakuliah,
			absensi_mahasiswa.status
			FROM absensi_mahasiswa,kuliah,matakuliah,kelas,datamahasiswa
			WHERE 
			absensi_mahasiswa.status 	= "Hadir" AND
			absensi_mahasiswa.kuliah	= kuliah.nomor AND
			kuliah.kelas		 		= kelas.nomor AND
			kuliah.matakuliah 			= matakuliah.nomor AND
			datamahasiswa.nomor			= absensi_mahasiswa.mahasiswa
			ORDER BY absensi_mahasiswa.nomor asc
			')->result();
			// 	tb_jadwal.minggu

		$data['absensis'] = $data_absensi;

		$this->template->content->view('back_page/page/page_absensi', $data, FALSE );
		$this->template->publish('back_page/back_template');
	}

	public function cari_absen() 
	{
		$kelas = $this->input->post('kelas');
		$matakuliah = $this->input->post('matakuliah');
		$pertemuan = $this->input->post('pertemuan');


		$q_kelas = '';
		if( isset( $kelas ) ) {
			$q_kelas = " AND kelas.kelas = '$kelas' ";
		}

		$q_matakuliah = '';
		if( isset( $matakuliah ) ) {
			$q_matakuliah = " AND matakuliah.matakuliah = '$matakuliah' ";
		}

		// $q_pertemuan = '';
		// if( isset( $pertemuan ) ) {
		// 	$q_pertemuan = " AND tb_jadwal.minggu = '$pertemuan' ";
		// }  //BELUM DIPERBAIKI

		$data_absensi = $this->db->query('
			SELECT datamahasiswa.nrp, 
			concat(date_format(absensi_mahasiswa.tanggal, "%d-%m-%Y")) as tanggal,
			kelas.kelas,
			matakuliah.matakuliah,
			absensi_mahasiswa.status,

			FROM absensi_mahasiswa,kuliah,matakuliah,kelas,datamahasiswa
			WHERE 
			absensi_mahasiswa.status 	= "Hadir" AND
			kuliah.kelas		 		= kelas.nomor AND
			absensi_mahasiswa.kuliah	= kuliah.nomor AND
			kuliah.matakuliah	 		= matakuliah.nomor AND
			datamahasiswa.nomor 		= absensi_mahasiswa.mahasiswa
			'. $q_kelas .' '. $q_matakuliah .' '. $q_pertemuan .'
			ORDER BY minggu asc
			')->result(); //tb_jadwal.minggu

		$data['absensis'] = $data_absensi;

		$this->template->content->view('back_page/page/page_absensi', $data, FALSE );
		$this->template->publish('back_page/back_template');	
	}

	public function list_matkul() {

		$get_kelas = $this->input->get('kelas');

		$data_matkul = $this->db->query('
			SELECT DISTINCT matakuliah.matakuliah
			FROM matakuliah, kuliah, kelas
			WHERE
			kuliah.matakuliah  	= matakuliah.nomor AND
			kuliah.kelas		= kelas.nomor AND
			kelas.kelas			= "'.$get_kelas.'"
			')->result();

		echo '<option selected="" disabled="">--Pilih Matakuliah--</option>';
		foreach ($data_matkul as $matkul) {
			echo '<option>'.$matkul->matakuliah.'</option>';
		}

	}

}

/* End of file Kehadiranmhs.php */
/* Location: ./application/controllers/Kehadiranmhs.php */