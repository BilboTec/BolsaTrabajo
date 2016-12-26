<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends BT_Controller {
	public function index()
	{
		$tipo = $this->session->tipo;
		if($tipo!==null){
			switch ($tipo) {
				case 0:
					redirect("/Alumno");
					break;
				case 1:
					redirect("/Empresa");
					break;
				
				case 2:
					redirect("/Profesor");
					break;
				default:
					redirect("/Login");
					break;
			}
		}else{
			redirect("/Login");
		}
	}
}
