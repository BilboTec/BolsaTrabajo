<?php

require_once 'BT_ModeloEstandar.php';
require_once 'Entidad.php';
class _TipoTitulacion extends Entidad{
    public $id_tipo_titulacion, $nombre;
}
class BT_Modelo_TipoTitulacion extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("tipo_titulacion", "_TipoTitulacion", "id_tipo_titulacion");
        
    }
    
}