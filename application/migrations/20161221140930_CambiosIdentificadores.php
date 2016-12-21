<?php

class Migration_Cambiosidentificadores extends CI_Migration {
	public function up(){
		$this->load->database();
		$this->db->query("DROP TABLE IF EXISTS identificador_alta");
		$this->db->query("CREATE TABLE identificador_alta (
			id_identificador INT UNSIGNED AUTO_INCREMENT,
			identificador TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			email VARCHAR(40) NOT NULL,
			constraint pk_identificador_alta PRIMARY KEY identificador_alta(id_identificador)
		)");
	}
}
