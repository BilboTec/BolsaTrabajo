<?php
class BT_Controlador_api_estandar extends BT_Controller
{
	public $id;
    public function __construct($modelo, $id)
    {
    	$this->id = $id;
        parent::__construct();
        /*set_exception_handler(function($error){
            $this->json_excepcion($error);
        });*/
        $this->load->library("form_validation");
        $this->load->model($modelo,"modelo");
        $this->load->helper("BT_ui_helper");
        $this->output->set_content_type("application/json");
    }
    public function GetLike($nombre){
        echo json_encode($this->modelo->get_like($nombre));
    }
    public function Get($id=null){
        $resultadosPorPagina = $this->input->get("resultadosPorPagina");
        $pagina = $this->input->get("pagina");
        $orden = $this->input->get("orden");
        $direccion = $this->input->get("direccion");
        if($direccion===null){
            $direccion = "asc";
        }
		if($id!==null){
			$this->json($this->modelo->get_by_id($id));
		}else{
			echo data_result($this->modelo->get($resultadosPorPagina,$pagina,$orden,$direccion),$this->modelo->count());
		}
        
    }
    public function Insert(){
        try {
            //$this->requerir_login_json();
            $tupla = $this->input->post();
            $tupla = $this->modelo->insert($tupla);
            echo json_encode($tupla);
        }catch(Exception $ex){
            $this->json_excepcion($ex);
        }

    }
    public function delete(){
        //$this->requerir_login_json();
        try{
                $elem = $this->input->post("elem");
    			$respuesta = new stdClass();
                var_dump($elem);
                $respuesta->mensaje=$this->modelo->delete($elem[$this->id]);
                $this->json($respuesta);
        		
            }catch(Exception $ex){
                $this->json_excepcion($ex);
            }
    }
	public function update(){
		//$this->requerir_login_json();
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

		$tupla = $this->modelo->update($viejo,$nuevo);
		echo $this->json($tupla);
        }catch(Exception $ex){
            $this->json_excepcion($ex);
        }
	}
    protected function json_excepcion($ex){
        $error = new stdClass();
        $mensaje = $this->lang->line($ex->getMessage());
        if(!$mensaje){
            $mensaje = $ex->getMessage();
        }
        $error->data = $mensaje;
        $error->codigo = $ex->getCode();
        $this->json($error,500);
    }
    protected function json($objeto,$codigo_estado=200){
        set_status_header($codigo_estado);
        $this->output->set_output(json_encode($objeto));
    }

     protected function query($condiciones){
        $resultadosPorPagina = $this->input->get("resultadosPorPagina");
        $pagina = $this->input->get("pagina");
        $orden = $this->input->get("orden");
        $direccion = $this->input->get("direccion");
        if($direccion===null){
            $direccion = "asc";
        }
        echo data_result($this->modelo->query($condiciones,$resultadosPorPagina,$pagina,$orden,$direccion),$this->modelo->count());
    }
}