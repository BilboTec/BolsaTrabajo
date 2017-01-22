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

		 //cargo el modelo de departamentos
      	$this->load->model('BT_Modelo_Departamento');
	}
	public function index(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

		$data['activo'] = "ofertas";
		$data['es_administrador'] = $this->es_admin();
		$data["user"] = $this->get_usuario_actual();
		
		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Profesor/menu", $data);
		$this->load->view("/Profesor/ofertas", $data);
		$this->load->view("/plantillas/footer", $data);
	}
	
	public function ofertas(){
		$this->index();
	}
	
	public function buscarOferta(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		
		 //cargo el modelo de departamentos
      		$this->load->model('BT_Modelo_Departamento');
      
      	//pido los departamentos al modelo
       		$data['departamentos'] = $this->BT_Modelo_Departamento->coger_departamentos();
			
      
		$this->load->view("/Profesor/buscarOferta",$data);
	}
	
	public function detalleOferta(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/Profesor/detalleOferta",$data);
	}
	
	public function administrador(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

		$data['activo'] = "administrador";
		$data['es_administrador'] = $this->es_admin();
		$data["user"] = $this->get_usuario_actual();

		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Profesor/menu", $data);
		$this->load->view("/Profesor/administrador", $data);
		$this->load->view("/plantillas/footer", $data);
	}

	public function perfil(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};

		$data['activo'] = "perfil";
		$data['es_administrador'] = $this->es_admin();
		$data["user"] = $this->get_usuario_actual();

		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Profesor/menu", $data);
		$this->load->view("/Profesor/perfil", $data);
		$this->load->view("/plantillas/footer", $data);
	}

	public function datosPerfil(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/Profesor/perfil_datos",$data);
	}
	public function EditarOferta(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/Profesor/editar_oferta",$data);
	}

	public function CambiarClave(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/Profesor/perfil_clave",$data);
	}

	public function editarPerfil(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
      
      	//pido los departamentos al modelo
       		$data['departamentos'] = $this->BT_Modelo_Departamento->get();

		$this->load->view("/Profesor/perfil_editar",$data);
	}
	public function Alumnos(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$data['activo'] = "alumnos";
		$data['es_administrador'] = $this->es_admin();
		$data["user"] = $this->get_usuario_actual();

		$this->load->view("/plantillas/header", $data);
		$this->load->view("/Profesor/menu", $data);
		$this->load->view("/Profesor/alumnos", $data);
		$this->load->view("/plantillas/footer", $data);
	}
	public function BuscarAlumno(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$data['departamentos'] = $this->BT_Modelo_Departamento->get();
		$this->load->view("/Profesor/buscarAlumno",$data);
	}
	public function InvitarAlumnos(){
		$data['idioma'] = function($clave){
			return $this->lang->line($clave);
		};
		$this->load->view("/Profesor/invitar_alumnos",$data);
	}
}
