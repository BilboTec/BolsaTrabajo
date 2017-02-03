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
    public function update($viejo,$nuevo){
    	if($nuevo->id_oferta_formativa === ""){
    		$nuevo->id_oferta_formativa = null;
    	}
    	if($nuevo->id_tipo_titulacion === ""){
    		$nuevo->id_tipo_titulacion = null;
    	}
    	return parent::update($viejo,$nuevo);
    }
    public function actualizar_conocimentos($id_formacion_complementaria,$conocimientos){
        $this->db->delete("conocimiento_formacion_complementaria",["id_formacion_complementaria"=>$id_formacion_complementaria]);
        foreach($conocimientos as $conocimiento){
            $this->db->insert("conocimiento_formacion_complementaria",[
                    "id_formacion_complementaria"=>$id_formacion_complementaria,
                    "id_conocimiento"=>$conocimiento["id_conocimiento"]
                ]);
        }
    }
    public function get_conocimientos($id_formacion_complementaria){
        return $this->db->from("conocimiento")
        ->join("conocimiento_formacion_complementaria","conocimiento_formacion_complementaria.id_conocimiento = conocimiento.id_conocimiento")
        ->where(["id_formacion_complementaria"=>$id_formacion_complementaria])
        ->get()->result();
    }
}