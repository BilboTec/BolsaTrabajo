<?php
class _Conocimiento{
    public $id_conocimiento, $id_departamento, $nombre;
}
class BT_Modelo_Conocimiento extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper("BT_mysql_helper");
    }
    public function get_like($nombre){
        return $this->db->where(sql_string_busqueda('nombre')." LIKE " . sql_string_busqueda("'%$nombre%'") )->get("conocimiento")->result("_Conocimiento");
    }
    public function get($resultadosPorPagina){
        if($resultadosPorPagina){
            $this->db->limit($resultadosPorPagina);
        }
        return $this->db->get("conocimiento")->result("_Conocimiento");
    }
    public function insert($conocimiento){
        $this->db->insert("conocimiento",$conocimiento);
        $id_conocimiento = $this->db->insert_id();
        return $this->db->get_where("conocimiento",["id_conocimiento"=>$id_conocimiento])->result("_Conocimiento");
    }
    public function delete($id_conocimiento){
        $this->db->delete_where("conocimiento",["id_conocimiento"=>$id_conocimiento]);
    }
}