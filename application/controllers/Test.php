<?php


class Test extends CI_Controller
{
    public function index(){
    	$data["idioma"] = function(){};
        $this->load->view("plantillas/header",$data);
        $this->load->view("test/testTabla");
        $this->load->view("plantillas/footer");
    }
    public function Desplegable(){
        $data["idioma"] = function(){};
        $this->load->view("plantillas/header",$data);
        $this->load->view("test/testListaDesplegable");
        $this->load->view("plantillas/footer");
    }

}