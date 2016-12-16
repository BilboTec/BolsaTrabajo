<?php
class Plantillas extends CI_Controller
{
    public function Get($vista){
        $this->load
            ->view("/Plantillas/BilboTec/$vista",$_GET);
    }
    public function Editor($vista){
        $this->load
            ->view("/Plantillas/BilboTec/EditorTemplate/$vista",$_GET);
    }
	public function select($controlador){
		
		$this->load->model("BT_Modelo_TipoTitulacion","tipo_titulacion");
		$this->load->model("BT_Modelo_Departamento","departamentos");
	 	$data["elementos"] = $this->$controlador->get();
		$data["clave"] = $this->input->get("clave");
		$data["texto"] =$this->input->get("texto");
		$this->load
            ->view("/Plantillas/BilboTec/EditorTemplate/selectTemplate",$data);
	}
}