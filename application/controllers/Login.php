<?php

class Login extends BT_Controlador{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}
	
	public function index(){
		$this->form_validation->set_rules(array(
		array('field'=>'email', 'label'=>'Email', 'rules'=>'required'),
		array('field'=>'email', 'label'=>'Contraseña', 'rules'=>'required')
		));
		
		$this->form_validation->set_error_delimiters("<li class='error'>", "</li>");
		
		$email = $this->input->post->email;
		$clave = $this->input->post->clave;
		$tipo = $this->input->post->tipo;
		if($this->form_validation->run()){
			switch ($tipo) {
				case 0:
					$usuario = $this->alumnos->get_by_email($email);
					break;
					
				case 1:
					$usuario = $this->empresas->get_by_email($email);
					break;
				
				case 2:
					$usuario = $this->profesores->get_by_email($email);
					break;

			}
			
			if($usuario->verificar_clave($clave)){
				$this->session->set_userdata("id", $usuario->get_id());
				$this->session->set_userdata("tipo", $tipo);
			}
			
		}
		else{
			$this->load->view("/plantillas/header");
			$this->load->view("/Login/FormularioLogin");
			$this->load->view("/plantillas/footer");
		}
	}
}
