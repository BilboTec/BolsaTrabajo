<?php

require_once "BT_Controlador_api_estandar.php";

class OfertaFormativa extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_OfertaFormativa","id_oferta_formativa");
    }
    public function GetByTipo($id){
    	$this->query(["id_tipo_titulacion"=>$id]);
    }
    public function GetById($id_oferta_formativa){
    	$this->query(["id_oferta_formativa"=>$id_oferta_formativa]);
    }
}