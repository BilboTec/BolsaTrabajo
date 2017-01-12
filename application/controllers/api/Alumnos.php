<?php 
require_once "BT_Controlador_api_estandar.php";

class Alumnos extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Alumno", "id_alumno");
        
    }
    public function Invitar(){
    	$this->form_validation->set_rules([
    		[
    		"field"=>"emails",
    		"caption"=>"correos",
    		"rules"=>"trim|valid_emails"
    		]
    		]);
    	if($this->form_validation->run()){

    	}else{
    		$this->json->($this->form_validation->error("emails"),400);
    	}
    }
}