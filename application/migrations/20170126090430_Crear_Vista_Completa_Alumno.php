<?php
class Migration_Crear_Vista_Completa_Alumno extends CI_Migration{
	public function up(){
		$this->load->database();
		$db = $this->db;
		$db->query("ALTER TABLE formacion_complementaria MODIFY COLUMN fecha_inicio DATE");
		$db->query("ALTER TABLE formacion_complementaria MODIFY COLUMN fecha_fin DATE");
		$db->query("ALTER TABLE formacion_academica MODIFY COLUMN fecha_inicio DATE");
		$db->query("ALTER TABLE formacion_academica MODIFY COLUMN fecha_fin DATE");

		$db->query("DROP TABLE IF EXISTS conocimiento_formacion_academica");
		$db->query("DROP TABLE IF EXISTS conocimiento_formacion_complementaria");

		$db->query("CREATE TABLE conocimiento_formacion_academica(
				id_conocimiento INT UNSIGNED,
				id_formacion_academica INT UNSIGNED,
				CONSTRAINT pk_conocimiento_formacion_academica PRIMARY KEY(id_conocimiento, id_formacion_academica),
				CONSTRAINT fk_conocimiento_conocimiento_formacion_academica FOREIGN KEY(id_conocimiento) REFERENCES
				conocimiento(id_conocimiento),
				CONSTRAINT fk_f_a_conocimiento_formacion_academica FOREIGN KEY(id_formacion_academica)REFERENCES formacion_academica(id_formacion_academica)
			)");

			$db->query("CREATE TABLE conocimiento_formacion_complementaria(
				id_conocimiento INT UNSIGNED,
				id_formacion_complementaria INT UNSIGNED,
				CONSTRAINT pk_conocimiento_formacion_complementaria PRIMARY KEY(id_conocimiento, id_formacion_complementaria),
				CONSTRAINT fk_conocimiento_conocimiento_formacion_complementaria FOREIGN KEY(id_conocimiento) REFERENCES
				conocimiento(id_conocimiento),
				CONSTRAINT fk_f_c_conocimiento_formacion_complementaria FOREIGN KEY(id_formacion_complementaria)REFERENCES formacion_complementaria(id_formacion_complementaria)
			)");

			$db->query("CREATE OR REPLACE VIEW vw_completa_alumno AS select * from alumno a left join idioma i using a.id_alumno = i.id_alumno left join formacion_academica fa using a.id_alumno = fa.id_alumno left join experiencia e using e.id_alumno = a.id_alumno left join conocimiento_experiencia ce using ce.id_experiencia = e.id_experiencia left join localidad l using l.id_localidad = a.id_localidad left join conocimiento_formacion_academica cfa using cfa.id_formacion_academica = fa.id_formacion_academica left join formacion_complementaria cf using cf.id_alumno = a.id_alumno left join conocimiento_formacion_complementaria cfc using cfc.id_formacion_complementaria = cf.id_formacion_complementaria; ");

	}

	public function down(){

		$db->query("DROP TABLE IF EXISTS conocimiento_formacion_academica");
		$db->query("DROP TABLE IF EXISTS conocimiento_formacion_complementaria");

		$db->query("DROP VIEW IF EXISTS vw_completa_alumno");
		
	}
}