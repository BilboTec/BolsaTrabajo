<?php
require_once "Entidad.php";
require_once "BT_ModeloVista.php";
class _Empresa extends Entidad implements iEntidadConId {
    public $id_empresa, $id_email, $cif, $sector,
        $nombre, $clave, $id_localidad, $id_pais, $email;
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
	
	public function buscar($filtros){
		if(!$filtros){
			$filtros = [];
		}
					
		if(isset($filtros['id_provincia'])){
			$ids = $this->db->select("id_localidad")->get_where("localidad",["id_provincia"=>$filtros['id_provincia']])
			->result_array();
			$this->db->where_in(["id_localidad"=>$ids]);
			}
		foreach ($filtros as $key => $value) {
			switch ($key) {
				case 'id_pais':
					$this->db->where(["id_pais"=>$value]);
					break;
				
				case 'id_localidad':
					if($value)
					$this->db->where(["id_localidad"=>$value]);
					break;
				case 'buscador':
					$texto = mb_strtolower($value);
					$this->db->where("(LOWER(nombre) like '%$texto%' OR LOWER(cif) LIKE '%$texto%' OR LOWER(sector) LIKE '%$texto%' OR 
					LOWER(email) LIKE '%$texto%')");
					break;
			}
		}
		
		return $this->db->from($this->vista)->get()->custom_result_object($this->clase);
	}
	
	public function update($viejo, $nuevo){
		if(!$nuevo->id_pais){
			$nuevo->id_pais = NULL;
		}
		
		if(!$nuevo->id_localidad){
			$nuevo->id_localidad = NULL;
		}
		return parent::update($viejo, $nuevo);
	}
	
}