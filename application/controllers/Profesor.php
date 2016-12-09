<?php class Profesor extends BT_Controller {
	public function index(){
		$this->requerir_login();
		echo "Ok";
	}
}
