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
        
    }

}