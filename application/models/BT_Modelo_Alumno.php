<?php
require_once "Entidad.php";
require_once "BT_ModeloVista.php";
class _Alumno extends  Entidad implements iEntidadConId{
	public $id_alumno, $nombre, $apellido1, $apellido2, $id_email, $calle, $cp, $disponibilidad, $dni, $fecha_nacimiento,
	$id_localidad, $nacionalidad, $otros_datos, $sexo, $tlf, $email;
	
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
	public function buscar($filtros){
		$db = $this->db;
		$db->from("alumnos");
		foreach($filtros as $clave => $valor){
			switch($clave){
				case "conocimientos":
					$filtrosConocimientos = [];
					foreach($valor as $conocimiento){
						array_push($filtrosConocimientos,$conocimiento);
					}
					if(count($filtrosConocimientos) > 0){
					}
					break;
			}
		}
	}
	public function guardar_imagen($imagen, $alumno){
		if($imagen != null){
			$imagen = base64_decode(str_replace("data:image/png;base64,", "", $imagen));
			/*$imagen = imagecreatefromstring(str_replace("data:image/png;base64,", "", $imagen));
			$imagen = imagejpeg($imagen, "data/fotos/" .$alumno->id_alumno .".jpg");
			imagedestroy($imagen);*/
			$file = fopen("data/fotos/" .$alumno->id_alumno .".jpg", "wb");
			fwrite($file, $imagen);
			fclose($file);
		}
	}
	public function cargar_imagen($alumno){
		$ruta = "data/fotos/" .$alumno->id_alumno .".jpg";
		if(file_exists($ruta)){
			$file = fopen($ruta, "rb");
			$imagen = fread($file, filesize($ruta));
			$imagen = "data:image/png;base64," .base64_encode($imagen);
			return $imagen;
		}
		return null;
	}
	
	/*public function get($resultadosPorPagina=false,$pagina=false,$orden=false,$direccion="asc"){
		$alumnos = parent::get($resultadosPorPagina,$pagina,$orden,$direccion);
		for($i=0; $i<count($alumnos); $i++){
			$imagen = $this->cargar_imagen($alumnos[$i]);
			if($imagen != null){
				$alumnos[$i]->imagen = $imagen;
			}
		}
		return $alumnos;
	}
	
	public function query(array $condiciones,$resultadosPorPagina=false,$pagina=false,$orden=false,$direccion="asc"){
		$alumnos = parent::query($condiciones, $resultadosPorPagina,$pagina,$orden,$direccion);
		for($i=0; $i<count($alumnos); $i++){
			$imagen = $this->cargar_imagen($alumnos[$i]);
			if($imagen != null){
				$alumnos[$i]->imagen = $imagen;
			}
		}
		return $alumnos;
	}
	
	public function get_by_id($id){
        $alumno = $this->db->get_where($this->tabla,[$this->clave=>$id])->custom_row_object(0, $this->clase);
		$imagen = $this->cargar_imagen($alumno);
			if($imagen != null){
				$alumno->imagen = $imagen;
			}
    }*/
}
