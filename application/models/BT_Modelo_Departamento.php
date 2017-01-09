<?php

require_once 'BT_ModeloEstandar.php';

class _Departamento{
    public $id_departamento, $nombre;
}
class BT_Modelo_Departamento extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("departamento", "_Departamento", "id_departamento");
    }
	
	public function coger_departamentos()
	{
		$consulta = $this->db->get('departamento');
		return $consulta->result_array();
	}

}