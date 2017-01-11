<?php

require_once 'BT_ModeloEstandar.php';
require_once 'Entidad.php';

class _Oferta extends Entidad{
    public $id_oferta, $titulo, $id_empresa, $nombre_empresa, $fecha, $estudios_min, $experiencia_min,
	$requisitos, $descripcion, $horario, $salario, $visible;
}

class BT_Modelo_Oferta extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("oferta", "_Oferta", "id_oferta");
    }
	
	public function coger_ofertas()
	{
		$consulta = $this->db->get('oferta');
		return $consulta->result_array();
	}

}
?>