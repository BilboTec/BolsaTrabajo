<?php
class Plantillas extends CI_Controller
{
    public function Get($vista){
        $this->load
            ->view("/Plantillas/BilboTec/$vista",$_GET);
    }
}