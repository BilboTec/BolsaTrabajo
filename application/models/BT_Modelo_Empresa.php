<?php

class Empresa{
    public $id_empresa, $id_email, $cif, $sector,
        $nombre, $clave, $id_localidad, $id_pais;
}
class BT_Modelo_Empresa extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
}