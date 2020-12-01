<?php
class Ajaxsearch_model extends CI_Model
{
 function fetch_data($query)
 {
  $this->db->select("*");
  $this->db->from("tb_ruang");
  if($query != '')
  {
   $this->db->like('nama', $query);
   $this->db->or_like('kode_ruang', $query);
 }
 $this->db->order_by('rg_id', 'DESC');
 return $this->db->get();
}
}
?>
