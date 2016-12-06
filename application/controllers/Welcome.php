<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model("BT_Modelo_Profesor","profesores");
		$profesor = new Profesor();
		$profesor->nombre = "Yanire";
		$profesor->apellido = "Lopez";
		$profesor->apellido2 ="Ruiz";
		$profesor->email = "yanire_loru@gmail.com";
		$profesor->establecer_clave("yanire");
		$profesor->id_departamento = 1;
		$profesor->id_rol = 7;
		$profesor = $this->profesores->alta($profesor);
		$data["profesor"] = $profesor;
		$this->load->view('welcome_message',$data);
	}
}
