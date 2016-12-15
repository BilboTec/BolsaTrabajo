<?php
class OfertaFormativa extends BT_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("BT_Modelo_OfertaFormativa","ofertasFormativas");
    }
    public function GetLike($nombre){
        echo json_encode($this->ofertasFormativas->get_like($nombre));
    }
    public function Get(){
        $resultadosPorPagina = $this->input->get("resultadosPorPagina");
        echo json_encode($this->ofertasFormativas->get($resultadosPorPagina));
    }
    public function Insert(){
        //$this->requerir_login_json();
        $ofertaFormativa = $this->input->post();
        $ofertaFormativa = $this->ofertasFormativas->insert($ofertaFormativa);
        echo json_encode($tipoTitulacion);

    }
    public function delete(){
        //$this->requerir_login_json();
        $elem = $this->input->post("elem");
		if($this->ofertasFormativas->delete($elem["id_oferta_formativa"])){
			echo "Ok";
		}else{
			set_status_header(405);
		}
    }
	public function update(){
		//$this->requerir_login_json();
		$viejo = $this->input->post("viejo");
		$nuevo = $this->input->post("nuevo");
		$ofertaFormativa = $this->ofertasFormativas->update($viejo,$nuevo);
		echo json_encode($ofertaFormativa);
	}

}