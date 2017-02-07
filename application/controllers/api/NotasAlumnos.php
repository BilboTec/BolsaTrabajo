<?php
require_once  "BT_Controlador_api_estandar.php";

class NotasAlumnos extends BT_Controlador_api_estandar
{
    public function __construct()
    {
        parent::__construct("BT_Controlador_Nota_Alumno","id_alumno");
    }
    public function Get($id = null)
    {
        if($id==null){
            die();
        }
       $usuario = $this->get_usuario_actual();
        if(isset($usuario->id_profesor)){
            $alumno = $this->alumnos->get_by_id($id);
            $this->json($this->modelo->get_by_alumno($alumno));
        }else{
            $this->json("acceso denegado",403);
        }
    }
    public function Insert()
    {
        $usuario = $this->get_usuario_actual();
        if(isset($usuario->id_profesor)){
            $this->form_validation->set_rules([
                [
                    "field"=>"id_alumno",
                    "caption"=>"Alumno",
                    "rules"=>"required"
                ],
                [
                    "field"=>"id_profesor",
                    "caption"=>"Profesor",
                    "rules"=>"required"
                ],
                [
                    "field"=>"nota",
                    "caption"=>"Observaciones",
                    "rules"=>"required"
                ]
            ]);
            if($this->form_validation()->run()){
                $nota = new NotaAlumno();
                $nota->fromPost($this);
                $this->modelo->insert($nota);
            }else{
                $this->json("bad request",400);
            }
        }else{
            $this->json("acceso denegado",403);
        }
    }
    public function Update(){
        die();
    }
}