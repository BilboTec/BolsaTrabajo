<?php

class Empresa extends BT_Controller{
	public function __construct(){
		parent::__construct();
		$this->requerir_login();
		switch($this->session->tipo){
			case 0:
				redirect("/Alumno");
				break;
			case 2:
				redirect("/Profesor");
				break;
		}
	}
	public function index(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

		$data['activo'] = "ofertas";

		
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Empresa/menu", $data);
		$this->load->view("/Empresa/ofertas", $data);
		$this->load->view("/plantillas/footer", $data);
	}
	
	public function perfil(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

		$data['activo'] = "perfil";

		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Empresa/menu", $data);
		$this->load->view("/Empresa/perfil", $data);
		$this->load->view("/plantillas/footer", $data);
	}
}
