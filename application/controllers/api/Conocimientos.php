<?php

require_once "BT_Controlador_api_estandar.php";

class Conocimientos extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Conocimiento", "id_conocimiento");
        
    }
    public function GetLike($nombre){
        echo json_encode($this->conocimientos->get_like($nombre));
    }
    

}