<?php
class BT_Controlador_api_estandar extends BT_Controller
{
	public $id;
    public function __construct($modelo, $id)
    {
    	$this->id = $id;
        parent::__construct();
        $this->load->model($modelo,"modelo");
        $this->load->helper("BT_ui_helper");
    }
    public function GetLike($nombre){
        echo json_encode($this->modelo->get_like($nombre));
    }
    public function Get(){
        $resultadosPorPagina = $this->input->get("resultadosPorPagina");
        $pagina = $this->input->get("pagina");
        $orden = $this->input->get("orden");
        $direccion = $this->input->get("direccion");
        if($direccion===null){
            $direccion = "asc";
        }
        echo data_result($this->modelo->get($resultadosPorPagina,$pagina,$orden,$direccion),$this->modelo->count());
    }
    public function Insert(){
        try {
            //$this->requerir_login_json();
            $tupla = $this->input->post();
            $tupla = $this->modelo->insert($tupla);
            echo json_encode($tupla);
        }catch(Exception $ex){
            http_response_code(500);
            echo $ex;
        }

    }
    public function delete(){
        //$this->requerir_login_json();
        $elem = $this->input->post("elem");
		if($this->modelo->delete($elem[$this->id])){
			echo "Ok";
		}else{
			set_status_header(405);
		}
    }
	public function update(){
		//$this->requerir_login_json();
		$viejo = $this->input->post("viejo");
		$nuevo = $this->input->post("nuevo");
		$tupla = $this->modelo->update($viejo,$nuevo);
		echo json_encode($tupla);
	}

}