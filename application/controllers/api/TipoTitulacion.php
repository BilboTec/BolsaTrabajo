<?php
class TipoTitulacion extends BT_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("BT_Modelo_TipoTitulacion","tipostitulaciones");
    }
    public function GetLike($nombre){
        echo json_encode($this->tipostitulaciones->get_like($nombre));
    }
    public function Get(){
        $resultadosPorPagina = $this->input->get("resultadosPorPagina");
        echo json_encode($this->tipostitulaciones->get($resultadosPorPagina));
    }
    public function Insert(){
        //$this->requerir_login_json();
        $tipoTitulacion = $this->input->post();
        $tipoTitulacion = $this->tipostitulaciones->insert($tipoTitulacion);
        echo json_encode($tipoTitulacion);

    }
    public function delete(){
        //$this->requerir_login_json();
        $elem = $this->input->post("elem");
		if($this->tipostitulaciones->delete($elem["id_tipo_titulacion"])){
			echo "Ok";
		}else{
			set_status_header(405);
		}
    }
	public function update(){
		//$this->requerir_login_json();
		$viejo = $this->input->post("viejo");
		$nuevo = $this->input->post("nuevo");
		$tipoTitulacion = $this->tipostitulaciones->update($viejo,$nuevo);
		echo json_encode($tipoTitulacion);
	}

}