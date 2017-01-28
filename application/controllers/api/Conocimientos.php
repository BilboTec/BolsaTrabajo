<?php

require_once "BT_Controlador_api_estandar.php";

class Conocimientos extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Conocimiento", "id_conocimiento");
        
    }
    public function Like(){
    	$nombre = $this->input->get("texto");
        echo json_encode($this->modelo->get_like($nombre));
    }
    public function GetFromOferta($id_oferta){
    	$this->json($this->modelo->get_from_oferta($id_oferta));
    }
    

}