<?php
require_once 'BT_ModeloEstandar.php';

class _Profesor {
	public $id_profesor, $nombre, $apellido, $apellido2, $clave,
	$id_departamento,$id_email, $id_rol;
	public function establecer_clave($clave){
		$this->clave = password_hash($clave,PASSWORD_DEFAULT);
	}
	public function verificar_clave($clave){
		return password_verify($clave,$this->clave);
	}
	public function get_id(){
		return $this->id_profesor;
	}
}
class BT_Modelo_Profesor extends BT_ModeloEstandar{
	public function __construct(){
		parent::__construct("profesor", "_Profesor", "id_profesor");
		$this->load->database();
	}
	public function get($id_profesor=null, $resultadosPorPagina=false,$pagina=false,$orden=false,$direccion="asc"){
		if($id_profesor == null){
			return parent::get($resultadosPorPagina,$pagina,$orden,$direccion);
		}
		$profesor = $this->db->get_where("profesor",["id_profesor"=>$id_profesor])->custom_row_object(0,'_Profesor');
		if($profesor!=null){
			$profesor->email = $this->db->get_where("email",["id_email"=>$profesor->id_email]);
		}
		return $profesor;
	}
	public function get_by_email($email){
		$email  =$this->db->get_where("email",["email"=>$email])->row();
		if($email !== null){
		$profesor = $this->db->get_where("profesor",["id_email"=>$email->id_email])->custom_row_object(0,'_Profesor');
		if($profesor!=null){
			$profesor->email = $email;
		}
		return $profesor;
		}
		return null;
	}
	public function alta(_Profesor $profesor){
		$email = $profesor->email;
		if($this->db->query("SELECT COUNT(*) count FROM email WHERE email='$email'")->row()->count == 0){
			$this->db->trans_start();
			$this->db->insert("email",array("email"=>$email));
			$id_email = $this->db->insert_id();
			unset($profesor->email);
			$profesor->id_email = $id_email;
			$this->db->insert("profesor",$profesor);
			$profesor->id_profesor = $this->db->insert_id();
			$this->db->trans_complete();
			return $profesor;
		}
		return null;
	}
}
