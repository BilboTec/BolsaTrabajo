<?php

require_once 'BT_ModeloEstandar.php';
require_once 'Entidad.php';

class _Experiencia extends Entidad{
    public $id_experiencia, $id_alumno, $fecha_fin, $fecha_inicio, $trabajando_actualmente,
    $empresa, $cargo, $funciones;
}
class BT_Modelo_Experiencia extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("experiencia", "_Experiencia", "id_experiencia");

    }
	public function get_conocimientos($id_experiencia){
		return $this->db->from("experiencia")
		->join("conocimiento_experiencia","conocimiento_experiencia.id_experiencia = experiencia.id_experiencia")
		->where(["experiencia.id_experiencia"=>$id_experiencia])->get()
		->result();
	}
	public function actualizar_conocimientos($id_experiencia,$conocimientos){
		$this->delete("conocimiento_experiencia",["id_experiencia"=>$id_experiencia]);
		foreach ($conocimientos as $conocimiento) {
			$this->db->insert("conocimiento_experiencia",
			["id_experiencia"=>$id_experiencia,"id_conocimiento"=>$conocimiento["id_conocimiento"]]);
		}
	}
}