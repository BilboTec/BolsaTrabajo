<?php

require_once "BT_Controlador_api_estandar.php";

class Profesores extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Profesor", "id_profesor");
        
    }
    
    public function GuardarPerfil(){
    	$profesor = new _Profesor();
        $profesor->fromPost($this);
        $profesor_viejo = $this->get_usuario_actual();

        if($profesor->id_profesor != $profesor_viejo->id_profesor){
        	$this->json("id identificador incorrecto", 400);
        }
        else{
            try{
            $this->modelo->update($profesor_viejo, $profesor);  
                $respuesta = new stdClass;
                $respuesta->mensaje = "ok";
                $this->json($respuesta);
            }
            catch(Exception $ex){
                $error_msg = $this->lang->line($ex->getMessage());
                $this->json(["error"=>$error_msg?$error_msg:$ex->getMessage()],400);
            }
        }
    }

    public function CambiarClave(){
    	$this->form_validation->set_rules([
    		["field"=>"clave", "caption"=>"contraseña actual", "rules"=>"trim|required"],
    		["field"=>"nuevaclave", "caption"=>"contraseña nueva", "rules"=>"trim|required|callback_claves_iguales"],
    		["field"=>"repetirclave", "caption"=>"repetir contraseña", "rules"=>"trim|required"]
    		]);
    	if($this->form_validation->run()){
	    	$clave_vieja = $this->input->post("clave");
	    	$profesor = $this->get_usuario_actual();
	    	if($profesor->verificar_clave($clave_vieja)){
	    		$clave = $this->input->post("nuevaclave");
	    		$profesor->establecer_clave($clave);
	    		$this->modelo->update($profesor, $profesor);
	    		$respuesta = new stdClass();
	    		$respuesta->mensaje = "ok";
	    		$this->json($respuesta);
	    	}
	    	else{
	    		$respuesta = new stdClass();
	    		$respuesta->mensaje = "clave incorrecta";
	    		$this->json($respuesta, 400);
	    	}
    	}
    	else{
    		$this->json($this->form_validation->error_array(),400);
    	}
    }

    public function claves_iguales($nuevaclave){
    	$clave_repetida = $this->input->post("repetirclave");
    	if($nuevaclave == $clave_repetida){
    		return true;
    	}
    	$this->form_validation->set_message("claves_iguales", "las contraseñas deben ser iguales");
    }
	
	public function anadirEmpresa(){
		$empresa = new _Empresa();
        $empresa->fromPost($this);
        $usuario = $this->get_usuario_actual();
		
		if(isset($usuario->id_profesor)){
			$this->modelo->Insert();
			$respuesta = new stdClass();
	    	$respuesta->mensaje = "ok";
	    	$this->json($respuesta);
	    }
	    else
	    {
	    	$respuesta = new stdClass();
	    	$respuesta->mensaje = "no tiene privilegios";
	    	$this->json($respuesta, 400);
	    }
	}
}