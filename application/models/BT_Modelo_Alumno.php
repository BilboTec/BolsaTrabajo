<?php
class _Alumno{
	public $id_alumno, $nombre, $apellido1, $apellido2, $id_email, $calle, $cp, $disponibilidad, $dni, $fecha_nacimiento,
	$id_localidad, $nacionalidad, $otros_datos, $sexo, $tlf;
	public function get_id(){
		return $this->id_alumno;
	}
}

class BT_Modelo_Alumno extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function get($id_alumno){
		$alumno = $this->db->get_where("alumno",["id_alumno"=>$id_alumno])->custom_row_object(0,'_Alumno');
		if($profesor!=null){
			$profesor->email = $this->db->get_where("email",["id_email"=>$alumno->id_email]);
		}
		return $alumno;
	}
	public function get_by_email($email){
		$id_email =$this->db->get_where("email",["email"=>$email])->row()->id_email;
		$profesor = $this->db->get_where("alumno",["id_email"=>$id_email])->custom_row_object(0,'_Alumno');
		if($profesor!=null){
			$profesor->email = $email;
		}
		return $profesor;
	}
}
