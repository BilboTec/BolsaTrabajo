<?php
require_once "Entidad.php";
require_once "BT_ModeloVista.php";
class _Alumno extends  Entidad implements iEntidadConId{
	public $id_alumno, $nombre, $apellido1, $apellido2, $id_email, $calle, $cp, $disponibilidad, $dni, $fecha_nacimiento,
	$id_localidad, $nacionalidad, $otros_datos, $sexo, $tlf,$email;
	
	public function establecer_clave($clave){
		$this->clave = password_hash($clave,PASSWORD_DEFAULT);
	}
	
	public function verificar_clave($clave){
		return password_verify($clave,$this->clave);
	}
	
	public function get_id(){
		return $this->id_alumno;
	}

	public function fromPost($controlador){
		parent::fromPost($controlador);
		if(!$this->id_localidad){
			unset($this->id_localidad);
		}
	}
}

class BT_Modelo_Alumno extends BT_ModeloVista {
	public function __construct()
	{
		parent::__construct("alumno", "vw_alumno", "_Alumno", "id_alumno");
	}
}
