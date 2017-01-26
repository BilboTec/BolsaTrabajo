<?php

class Migration_Tabla_indentificador_clave extends CI_Migration {
	public function up(){
		$this->load->database();
		$this->db->query("DROP TABLE IF EXISTS identificador_clave");
		$this->db->query("CREATE TABLE identificador_clave (
			id_identificador_clave INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			id_email INT UNSIGNED,
			CONSTRAINT fk_identificador_clave_email FOREIGN KEY (id_email) REFERENCES email(id_email) ON DELETE CASCADE
		)");
	}
	public function down(){
		$this->load->database();
		$this->db->query("DROP TABLE IF EXISTS identificador_clave");
	}
}
