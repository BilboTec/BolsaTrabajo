<?php
require_once 'BT_ModeloEstandar.php';
require_once 'Entidad.php';

class _Identificador_Clave extends Entidad{
	public $id_identificador_clave, $id_email,$fecha;
	
}
class BT_Modelo_Identificador_Clave extends BT_ModeloEstandar{
	public function __construct(){
		parent::__construct("identificador_clave", "_Identificador_Clave", "id_identificador_clave");
	}
	public function crear($email){
		$email = mb_strtolower($email);
		$id_email = $this->db->select("id_email")->get_where("email",["email"=>$email])->row()->id_email;
		if($id_email !== null){
			$fecha = new DateTime();
			$fecha = date("Y-m-d H:i:s", $fecha->getTimestamp());
			$this->db->insert($this->tabla,["id_email"=>$id_email,"fecha"=>$fecha]);
			$identificador =  $this->db->get_where($this->tabla,["id_email"=>$id_email,"fecha"=>$fecha])->row(0, $this->clase);
			return base64_encode($identificador->id_identificador_clave . "#" . $identificador->fecha);
		}
		return null;
	}
	public function obtener($identificador){
		$identificador = base64_decode($identificador);
		$parametros = explode("#", $identificador);
		if(count($parametros) > 1){
			$id_identificador = $parametros[0];
			$fecha = $parametros[1];
			$ahora = new DateTime();
			$ahora->sub(new DateInterval("PT30M"));
			$ahora = date("Y-m-d H:i:s", $ahora->getTimestamp());
			echo $ahora;
			$identificador = $this->db->get_where("identificador_clave", ["id_identificador_clave"=>$id_identificador, 
			"fecha"=>$fecha, "fecha >"=>$ahora])->row(0, $this->clase);
			return $identificador;
		}
		
		return null;
	}
	
	public function comprobar($identificador){
		$ahora = new DateTime();
		$ahora->sub(new DateInterval("PT30M"));
		$ahora = date("Y-m-d H:i:s", $ahora->getTimestamp());
		$identificador = $this->db->get_where("identificador_clave", ["id_identificador_clave"=>$identificador["id_identificador_clave"], 
		"fecha"=>$identificador["fecha"], "fecha >"=>$ahora])->row(0, $this->clase);
		echo $this->db->last_query();
		return $identificador != null;
	}
}
