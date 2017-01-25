<?php 
require_once "BT_Controlador_api_estandar.php";

class Alumnos extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Alumno", "id_alumno");
        $this->load->helper("bt_email");
    }
    public function Curriculum($id_alumno){
        $alumno = $this->modelo->get_by_id($id_alumno);
        if($alumno !== null){
            require_once "html2pdf/vendor/autoload.php";
            require_once "html2pdf/html2pdf.class.php";
            $pdf = new HTML2PDF("P","A4","en");
            $pdf->WriteHtml("<p>Curriculum</p>");
            $pdf->output("Curriculum.pdf");
        }
    }
	public function Buscar(){
		$filtros = $this->input->post("filtros");
		$this->get($filtros);
		
	}
	public function GetById($id_alumno){
		$this->query(["id_alumno"=>$id_alumno]);
	}
    public function Invitar(){
    	$this->form_validation->set_rules([
    		[
    		"field"=>"emails",
    		"caption"=>"correos",
    		"rules"=>"trim|valid_emails"
    		]
    		]);
    	if($this->form_validation->run()){
    		$emails = $this->input->post("emails");
    		$emails = explode(",",$emails);
    		$errores = [];
    		$anadidos = [];
            $texto = file_get_contents("data/cuerpo_email_alumno.html");
            $asunto = file_get_contents("data/asunto_email_alumno.txt");
    		foreach($emails as $email){
                try{
        			$alumno = [];
        			$alumno["email"] = $email;
        			$alumno["nombre"] = explode("@",$email)[0];
        			$alumno = $this->modelo->insert($alumno);
                    array_push($anadidos,$email);
                }catch(Exception $ex){
                    array_push($errores,$email);
                }
    		}
    		foreach($anadidos as $email){
                $cuerpo = str_replace("{{email}}",$email,$texto);
                $cuerpo = str_replace("{{clave}}",explode("@",$email)[0],$cuerpo);
    			enviar_email($this,$email,$asunto,$cuerpo);
    		}
            $respuesta = new stdClass();
            $respuesta->enviados = $anadidos;
            $respuesta->errores = $errores;
            $this->json($respuesta);
    	}else{
    		$this->json($this->form_validation->error("emails"),400);
    	}
    }

    public function GuardarPerfil(){
    	$imagen = $this->input->post("imagen");
        $alumno = new _Alumno();
        $alumno->fromPost($this);
        $alumno_viejo = $this->get_usuario_actual();

        if($alumno->id_alumno != $alumno_viejo->id_alumno){
            $this->json("id identificador incorrecto", 400);
        }
        else{
        	$alumno =  $this->modelo->update($alumno_viejo, $alumno);		
            $this->json($alumno);
        }
    }

    public function GuardarImagen(){
        $alumno = $this->get_usuario_actual();
        $imagen = $this->input->post("imagen");
        $this->modelo->guardar_imagen($imagen, $alumno);
        $this->CargarImagen();
    }

    public function CargarImagen(){
        $alumno = $this->get_usuario_actual();
        $imagen = $this->modelo->cargar_imagen($alumno);
        $this->json(["imagen"=>$imagen]);
    }
}