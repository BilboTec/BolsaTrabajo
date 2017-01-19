<?php 
class Migration_Vistas_Empresa_Alumno extends CI_Migration{
	public function up(){
		$this->load->database();
		$this->db->query("CREATE OR REPLACE VIEW `vw_alumno` AS SELECT id_alumno, nombre, apellido1, apellido2, fecha_nacimiento, calle, cp, id_localidad, nacionalidad,
tlf, sexo, disponibilidad, dni, e.id_email,e.email, otros_datos, clave FROM alumno a, email e WHERE a.id_email = e.id_email");
		$this->db->query("CREATE OR REPLACE VIEW vw_empresa AS SELECT id_empresa, e.id_email, e.email, cif, sector, nombre, clave, id_localidad, id_pais FROM empresa p, email e WHERE e.id_email = p.id_email");
	}
	public function down(){
		$this->load->database();
		$this->db->query("DROP VIEW IF EXISTS vw_alumno");
		$this->db->query("DROP VIEW IF EXISTS vw_empresa");
	}
}