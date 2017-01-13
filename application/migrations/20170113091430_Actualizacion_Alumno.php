<?php 
class Migration_Actualizacion_Alumno extends CI_Migration{
	public function up(){
		$this->load->database();
		$this->db->query("ALTER TABLE ALUMNO drop index dni");
		$this->db->query("ALTER TABLE ALUMNO MODIFY COLUMN apellido1 VARCHAR(40)");
		$this->db->query("ALTER TABLE ALUMNO MODIFY COLUMN fecha_nacimiento DATE");
		$this->db->query("ALTER TABLE experiencia MODIFY COLUMN fecha_inicio DATE");
		$this->db->query("ALTER TABLE experiencia MODIFY COLUMN fecha_fin DATE");
		$this->db->query("ALTER TABLE candidatura MODIFY COLUMN fecha DATE");

	}
	public function down(){

	}
}