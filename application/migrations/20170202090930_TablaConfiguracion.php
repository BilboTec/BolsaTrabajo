<?php

class Migration_TablaConfiguracion extends CI_Migration {
	public function up(){
		$this->load->database();
		$this->db->query("DROP TABLE IF EXISTS rutas_backup");
		$this->db->query("DROP TABLE IF EXISTS config");
		$this->db->query("CREATE TABLE rutas_backup(
				ruta VARCHAR(250) PRIMARY KEY
			)");
		$this->db->query("CREATE TABLE config(
				clave VARCHAR(100) PRIMARY KEY,
				valor VARCHAR(200)
			)");		
	}
	public function down(){
		$this->load->database();
		$this->db->query("DROP TABLE IF EXISTS rutas_backup");
		$this->db->query("DROPT TABLE IF EXITS config");
	}
}