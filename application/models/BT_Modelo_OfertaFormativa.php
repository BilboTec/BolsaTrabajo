<?php
class _OfertaFormativa{
    public $id_tipo_titulacion,$id_departamento,$id_oferta_formativa, $nombre;
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
        return $this->db->get("oferta_formativa")->result("_OfertaFormativa");
    }
    public function insert($conocimiento){
        $this->db->insert("oferta_formativa",$conocimiento);
        $id_tipo_titulacion = $this->db->insert_id();
        return $this->db->get_where("oferta_formativa",["id_oferta_formativa"=>$id_tipo_titulacion])->result("_OfertaFormativa");
    }
    public function delete($id_tipo_titulacion){
        $this->db->delete("oferta_formativa",["id_oferta_formativa"=>$id_tipo_titulacion]);
		return true;
    }
	public function update($viejo,$nuevo){
		
		$this->db->update("oferta_formativa",["nombre"=>$nuevo["nombre"]],["id_oferta_formativa"=>$viejo["id_oferta_formativa"]]);
		return $this->db->get_where("oferta_formativa",["id_oferta_formativa"=>$viejo["id_oferta_formativa"]])->result("_TipoTitulacion");
	}
}