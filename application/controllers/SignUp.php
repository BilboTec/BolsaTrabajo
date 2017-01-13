<?php 
class SignUp extends BT_Controller{
	protected $idioma;
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->model("BT_Modelo_IdentificadorAlta","identificadores");
		$this->lang->load("BT_email");
		$this->idioma =function ($clave){
				return $this->lang->line($clave);
			};
	}
	public function ConfirmarEmpresa(){
		$data["idioma"] = $this->idioma;
		$metodo = $this->input->method(true);
		if($metodo === "POST"){
			$this->form_validation->set_rules([
					[
						"field"=>"nombre",
						"caption"=>"Nombre",
						"rules"=>"trim|required"
					],
					[
						"field"=>"email",
						"caption"=>"Email",
						"rules"=>"trim|required|valid_email"
					]
				]);
			if($this->form_validation->run()){
				$identificador = new _IdentificadorAlta();
				$identificador->email = $this->input->post("email");
				$identificador = $this->identificadores->insert($identificador)[0];
				$link = $_SERVER["HTTP_ORIGIN"]."/SignUp/Empresa/?I" . base64_encode($identificador->id_identificador . "#" . $identificador->identificador);
				$link = "<a href='.$link'>$link</a>";
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

		        $this->email->initialize($config);


				$this->email->from('BilboTec.algo@gmail.com', 'CIFP Txurdinaga');
				$this->email->to($identificador->email);

				$this->email->subject($this->lang->line("asunto_confirmar_email"));
				$this->email->message(sprintf($this->lang->line("confirmar_email_empresa_cuerpo"),$this->input->post("nombre"),$identificador));

				$this->email->send();
			}else{
				$data["errores"] = $this->from_validation->error_array();
				$this->muestraSolicitudAltaEmpresa($data);
			}
		}
	}
	public function Empresa(){
		$data["idioma"] = $this->idioma;
		$data["errores"] = [];
		$metodo = $this->input->method(true);
		if($metodo=="GET"){
			/*Si venimos de get*/
			$identificador = $this->input->get("I");
			$data["identificador"] = $identificador;
			if($identificador!=null){
				/*1. Comprobamos que los datos del identificador sean correctos*/
				$identificador_alta = $this->obtenerIdentificadorAlta($identificador);
				if($identificador_alta!==null){
					/*Mostramos el formulario de alta para una nueva empresa*/
					$empresa = new _Empresa();
					$empresa->email = $identificador_alta->email;
					$data["empresa"] = $empresa;
					$this->muestraFormularioAltaEmpresa($data);
				}else{
					/*Muestra el dialogo de solicitud con un mensaje de error*/
					array_push($data["errores"],$this->idioma("identificador_alta_incorrecto"));
					$this->muestraSolicitudAltaEmpresa($data);
				}
			}else{
				/*Podemos suponer que el usuario viene de haber hecho click en la opción registrarse*/
				$this->muestraSolicitudAltaEmpresa($data);
			}
		}else{
			$empresa = new _Empresa();
			$empresa->fromPost($this);
			$data["empresa"] = $empresa;
			/*El usuario ha enviado el formulario de alta de la empresa*/
			$identificador = $this->input->post("I");
			$identificador_alta = $this->obtenerIdentificadorAlta($identificador);
			if($identificador_alta!==null){
				$this->form_validation->set_rules([
					[
						"field"=>"cif",
						"rules"=>"trim|callback_comprobar_cif"
					]
				]);
				if($this->form_validation_run()){
					$this->empresas->insert($empresa);
				}else{
					$this->muestraFormularioAltaEmpresa($data);
				}
			}else{
				/*Muestra el dialogo de solicitud con un mensaje de error*/
				array_push($data["errores"],$this->idioma("identificador_alta_incorrecto"));
				$this->muestraSolicitudAltaEmpresa($data);
			}
		}	
	}
	protected function comprobar_cif($cif){
		$cif = strtoupper($cif);
     
    $cifRegEx1 = '/^[ABEH][0-9]{8}$/i';
    $cifRegEx2 = '/^[KPQS][0-9]{7}[A-J]$/i';
    $cifRegEx3 = '/^[CDFGJLMNRUVW][0-9]{7}[0-9A-J]$/i';
     
    if (preg_match($cifRegEx1, $cif) || preg_match($cifRegEx2, $cif) || preg_match($cifRegEx3, $cif)) {
        $control = $cif[strlen($cif) - 1];
        $suma_A = 0;
        $suma_B = 0;
         
        for ($i = 1; $i < 8; $i++) {
            if ($i % 2 == 0) $suma_A += intval($cif[$i]);
            else {
                $t = (intval($cif[$i]) * 2);
                $p = 0;
                 
                for ($j = 0; $j < strlen($t); $j++) {
                    $p += substr($t, $j, 1);
                }
                $suma_B += $p;
            }
        }
         
        $suma_C = (intval($suma_A + $suma_B)) . "";
        $suma_D = (10 - intval($suma_C[strlen($suma_C) - 1])) % 10;
         
        $letras = "JABCDEFGHI";
         
        if ($control >= "0" && $control <= "9") return ($control == $suma_D);
        else return (strtoupper($control) == $letras[$suma_D]);
    }
    else return false;
	}
	protected function muestraSolicitudAltaEmpresa($data=[]){
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/SignUp/empresa", $data);
		$this->load->view("/plantillas/footer", $data);
	}

	/*
	*Intenta Obtener el identificador de alta de la base de datos, devuelve null en caso de no encontrarlo
	*/
	protected function obtenerIdentificadorAlta($identificador){
		$identificador = explode("#",base64_decode($identificador));
		if(count($identificador)>0){
					$id_identificador = $identificador[0];
					$identificador = $identificador[1];
					/*Obtenemos un identificador con esa id y fecha, de la cual no haya pasado mas de un día*/
					$identificador_alta = $this->identificadores->query([
						"id_identificador"=>$id_identificador,
						"identificador"=>$identificador,
						"identificador <="=>$identificador . " ADD INTERVAL 1 DAY"
						]);
					$identificador_alta = count($identificador_alta>0)?$identificador_alta[0]:null;
		}else{
			$identificador_alta = null;
		}
		return $identificador_alta;
	}
	protected function muestraFormularioAltaEmpresa($data=[]){
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/SignUp/altaEmpresa", $data);
		$this->load->view("/plantillas/footer", $data);
	}
	
	public function alumno(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/SignUp/alumno", $data);
		$this->load->view("/plantillas/footer", $data);
	}
}
