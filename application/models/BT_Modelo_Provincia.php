<?php

require_once 'BT_ModeloEstandar.php';

class _Provincia{
    public $id_provincia, $nombre;
}
class BT_Modelo_Provincia extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("provincia", "_Provincia", "id_provincia");
        
    }
    
}
