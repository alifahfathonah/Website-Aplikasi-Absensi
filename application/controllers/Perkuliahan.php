<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perkuliahan extends CI_Controller {

	public function index()
	{
		// DB LUMEN_ABSENSI VERSION
		$data_jadwal = $this->db->query('
			SELECT DISTINCT
			pegawai.nama AS dosen,
			matakuliah.matakuliah,
			kelas.kelas,
			ruang.keterangan AS ruangan,
			concat( kuliah.hari, ", ", date_format( kuliah.tglujian, "%d-%m-%Y" ) ) AS hari
			FROM
			datamahasiswa,kuliah,matakuliah,ruang,pegawai,kelas 
			WHERE
			kuliah.matakuliah = matakuliah.nomor AND 
			kuliah.dosen = pegawai.nomor AND
			kuliah.kelas = kelas.nomor AND
			kuliah.ruang = ruang.nomor
			GROUP BY matakuliah.matakuliah, kelas.kelas
			ORDER BY kelas.kelas
			')->result(); 
			// concat( date_format( tb_jam.jam_masuk, "%H:%i" ), " - ", date_format( tb_jam.jam_keluar, "%H:%i" ) ) AS jam 	
			// tb_jadwal.minggu,	tb_jam, 	AND tb_jadwal.jam_id = tb_jam.jam_id  ,tb_jadwal.tanggal
		
		$data['jadwals'] = $data_jadwal;

		$this->template->content->view('back_page/page/page_perkuliahan', $data, FALSE );
		$this->template->publish('back_page/back_template');

	}

	public function cari_jadwal() 
	{

		$kelas 		= $this->input->post('kelas');
		$matakuliah = $this->input->post('matakuliah');
		$pertemuan 	= $this->input->post('pertemuan');

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
		} // BELUM DIPERBAIKI

		$data_jadwal = $this->db->query('
			SELECT DISTINCT
			pegawai.nama AS dosen,
			matakuliah.matakuliah,
			kelas.kelas,
			ruang.nama AS ruangan,
			concat( kuliah.hari, ", ", date_format( kuliah.tglujian, "%d-%m-%Y" ) ) AS hari,
			FROM
			datamahasiswa,
			kuliah,
			matakuliah,
			ruang,
			pegawai,
			kelas 
			WHERE
			kuliah.matakuliah = matakuliah.nomor 
			AND kuliah.dosen = pegawai.nomor 
			AND kuliah.kelas = kelas.nomor 
			AND kuliah.ruang = ruang.nomor
			'. $q_kelas .' '. $q_matakuliah .' '. $q_pertemuan .'
			ORDER BY kelas.kelas, kuliah.tglujian
			')->result();

		$data['jadwals'] = $data_jadwal;

		$this->template->content->view('back_page/page/page_perkuliahan', $data, FALSE );
		$this->template->publish('back_page/back_template');


	}

}

/* End of file Perkuliahan.php */
/* Location: ./application/controllers/Perkuliahan.php */