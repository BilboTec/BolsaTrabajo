<?php

require_once "Entidad.php";
class NotaAlumno extends Entidad {
    public $id_alumno,$id_profesor,$fecha,$nota,$alumno,$profesor;
}

class BT_Modelo_Nota_Alumno extends CI_Model
{
    public  function __construct()
    {
        parent::__construct();
        $this->load->model("BT_Modelo_Alumno","alumnos");
        $this->load->model("BT_Modelo_Profesor","profesores");
    }

    public function get_by_alumno($alumno){
        $notaAlumnos = $this->db->get_where("nota_alumno",["id_alumno"=>$alumno->id_alumno])->result("NotaAlumno");
        for($i = 0; $i < count($notaAlumnos); $i++){
            $notaAlumnos[$i]->alumno = $alumno;
            $notaAlumnos[$i]->profesor = $this->profesores->get_by_id($notaAlumnos[$i]->id_profesor);
        }
        return $notaAlumnos;
    }
    public function insert($nota_alumno){
        unset($nota_alumno->profesor);
        unset($nota_alumno->alumno);
        $this->db->insert("nota_alumno",$nota_alumno);
        return true;
    }

}