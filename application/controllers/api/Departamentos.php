<?php

require_once "BT_Controlador_api_estandar.php";

class Departamentos extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Departamento", "id_departamento");
      
    }
    
}