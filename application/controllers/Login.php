<?php

class Login extends CI_Controller{
	public function index(){
		$this->load->view("/plantillas/header");
		$this->load->view("/Login/FormularioLogin");
		$this->load->view("/plantillas/footer");
	}
}
