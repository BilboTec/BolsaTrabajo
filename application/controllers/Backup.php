<?php


class Backup extends CI_Controller
{
    public function index(){
        $this->load->model("BT_Modelo_Configuracion","bt_conf");
        $this->bt_conf->forzar_backup();

    }

}