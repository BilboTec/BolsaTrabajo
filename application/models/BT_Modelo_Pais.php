<?php

require_once 'BT_ModeloEstandar.php';
class _Pais{
	public $id_pais, $nombre;
	
}
class BT_Modelo_Pais extends BT_ModeloEstandar{
	public function __construct(){
		parent::__construct("pais", "_Pais", "id_pais");
	}
	public function id_es(){
		return $this->db->select("id_pais")->get_where("pais",["nombre"=>"España"])->row()["id_pais"];
	}
}
