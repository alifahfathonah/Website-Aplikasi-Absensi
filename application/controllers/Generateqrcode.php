<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generateqrcode extends CI_Controller {

  public function __construct()
  {   
    parent::__construct();
    $this->load->library('Pdf');
  }

  public function cariruangan() 
  {

  }

  public function buatkodeqr()
  {

    $kode_ruangan = $this->input->post('kode_ruangan');
    $nama_ruangan = $this->input->post('nama_ruangan');

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './kodeqr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)

        $this->ciqrcode->initialize($config);

        $kode_qr = $kode_ruangan.'.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] 	= $kode_ruangan; //data yang akan di jadikan QR CODE
        $params['level'] 	= 'H'; //H=High
        $params['size'] 	= 20;
        $params['savename'] = FCPATH . $config['imagedir'] . $kode_qr; //simpan image QR CODE ke folder assets/images/

        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data_ruangan = array(
        	'kode_ruang'=> $kode_ruangan,
        	'nama' 		=> $nama_ruangan,
        );

        $this->db->insert('tb_ruang', $data_ruangan);
        redirect('page/back_view/kodeqr','refresh');

      }

      public function hapusruangan() 
      {

       $kode_ruang = $this->input->get_post('kode_ruang');
       $file_qr = $kode_ruang.'.png';

       $this->db->where('kode_ruang', $kode_ruang);
       $this->db->delete('tb_ruang');
       $path_qr = FCPATH . './kodeqr/'.$file_qr;
       unlink( $path_qr );

     }

     public function cetakkodeqr()
     {

      $this->load->view('Kodeqrpdf');

    }

  }

  /* End of file Generateqrcode.php */
/* Location: ./application/controllers/Generateqrcode.php */