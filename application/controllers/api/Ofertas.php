<?php

require_once "BT_Controlador_api_estandar.php";

class Ofertas extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Modelo_Oferta", "id_oferta");
        
    }
    
    public function Get(){
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
        if(isset($oferta->id_empresa) && !$oferta->id_empresa){
            $oferta = $oferta->toArray(["id_empresa"]);
        }
        $conocimientos = $this->input->post("conocimientos");
        if(isset($oferta->id_oferta) || (is_array($oferta) && isset($oferta["id_oferta"]))){
            $id = isset($oferta->id_oferta)?$oferta->id_oferta:$oferta["id_oferta"];
            $oferta_vieja = $this->modelo->query(["id_oferta"=>$id])[0];
            $oferta = $this->modelo->update($oferta_vieja, $oferta);
            if(is_array($oferta)){
                $oferta = $oferta[0];
            }
        }
        else{
            $oferta = $this->modelo->insert($oferta);
        }
        $this->modelo->actualizar_conocimientos($oferta,$conocimientos);
        $this->json($oferta);
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
}