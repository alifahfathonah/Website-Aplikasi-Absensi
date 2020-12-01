<?php
if( $this->input->get('kode_ruang') ) {
	$data_kodeqr = $this->db->get_where('tb_ruang', array('kode_ruang' => $this->input->get('kode_ruang')))->row();
}

$data = '<div style="text-align: center;">
<img style="width: 70px; height: 70px;" src="http://localhost/absensiqr/kodeqr/poliwangi_logo.png"/>
<p style="font-size: 12px;">Politeknik Negeri Banyuwangi</p>

<h1 style="font-size: 30px;">PINDAI KODE QR</h1>

<img style="width: 350px; height: 350px;" border="5" src="http://localhost/absensiqr/kodeqr/'.$data_kodeqr->kode_ruang.'.png"/>
</div>';
$data .= '<div style="text-align: center;"><h1 style="font-size: 25px;">'.$data_kodeqr->nama.'</h1>
<p style="font-size: 14px;">Pastikan aplikasi diberi akses kamera agar dapat melakukan pemindaian</p>
</div>';


$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Cetak Kode QR');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Admin');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();

$pdf->WriteHTML( $data );

$pdf->Output('kode_qr_'.$data_kodeqr->nama.'.pdf', 'I');
?>