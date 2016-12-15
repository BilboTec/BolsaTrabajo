<?php
class _Departamento{
    public $id_departamento, $nombre;
}
class BT_Modelo_Departamento extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper("BT_mysql_helper");
    }
    public function get($resultadosPorPagina){
        if($resultadosPorPagina){
            $this->db->limit($resultadosPorPagina);
        }
        return $this->db->get("departamento")->result("_Conocimiento");
    }
    public function insert($conocimiento){
        $this->db->insert("departamento",$conocimiento);
        $id_conocimiento = $this->db->insert_id();
        return $this->db->get_where("departamento",["id_departamento"=>$id_conocimiento])->result("_Departamento");
    }
    public function delete($id_departamento){
        $this->db->delete("departamento",["id_departamento"=>$id_departamento]);
		return true;
    }
	public function update($viejo,$nuevo){
		
		$this->db->update("departamento",["nombre"=>$nuevo["nombre"]],["id_conocimiento"=>$viejo["id_departamento"]]);
		return $this->db->get_where("departamento",["id_departamento"=>$viejo["id_departamento"]])->result("_Departamento");
	}
}