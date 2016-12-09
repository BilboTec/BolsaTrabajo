<?php class Alumno extends BT_Controller{
	public function index(){
		$this->requerir_login();
		echo "Ok";
	}
}
