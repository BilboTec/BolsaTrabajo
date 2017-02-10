<?php 
function enviar_email($controlador,$to,$asunto,$mensaje){
	$config = Array(
 				    'protocol' => 'smtp',
 				    'smtp_host' => $controlador->email_conf->host,
 				    'smtp_port' => $controlador->email_conf->port,
 				    'smtp_user' => $controlador->email_conf->user,
 				    'smtp_pass' => $controlador->email_conf->pass,
 				    'mailtype'  => 'html',
 				    'charset'   => 'utf-8'
 				);
	$controlador->load->library('email', $config);
	$controlador->email->set_newline("\r\n");
	$controlador->email->initialize($config);
	$controlador->email->from($controlador->email_conf->user, 'CIFP Txurdinaga');
	$controlador->email->to($to);

	$controlador->email->subject($asunto);
	$controlador->email->message($mensaje);

	$controlador->email->send();
}