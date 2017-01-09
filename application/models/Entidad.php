<?php  
		abstract class Entidad {
				public  function fromPost($controlador){
					$propiedades = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);
					foreach($propiedades as $propiedad){
						$nombre = $propiedad->name;
						$val = $controlador->input->post($nombre);
						if($val !== null){
							$this->$nombre = $val;
						}
					}
				}
				public function fromArray($array){
					$propiedades = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);
					foreach($propiedades as $propiedad){
						$nombre = $propiedad->name;
						if(isset($array[$nombre])){
							$this->$nombre = $array[$nombre];
						}
					}
				}
				 /**Devuelve un array de anotaciones del elemento reflector
			     * @param $element
			     * @return array
			     */
			    protected  function getComentarios($element){
			        return explode("@",str_replace("/","",str_replace("*","" ,$element->getDocComment())));
			    }
				public function crear_reglas_validacion($excepciones=[]){
					if(!is_array($excepciones)){
						$excepciones = [$excepciones];
					}
					$info_clase = new ReflectionClass($this);
					$propiedades =	$info_clase->getProperties();
					$reglas = [];
					foreach ($propiedades as $propiedad) {
						$nombre = $propiedad->getName();
						if(!in_array($nombre, $excepciones)){
							$anotaciones = $this->getComentarios($propiedad);
							if(count($anotaciones)>0){
								$regla = [
									"field"=>$nombre,
								];
								foreach ($anotaciones as $anotacion) {
									$valores = explode("=",$anotacion);
									$regla[$valores[0]]=$valores[1];
								}
								array_push($reglas, $regla);
							}
						}
					}
					return $reglas;
				}
		}
		interface iEntidadConId {
			public function get_id();
		}