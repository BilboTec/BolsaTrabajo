<?php
class Alumno{
	public $id_alumno, $nombre, $apellido1, $apellido2, $id_email, $calle, $cp, $disponibilidad, $dni, $fecha_nacimiento,
	$id_localidad, $nacionalidad, $otros_datos, $sexo, $tlf;
}

class BT_Modelo_Alumno extends CI_Model {
	public function __construct(){
		parent::__constuct();
	}
}
