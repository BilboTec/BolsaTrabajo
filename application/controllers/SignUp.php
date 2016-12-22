<?php 
class SignUp extends BT_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("BT_Modelo_IdentificadorAlta","identificadores");
	}
	public function AltaEmpresa(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

			$empresa = $this->input->post("empresa");
			var_dump($this->input->post);
			die(json_encode($this->input->post()));
		$this->form_validation->set_rules([
				["field"=>"empresa.email","label"=>ucfirst($this->lang->line("email")),"rules"=>"required|valid_email"],
				["field"=>"empresa.nombre","label"=>ucfirst($this->lang->line("nombre")),"rules"=>"required"],
				["field"=>"empresa.clave","label"=>ucfirst($this->lang->line("clave")),"rules"=>"required"]
			]);
		if($this->form_validation->run()){
			$this->load->model("BT_Modelo_Empresa","empresas");
			$this->empresas->insert($empresa);
			redirect("/Login");
		}else{
			$this->load->model("BT_Modelo_Pais","paises");
			$this->load->model("BT_Modelo_Provincia","provincias");
			$data["paises"] = $this->paises->get();
			$data["es"] = $this->paises->query(["nombre"=>"España"])[0];
			$data["provincias"] = $this->provincias->get();
			$data["email"]=$this->input->post("empresa.email");			 	
			$this->load->view("/plantillas/header", $data);
			$this->load->view("/SignUp/altaEmpresa", $data);
			$this->load->view("/plantillas/footer", $data);
		}
	}
	public function empresa(){		
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$identificador = $this->input->get("I");
		if($identificador===null){
			/*El usuario no es una empresa que ha hecho click en el vínculo del email*/
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
				$vinculo = "http://BolsaTrabajo.local/SignUp/Empresa?I="
				.base64_encode($identificador->id_identificador ."#" .$identificador->identificador);
				$contenido = "Estimado $nombre:<br/>Hemos recibido su solicitud de alta, por favor haga click en el siguiente vínculo para continuar o copielo y pegelo en la barra de direcciones.<br/><a href='$vinculo'>$vinculo</a><br/>En caso de no haber solicitado el alta, por favor ignore éste email";
				mb_convert_encoding($contenido, "UTF-8");
				$this->email->subject('Confirmación alta');
				$this->email->message($contenido);
			
				$this->email->send();
			}
			$this->load->view("/plantillas/header", $data);
			$this->load->view("/SignUp/Empresa", $data);
			$this->load->view("/plantillas/footer", $data);
		}else{
			$identificador = explode("#",base64_decode($identificador));
			$identificador_alta = $this->identificadores->query(["id_identificador"=>$identificador[0],
			"identificador"=>$identificador[1]])[0];
			if($identificador_alta!==null){
				$this->load->model("BT_Modelo_Pais","paises");
				$this->load->model("BT_Modelo_Provincia","provincias");
				$data["paises"] = $this->paises->get();
				$data["es"] = $this->paises->query(["nombre"=>"España"])[0];
				$data["provincias"] = $this->provincias->get();
				$data["email"]=$identificador_alta->email;			 	
				$this->load->view("/plantillas/header", $data);
				$this->load->view("/SignUp/altaEmpresa", $data);
				$this->load->view("/plantillas/footer", $data);
			}else{
				die("Incorrecto");
			}
		}
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
