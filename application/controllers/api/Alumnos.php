<?php 
require_once "BT_Controlador_api_estandar.php";

class Alumnos extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Alumno", "id_alumno");
        $this->load->helper("bt_email");
    }
    public function Curriculum($id_alumno=null){
        if($id_alumno!==null){
            $alumno = $this->modelo->get_by_id($id_alumno);
        }else{
            $alumno = $this->get_usuario_actual();
        }
        if($alumno !== null){
            if(file_exists("data/curriculum/".$id_alumno.".pdf")){
                $this->output
        		->set_content_type('pdf')
       			->set_output(file_get_contents('data/curriculum/'.$id_alumno.".dpf"));
            }else{
                $this->generarCurriculum($id_alumno);
            }
        }
    }
    protected function generarCurriculum($id_alumno=null){
        require_once "html2pdf/vendor/autoload.php";
        if($id_alumno === null){
            $alumno = $this->get_usuario_actual();
        }else{
            $alumno = $this->alumnos->get_by_id($id_alumno);
        }
        $provincia = "";
        $loalidad = "";
        if($alumno->id_localidad){
            $this->load->model("BT_Modelo_Provincia","provincias");
            $this->load->model("BT_Modelo_Localidad","localidades");
            $localidad = $this->localidades->get_by_id($alumno->id_localidad);
            $provincia = $this->provincias->get_by_id($localidad->id_provincia);
            $localidad = $localidad->nombre;
            $provincia = $provincia->nombre;
        }
            require_once "html2pdf/html2pdf.class.php";
            $pdf = new HTML2PDF("P","A4","en");
            $edad = new DateTime();
            $edad = $edad->diff(new DateTime($alumno->fecha_nacimiento));
            $imagen = $this->modelo->cargar_imagen($alumno);
            $html = "<style>
                        .titulo{
                        }
                    </style>";
            $html .= "<h1 class='titulo'>" . $alumno->nombre . " " . $alumno->apellido1 . " " . $alumno->apellido2 ."</h1>";
            $html .= "<table>
                        <tr>
                            <td rowspan='99'>
                                <img src='$imagen'/>
                            </td>
                            <td>
                                ".$edad->format("%y años")."
                            </td>
                        </tr>
                        ".(isset($alumno->nacionalidad)?
                            "<tr>
                                <td>".$alumno->nacionalidad."</td>
                            </tr>"
                            :"").
                        "<tr>
                            <td>
                                ".$alumno->dni."
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ".$alumno->email."
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ".$alumno->tlf."
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ".$alumno->calle." ".$localidad." ".$provincia." ".$alumno->cp."
                            </td>
                        </tr>
                      </table>";
            $this->load->model("BT_Modelo_Experiencia","experiencias");
            $experiencias = $this->experiencias->query(["id_alumno"=>$alumno->id_alumno]);
            if(count($experiencias)>0){
                $html.="<h1>Experiencia Laboral</h1>";
            }
            foreach($experiencias as $experiencia){
                $html.="<table>
                            <h2>" .(isset($experiencia->nombre)?$experiencia->nombre:"") ."</h2>
                        </table>";
            }
            $pdf->WriteHtml($html);
            $pdf->output("Curriculum.pdf");
    }
	public function Buscar(){
		$filtros = $this->input->post("filtros");
		$alumnos = $this->modelo->buscar($filtros);
		
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

    public function CargarImagen($id_alumno=null){
        if(!$id_alumno){
            $alumno = $this->get_usuario_actual();
        }else{
            $alumno = $this->alumnos->get_by_id($id_alumno);  
        }
        $imagen = $this->modelo->cargar_imagen($alumno);
        $this->json(["imagen"=>$imagen]);
    }
}