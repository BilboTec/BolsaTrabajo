<?php class Profesor extends BT_Controller {
	public function __construct(){
		parent::__construct();
		$this->requerir_login();
		switch ($this->session->tipo) {
			case '1':
				redirect("/Empresa");
				break;
			case '0':
				redirect("/Alumno");
				break;
		}
	}
	public function index(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		
		$data['activo'] = "ofertas";
		
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Profesor/menu", $data);
		$this->load->view("/Profesor/ofertas", $data);
		$this->load->view("/plantillas/footer", $data);
	}
	
	public function ofertas(){
		$this->index();
	}
	
	public function administrador(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		
		$data['activo'] = "administrador";
		
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Profesor/menu", $data);
		$this->load->view("/Profesor/administrador", $data);
		$this->load->view("/plantillas/footer", $data);
	}
}
