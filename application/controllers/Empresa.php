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
		$data["user"] = $this->get_usuario_actual();
		
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Empresa/menu", $data);
		$this->load->view("/Empresa/ofertas", $data);
		$this->load->view("/plantillas/footer", $data);
	}
	
	public function perfil(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

		$this->load->model("BT_Modelo_Pais","paises");
		$this->load->model("BT_Modelo_Provincia","provincias");
		$data['paises'] = $this->paises->get();
		$data["espana"] = $this->paises->query(["nombre"=>"España"])[0];
		$data['provincias'] = $this->provincias->get();
		$data['activo'] = "perfil";
		$data["user"] = $this->get_usuario_actual();
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Empresa/menu", $data);
		$this->load->view("/Empresa/perfil", $data);
		$this->load->view("/plantillas/footer", $data);
	}
}
