<?php
class _TipoTitulacion{
    public $id_tipo_titulacion, $nombre;
}
class BT_Modelo_TipoTitulacion extends CI_Model
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
        return $this->db->get("tipo_titulacion")->result("_TipoTitulacion");
    }
    public function insert($conocimiento){
        $this->db->insert("tipo_titulacion",$conocimiento);
        $id_tipo_titulacion = $this->db->insert_id();
        return $this->db->get_where("tipo_titulacion",["id_tipo_titulacion"=>$id_tipo_titulacion])->result("_TipoTitulacion");
    }
    public function delete($id_tipo_titulacion){
        $this->db->delete("tipo_titulacion",["id_tipo_titulacion"=>$id_tipo_titulacion]);
		return true;
    }
	public function update($viejo,$nuevo){
		
		$this->db->update("tipo_titulacion",["nombre"=>$nuevo["nombre"]],["id_tipo_titulacion"=>$viejo["id_tipo_titulacion"]]);
		return $this->db->get_where("tipo_titulacion",["id_tipo_titulacion"=>$viejo["id_tipo_titulacion"]])->result("_TipoTitulacion");
	}
}