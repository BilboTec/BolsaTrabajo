<?php

require_once "BT_Controlador_api_estandar.php";

class TipoTitulacion extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_TipoTitulacion", "id_tipo_titulacion");
        
    }
    
}