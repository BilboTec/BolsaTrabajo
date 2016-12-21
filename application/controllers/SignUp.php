<?php 
class SignUp extends BT_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("BT_Modelo_IdentificadorAlta","identificadores");
	}
	public function empresa(){
		$this->form_validation->set_rules(array(
		array('field'=>'email', 'label'=>ucfirst($this->lang->line('email')), 'rules'=>'required|valid_email'),
		array('field'=>'nombre', 'label'=>ucfirst($this->lang->line('nombre')), 'rules'=>'required')
		));
		if($this->form_validation->run()){
			$config = Array(
				    'protocol' => 'smtp',
				    'smtp_host' => 'ssl://smtp.googlemail.com',
				    'smtp_port' => 465,
				    'smtp_user' => 'BilboTec.algo@gmail.com',
				    'smtp_pass' => 'q1w2e3R4',
				    'mailtype'  => 'html', 
				    'charset'   => 'utf-8'
				);
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
			$nombre = $this->input->post("nombre");
			$email = $this->input->post("email");
			$this->email->from('your@example.com', 'FPTXURDINAGA: Bolsa de Trabajo');
			$this->email->to($email);
			$identificador = new _IdentificadorAlta();
			$identificador->email = $email;
			$identificador->identificador = new DateTime();
			$identificador = $this->identificadores->insert($identificador)[0];
			$vinculo = "http://BolsaTrabajo.local/Empresa/Alta?"
			.md5($identificador->id_identificador ."#" .$identificador->identificador);
			$contenido = "Estimado $nombre:<br/>Hemos recibido su solicitud de alta, por favor haga click en el siguiente vínculo para continuar o copielo y pegelo en la barra de direcciones.<br/><a href='$vinculo'>$vinculo</a><br/>En caso de no haber solicitado el alta, por favor ignore éste email";
			mb_convert_encoding($contenido, "UTF-8");
			$this->email->subject('Confirmación alta');
			$this->email->message($contenido);
		
			$this->email->send();
		}
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/SignUp/Empresa", $data);
		$this->load->view("/plantillas/footer", $data);
	}
	
	public function alumno(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/SignUp/Alumno", $data);
		$this->load->view("/plantillas/footer", $data);
	}
}
