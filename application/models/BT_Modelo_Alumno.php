<?php
require_once "Entidad.php";
require_once "BT_ModeloVista.php";
class _Alumno extends  Entidad implements iEntidadConId{
	public $id_alumno, $nombre, $apellido1, $apellido2, $id_email, $calle, $cp, $disponibilidad, $dni, $fecha_nacimiento,
	$id_localidad, $nacionalidad, $otros_datos, $sexo, $tlf, $email, $clave, $ultima_conexion,$avisado;
	
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
								if(!in_array($id["id_alumno"], $ids_alumno_conocimientos)){
										array_push($ids_alumno_conocimientos, $id["id_alumno"]);
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
				case "fecha_fin":
					$fecha = $filtros["fecha_fin"];
					if($fecha){	
						$ids_fechas = [];
						$resultado = $this->db
						->query("SELECT id_alumno FROM formacion_academica WHERE YEAR(fecha_fin) = YEAR('$fecha')")->result();
						foreach($resultado as $alumno){
							if(!in_array($alumno->id_alumno, $ids_fechas)){
								array_push($ids_fechas,$alumno->id_alumno);
							}
						}
						if(count($ids_fechas) === 0){
							return[];
						}
					}
				break;
				case "id_oferta_formativa":
					$id_oferta_formativa = $filtros["id_oferta_formativa"];
					if($id_oferta_formativa){
						$ids_oferta = [];
						$resultado = $this->db
						->query("SELECT id_alumno FROM formacion_academica where id_oferta_formativa = $id_oferta_formativa UNION
								SELECT id_alumno FROM formacion_complementaria WHERE id_oferta_formativa = $id_oferta_formativa")
						->result();
						foreach($resultado as $alumno){
							if(!in_array($alumno->id_alumno, $ids_oferta)){
								array_push($ids_oferta,$alumno->id_alumno);
							}
						}
						if(count($ids_oferta) === 0){
							return[];
						}
					}
				break;
			}
		}
		if(isset($ids_fechas)){
			$this->db->where_in("id_alumno",$ids_fechas);
		}
		if(isset($ids_oferta)){
			$this->db->where_in("id_alumno",$ids_oferta);
		}
		if($ids_alumno_conocimientos!== null){
			$this->db->where_in("id_alumno",$ids_alumno_conocimientos);
		}
		if($ids_alumno_busqueda !== null){
			$this->db->where_in("id_alumno",$ids_alumno_busqueda);
		}
		$limite = new DateTime();
		$limite->sub(new DateInterval("P6M"));
		$limite = $limite->format("Y-m-d");
		$this->db->where(["ultima_conexion >"=>$limite]);
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
	
	public function baja($alumno){
		$db = $this->db;
		$db->trans_start();
		$tablas = ["idioma", "experiencia", "formacion_academica", "formacion_complementaria", "candidatura", "alumno"];
		foreach ($tablas as $tabla) {
			$db->delete($tabla,["id_alumno"=>$alumno->id_alumno]);
		}
		$db->delete("email", ["id_email"=>$alumno->id_email]);
		$db->trans_complete();
		return true;
	}	
	
}
