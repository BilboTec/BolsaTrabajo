<?php
class Alumno{
	public $id_alumno, $nombre, $apellido1, $apellido2, $id_email, $calle, $cp, $disponibilidad, $dni, $fecha_nacimiento,
	$id_localidad, $nacionalidad, $otros_datos, $sexo, $tlf;
}

class BT_Modelo_Alumno extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function get($id_alumno){
		$alumno = $this->db->get_where("alumno",["id_alumno"=>$id_alumno])->custom_row_object(0,'Alumno');
		if($profesor!=null){
			$profesor->email = $this->db->get_where("email",["id_email"=>$alumno->id_email]);
		}
		return $alumno;
	}
}
