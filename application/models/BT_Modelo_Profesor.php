<?php
require_once 'BT_ModeloEstandar.php';

class _Profesor {
	public $id_profesor, $nombre, $apellido, $apellido2, $clave,
	$id_departamento,$id_email, $id_rol,$email;
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
	public function query(array $condiciones,$resultadosPorPagina=false,$pagina=false,$orden=false,$direccion="asc"){
		if($resultadosPorPagina){
			if($pagina){
				$this->db->offset(($pagina-1)*$resultadosPorPagina);
			}
			$this->db->limit($resultadosPorPagina);
		}
		if($orden){
			$this->db->order_by($orden,$direccion);
		}
		return $this->db->get_where("vw_profesor",$condiciones)->result("_Profesor");
	}
	public function get($resultadosPorPagina=false,$pagina=false,$orden=false,$direccion="asc"){
		if($resultadosPorPagina){
			if($pagina){
				$this->db->offset(($pagina-1)*$resultadosPorPagina);
			}
			$this->db->limit($resultadosPorPagina);
		}
		if($orden){
			$this->db->order_by($orden,$direccion);
		}
		return $this->db->get_where("vw_profesor")->result("_Profesor");
	}
	public function get_by_id($id_profesor){
		$profesores = $this->query(["id_profesor"=>$id_profesor]);
		if(count($profesores)>0)
			return $profesores[0];
		return null;
	}
	
	public function get_by_email($email){
		$profesores = $this->query(["email"=>$email]);
		if(count($profesores)>0)
			return $profesores[0];
		return null;
	}
	public function update($viejo, $nuevo){
		$this->db->trans_start();
			$email = is_array($nuevo) ? $nuevo["email"] : $nuevo->email;
			if (isset($viejo["id_email"]) && $viejo["email"] !== null) {
				$this->db->where(["id_email" => $viejo["id_email"]])->update("email", ["email" => $email]);
			} else {
				$this->db->insert("email", ["email" => $email]);
				$nuevo->id_email = $this->db->insert_id();
			}
			unset($nuevo->email);
			unset($nuevo["email"]);
			$result = parent::update($viejo, $nuevo);
		$this->db->trans_complete();
		return $this->get_by_id($viejo["id_profesor"]);
	}

	public function insert($profesor){
		$email = $profesor["email"];
		$profesor["clave"] = password_hash($profesor["nombre"],PASSWORD_DEFAULT);
		$this->db->trans_start();
		$this->db->insert("email",array("email"=>$email));
		$id_email = $this->db->insert_id();
		unset($profesor["email"]);
		$profesor["id_email"] = $id_email;
		$this->db->insert("profesor",$profesor);
		$profesor = $this->get_by_id($this->db->insert_id());
		$this->db->trans_complete();
		return $profesor;
	}
	public function delete($id){
		$profesor = $this->get_by_id($id);
		$this->db->where(["id_email"=>$profesor->id_email])->delete("email");
		$resultado =  parent::delete($id);
		$this->db->trans_complete();
		return $resultado;
	}
}
