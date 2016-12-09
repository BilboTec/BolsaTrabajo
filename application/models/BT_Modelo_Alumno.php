<?php
class _Alumno{
	public $id_alumno, $nombre, $apellido1, $apellido2, $id_email, $calle, $cp, $disponibilidad, $dni, $fecha_nacimiento,
	$id_localidad, $nacionalidad, $otros_datos, $sexo, $tlf;
	
	public function establecer_clave($clave){
		$this->clave = password_hash($clave,PASSWORD_DEFAULT);
	}
	
	public function verificar_clave($clave){
		return password_verify($clave,$this->clave);
	}
	
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
		$email =$this->db->get_where("email",["email"=>$email])->row();
		if($email != null){
			$alumno = $this->db->get_where("alumno",["id_email"=>$email->id_email])->custom_row_object(0,'_Alumno');
			if($alumno!=null){
				$alumno->email = $email;
			}
			return $alumno;
		}
		else{
			return null;
		}
	}
}
