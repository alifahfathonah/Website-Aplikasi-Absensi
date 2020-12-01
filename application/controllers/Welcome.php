<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function unduh_spb($nik)
	{

        $this->db->where('nim', $nik);
        $data_nik = $this->db->get('tb_mahasiswa');

        if( $data_nik->num_rows() > 0 ) {
            // load view atau query spb berdasarkan nik
            $this->load->view('back_page/page_notification');        
        } else {
            $this->load->view('back_page/v_login');
        }


    }

    public function tambah_produk()
    {

        $files = $_FILES;
        $count = count($_FILES['userfile']['name']);
        $upload_foto = array();

        for($i=0; $i<$count; $i++) {           
            $_FILES['userfile']['name']     = $files['userfile']['name'][$i];
            $_FILES['userfile']['type']     = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error']    = $files['userfile']['error'][$i];
            $_FILES['userfile']['size']     = $files['userfile']['size'][$i];
            
            $config['upload_path'] = './assets/products/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']  = '10000';
            $config['max_width']  = '10240';
            $config['max_height']  = '7680';

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('userfile')) {
            // echo $this->upload->display_errors();
            }else {

                $upload_foto[] = $this->upload->data();

                $img[] = $upload_foto[$i]['file_name'];
                $hasil = json_encode( $img );

                $data = array(
                    'produk_foto' => $hasil,
                );     
            }
        }
        $this->db->insert('tb_produk', $data);
        redirect('page_admin/view/data','refresh');
    }


}

/* End of file Welcome.php */
/* Location: ./application/controllers/Welcome.php */