<?php
require_once "Entidad.php";
require_once 'BT_ModeloEstandar.php';

class _OfertaFormativa extends Entidad {
    public $id_tipo_titulacion,$id_departamento,$id_oferta_formativa, $nombre;
}
class BT_Modelo_OfertaFormativa extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("oferta_formativa","_OfertaFormativa","id_oferta_formativa");
    }
}