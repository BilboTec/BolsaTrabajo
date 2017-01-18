<?php

require_once "BT_Controlador_api_estandar.php";

class Experiencias extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Experiencia", "id_experiencia");
      
    }
    
    public function getById($id){
    	$this->json($this->modelo->query(["id_alumno"=>$id]));
    }
	public function Insert(){
		$usuario_actual = $this->get_usuario_actual();
		$experiencia = new _Experiencia();
		$experiencia->fromPost($this);
		$experiencia->id_alumno = $usuario_actual->id_alumno;
		$experiencia = $this->modelo->insert($experiencia);
		$this->json($experiencia);
	}
}