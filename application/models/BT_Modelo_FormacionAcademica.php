<?php
require_once "Entidad.php";
require_once 'BT_ModeloEstandar.php';

class _FormacionAcademica extends Entidad {
    public $id_formacion_academica,$id_alumno, $descripcion,$id_oferta_formativa, $id_tipo_titulacion, $fecha_inicio,
    $fecha_fin, $cursando, $nombre;
}
class BT_Modelo_FormacionAcademica extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("formacion_academica","_FormacionAcademica","id_formacion_academica");
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
	public function get_conocimientos($id_formacion_academica){
		return $this->db->from("conocimiento")
		->join("conocimiento_formacion_academica","conocimiento_formacion_academica.id_conocimiento = conocimiento.id_conocimiento")
		->where(["id_formacion_academica"=>$id_formacion_academica])
		->get()->result();
	}
	public function actualizar_conocimientos($id_formacion_academica,$conocimientos){
		if($conocimientos == null){
			$conocimientos = [];
		}
		$this->db->delete("conocimiento_formacion_academica",["id_formacion_academica"=>$id_formacion_academica]);
		foreach($conocimientos as $conocimiento){
			$this->db->replace("conocimiento_formacion_academica",["id_conocimiento"=>$conocimiento["id_conocimiento"],
			"id_formacion_academica"=>$id_formacion_academica]);
		}
	}
}