<?php
require_once "Entidad.php";
require_once 'BT_ModeloEstandar.php';

class _Localidad{
    public $id_localidad, $nombre;
}
class BT_Modelo_Localidad extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("localidad", "_Localidad", "id_localidad");    
    }
    
    
}
