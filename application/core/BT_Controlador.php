<?php

class BT_Controlador extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model("BT_Modelo_Profesor", "profesores");
		$this->load->model("BT_Modelo_Alumno", "alumnos");
		$this->load->model("BT_Modelo_Empresa", "empresas");
		$this->load->helper("url");
		$this->load->library("session");
		
	}
	public function requerir_login(){
		if($this->get_usuario_actual()===null){
			redirect("/Login");
		}
	}
	public function get_usuario_actual(){
		$id = $this->session->id;
		$tipo = $this->session->tipo;
		$usuario = null;
		if($id!==null){
			switch($tipo){
				case 0:
					//Coger de alumno
					break;
				case 1:
					//Coger de empresa
					break;
				case 2:
					$usuario = $this->profesores->get($id);
					break;
			}
		}
		return $usuario;
	}
}
