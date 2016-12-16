<?php
class BT_Controlador_api_estandar extends BT_Controller
{
	public $id;
    public function __construct($modelo, $id)
    {
    	$this->id = $id;
        parent::__construct();
        $this->load->model($modelo,"modelo");
    }
    public function GetLike($nombre){
        echo json_encode($this->modelo->get_like($nombre));
    }
    public function Get(){
        $resultadosPorPagina = $this->input->get("resultadosPorPagina");
        echo json_encode($this->modelo->get($resultadosPorPagina));
    }
    public function Insert(){
        //$this->requerir_login_json();
        $tupla = $this->input->post();
        $tupla = $this->modelo->insert($tupla);
        echo json_encode($tupla);

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