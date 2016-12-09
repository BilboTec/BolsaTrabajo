<?php

class _Empresa{
    public $id_empresa, $id_email, $cif, $sector,
        $nombre, $clave, $id_localidad, $id_pais;
	public function get_id(){
		return $this->id_empresa;
	}
}
class BT_Modelo_Empresa extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function get($id_empresa){
		$empresa = $this->db->get_where("empresa",["id_empresa"=>$id_empresa])->custom_row_object(0,'_Empresa');
		if($empresa!=null){
			$empresa->email = $this->db->get_where("email",["id_email"=>$empresa->id_email]);
		}
		return $empresa;
	}
}