<?php

class BT_Controller extends CI_Controller{
	
	protected $idioma;
	
	public function get_rol(){
		$usuario = $this->get_usuario_actual();
		$rol = ["ver", "editar", "admin"];
		if($usuario != null && isset($usuario->id_rol)){
			return $rol[($usuario->id_rol > 2?2:$usuario->id_rol)];
		}
		return null;
	}
	
	
	public function __construct(){
		parent::__construct();
		$this->load->model("BT_Modelo_Profesor", "profesores");
		$this->load->model("BT_Modelo_Alumno", "alumnos");
		$this->load->model("BT_Modelo_Empresa", "empresas");
		$this->load->helper("url");
		$this->load->helper("BT_ui_helper");
		$this->load->library("session");
		$this->load->helper("cookie");
		$this->idioma = get_cookie("idioma");
		if($this->idioma==null){
			$this->idioma = "spanish";
		}
		$this->lang->load('form_validation', $this->idioma);
		$this->lang->load('general', $this->idioma);
		$this->config->set_item('language', $this->idioma);
	
	}
	 public function requerir_login(){
	 		if($this->get_usuario_actual()===null){
			redirect("/Login");
		}
	 }
	 public function requerir_login_json(){
		 if($this->get_usuario_actual()===null){
			 set_status_header(302);
			 die(ucfirst($this->lang->line("api_acceso_denegado")));
		 }
	 }
	public function get_usuario_actual(){
		$id = $this->session->id;
		$tipo = $this->session->tipo;
		$usuario = null;
		if($id!==null){
			switch($tipo){
				case 0:
					$usuario = $this->alumnos->get($id);
					break;
				case 1:
					$usuario = $this->empresas->get($id);
					break;
				case 2:
					$usuario = $this->profesores->get($id);
					break;
			}
		}
		return $usuario;
	}
}
