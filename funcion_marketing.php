<?php
function enviar_email($subject,$body_html,$grupo,$token,$body_plain){

//next example will insert new conversation
$service_url = 'http://192.168.6.57:5000/envios/guardar';
$curl = curl_init($service_url);

$curl_post_data = array(
	'subject' => $subject,
	'body_html' => $body_html,
	'fecha_envio' => date("Y-m-d H:i:s"),
	'grupo' => '4',
	'body_plain' => $body_plain,
	'file' => '1',
	'idcfrom' => '1',
	'idcreply' => '1',
	'name_from' => 'Comunicaciones',
	'name_reply' => 'Comunicaciones',
	'grupo' => $grupo,
	'token' => $token
);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('error occured: ' . $decoded->response->errormessage);
}
return 1;
//var_export($decoded->response);
}
?>