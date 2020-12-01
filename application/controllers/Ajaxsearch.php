<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxsearch extends CI_Controller {

  public function index()
  {
    $this->load->view('ajaxsearch');
  }

  public function fetch()
  {
    $output = '';
    $query = '';
    $this->load->model('ajaxsearch_model');
    if($this->input->post('query'))
    {
     $query = $this->input->post('query');
   }
   $data = $this->ajaxsearch_model->fetch_data($query);
   $output .= '
   <div class="table-responsive">
   <table class="table table-bordered table-striped">
   <tr>
   <th>No</th>
   <th>Kode Ruang</th>
   <th>Nama Ruang</th>
   </tr>
   ';
   if($data->num_rows() > 0)
   {       
    $no=1;
    foreach($data->result() as $row)
    {
     $output .= '
     <tr>
     <td>'.$no.'</td>
     <td>'.$row->kode_ruang.'</td>
     <td>'.$row->nama.'</td>
     </tr>
     ';
     $no++;
   }
 }
 else
 {
   $output .= '<tr>
   <td colspan="4">No Data Found</td>
   </tr>';
 }
 $output .= '</table>';
 echo $output;
}

}
