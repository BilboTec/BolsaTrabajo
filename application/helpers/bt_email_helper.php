<?php 
function enviar_email($controlador,$to,$asunto,$mensaje){
	$config = Array(
 				    'protocol' => 'smtp',
 				    'smtp_host' => 'ssl://smtp.googlemail.com',
 				    'smtp_port' => 465,
 				    'smtp_user' => 'BilboTec.algo@gmail.com',
 				    'smtp_pass' => 'q1w2e3R4',
 				    'mailtype'  => 'html', 
 				    'charset'   => 'utf-8'
 				);
	$controlador->load->library('email', $config);
	$controlador->email->set_newline("\r\n");
	$controlador->email->initialize($config);
	$controlador->email->from('BilboTec.algo@gmail.com', 'CIFP Txurdinaga');
	$controlador->email->to($to);

	$controlador->email->subject($asunto);
	$controlador->email->message($mensaje);

	$controlador->email->send();
}