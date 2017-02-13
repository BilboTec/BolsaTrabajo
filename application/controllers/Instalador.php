<?php 


class Instalador extends CI_Controller{
	protected $conectado = false;
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
		$this->load->view("Instalador/Index");
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
}
