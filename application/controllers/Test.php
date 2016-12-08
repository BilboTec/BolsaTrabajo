<?php


class Test extends CI_Controller
{
    public function index(){
        $this->load->view("plantillas/header");
        $this->load->view("test/testTabla");
        $this->load->view("plantillas/footer");
    }

}