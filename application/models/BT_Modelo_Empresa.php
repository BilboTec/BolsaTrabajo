<?php

class _Empresa{
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
class BT_Modelo_Empresa extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	public function get_by_email($email){
		$email  =$this->db->get_where("email",["email"=>$email])->row();
		if($email !== null){
		$empresa = $this->db->get_where("empresa",["id_email"=>$email->id_email])->custom_row_object(0,'_Empresa');
			if($empresa!=null){
				$empresa->email = $email;
			}
			return $empresa;
		}
		return null;
	}
	
	public function get($id_empresa){
		$empresa = $this->db->get_where("empresa",["id_empresa"=>$id_empresa])->custom_row_object(0,'_Empresa');
		if($empresa!=null){
			$empresa->email = $this->db->get_where("email",["id_email"=>$empresa->id_email]);
		}
		return $empresa;
	}
}