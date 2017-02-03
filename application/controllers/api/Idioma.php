<?php

require_once "BT_Controlador_api_estandar.php";

class Idioma extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Idioma","id_idioma");
    }
    public function insert(){
    	$idioma = new _Idioma();
    	$idioma->fromPost($this);
    	$alumno = $this->get_usuario_actual();
    	$idioma->id_alumno = $alumno->id_alumno;
    	$idioma = $this->modelo->insert($idioma);
    	$this->json($idioma);
    }
	public function get($id=null){
		echo data_result($this->modelo->query(["id_alumno"=>$id]),$this->modelo->count_where(["id_alumno"=>$id]));
	}

}