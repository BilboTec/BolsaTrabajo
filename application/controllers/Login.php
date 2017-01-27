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
			}else{
				$data["email_o_clave_incorrectos"] = true;
			}
		}
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Login/FormularioLogin", $data);
		$this->load->view("/plantillas/footer", $data);
	}

	public function RecordarClave(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Login/RecordarClave", $data);
		$this->load->view("/plantillas/footer", $data);
	}
	
	public function EnviarIdentificador(){
		$this->lang->load("BT_email");
		$this->form_validation->set_rules("email", $this->lang->line("email"), "required|trim|valid_email");
		if(/*$this->form_validation->run()*/true){
			$this->load->model("BT_Modelo_Identificador_Clave", "ids");
			$this->load->helper("bt_email");
			$email = $this->input->get("email");
			$identificador = $this->ids->crear($email);
			$link = "http://" .$_SERVER["SERVER_NAME"]."/Login/CambiarClave/?I=" .$identificador;
			$link = "<a href='.$link'>$link</a>";
			$asunto = $this->lang->line("asunto_email_recordar_clave");
			$mensaje = sprintf($this->lang->line("cuerpo_email_recordar_clave"), $link);
			enviar_email($this, $email, $asunto, $mensaje);
			echo "ok";
		}
		else{
			var_dump($this->input->get());
			echo "no";
		}
	}
	
	public function CambiarClave(){
		$this->load->model("BT_Modelo_Identificador_Clave", "ids");
		$metodo = $this->input->method(true);
		if($metodo === "POST"){
			$identificador = $this->input->post("identificador");
			$nueva_clave = $this->input->post("claveNueva");
			$repetir_clave = $this->input->post("repetirClave");
			$exito = false;
			if($this->ids->comprobar($identificador) && $repetir_clave === $nueva_clave && $nueva_clave){
				$modelos = [$this->empresas, $this->alumnos, $this->profesores];
					var_dump($modelos);
				foreach ($modelos as $modelo) {
					$usuario = $modelo->query(["id_email"=>$identificador["id_email"]]);
					var_dump($usuario);
					if(count($usuario) > 0){
						var_dump($usuario);
						$usuario[0]->establecer_clave($nueva_clave);
						var_dump($usuario);
						$modelo->update($usuario[0], $usuario[0]);
						$exito = true;
					} 
				}
			}
			if($exito){
				$this->output->set_content_type("application/json")
				->set_output(json_encode(["mesaje"=>"ok"]));
			}
			else{
				set_status_header(400);
				$this->output->set_content_type("application/json")
				->set_output(json_encode(["mesaje"=>"ohhh:("]));
			}
		}
		else{
			$identificador = $this->ids->obtener($this->input->get("I"));
			if($identificador != null){
				$data["idioma"] = function($clave){
					return $this->lang->line($clave);
				};
				$data["identificador"] = $identificador;
				$this->load->view("/plantillas/header", $data);
				$this->load->view("/Login/CambiarClave", $data);
				$this->load->view("/plantillas/footer", $data);
			}
			else{
				/*redirect("/Login/RecuperarClave");*/
			}
		}
	}

}
