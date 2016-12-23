<?php  
		abstract class Entidad{
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
		}
		interface iEntidadConId {
			public function get_id();
		}