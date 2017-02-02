<?php

require_once "BT_Controlador_api_estandar.php";

class FormacionAcademica extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_FormacionAcademica","id_formacion_academica");
    }
    public function GetByTipo($id_oferta_formativa){
    	$this->query(["id_oferta_formaiva"=>$id_oferta_formativa]);
    }
    public function insert(){
    	$formacion_academica = new _FormacionAcademica();
    	$formacion_academica->fromPost($this);
    	$alumno = $this->get_usuario_actual();
    	$formacion_academica->id_alumno = $alumno->id_alumno;
    	$formacion_academica = $this->modelo->insert($formacion_academica);
		$this->actualizarConocimientos($formacion_academica[0]->id_formacion_academica);
    	$this->json($formacion_academica);
    }
	public function Conocimientos($id_formacion_academica){
		$this->json($this->modelo->get_conocimientos($id_formacion_academica));
	}
	protected function actualizarConocimientos($id_formacion_academica){
		$conocimientos = $this->input->post();
		if(isset($conocimientos["conocimientos"])){
			$conocimientos = $conocimientos["conocimientos"];
		}else if(isset($conocimientos["nuevo"]) && isset($conocimientos["nuevo"]["conocimientos"])){
			$conocimientos = $conocimientos["nuevo"]["conocimientos"];
		}else{
			$conocimientos = [];
		}
		$this->modelo->actualizar_conocimientos($id_formacion_academica,$conocimientos);
	}
    public function update(){
        $this->requerir_login_json();
        try{
	        $clase = $this->modelo->clase;
	        $viejo = new $clase();
	        $nuevo = new $clase();
	        $indice = "nuevo";
	        if($this->input->post($indice)===null){
	            $indice = "vista";
	        }
	        $viejo->fromArray($this->input->post("viejo"));
	        $nuevo->fromArray($this->input->post($indice));
	        if(!$nuevo->id_tipo_titulacion){
	            $nuevo->id_tipo_titulacion = null; 
	        }
	        if(!$nuevo->id_oferta_formativa){
	            $nuevo->id_oferta_formativa = null;
	        }
	        $tupla = $this->modelo->update($viejo,$nuevo);
	        echo $this->json($tupla);
			$this->actualizarConocimientos($nuevo->id_formacion_academica);
        }catch(Exception $ex){
            $this->json_excepcion($ex);
        }
    }
    protected function actualizar_conocimientos(){

    }
}