<?php
  function curl($url, $data){
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POST, true );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch); 
    curl_close($ch);      
    return $output;
}
$nrp 	   	= $request->post('nrp');
$kodeqr 	= $request->post('kodeqr');
// Data Parameter yang Dikirim oleh cURL
$data = array("nrp"=> $nrp,"kodeqr"=>$kodeqr);
$send = curl("http://localhost:8000/absensi",json_encode($data));
$result = json_decode($send, true);
			
?>