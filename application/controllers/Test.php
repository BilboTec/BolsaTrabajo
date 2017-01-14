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
    public function Ventana(){

        $data["idioma"] = function(){};
        $this->load->view("plantillas/header",$data);
        $this->load->view("test/testVentana");
        $this->load->view("plantillas/footer");
    }
    public function ImageUploader(){

        $data["idioma"] = function(){};
        $this->load->view("plantillas/header",$data);
        $this->load->view("test/testImageUploader");
        $this->load->view("plantillas/footer");
    }
    public function Editor(){
        $data["idioma"] = function(){};
        $this->load->view("plantillas/header",$data);
        $this->load->view("test/btEditor");
        $this->load->view("plantillas/footer");
    }
    public function DatePicker(){
        $data["idioma"] = function(){};
        $this->load->view("plantillas/header",$data);
        $this->load->view("test/testDatePicker");
        $this->load->view("plantillas/footer");
    }

}