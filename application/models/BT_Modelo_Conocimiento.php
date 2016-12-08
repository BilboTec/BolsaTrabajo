<?php
class Conocimiento{
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
        return $this->db->where(sql_string_busqueda('nombre')." LIKE " . sql_string_busqueda("'%$nombre%'") )->get("conocimiento")->result("Conocimiento");
    }
}