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
	public function buscar($filtros=[]){
		if(!$filtros){
				$filtros = [];
		}
		$db = $this->db;
		$ids_alumno_conocimientos = null;
		$ids_alumno_busqueda = null;
		foreach($filtros as $clave => $valor){
			switch($clave){
				case "conocimientos":
					$filtrosConocimientos = [];
					foreach($valor as $conocimiento){
						array_push($filtrosConocimientos,$conocimiento["id_conocimiento"]);
					}
					if(count($filtrosConocimientos) > 0){
						$ids_alumno_conocimientos = [];
						$tablas = [
								"experiencia"=>[
									"join"=>"conocimiento_experiencia",
									"columna"=>"id_experiencia"
								],
								"formacion_academica"=>[
									"join"=>"conocimiento_formacion_academica",
									"columna"=>"id_formacion_academica"
								],
								"formacion_complementaria"=>[
									"join"=>"conocimiento_formacion_complementaria",
									"columna"=>"id_formacion_complementaria"
								]];
						foreach($tablas as $tabla => $conf){
							$resultado = $this->db->select("id_alumno")
							->from($tabla)
							->join($conf["join"],$conf["join"].".".$conf["columna"]." = "
								. $tabla . "." . $conf["columna"])
							->where_in("id_conocimiento",$filtrosConocimientos)
						->get()->result_array();
							foreach($resultado as $id){
								if(!in_array($id, $ids_alumno_conocimientos)){
										array_push($ids_alumno_conocimientos, $id);
								}
							}
						}
						if(count($ids_alumno_conocimientos)===0){
							return [];
						}
					}
					break;
				case "buscador":
					$buscar = $filtros["buscador"];
					if($buscar){
						$tablas = [
							"experiencia"=>[
								 "empresa","cargo","funciones"
							],
							"formacion_academica"=>[
								"descripcion","nombre"
							],
							"formacion_complementaria"=>[
								"descripcion","nombre"
							],
							"vw_alumno"=>[
								"otros_datos",
								"email",
								"nombre",
								"apellido1",
								"apellido2",
								"dni",
								"calle"
							]
						];
						$ids_alumno_busqueda = [];
						foreach ($tablas as $tabla => $columnas) {
							foreach($columnas as $columna){
								$this->db->or_like($columna,$buscar);
							}
							$ids = $this->db
							->select("id_alumno")->get($tabla)->result();
							foreach($ids as $id){
								if(!in_array($id->id_alumno,$ids_alumno_busqueda)){
									array_push($ids_alumno_busqueda,$id->id_alumno);
								}
							}
						}
						if(count($ids_alumno_busqueda) ===0){
							return [];
						}
					}
				break;
				case "fecha":
					$fecha = $filtros["fecha"];
					try{
						$fecha = DateTime::createFromFormat("Y-m-d", $fecha);
						$fecha = $fecha->format("Y");
					}catch(Exception $ex){
						$fecha = null;
					}
				break;
			}
		}
		if($ids_alumno_conocimientos!== null){
			$this->db->where_in("id_alumno",$ids_alumno_conocimientos);
		}
		if($ids_alumno_busqueda !== null){
			$this->db->where_in("id_alumno",$ids_alumno_busqueda);
		}
		if(isset($fecha) && $fecha !== null){

		}
		return $this->db->get($this->vista)->custom_result_object($this->clase);
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
    
    public function getByOferta($id_oferta){
    	return $this->db->from("vw_alumno")->join("candidatura", "vw_alumno.id_alumno = candidatura.id_alumno")
    	->where(["id_oferta"=>$id_oferta])->get()->custom_result_object($this->clase);
    }
}
