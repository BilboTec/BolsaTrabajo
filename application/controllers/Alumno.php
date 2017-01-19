<?php class Alumno extends BT_Controller{
	public function __construct(){
		parent::__construct();
		$this->requerir_login();
		switch ($this->session->tipo) {
			case '1':
				redirect("/Empresa");
				break;
			case '2':
				redirect("/Profesor");
				break;
		}
		$this->load->model("BT_Modelo_Provincia","provincias");
	}
	public function index(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

		$data['activo'] = "ofertas";

		
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Alumno/menu", $data);
		$this->load->view("/Alumno/ofertas", $data);
		$this->load->view("/plantillas/footer", $data);
	}

	public function ofertas(){
		$this->index();
	}
	public function DatosPersonales(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->model('BT_Modelo_Provincia', 'provincias');
		$data['provincias'] = $this->provincias->get();
		
		$this->load->view("/Alumno/DatosPersonales", $data);
	}

	public function OtrosDatos(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		
		$this->load->view("/Alumno/OtrosDatos", $data);
	}
	public function buscarOferta(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		
		 //cargo el modelo de departamentos
      		$this->load->model('BT_Modelo_Departamento');
      
      	//pido los departamentos al modelo
       		$data['departamentos'] = $this->BT_Modelo_Departamento->coger_departamentos();
			
      
		$this->load->view("/Alumno/buscarOferta",$data);
	}
	
	public function detalleOferta(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/Alumno/detalleOferta",$data);
	}

	public function perfil(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

		$data['activo'] = "perfil";

		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Alumno/menu", $data);
		$this->load->view("/Alumno/perfil", $data);
		$this->load->view("/plantillas/footer", $data);
	}

	public function datosPerfil(){
		$data['provincias'] = $this->provincias->get();
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/Alumno/perfil_datos",$data);
	}

	public function CambiarClave(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/Alumno/perfil_clave",$data);
	}

	public function editarPerfil(){
		$data['provincias'] = $this->provincias->get();
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

		$this->load->view("/Alumno/perfil_editar",$data);
	}

}
