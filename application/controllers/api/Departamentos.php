<?php
class Departamentos extends BT_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("BT_Modelo_Departamento","departamentos");
    }
    public function GetLike($nombre){
        echo json_encode($this->departamentos->get_like($nombre));
    }
    public function Get(){
        $resultadosPorPagina = $this->input->get("resultadosPorPagina");
        echo json_encode($this->departamentos->get($resultadosPorPagina));
    }
    public function Insert(){
        //$this->requerir_login_json();
        $departamento = $this->input->post();
        $departamento = $this->departamentos->insert($departamento);
        echo json_encode($departamento);

    }
    public function delete(){
        //$this->requerir_login_json();
        $elem = $this->input->post("elem");
		if($this->departamentos->delete($elem["id_departamento"])){
			echo "Ok";
		}else{
			set_status_header(405);
		}
    }
	public function update(){
		//$this->requerir_login_json();
		$viejo = $this->input->post("viejo");
		$nuevo = $this->input->post("nuevo");
		$departamento = $this->departamentos->update($viejo,$nuevo);
		echo json_encode($departamento);
	}

}