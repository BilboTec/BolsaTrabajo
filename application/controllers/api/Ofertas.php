<?php

require_once "BT_Controlador_api_estandar.php";

class Ofertas extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Oferta", "id_oferta");
        
    }
    public function ActualizarCandidatos(){
    	$metodo = $this->input->method(true);
		if($metodo === "POST"){
			$id_oferta = $this->input->post("id_oferta");
			$alumnos = $this->input->post("alumnos");
			if($alumnos===null){
				$alumnos = [];
			}
			$resultado = $this->modelo->actualizar_candidaturas($id_oferta,$alumnos);
			$oferta = $this->modelo->get_by_id($id_oferta);
			if(is_array($oferta) ){
				$oferta = $oferta[0];
			}
			$mensaje = function($alumno,$oferta){
				return "Buenos días " . $alumno->nombre."<br>Desafortunadamente su candidatura para la oferta
				 " . $oferta->titulo . " ha expirado.<br>Egun on " . $alumno->nombre."<br>
				 Sentitzen dugu, baina " . $oferta->titulo." eskaintzarako zure kandidatura iraungi da.";
			};
			foreach ($resultado["eliminados"] as $id_alumno){
				$alumno = $this->alumnos->get_by_id($id_alumno);
				enviar_email($this,$this->lang->line("asunto_candidatura") 
					, $mensaje($oferta,$alumno),$alumno->email);
			}
			$mensaje = function($alumno,$oferta){
				return "Buenos días " .$alumno->nombre . "<br>Se le ha apuntado a la oferta" . $oferta->titulo .
				"<br>Egun on " . $alumno->nombre . "<br>" . $oferta->titulo . " eskaintzarako apuntuatua izan zara";
			};
			foreach($resultado["nuevos"] as $id_alumno){
				$alumno = $this->alumnos->get_by_id($id_alumno);
				enviar_email($this,$this->lang->line("asunto_candidatura")
					, $mensaje($alumno,$oferta),$alumno->email);
			}
		}
    }
    public function Get($id=null){
        $tipo = $this->session->tipo;
        $usuario = $this->get_usuario_actual();
		$string_filtros = $this->input->post("filtros");
		if($string_filtros === null){
			$condiciones = new stdClass();
		}
		else{
			$condiciones = json_decode($string_filtros);
		}
        switch($tipo){
        	//si alumno
            case 0:
                $condiciones->visible = 1;
                break;
			//si empresa
            case 1:
                $condiciones->id_empresa = $usuario->id_empresa;
                break;
            }
		$resultadosPorPagina = $this->input->post("resultadosPorPagina");
		$pagina = $this->input->post("pagina");
    	parent::query((array)$condiciones, $resultadosPorPagina, $pagina);
    }

    public function getById($id){
    	$this->json($this->modelo->query(["id_oferta"=>$id]));
    }

    public function guardar(){
        $oferta = new _Oferta();
        $oferta->fromPost($this);
		$usuario = $this->get_usuario_actual();
		if(isset($usuario->id_empresa)){
			$oferta->id_empresa = $usuario->id_empresa;
			$oferta->nombre_empresa = $usuario->nombre;
		}
        if(isset($oferta->id_empresa) && !$oferta->id_empresa){
            $oferta = $oferta->toArray(["id_empresa"]);
        }
        $conocimientos = $this->input->post("conocimientos");
        if(isset($oferta->id_oferta) || (is_array($oferta) && isset($oferta["id_oferta"]))){
            $id = isset($oferta->id_oferta)?$oferta->id_oferta:$oferta["id_oferta"];
            $oferta_vieja = $this->modelo->query(["id_oferta"=>$id])[0];
            $oferta = $this->modelo->update($oferta_vieja, $oferta);
        }
        else{
            $oferta = $this->modelo->insert($oferta);
        }
	 	if(is_array($oferta)){
            $oferta = $oferta[0];
        }
        $this->modelo->actualizar_conocimientos($oferta,$conocimientos);
        $this->json($oferta);
    }
	public function delete(){
		$id_oferta = $this->input->post("id_oferta");
		if($id_oferta !== null){
			$this->modelo->delete($id_oferta);
		}
	}
	public function Candidatura(){
		$metodo = $this->input->method(true);
		if($metodo === "GET"){
			$id_alumno = $this->input->get("id_alumno");
			if($id_alumno === null){
				$id_alumno = $this->get_usuario_actual()->id_alumno;
			}
			$id_oferta = $this->input->get("id_oferta");
			$ids_alumnos = $this->modelo->get_alumnos_apuntados($id_oferta);
			$esta_apuntado = false;
			foreach ($ids_alumnos as $id) {
				if($id->id_alumno == $id_alumno){
					$esta_apuntado = true;
				}
			}
			$this->json($esta_apuntado);
		}
	}
	
	public function Apuntar(){
		$id_oferta = $this->input->post("id_oferta");
		if($id_oferta){
			$oferta = $this->modelo->query(["id_oferta"=>$id_oferta]);
			if(count($oferta) > 0){
				$id_alumno = $this->input->post("id_alumno");
				if(!$id_alumno){
					$id_alumno = $this->get_usuario_actual()->id_alumno;
				}
				$this->modelo->apuntar_alumno($id_oferta,$id_alumno);
				$this->json(true);
			}
			else{
				$this->json(false);
			}
			
		}
		else{
			$this->json(false);
		}
	}
	
	public function update(){
		$usuario = $this->get_usuario_actual();
		if(isset($usuario->id_profesor)){
			parent::update();
		}
		else{
			if(isset($usuario->id_empresa)){
				$viejo = new _Oferta();
				$nuevo = new _Oferta();
				$viejo->fromArray($this->input->post("viejo"));
				$nuevo->fromArray($this->input->post("nuevo"));
				
			}
		}
	}
	
	public function Candidatos($id_oferta){
		$this->json($this->alumnos->getByOferta($id_oferta));
		
	}
}