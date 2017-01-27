/*?php
require_once "Entidad.php";
require_once 'BT_ModeloEstandar.php';
class _Candidatura extends Entidad {
	public $estado, $fecha, $id_alumno,
	$id_oferta;
}

class BT_Modelo_Candidatura extends BT_ModeloEstandar{
	public function __construct(){
		parent::__construct("candidatura","_Candidatura","id_oferta");
	}
	
}*/
