<?php
require_once "Entidad.php";
require_once 'BT_ModeloEstandar.php';

class _FormacionComplementaria extends Entidad {
    public $id_formacion_complementaria,$id_alumno, $descripcion,$id_oferta_formativa, $id_tipo_titulacion, $fecha_inicio,
    $fecha_fin, $cursando, $nombre,$horas;
}
class BT_Modelo_FormacionComplementaria extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("formacion_complementaria","_FormacionComplementaria","id_formacion_complementaria");
    }
    public function update($nuevo, $viejo){
    	if($nuevo->id_oferta_formativa === ""){
    		$nuevo->id_oferta_formativa = null;
    	}
    	if($nuevo->id_tipo_titulacion === ""){
    		$nuevo->id_tipo_titulacion = null;
    	}
    	return parent::update($nuevo,$viejo);
    }
}