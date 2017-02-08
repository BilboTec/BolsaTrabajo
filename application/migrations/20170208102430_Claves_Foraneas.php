<?php 
class Migration_Claves_Foraneas extends CI_Migration{
	public function up(){
		$this->load->database();
		$this->db->query("ALTER TABLE conocimiento_experiencia DROP FOREIGN KEY `fk_conocimiento_experiencia_experiencia`");
		$this->db->query("ALTER TABLE conocimiento_experiencia ADD CONSTRAINT 
		fk_conocimiento_experiencia_experiencia FOREIGN KEY(id_experiencia) REFERENCES experiencia(id_experiencia) ON DELETE CASCADE");
		$this->db->query("ALTER TABLE conocimiento_formacion_academica ADD CONSTRAINT 
		fk_conocimiento_formacion_academica_conocimiento FOREIGN KEY(id_formacion_academica) REFERENCES formacion_academica(id_formacion_academica) ON DELETE CASCADE");
		$this->db->query("ALTER TABLE conocimiento_formacion_complementaria ADD CONSTRAINT 
		fk_conocimiento_formacion_complementaria_conocimiento FOREIGN KEY(id_formacion_complementaria) REFERENCES formacion_complementaria(id_formacion_complementaria) ON DELETE CASCADE");		
		$this->db->query("ALTER TABLE empresa MODIFY COLUMN cif VARCHAR(9)");
		$this->db->query("alter table empresa DROP INDEX cif");
	}
	
	public function down(){
		
	}
}
