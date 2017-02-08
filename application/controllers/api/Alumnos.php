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
        $localidad = "";
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
            			.contenedor{
            				margin: 50px;
            			}
                        .titulo, h1{
                        	color: green;
                        }
                        img{
                        	margin-right: 20px;
                        }
                      	.linea{
                      		border-top: solid 1px green;
                      	}
                    </style>";
            $html .= "<div class='contenedor'><h1 class='titulo'>" . $alumno->nombre . " " . $alumno->apellido1 . " " . $alumno->apellido2 ."</h1>";
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
                $html.="<div>
                            <h2>" .(isset($experiencia->empresa)?$experiencia->empresa:"") ."</h2>
                            <p> " .(isset($experiencia->fecha_inicio)?$experiencia->fecha_inicio:"") ."-" .(isset($experiencia->trabajando_actualmente)? "Trabajando actualmente" :$experiencia->fecha_fin) ."</p>
                            <p> " .(isset($experiencia->cargo)?$experiencia->cargo:"") ."</p>
                            <p> " .(isset($experiencia->funciones)?$experiencia->funciones:"") ."</p>
                        </div>";
            }
             $this->load->model("BT_Modelo_FormacionAcademica","formacionAcademica");
            $formaciones_academicas = $this->formacionAcademica->query(["id_alumno"=>$alumno->id_alumno]);
            if(count($formaciones_academicas)>0){
                $html.="<h1>Formacion Académica</h1>";
                $this->load->model("BT_Modelo_OfertaFormativa","oferta_formativa");
                $this->load->model("BT_Modelo_TipoTitulacion","tipo_titulacion");
            }
            foreach($formaciones_academicas as $formacion_academica){
                $oferta_formativa = $this->oferta_formativa->get_by_id($formacion_academica->id_oferta_formativa);
                $tipo_titulacion = $this->tipo_titulacion->get_by_id($formacion_academica->id_tipo_titulacion);
                $oferta_formativa =($oferta_formativa === null)?"":$oferta_formativa->nombre;
                $tipo_titulacion =($tipo_titulacion === null)?"": $tipo_titulacion->nombre; 
                $html.="<div>
                            <h2>" .(isset($formacion_academica->nombre)?$formacion_academica->nombre:"") ."</h2>
                            <p> " .(isset($formacion_academica->fecha_inicio)?$formacion_academica->fecha_inicio:"") ."-" 
                            .(isset($formacion_academica->cursando)?"Cursando":$formacion_academica->fecha_fin) ."</p>
                            <p> " .(isset($oferta_formativa)?$oferta_formativa:"") ."</p>
                            <p> " .(isset($tipo_titulacion)?$tipo_titulacion:"") ."</p>
                            <p> " .(isset($formacion_academica->descripcion)?$formacion_academica->descripcion:"") ."</p>
                        </div>";
            }
			$this->load->model("BT_Modelo_FormacionComplementaria","formacionComplementaria");
            $formaciones_complementarias = $this->formacionComplementaria->query(["id_alumno"=>$alumno->id_alumno]);
            if(count($formaciones_complementarias)>0){
                $html.="<h1>Formacion Complementaria</h1>";
                $this->load->model("BT_Modelo_OfertaFormativa","oferta_formativa");
                $this->load->model("BT_Modelo_TipoTitulacion","tipo_titulacion");
            }
            foreach($formaciones_complementarias as $formacion_complementaria){
                $oferta_formativa = $this->oferta_formativa->get_by_id($formacion_complementaria->id_oferta_formativa);
                $tipo_titulacion = $this->tipo_titulacion->get_by_id($formacion_complementaria->id_tipo_titulacion);
                $oferta_formativa =($oferta_formativa === null)?"":$oferta_formativa->nombre;
                $tipo_titulacion =($tipo_titulacion === null)?"": $tipo_titulacion->nombre; 
                $html.="<div>
                            <h2>" .(isset($formacion_complementaria->nombre)?$formacion_complementaria->nombre:"") ."</h2>
                            <p> " .(isset($formacion_complementaria->fecha_inicio)?$formacion_complementaria->fecha_inicio:"") ."-" 
                            .(isset($formacion_complementaria->cursando)?"Cursando":$formacion_complementaria->fecha_fin) ."</p>
                            <p> " .(isset($oferta_formativa)?$oferta_formativa:"") ."</p>
                            <p> " .(isset($tipo_titulacion)?$tipo_titulacion:"") ."</p>
                            <p> " .(isset($formacion_complementaria->horas)?$formacion_complementaria->horas:"") ."</p>
                            <p> " .(isset($formacion_complementaria->descripcion)?$formacion_complementaria->descripcion:"") ."</p>
                        </div>";
            }

			$this->load->model("BT_Modelo_Idioma","idiomas");
            $idiomas = $this->idiomas->query(["id_alumno"=>$alumno->id_alumno]);
            if(count($idiomas)>0){
                $html.="<h1>Idiomas</h1>";
            }
            foreach($idiomas as $idioma){
                $html.="<div>
                            <h2>" .(isset($idioma->nombre)?$idioma->nombre:"") ."</h2>
                            <p> "; if(isset($idioma->nivel)){
                            			switch ($idioma->nivel) {
											case '1':
												$resultado = "Básico";
												break;
											
											case '2':
												$resultado = "Intermedio";
												break;
											case '3':
												$resultado = "Avanzado";
												break;
										}
									}else{
                            			$resultado = "";
                            		}
                 			$html.= $resultado ."</p>
                            <p> " .(isset($idioma->oficial)?"Oficial":"") ."</p>
                        </div>";
            }            
			$html.="<h1>Otros Datos</h1><p>"
            	.(isset($alumno->otros_datos)?$alumno->otros_datos:"") ."</p>
                </div>";
            
            $pdf->WriteHtml($html);
            $pdf->output("Curriculum.pdf");
    }
	public function Buscar(){
		$filtros = $this->input->post("filtros");
		$alumnos = $this->modelo->buscar($filtros);
		$this->json($alumnos);
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
	
	public function CambiarClave(){
    	$this->form_validation->set_rules([
    		["field"=>"clave", "caption"=>"contraseña actual", "rules"=>"trim|required"],
    		["field"=>"nuevaclave", "caption"=>"contraseña nueva", "rules"=>"trim|required|callback_claves_iguales"],
    		["field"=>"repetirclave", "caption"=>"repetir contraseña", "rules"=>"trim|required"]
    		]);
    	if($this->form_validation->run()){
	    	$clave_vieja = $this->input->post("clave");
	    	$alumno = $this->get_usuario_actual();
	    	if($alumno->verificar_clave($clave_vieja)){
	    		$clave = $this->input->post("nuevaclave");
	    		$alumno->establecer_clave($clave);
	    		$this->modelo->update($alumno, $alumno);
	    		$respuesta = new stdClass();
	    		$respuesta->mensaje = "ok";
	    		$this->json($respuesta);
	    	}
	    	else{
	    		$respuesta = new stdClass();
	    		$respuesta->mensaje = "clave incorrecta";
	    		$this->json($respuesta, 400);
	    	}
    	}
    	else{
    		$this->json($this->form_validation->error_array(),400);
    	}
    }

    public function claves_iguales($nuevaclave){
    	$clave_repetida = $this->input->post("repetirclave");
    	if($nuevaclave == $clave_repetida){
    		return true;
    	}
    	$this->form_validation->set_message("claves_iguales", "las contraseñas deben ser iguales");
    }
    
    public function Baja(){
    	$usuario = $this->get_usuario_actual();
			if(isset($usuario->id_alumno)){
				$clave = $this->input->post("clave");
				if(password_verify($clave, $usuario->clave)){
					$this->modelo->baja($usuario);
				}
				else{
					$this->json("La contraseña no coincide", 400);
				}
			}
	}
    
}