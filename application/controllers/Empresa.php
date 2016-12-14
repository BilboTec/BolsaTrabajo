<?php

class Empresa extends BT_Controller{
	public function __construct(){
		parent::__construct();
		$this->requerir_login();
		switch($this->session->tipo){
			case 0:
				redirect("/Alumno");
				break;
			case 2:
				redirect("/Profesor");
				break;
		}
	}
	public function index(){
		echo "Ok";
	}
}
