<?php
class Conocimientos extends BT_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("BT_Modelo_Conocimiento","conocimientos");
    }
    public function GetLike($nombre){
        echo json_encode($this->conocimientos->get_like($nombre));
    }
    public function Get(){
        $resultadosPorPagina = $this->input->get("resultadosPorPagina");
        echo json_encode($this->conocimientos->get($resultadosPorPagina));
    }
    public function Insert(){
        //$this->requerir_login_json();
        $conocimiento = $this->input->post();
        $conocimiento = $this->conocimientos->insert($conocimiento);
        echo json_encode($conocimiento);

    }
    public function delete(){
        //$this->requerir_login_json();
        $elem = $this->input->post("elem");
		if($this->conocimientos->delete($elem["id_conocimiento"])){
			echo "Ok";
		}else{
			set_status_header(405);
		}
    }
	public function update(){
		//$this->requerir_login_json();
		$viejo = $this->input->post("viejo");
		$nuevo = $this->input->post("nuevo");
		$conocimiento = $this->conocimientos->update($viejo,$nuevo);
		echo json_encode($conocimiento);
	}

}