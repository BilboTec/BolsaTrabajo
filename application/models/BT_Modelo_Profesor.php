<?php
require_once 'BT_ModeloVista.php';
require_once "Entidad.php";
class _Profesor extends Entidad implements iEntidadConId {
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
class BT_Modelo_Profesor extends BT_ModeloVista {
	public function __construct(){
		parent::__construct("profesor","vw_profesor", "_Profesor", "id_profesor");
		$this->load->database();
	}
	public function delete($id){
		$profesor = $this->get_by_id($id);
		if($profesor->id_rol==3){
			$n_admins = $this->count_where(["id_rol"=>3]);
			if($n_admins<2){
				throw new Exception("eliminar_ultimo_admin");
			}
		}
		return parent::delete($id);
	}
	public function update($viejo,$nuevo){
		if($viejo->id_rol == 3 && $nuevo->id_rol < 3){
			$n_admins = $this->count_where(["id_rol"=>3]);
			if($n_admins<2){
				throw new Exception("degradar_ultimo_admin");
			}
		}
		return parent::update($viejo,$nuevo);
	}
}
