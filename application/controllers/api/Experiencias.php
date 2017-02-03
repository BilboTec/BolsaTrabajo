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
		$experiencia = $this->modelo->insert($experiencia)[0];
		$this->actualizarConocimientos($experiencia->id_experiencia);
		$this->json($experiencia);
	}
	protected function actualizarConocimientos($id_experiencia){
		$conocimientos = $this->input->post();
		if(isset($conocimientos["conocimientos"])){
			$conocimientos = $conocimientos["conocimientos"];
		}else if(isset($conocimientos["nuevo"]) && isset($conocimientos["nuevo"]["conocimientos"])){
			$conocimientos = $conocimientos["nuevo"]["conocimientos"];
		}
		else{
			$conocimientos = [];
		}
		$this->modelo->actualizar_conocimientos($id_experiencia,$conocimientos);
	}
	public function Conocimientos($id_experiencia){
		$this->json($this->modelo->get_conocimientos($id_experiencia));
	}
	public function update(){
		parent::update();
		$experiencia = new _Experiencia();
		$experiencia->fromArray($this->input->post("nuevo"));
		$this->actualizarConocimientos($experiencia->id_experiencia);
	}
	public function get($id=null){
		echo data_result($this->modelo->query(["id_alumno"=>$id]),$this->modelo->count_where(["id_alumno"=>$id]));
	}
}