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
        $condiciones = [];
        switch($tipo){
            case 0:
                $condiciones["visible"] = 1;
                break;
            case 1:
                $condiciones["id_empresa"] = $usuario->id_empresa;
                break;
            }
    	parent::query($condiciones);
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
        if(isset($oferta->id_oferta) || (is_array($oferta) && isset($oferta["id_oferta"]))){
            $id = isset($oferta->id_oferta)?$oferta->id_oferta:$oferta["id_oferta"];
            $oferta_vieja = $this->modelo->query(["id_oferta"=>$id])[0];
            $this->modelo->update($oferta_vieja, $oferta);  
            $respuesta = new stdClass;
            $respuesta->mensaje = "ok";
            $this->json($respuesta);
        }
        else{
            $this->modelo->insert($oferta);
        }
    }
}