<?php 

class Migration_tabla_vista_profesor extends CI_Migration{
	public function up(){
		$this->load->database();
		$this->db->query("CREATE OR REPLACE VIEW vw_profesor AS
							SELECT id_profesor, nombre, apellido,apellido2,e.email, clave,e.id_email,id_departamento,
								id_rol FROM profesor p, email e WHERE e.id_email = p.id_email");
	}
	public function down(){
		$this->load->database();
		$this->db->query("DROP TABLE IF EXISTS vw_profesor");
	}
}
