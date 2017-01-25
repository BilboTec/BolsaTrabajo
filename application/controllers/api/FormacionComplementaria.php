<?php

require_once "BT_Controlador_api_estandar.php";

class FormacionComplementaria extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_FormacionComplementaria","id_formacion_complementaria");
    }
    public function GetByTipo($id_oferta_formativa){
    	$this->query(["id_oferta_formativa"=>$id_oferta_formativa]);
    }
    public function insert(){
    	$formacion_complementaria = new _FormacionComplementaria();
    	$formacion_complementaria->fromPost($this);
    	$alumno = $this->get_usuario_actual();
    	$formacion_complementaria->id_alumno = $alumno->id_alumno;
    	$formacion_complementaria = $this->modelo->insert($formacion_complementaria);
    	$this->json($formacion_complementaria);
    }
}