<?php
require_once "BT_ModeloEstandar.php";

abstract class BT_ModeloVista extends BT_ModeloEstandar{
    protected $vista;
    public function __construct($tabla,$vista, $clase, $clave)
    {
        parent::__construct($tabla, $clase, $clave);
        $this->vista = $vista;
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
        return $this->db->get_where($this->vista,$condiciones)->result($this->clase);
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
        return $this->db->get_where($this->vista)->result($this->clase);
    }
    public function get_by_id($id){
        $elementos = $this->query([$this->clave=>$id]);
        if(count($elementos)>0)
            return $elementos[0];
        return null;
    }

    public function get_by_email($email){
        $elementos = $this->query(["email"=>$email]);
        if(count($elementos)>0)
            return $elementos[0];
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
        return $this->get_by_id($viejo[$this->clave]);
    }

    public function insert($elemento){
        $email = $elemento["email"];
        $elemento["clave"] = password_hash($elemento["nombre"],PASSWORD_DEFAULT);
        $this->db->trans_start();
        $this->db->insert("email",array("email"=>$email));
        $id_email = $this->db->insert_id();
        unset($elemento["email"]);
        $elemento["id_email"] = $id_email;
        $this->db->insert($this->tabla,$elemento);
        $elemento = $this->get_by_id($this->db->insert_id());
        $this->db->trans_complete();
        return $elemento;
    }
    public function delete($id){
        $elemento = $this->get_by_id($id);
        $this->db->where(["id_email"=>$elemento->id_email])->delete("email");
        $resultado =  parent::delete($id);
        $this->db->trans_complete();
        return $resultado;
    }
}