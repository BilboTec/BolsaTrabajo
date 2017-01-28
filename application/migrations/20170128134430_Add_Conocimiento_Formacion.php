<?php
class Migration_Add_Conocimiento_Formacion extends CI_Migration {
	public function up(){
		$this->load->database();
		$this->db->query("DROP TABLE IF EXISTS conocimiento_formacion_academica");
		$this->db->query("CREATE TABLE conocimiento_formacion_academica (
				id_conocimiento INT UNSIGNED,
				id_formacion_academica INT UNSIGNED,
				nivel INT
			)");
		$this->db->query("DROP TABLE IF EXISTS conocimiento_formacion_complementaria");
		$this->db->query("CREATE TABLE conocimiento_formacion_complementaria (
				id_conocimiento INT UNSIGNED,
				id_formacion_complementaria INT UNSIGNED,
				nivel INT 
			)");
	}
	public function down(){
		$this->db->query("DROP TABLE IF EXISTS conocimiento_formacion_academica");
		$this->db->query("DROP TABLE IF EXISTS conocimiento_formacion_complementaria");
	}
}