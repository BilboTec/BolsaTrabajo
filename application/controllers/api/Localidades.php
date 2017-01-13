<?php

require_once "BT_Controlador_api_estandar.php";

class Localidades extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Localidad", "id_localidad");
        
    }
	public function GetDeProvincia($id_provincia){
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->modelo->query(["id_provincia"=>$id_provincia])));
	}
    
    public function GetById($id){
    	$this->load->model("BT_Modelo_Provincia", "provincias");
    	$respuesta = new stdClass();
    	$respuesta->localidad = $this->modelo->get_by_id($id);
    	$respuesta->provincia = $this->provincias->get_by_id($respuesta->localidad->id_provincia);
    	$this->json($respuesta);
    }
}