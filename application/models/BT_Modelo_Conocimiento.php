<?php

require_once 'BT_ModeloEstandar.php';

class _Conocimiento{
    public $id_conocimiento, $nombre;
}
class BT_Modelo_Conocimiento extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("conocimiento", "_Conocimiento", "id_conocimiento");

    }
    public function get_like($nombre){
        return $this->db->from($this->tabla)->like("LOWER(nombre)",mb_strtolower($nombre))
        ->get()->custom_result_object($this->clase);
    }
    public function get_from_oferta($id_oferta){
    	return $this->db->from($this->tabla)->join("conocimiento_oferta",
    		"conocimiento.id_conocimiento = conocimiento_oferta.id_conocimiento")->where(["id_oferta"=>$id_oferta])->get()
    	->custom_result_object($this->clase);
    }
    
}