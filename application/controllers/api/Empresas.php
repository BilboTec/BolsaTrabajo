<?php
require_once "BT_Controlador_api_estandar.php";
class Empresa extends BT_Controlador_api_estandar{

	public function _construct(){
		parent::__construct("BT_Modelo_Empresa","id_empresa");
		$this->load->model("BT_Modelo_IdentificadorAlta","altas");
	}

}