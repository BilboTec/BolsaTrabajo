<?php 
require_once "BT_Controlador_api_estandar.php";
class Empresas extends BT_Controlador_api_estandar {
	public function __construct(){
		parent::__construct("BT_Modelo_Empresa","id_empresa");
	}
	public function SignUp(){
		$respuesta = new stdClass();
		$metodo = $this->input->method(true);
		if($metodo === "POST"){
			$string_identificador = $this->input("identificador_alta");
			$this->load->model("BT_Modelo_IdentificadorAlta","identificadores");
			$identificador_alta = $this->obtenerIdentificadorAlta($string_identificador);
			if($identificador_alta!==null){
				$empresa = new _Empresa();
				$reglas_validacion = $empresa->get_reglas_validacion();
				
			}else{
				$this->output->set_status_header(303);
				$respuesta->error = "Acceso denegado";
				$this->json($respuesta,403);
			}
		}else{
			$respuesta->error = "Ésta acción no soporta el método GET";
			$this->json($respuesta,405);
		}
	}
	public function obtenerIdentificadorAlta($identificador){
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
	
	public function Buscar(){
		$filtros = $this->input->post("filtros");
		$empresas = $this->modelo->buscar($filtros);
		
	}

}