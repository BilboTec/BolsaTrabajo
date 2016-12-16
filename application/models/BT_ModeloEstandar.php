<?php
abstract class BT_ModeloEstandar extends CI_Model
{
	public $tabla, $clase, $clave;
	
    public function __construct($tabla, $clase, $clave)
    {
    	$this->tabla = $tabla;
		$this->clase = $clase;
		$this->clave = $clave;
		
        parent::__construct();
        $this->load->database();
        $this->load->helper("BT_mysql_helper");
    }
    public function count(){
        return $this->db->select("COUNT(*) cuantos")->get($this->tabla)->row()->cuantos;
    }
    public function get($resultadosPorPagina=false,$pagina=false){
        if($resultadosPorPagina){
            if($pagina){
               $this->db->offset(($pagina-1)*$resultadosPorPagina);
            }
            $this->db->limit($resultadosPorPagina);
        }
        return $this->db->get($this->tabla)->result($this->clase);
    }
    public function insert($tupla){
        $this->db->insert($this->tabla,$tupla);
        $id = $this->db->insert_id();
        return $this->db->get_where($this->tabla,[$this->clave=>$id])->result($this->clase);
    }
    public function delete($id){
        $this->db->delete($this->tabla,[$this->clave=>$id]);
		return true;
    }
	public function update($viejo,$nuevo){
		$this->db->update($this->tabla,$nuevo,[$this->clave=>$viejo[$this->clave]]);
		return $this->db->get_where($this->tabla,[$this->clave=>$viejo[$this->clave]])->result($this->clase);
	}
}