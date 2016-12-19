<?php

require_once 'BT_ModeloEstandar.php';

class _Idioma{
    public $id_idioma, $nombre ,$id_alumno, $nivel, $oficial;
}
class BT_Modelo_Idioma extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("idioma", "_Idioma", "id_idioma");
    }

}

?>
