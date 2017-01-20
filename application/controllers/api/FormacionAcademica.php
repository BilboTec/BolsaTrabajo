<?php

require_once "BT_Controlador_api_estandar.php";

class FormacionAcademica extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_FormacionAcademica","id_formacion_academica");
    }
    public function GetByTipo($id_oferta_formaiva){
    	$this->query(["id_oferta_formaiva"=>$id_oferta_formaiva]);
    }
    public function insert(){
    	$formacion_academica = new _FormacionAcademica();
    	$formacion_academica->fromPost($this);
    	$alumno = $this->get_usuario_actual();
    	$formacion_academica->id_alumno = $alumno->id_alumno;
    	$formacion_academica = $this->modelo->insert($formacion_academica);
    	$this->json($formacion_academica);
    }
}