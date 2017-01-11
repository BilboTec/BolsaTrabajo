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
        $profesor_viejo = $this->get_usuario_actual()[0];

        if($profesor->id_profesor != $profesor_viejo->id_profesor){
        	$this->json("id identificador incorrecto", 400);
        }
        else{
            $this->modelo->update($profesor_viejo, $profesor);  
            $respuesta = new stdClass;
            $respuesta->mensaje = "ok";
            $this->json($respuesta);
        }
    }

    public function CambiarClave(){
    	$clave_vieja = $this->input->post("clave");
    	$profesor = $this->get_usuario_actual()[0];
    	if($profesor->verificar_clave($clave_vieja)){
    		$clave = $this->input->post("nuevaclave");
    	}
    }
}