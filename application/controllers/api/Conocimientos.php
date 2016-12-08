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

}