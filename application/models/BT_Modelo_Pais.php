<?php

require_once 'BT_ModeloEstandar.php';
class _Pais{
	public $id_pais, $nombre;
	
}
class BT_Modelo_Pais extends BT_ModeloEstandar{
	public function __construct(){
		parent::__construct("pais", "_Pais", "id_pais");
	}
}
