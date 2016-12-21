<?php

require_once 'BT_ModeloEstandar.php';
class _IdentificadorAlta{
	public $identificador, $email,$id_identificador;
	
}
class BT_Modelo_IdentificadorAlta extends BT_ModeloEstandar{
	public function __construct(){
		parent::__construct("identificador_alta", "_IdentificadorAlta", "id_identificador");
	}
}
