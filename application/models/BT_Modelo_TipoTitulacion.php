<?php

require_once 'BT_ModeloEstandar.php';

class _TipoTitulacion{
    public $id_tipo_titulacion, $nombre;
}
class BT_Modelo_TipoTitulacion extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("tipo_titulacion", "_TipoTitulacion", "id_tipo_titulacion");
        
    }
    
}