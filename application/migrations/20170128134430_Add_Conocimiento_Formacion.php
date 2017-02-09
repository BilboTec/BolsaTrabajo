<?php
class Migration_Add_Conocimiento_Formacion extends CI_Migration {
	public function up(){
		$this->load->database();
		$this->db->query("DROP TABLE IF EXISTS conocimiento_formacion_academica");
		$this->db->query("CREATE TABLE conocimiento_formacion_academica (
				id_conocimiento INT UNSIGNED,
				id_formacion_academica INT UNSIGNED,
				nivel INT,
				CONSTRAINT pk_conocimiento_formacion_academica PRIMARY KEY (id_conocimiento,id_formacion_academica),
				CONSTRAINT fk_conocimiento_formacion_academica_conocimiento FOREIGN KEY (id_conocimiento) REFERENCES
				conocimiento (id_conocimiento),
				CONSTRAINT fk_conocimiento_formacion_academica_formacion FOREIGN KEY (id_formacion_academica) REFERENCES
				formacion_academica(id_formacion_academica)
			)");
		$this->db->query("DROP TABLE IF EXISTS conocimiento_formacion_complementaria");
		$this->db->query("CREATE TABLE conocimiento_formacion_complementaria (
				id_conocimiento INT UNSIGNED,
				id_formacion_complementaria INT UNSIGNED,
				nivel INT,
				CONSTRAINT pk_conocimiento_formacion_complementaria PRIMARY KEY (id_conocimiento,id_formacion_complementaria),
				CONSTRAINT fk_conocimiento_formacion_complementaria_conocimiento FOREIGN KEY (id_conocimiento) REFERENCES
				conocimiento (id_conocimiento) ,
				CONSTRAINT fk_conocimiento_formacion_complementaria_formacion FOREIGN KEY (id_formacion_complementaria) REFERENCES
				formacion_complementaria(id_formacion_complementaria)
			)");
	}
	public function down(){
		$this->db->query("DROP TABLE IF EXISTS conocimiento_formacion_academica");
		$this->db->query("DROP TABLE IF EXISTS conocimiento_formacion_complementaria");
	}
}