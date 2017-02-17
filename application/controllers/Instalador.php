<?php 


class Instalador extends CI_Controller{
	protected $conectado = false;
	protected $idioma = [];
	public function __construct(){
		error_reporting(0);
		include_once ('application/config/database.php');
		
		parent::__construct();
		$this->load->helper("url");
		try{
			$dbd = $db['default'];
			$conexion = new mysqli($dbd['hostname'], $dbd['username'], $dbd['password'], $dbd['database']);
			if(!$conexion->connect_errno){
				$this->conectado = true;
				$resultado = $conexion->query("SELECT valor FROM config WHERE clave = 'instalado'");
				
				if($resultado !== false){
					$fila = $resultado->fetch_assoc();
					if($fila !== null && $fila['valor'] === "true"){
						redirect("/Login");
					}
				}
			}
		}
		catch(Exception $e){
			
		}
		$archivos_idioma = ["general","form_validation","instalador"];
		$idiomas = ["basque","spanish"];
		foreach($idiomas as $idioma){
			foreach($archivos_idioma as $archivo){
				$this->lang->load($archivo,$idioma);
			}
			$this->idioma[$idioma] = $this->lang->language;
		}
	}
	public function ComprobarDB(){
		$this->load->library("form_validation");
		$this->form_validation->set_rules([
			[
				"field"=>"dbname",
				"caption"=>"nombre de la base de datos",
				"rules"=>"required"
			],
			[
				"field"=>"user",
				"caption"=>"nombre de usuario de la base de datos",
				"rules"=>"required"
			],
			[
				"field"=>"pass",
				"caption"=>"contraseña de la base de datos",
				"rules"=>"required"
			],
			[
				"field"=>"host",
				"caption"=>"nombre del servidor",
				"rules"=>"required"
			]
			
		]);
		if($this->form_validation->run()){
			$input_array = ["dbname","user","pass","host"];
			$dbd =[];
			foreach ($input_array as $value) {
				$dbd[$value] = $this->input->post($value);
			}
			$conexion = new mysqli($dbd['host'], $dbd['user'], $dbd['pass'], $dbd['dbname']);
			if(!$conexion->connect_errno){
				echo "ok";
			}else{
				set_status_header(400);
				echo "ohhh...";
			}
		}
	}
	public function ComprobarDBExistente(){
		if(!$this->conectado){
			set_status_header(400);
			echo "ohhh...";
		}
	}
	public function EscribirConfDB(){
		$this->load->library("form_validation");
		$this->form_validation->set_rules([
			[
				"field"=>"dbname",
				"caption"=>"nombre de la base de datos",
				"rules"=>"required"
			],
			[
				"field"=>"user",
				"caption"=>"nombre de usuario de la base de datos",
				"rules"=>"required"
			],
			[
				"field"=>"pass",
				"caption"=>"contraseña de la base de datos",
				"rules"=>"required"
			],
			[
				"field"=>"host",
				"caption"=>"nombre del servidor",
				"rules"=>"required"
			]
			
		]);
		if($this->form_validation->run()){
			$input_array = ["dbname","user","pass","host"];
			$dbd =[];
			foreach ($input_array as $value) {
				$dbd[$value] = $this->input->post($value);
			}
			try{
			$file = fopen("application/config/database.php","w");
			
			$contenido = 
"<?php
	\$active_group = 'default';
	\$query_builder = TRUE;
	
	\$db['default'] = array(
		'dsn'	=> '',
		'hostname' => '".$dbd["host"]."',
		'username' => '".$dbd["user"]."',
		'password' => '".$dbd["pass"]."',
		'database' => '".$dbd["dbname"]."',
		'dbdriver' => 'mysqli',
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => (ENVIRONMENT !== 'production'),
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'encrypt' => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array(),
		'save_queries' => TRUE
);";
				if($file === false){
					throw new Exception("Archivo no abierto", 1);
					
				}
				fwrite($file, $contenido);
				var_dump($file);
				fclose($file);
				echo "Ok";
			}catch(Exception $ex){	
				set_status_header(400);
				$this->output->set_output("<pre>" .htmlspecialchars($contenido). "</pre>");
			}
			
		}
	}
	public function index(){
		$data["idioma"] = $this->idioma;
		$this->load->view("Instalador/Index",$data);
	}
	public function GuardarDatosEmail(){
		$this->load->library("form_validation");
		$this->load->database();
		$this->form_validation->set_rules([
			[
				"field"=>"host",
				"caption"=>"smtp host",
				"rules"=>"required"
			],
			[
				"field"=>"user",
				"caption"=>"nombre de usuario",
				"rules"=>"required"
			],
			[
				"field"=>"pass",
				"caption"=>"contraseña",
				"rules"=>"required"
			],
			[
				"field"=>"port",
				"caption"=>"puerto",
				"rules"=>"required"
			]
			
		]);
		if($this->form_validation->run()){
			$input_array = [
				"host"=>"email_host",
				"port"=>"email_port",
				"user"=>"email_user",
				"pass"=>"email_pass"
				];
				foreach($input_array as $clave_input => $clave_db){
					$this->db->replace("config",["clave"=>$clave_db,"valor"=>$this->input->post($clave_input)]);
				}
		}
		
	}
	
	public function Instalado(){
		$this->load->model("BT_Modelo_Configuracion", "configuracion");
		$this->configuracion->set("instalado", "true");
	}
	

	public function GenerarDatosPrueba(){
		
		
		$this->load->model("BT_Modelo_Alumno", "alumnos");		
		$this->load->model("BT_Modelo_Profesor", "profesores");			
		$this->load->model("BT_Modelo_Empresa", "empresas");		
		$this->load->model("BT_Modelo_Oferta", "ofertas");			
		$this->load->model("BT_Modelo_Experiencia", "experiencias");	 	
		$this->load->model("BT_Modelo_FormacionAcademica", "formAcademicas");	 	
		$this->load->model("BT_Modelo_FormacionComplementaria", "formComplementarias");	 	
		$this->load->model("BT_Modelo_OfertaFormativa", "ofertaFormativa");
		
		
		$ofertas = $this->ofertaFormativa->get();
	
		
		
		$calles = ["Gran Via" , "Franciso" , "Gloriera de Bilbao" , "Urquijo" , "Sabino Arana" , "Ibaizabal" , "Ercilla", "Elcano" , "Hurtado de mezaga" , "Simón Bolivar"];
		$letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H',  'L', 'C', 'K', 'E'];
		$sector = ["Informático", "Químico" ,"Agrario" , "Tecnológico"];
		$conocimientos = ["uno" , "dos" ,"tres" , "cuatro" , "cinco" , "seis" , "siete", "ocho" , "nueve" , "diez"];
		$funciones = ["Administración", "Comercial/Marketing", "Compras/Logística/Almacén", "Dirección/Gerencia", "Dpto. financiero", "Estudios, Proyectos , I+D", "Informático", "Mantenimiento", "Oficios Profesional", "Producción / Calidad", "Recursos humanos"];
		$cargos = ["Becario/a Prácticas", "Empleado/a", "Especialista", "Mando Intermedio", "Dirección / Gerencia", "Consejo directivo","Socio/asociado"];
		$nombres = ["Andrés" , "Juan" , "Pedro" , "Jóse" , "Ana" , "Guillermo" , "Gorka" , "Josu" , "Yanire", "Román", "Luis" , "Ander" , "Iñigo" , "Maite", "Laura", "Jorge" , "Alex" , "Aitor" , "Sofia" , "Carmen" , "Marije" , "Inés" , "Irene" , "Itziar"];
		$apellidos = ["López", "Pérez", "García" , "Rodriguez" , "Zabala" , "Gonzales" , "Barrena" , "Muñoz" , "Bilbao" , "Rodas" , "Ramos" , "Insausti" , "Espinosa" ,"Domingo" , "Escobar" , "Salazar" , "Aranburu" ,"Ochoa"];
		$empresas = ["klico" , "bilbotec", "arrobajgg", "cooldevelopers", "youtube", "google", "facebook", "cocacola" , "apple", "seat"];
		$titulos = ["Programador web senior en .NET" , "Programador PL-SQL" , "Administrativo/a contable", "Secretaría de dirección", "Gestor/a comercial" , "Tecnico de control de calidad", "Auxiliar de Laboratorio" , "Electricista" , "Programador JAVA"];
		
		$this->load->model("BT_Modelo_Conocimiento", "conocimientos");	 	
		$conocimiento = new _Conocimiento();	
		
		
		
	
		foreach ($conocimientos as $key => $value) {
			$conocimiento->nombre =  $value;			
			$this->conocimientos->insert($conocimiento);			
		}
		
		$listaConocimientos = $this->conocimientos->get();
	
		
			
		
		for($x = 0; $x < 10; $x++){
				
			$alumno = new _Alumno();					
			//ALumnos
			
			$alumno->nombre = $nombres[rand(0, count($nombres)-1)];
			$alumno->apellido1 = $apellidos[rand(0, count($apellidos)-1)];
			$alumno->apellido2 = $apellidos[rand(0, count($apellidos)-1)];		
			$alumno->calle =  $calles[rand(0, count($calles)-1)];
			$alumno->cp = rand(10000, 99999);
			$alumno->disponibilidad = rand(0, 1);
			$alumno->dni = rand(10000000, 99999999) . $letras[rand(0, 22)];
			$alumno->fecha_nacimiento = rand(1970, 2000) . "-" . rand(1,12) . "-" .rand(1,28);
			$alumno->id_localidad = rand(0,8116);
			$alumno->nacionalidad = "española";
			$alumno->otros_datos = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod 
			tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 	quis nostrud
		    exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure 
			reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur 
			sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum";
			$alumno->sexo = rand(0,1);
			$alumno->tlf = "0034" . rand(600000000, 999999999);
			$alumno->email = $alumno->nombre . "." .$alumno->apellido1 . $x . "@alumno.com";
			$alumno->establecer_clave("alumno");
			
			$fecha = new DateTime('2017-02-13');		
	   		$fecha->sub( new DateInterval('P' . rand(1, 8) . 'M'));	    
			$alumno->ultima_conexion =  $fecha->format('Y-m-d');
			
			$alumno->avisado =	1;		
			$alumno = $this->alumnos->insert($alumno);
			
			
			
			$vez = 1;
			while($vez <= 2){
				
				//Experiencias
				
				
				$experiencia= new _Experiencia();
		
				$experiencia->id_alumno = $alumno->id_alumno;			 
				$fecha = new DateTime('2017-02-13');		
		   		$fecha->sub( new DateInterval('P' . rand(1, 8) . 'M'));	    
				
				
				$experiencia->empresa = $empresas[rand(0, count($empresas)-1)];
				$experiencia->trabajando_actualmente = 1;
				
				if($vez == 2){				
					$experiencia->trabajando_actualmente = 0;
					$experiencia->fecha_fin =  $fecha->format('Y-m-d');			
					$fecha->sub( new DateInterval('P' . rand(6, 12) . 'M'));	
				}
				
				
				$experiencia->fecha_inicio = $fecha->format('Y-m-d');
				$experiencia->cargo = $cargos[rand(0, 6)];
				$experiencia->funciones = $funciones[rand(0,9)];
				
				$experiencia = $this->experiencias->insert($experiencia)[0];
				
				$conocimientos = [];
				
				for($i = 0; $i < 3 ; $i++){
					$conocimiento = [];
					$conocimiento["id_conocimiento"] = $listaConocimientos[rand(0 , count($listaConocimientos)-1)]->id_conocimiento;
					$conocimientos[$i] = $conocimiento;
				};
			
				$this->experiencias->actualizar_conocimientos($experiencia->id_experiencia, $conocimientos);
				
			
				
				//Formación Académica			
				
				$formAcademica = new _FormacionAcademica();
				
				$formAcademica->id_alumno = $alumno->id_alumno;			
				$formAcademica->descripcion = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod 
				tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 	quis nostrud
			    exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure 
				reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur 
				sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum";
				
				$random = rand(0 , count($ofertas)-1);
				$formAcademica->id_oferta_formativa =  $ofertas[$random] -> id_oferta_formativa;				
				$formAcademica->id_tipo_titulacion = $ofertas[$random] ->  id_tipo_titulacion;
				$formAcademica->nombre = $ofertas[$random] -> nombre;
					
    		
    			$formAcademica->cursando = 1;
    					
				
				$fecha = new DateTime('2017-02-13');		
		   		$fecha->sub( new DateInterval('P' . rand(1, 8) . 'M'));	    
						
				
				if($vez == 2){
					$formAcademica->cursando = 0;
					$formAcademica->fecha_fin =  $fecha->format('Y-m-d');			
					$fecha->sub( new DateInterval('P' . rand(6, 12) . 'M'));	
				}
				
				$formAcademica->fecha_inicio = $fecha->format('Y-m-d');		
			
				
				$formAcademica = $this->formAcademicas->insert($formAcademica)[0];
				
				$conocimientos = [];
				
				for($i = 0; $i < 3 ; $i++){
					$conocimiento = [];
					$conocimiento["id_conocimiento"] = $listaConocimientos[rand(0 , count($listaConocimientos)-1)]->id_conocimiento;
					$conocimientos[$i] = $conocimiento;
				};
			
				$this->formAcademicas->actualizar_conocimientos($formAcademica->id_formacion_academica, $conocimientos);
							 
				 //Formacion complementaria
				 
				 
				$formComplementaria = new _FormacionComplementaria();
				
				$formComplementaria->id_alumno = $alumno->id_alumno;			
				$formComplementaria->descripcion = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod 
				tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 	quis nostrud
			    exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure 
				reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur 
				sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum";
				
				$random = rand(0 , count($ofertas)-1);
				$formComplementaria->id_oferta_formativa =  $ofertas[$random] -> id_oferta_formativa;				
				$formComplementaria->id_tipo_titulacion = $ofertas[$random] ->  id_tipo_titulacion;
				$formComplementaria->nombre = $ofertas[$random] -> nombre;
				$formComplementaria->horas = rand(4, 10) * 1000;	
    		
    			$formComplementaria->cursando = 1;
    					
				
				$fecha = new DateTime('2017-02-13');		
		   		$fecha->sub( new DateInterval('P' . rand(1, 8) . 'M'));	    
						
				
				if($vez == 2){
					$formComplementaria->cursando = 0;
					$formComplementaria->fecha_fin =  $fecha->format('Y-m-d');			
					$fecha->sub( new DateInterval('P' . rand(6, 12) . 'M'));	
				}
				
				$formComplementaria->fecha_inicio = $fecha->format('Y-m-d');		
			
				
				$formComplementaria = $this->formComplementarias->insert($formComplementaria)[0];
				
				$conocimientos = [];
				
				for($i = 0; $i < 3 ; $i++){
					$conocimiento = [];
					$conocimiento["id_conocimiento"] = $listaConocimientos[rand(0 , count($listaConocimientos)-1)]->id_conocimiento;
					$conocimientos[$i] = $conocimiento;
				};
			
				$this->formComplementarias->actualizar_conocimentos($formComplementaria->id_formacion_complementaria, $conocimientos);
				
				 
				 
				 
				 
				 
				$vez ++;
			
			}							
			
			//Profesores
			
			$profesor = new _Profesor();
			$profesor->nombre = $nombres[rand(0, count($nombres)-1)];
			$profesor->apellido = $apellidos[rand(0, count($apellidos)-1)];
			$profesor->apellido2 = $apellidos[rand(0, count($apellidos)-1)];
			$profesor->establecer_clave("profesor");
			$profesor->id_departamento = rand(1,4);
			
			$p = rand(0, 10);
			if($p <= 7){
				$profesor->id_rol = 2;
			}else{
				$profesor->id_rol = 1;
			}	
			
			
			$profesor->email = $profesor->nombre . "." .$profesor->apellido . $x . "@profesor.com";	       
			
			$this->profesores->insert($profesor);
			
			//empresas 
			$empresa = new _Empresa();
			$empresa->cif = rand(10000000, 99999999) . $letras[rand(0, 22)];
		    $empresa->sector = $sector[rand(0, 3)];
	        $empresa->nombre = $empresas[rand(0, count($empresas)-1)];
	        $empresa->establecer_clave("empresa");    
			$empresa->email = $empresa->nombre . $x . "@empresa.com";	       
			$this->empresas->insert($empresa);
			
			
			//Ofertas
			$oferta = new _Oferta();
			$oferta->titulo = $titulos [rand(0, count($titulos)-1)];
			
			$oferta->nombre_empresa = $empresas[rand(0, count($empresas)-1)];
			
			$fecha = new DateTime('2017-02-13');		
	   		$fecha->sub( new DateInterval('P' . rand(1, 8) . 'D'));	    
			$oferta->fecha =  $fecha->format('Y-m-d');		
			
			$oferta->descripcion = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod 
			tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 	quis nostrud
		    exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure 
			reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur 
			sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum";
			
			$oferta->visible = rand(0,1);
			
			$oferta = $this->ofertas->insert($oferta)[0];
			
		}				
		
		$alumnos = $this->alumnos->get();
		$ofertas = $this->ofertas->get();
	
		for($x = 0; $x < 4; $x++){				
			
			
			//Candidaturas
			
			
			$random = rand(0, 2);
			
			
			$idAlumnos = [];
			for($j = 0; $j <=$random ; $j++){
				array_push($idAlumnos, $alumnos[rand (0, count($alumnos) -1)]->id_alumno);
			}
						
			$random = rand(0, 2);
			
			$this->ofertas->actualizar_candidaturas($ofertas[rand(0, count($ofertas)-1)]->id_oferta , $idAlumnos);
			
		}	
		
	}
	

	public function ProbarDatosEmail(){
    	$this->load->library("form_validation");
		$this->form_validation->set_rules([
			[
				"field"=>"host",
				"caption"=>"smtp host",
				"rules"=>"required"
			],
			[
				"field"=>"user",
				"caption"=>"nombre de usuario",
				"rules"=>"required"
			],
			[
				"field"=>"pass",
				"caption"=>"contraseña",
				"rules"=>"required"
			],
			[
				"field"=>"port",
				"caption"=>"puerto",
				"rules"=>"required"
			],
			[
				"field"=>"prueba",
				"caption"=>"direccion de prueba",
				"rules"=>"required|valid_email"
			]
			
		]);
		if($this->form_validation->run()){
			$config = Array(
 				    'protocol' => 'smtp',
 				    'smtp_host' => $this->input->post('host'),
 				    'smtp_port' => $this->input->post('port'),
 				    'smtp_user' => $this->input->post('user'),
 				    'smtp_pass' => $this->input->post('pass'),
 				    'mailtype'  => 'html',
 				    'charset'   => 'utf-8'
 				);
			$controlador = $this;
			$controlador->load->library('email', $config);
			$controlador->email->set_newline("\r\n");
			$controlador->email->initialize($config);
			$controlador->email->from($this->input->post('user'), 'BilboTec');
			$controlador->email->to($this->input->post('prueba'));
		
			$controlador->email->subject('email de prueba');
			$controlador->email->message('si te ha llegado, es que está bien');
		
			$controlador->email->send();
		}
    }

}
