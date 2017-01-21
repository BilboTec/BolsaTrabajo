<?php

require_once "BT_Controlador_api_estandar.php";

class Provincias extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Provincia", "id_provincia");
        
    }
    public function GetByLocalidad($id_localidad){
    	$this->load->model("BT_Modelo_Localidad", "localidades");
    	$respuesta = new stdClass();
    	$respuesta->localidad = $this->localidades->get_by_id($id_localidad);
        $respuesta->provincia = $this->modelo->get_by_id($respuesta->localidad->id_provincia);
    	$this->json($respuesta);
    }
    
}