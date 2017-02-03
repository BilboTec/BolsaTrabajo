<?php

require_once "BT_Controlador_api_estandar.php";

class FormacionComplementaria extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_FormacionComplementaria","id_formacion_complementaria");
    }
    public function GetByTipo($id_oferta_formativa){
    	$this->query(["id_oferta_formativa"=>$id_oferta_formativa]);
    }
    public function insert(){
    	$formacion_complementaria = new _FormacionComplementaria();
    	$formacion_complementaria->fromPost($this);
    	$alumno = $this->get_usuario_actual();
    	$formacion_complementaria->id_alumno = $alumno->id_alumno;
    	$formacion_complementaria = $this->modelo->insert($formacion_complementaria);
        $this->actualizarConocimientos($formacion_complementaria[0]->id_formacion_complementaria);
    	$this->json($formacion_complementaria);
    }
    public function update(){
        if(isset($_POST["nuevo"])){
            $_POST["nuevo"]["id_alumno"] = $this->get_usuario_actual()->id_alumno;
        }
        $id = $this->input->post("nuevo")["id_formacion_complementaria"];
        $this->actualizarConocimientos($id);
        parent::update();
    }
    private function actualizarConocimientos($id_formacion_complementaria){
        $conocimientos = $this->input->post();
        if(isset($conocimientos["conocimientos"])){
            $conocimientos = $conocimientos["conocimientos"];
        } else if(isset($conocimientos["nuevo"]) && isset($conocimientos["nuevo"]["conocimientos"])){
            $conocimientos = $conocimientos["nuevo"]["conocimientos"];
        } else{
            $conocimientos = [];
        }
        $this->modelo->actualizar_conocimentos($id_formacion_complementaria,$conocimientos);
    }
    public function Conocimientos($id_formacion_complementaria){
        $this->json($this->modelo->get_conocimientos($id_formacion_complementaria));
    }
	public function get($id=null){
		echo data_result($this->modelo->query(["id_alumno"=>$id]),$this->modelo->count_where(["id_alumno"=>$id]));
	}
}