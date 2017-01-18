<?php

require_once 'BT_ModeloEstandar.php';
require_once 'Entidad.php';

class _Experiencia extends Entidad{
    public $id_experiencia, $id_alumno, $fecha_fin, $fecha_inicio, $trabajando_actualmente,
    $empresa, $cargo, $funciones;
}
class BT_Modelo_Experiencia extends BT_ModeloEstandar
{
    public function __construct()
    {
        parent::__construct("experiencia", "_Experiencia", "id_experiencia");

    }
}