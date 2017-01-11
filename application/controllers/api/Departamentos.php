<?php

require_once "BT_Controlador_api_estandar.php";

class Departamentos extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Departamento", "id_departamento");
      
    }
    
    public function getById($id){
    	$this->json($this->modelo->query(["id_departamento"=>$id])[0]);
    }
}