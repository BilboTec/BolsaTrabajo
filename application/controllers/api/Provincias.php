<?php

require_once "BT_Controlador_api_estandar.php";

class Provincias extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Provincia", "id_provincia");
        
    }
    
}