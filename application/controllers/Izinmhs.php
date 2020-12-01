<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Izinmhs extends CI_Controller {

	public function index()
	{
		$data_izin = $this->db->query('
			SELECT DISTINCT
			datamahasiswa.nama,
			izin.nrp, kelas.kelas,
			concat(date_format(izin.tanggal, "%d-%m-%Y")) as tanggal,
			matakuliah.matakuliah, izin.file_upload,
			izin.alasan
			FROM 
			izin, absensi_mahasiswa, kuliah, matakuliah, kelas, datamahasiswa
			WHERE
			datamahasiswa.nomor   	 = absensi_mahasiswa.mahasiswa AND
			izin.absen_id  	 	  	 = absensi_mahasiswa.nomor AND
			absensi_mahasiswa.kuliah = kuliah.nomor AND
			kuliah.matakuliah		 = matakuliah.nomor AND
			kuliah.kelas			 = kelas.nomor AND
			izin.status = "Approved"
			')->result();
			//tb_jadwal.minggu
		$data['izins'] = $data_izin;

		$this->template->content->view('back_page/page/page_izin', $data, FALSE );
		$this->template->publish('back_page/back_template');
	}

	public function cari_izin() {

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

		$q_pertemuan = '';
		if( isset( $pertemuan ) ) {
			$q_pertemuan = " AND tb_jadwal.minggu = '$pertemuan' ";
		} //Belum Diperbaiki

		$data_izin = $this->db->query('
			SELECT 
			datamahasiswa.nama, 
			izin.nrp, kelas.kelas, 
			concat(date_format(izin.tanggal, "%d-%m-%Y")) as tanggal,
			matakuliah.matakuliah, izin.file_upload,
			izin.alasan
			FROM izin, absensi_mahasiswa, kuliah, matakuliah, kelas, datamahasiswa
			WHERE
			datamahasiswa.nomor   	 = absensi_mahasiswa.mahasiswa AND
			izin.absen_id		  	 = absensi_mahasiswa.nomor AND
			absensi_mahasiswa.kuliah = kuliah.nomor AND
			kuliah.matakuliah  		 = matakuliah.nomor AND
			kuliah.kelas 			 = kelas.kelas
			'. $q_kelas .' '. $q_matakuliah .' '. $q_pertemuan .'
			')->result();
			//tb_jadwal.minggu,
		$data['izins'] = $data_izin;

		$this->template->content->view('back_page/page/page_izin', $data, FALSE );
		$this->template->publish('back_page/back_template');

	}
	
	public function list_matkul() {

		$get_kelas = $this->input->get('kelas');

		$data_matkul = $this->db->query('
			SELECT DISTINCT matakuliah.matakuliah
			FROM matakuliah, kuliah, kelas
			WHERE
			kuliah.matakuliah  	= matakuliah.nomor AND
			kuliah.kelas	 	= kelas.nomor AND
			kelas.kelas			= "'.$get_kelas.'"
			')->result();

		echo '<option selected="" disabled="">--Pilih Matakuliah--</option>';
		foreach ($data_matkul as $matkul) {
			echo '<option>'.$matkul->matakuliah.'</option>';
		}

	}
}

/* End of file Izinmhs.php */
/* Location: ./application/controllers/api/Izinmhs.php */