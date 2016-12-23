<?php
require_once "Entidad.php";
require_once "BT_ModeloVista.php";
class _Empresa extends Entidad{
    public $id_empresa, $id_email, $cif, $sector,
        $nombre, $clave, $id_localidad, $id_pais;
	public function get_id(){
		return $this->id_empresa;
	}
	public function verificar_clave($clave){
		return password_verify($clave, $this->clave);
	}
	public function establecer_clave($clave){
		$this->clave = password_verify($clave, $this->clave);
	}
}
class BT_Modelo_Empresa extends BT_ModeloVista
{
    public function __construct()
    {
        parent::__construct("empresa","vw_empresa","_Empresa","id_empresa");
		$this->load->database();
    }
}