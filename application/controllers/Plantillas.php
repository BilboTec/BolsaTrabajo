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
		$arhivo_idioma = $this->input->get("archivo_idioma");
		$_GET["lang"] = $this->idioma;
        $this->load
            ->view("/plantillas/BilboTec/$vista",$_GET);
    }
    public function Editor($vista){
        $this->load
            ->view("/plantillas/BilboTec/EditorTemplate/$vista",$_GET);
    }
	public function select($controlador){
		$modelos = [
			"tipo_titulacion"=>"BT_Modelo_TipoTitulacion",
			"departamentos"=>"BT_Modelo_Departamento",
			"provincias"=>"BT_Modelo_Provincia",
			"roles"=>[
				["id_rol"=>1,"nombre"=>"User"],
				["id_rol"=>2,"nombre"=>"Manager"],
				["id_rol"=>3,"nombre"=>"Admin"]
			]
		];
		$modelo = $modelos[$controlador];
		if(!is_array($modelo)){
			$this->load->model($modelo,$controlador);
			$modelo = $this->$controlador->get();
		}else{
			$resultado = [];
			foreach ($modelo as $elemento){
				$item = new stdClass();
				foreach ($elemento as $key => $value){
					$item->$key = $value;
				}
				array_push($resultado, $item);
			}
			$modelo = $resultado;
		}
	 	$data["elementos"] = $modelo;
		$data["clave"] = $this->input->get("clave");
		$data["texto"] =$this->input->get("texto");
		$this->load
            ->view("/plantillas/BilboTec/EditorTemplate/selectTemplate",$data);
	}
}