<?php

class BT_Controller extends CI_Controller{
	
	protected $idioma,$roles;
	private function backup(){
		
	}	
	public function get_rol(){
		$usuario = $this->get_usuario_actual();
		if($usuario != null && isset($usuario->id_rol)){
			return $this->roles[($usuario->id_rol > 2?2:$usuario->id_rol)];
		}
		return null;
	}
	public function rol_id($rol){
		foreach($this->roles as $id => $nombre){
			if($nombre == $rol){
				return $id;
			}
		}
		return -1;
	}
	public function rol_nombre($rol_id){
		return isset($this->roles[$rol_id])?$this->roles[$rol_id]:null;
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
		$this->roles = [
			1 => $this->lang->line("rol1"),
			2 => $this->lang->line("rol2"),
			3 => $this->lang->line("rol3")
		];
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
					$usuario = $this->alumnos->get_by_id($id);
					break;
				case 1:
					$usuario = $this->empresas->get_by_id($id);
					break;
				case 2:
					$usuario = $this->profesores->get_by_id($id);
					break;
			}
		}
		return $usuario;
	}

	protected function es_admin(){
		$usuario = $this->get_usuario_actual();
		return isset($usuario->id_rol) && $usuario->id_rol > 2;
	}

 	protected function es_user(){
		$usuario = $this->get_usuario_actual();
		return isset($usuario->id_rol) && $usuario->id_rol == 1;
	}
	public function getActual(){
		$usuario = $this->get_usuario_actual();
		unset($usuario->clave);
		$this->json($usuario);

	}
}
