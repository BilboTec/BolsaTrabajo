<?php
class Plantillas extends CI_Controller
{
	public $idioma;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("cookie");
		$idioma = get_cookie("idioma");
		if($idioma==null){
			$idioma = "spanish";
		}
		$this->lang->load('form_validation', $idioma);
		$this->lang->load('general', $idioma);
		$this->idioma = $idioma;
	}

	public function Get($vista){
		$_GET["idioma"] = function($texto){
			return $this->lang->line($texto);
		};
		$_GET["lang"] = $this->idioma;
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