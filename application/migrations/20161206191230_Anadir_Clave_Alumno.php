<?php
class Migration_Anadir_Clave_Alumno extends CI_Migration{
	public function up(){
		$this->load->database();
		$this->db->query("ALTER TABLE alumno add column clave VARCHAR(128) not null");
		
	}
	
	public function down(){
		$this->load->database();
		$this->db->query("ALTER TABLE alumno drop column clave");
	}
}
?>
