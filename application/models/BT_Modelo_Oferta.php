<?php

require_once 'BT_ModeloEstandar.php';
require_once 'Entidad.php';

class _Oferta extends Entidad{
    public $id_oferta, $titulo, $id_empresa, $nombre_empresa, $fecha, $estudios_min, $experiencia_min,
	$requisitos, $descripcion, $horario, $salario, $visible;
}

class BT_Modelo_Oferta extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("oferta", "_Oferta", "id_oferta");
    }
	public function actualizar_candidaturas($id_oferta,$alumnos){
		if(count($alumnos)===0){
			$this->db->where("id_oferta",$id_oferta)->delete("candidatura");
			return [
				"eliminados"=>$alumnos,
				"nuevos"=>[]
			];
		}
		$eliminados = $this->db->select("id_alumno")->where(["id_oferta"=>$id_oferta])
		->where_not_in("id_alumno",$alumnos)->from("candidatura")->get()->result();
		$eliminados = array_values($eliminados);
		$this->db->where(["id_oferta"=>$id_oferta])
		->where_not_in("id_alumno",$alumnos)->delete("candidatura");
		$candidaturas = $this->db->select("id_alumno")->where(["id_oferta"=>$id_oferta])->get("candidatura")
		->result();
		$candidaturas = array_values($candidaturas);
		$nuevos = [];
		foreach($alumnos as $alumno){
			if(!in_array($alumno, $candidaturas)){
				array_push($nuevos,$alumno);
				$this->apuntar_alumno($id_oferta, $alumno);
			}
		}
		return ["eliminados"=>$eliminados,"nuevos"=>$nuevos];
	}
	public function coger_ofertas()
	{
		$consulta = $this->db->get('oferta');
		return $consulta->result_array();
	}
	
    public function actualizar_conocimientos($oferta,$conocimientos){
    	$this->db->delete("conocimiento_oferta",["id_oferta"=>$oferta->id_oferta]);
		if(!$conocimientos){
			return;
		}
    	foreach ($conocimientos as $conocimiento) {
    		$this->db->insert("conocimiento_oferta",[
    			"id_oferta"=>$oferta->id_oferta,
    			"id_conocimiento"=>$conocimiento["id_conocimiento"]
    			]);
    	}
    }
	public function apuntar_alumno($id_oferta,$id_alumno){
		$this->db->set("fecha", "NOW()", false);
		$this->db->replace("candidatura",[
			"id_oferta"=>$id_oferta,
			"id_alumno"=>$id_alumno	
		]);
	}
	public function get_alumnos_apuntados($id_oferta){
		$ids = $this->db->select("id_alumno")->get_where("candidatura",["id_oferta"=>$id_oferta])->result();
		return $ids;
	}
	public function get_ofertas_por_alumno($id_alumno){
		return $this->db->from($this->tabla)
			->join("candidatura","oferta.id_oferta = alumno.id_alumno")
			->result($this->clase);
	}
	public function query(array $condiciones, $resultadosPorPagina=false, $pagina=false, $orden=false, $direccion="asc"){
		$filtros = [];
		foreach ($condiciones as $key => $value) {
			if(property_exists($this->clase, $key)){
				$filtros[$key] = $value;
			}
			else{
				switch ($key) {
					case 'conocimientos':
						$conocimientos = $value;
						break;
					
					case 'buscador':
						$buscador = $value;
						break;
						
					case "fecha_oferta":
						$fecha = $value;
						break;
				}
			}
		}
		
		$this->db->where($filtros)->from($this->tabla);
		if(isset($conocimientos) && count($conocimientos) > 0){
			$filtro_conocimiento = [];
			foreach ($conocimientos as $conocimiento) {
				array_push($filtro_conocimiento, $conocimiento->id_conocimiento);
			}
			$this->db->join("conocimiento_oferta", "conocimiento_oferta.id_oferta = oferta.id_oferta")
			->where_in("id_conocimiento", $filtro_conocimiento);
		}
		
		if(isset($buscador) && $buscador){
			$this->db->where("(LOWER(titulo) LIKE LOWER('%$buscador%') OR LOWER(nombre_empresa) LIKE LOWER('%$buscador%') OR 
			LOWER(estudios_min) LIKE LOWER('%$buscador%') OR LOWER(experiencia_min) LIKE LOWER('%$buscador%') OR 
			LOWER(requisitos) LIKE LOWER('%$buscador%') OR LOWER(descripcion) LIKE LOWER('%$buscador%') OR 
			LOWER(horario) LIKE LOWER('%$buscador%') OR LOWER(salario) LIKE LOWER('%$buscador%'))");
		}
		
		if(isset($fecha) && $fecha){
			switch ($fecha) {
				case '2':
					$fecha = '7';
					break;
				
				case '3':
					$fecha = '15';
					break;
			}
		$date = new DateTime();
		$date->sub(new DateInterval("P$fecha"."D"));
		$this->db->where(["fecha >" => $date->format("Y-m-d")]);
		}
		return $this->db->get()->result($this->clase);

	}

	public function get_candidaturas($id_alumno){
		return $this->db->select("oferta.id_oferta, titulo, candidatura.fecha")->from("oferta")
		->join("candidatura", "candidatura.id_oferta = oferta.id_oferta")
		->where(["id_alumno"=>$id_alumno])->get()->result();
		
	}

}
?>