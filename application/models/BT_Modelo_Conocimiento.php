<?php

require_once 'BT_ModeloEstandar.php';

class _Conocimiento{
    public $id_conocimiento, $nombre;
}
class BT_Modelo_Conocimiento extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("conocimiento", "_Conocimiento", "id_conocimiento");

    }
    public function get_like($nombre){
        return $this->db->where(sql_string_busqueda('nombre')." LIKE " . sql_string_busqueda("'%$nombre%'") )->get("conocimiento")->result("_Conocimiento");
    }
    
}