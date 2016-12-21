<?php

class Login extends BT_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}
	
	public function index(){
		$this->form_validation->set_rules(array(
		array('field'=>'email', 'label'=>ucfirst($this->lang->line('email')), 'rules'=>'required|valid_email'),
		array('field'=>'clave', 'label'=>ucfirst($this->lang->line('clave')), 'rules'=>'required')
		));
		
		$this->form_validation->set_error_delimiters("<li class='error'>", "</li>");
		
		
		if($this->form_validation->run()){
			$email = $this->input->post("email");
			$clave = $this->input->post("clave");
			$tipo = $this->input->post("tipo");
			$url ="";
			switch ($tipo) {
				case 0:
					$usuario = $this->alumnos->get_by_email($email);
					$url = "/Alumno";
					break;
					
				case 1:
					$usuario = $this->empresas->get_by_email($email);
					$url = "/Empresa";
					break;
				
				case 2:
					$usuario = $this->profesores->get_by_email($email);
					$url = "/Profesor";
					break;

			}
			
			if($usuario !==null && $usuario->verificar_clave($clave)){
				$this->session->set_userdata("id", $usuario->get_id());
				$this->session->set_userdata("tipo", $tipo);
				redirect($url);
			}	
		}
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Login/FormularioLogin", $data);
		$this->load->view("/plantillas/footer", $data);
	}
}
