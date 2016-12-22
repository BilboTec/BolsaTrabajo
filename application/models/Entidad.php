<?php  
		abstract class Entidad{
				public static function fromPost($controlador){
					$propiedades = get_object_vars($this);
					foreach($propiedades as $nombre => $valor){
						$val = $controlador->input->post($nombre);
						if($val !== null){
							$this->$valor = $val;
						}
					}
				}
		}

?>