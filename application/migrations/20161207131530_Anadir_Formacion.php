<?php

class Migration_Anadir_Formacion extends CI_Migration{
	public function up(){
		$this->load->database();
		$db = $this->db;
		$db->query("DROP TABLE IF EXISTS formacion_complementaria");
		$db->query("DROP TABLE IF EXISTS formacion_academica");
		$db->query("DROP TABLE IF EXISTS oferta_formativa");
		$db->query("DROP TABLE IF EXISTS tipo_titulacion");
		$db->query("CREATE TABLE tipo_titulacion(
			id_tipo_titulacion INT UNSIGNED AUTO_INCREMENT,
			nombre VARCHAR(200) NOT NULL,
			CONSTRAINT pk_tipo_titulacion PRIMARY KEY (id_tipo_titulacion)
		)");
		$db->query("CREATE TABLE oferta_formativa (
			id_oferta_formativa INT UNSIGNED AUTO_INCREMENT,
			id_departamento INT UNSIGNED NOT NULL,
			id_tipo_titulacion INT UNSIGNED,
			nombre VARCHAR(250) NOT NULL,
			CONSTRAINT pk_oferta_formativa PRIMARY KEY (id_oferta_formativa),
			CONSTRAINT fk_oferta_formativa_departamento FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento),
			CONSTRAINT fk_oferta_formativa_tipo_titulacion FOREIGN KEY (id_tipo_titulacion) REFERENCES tipo_titulacion(id_tipo_titulacion)
			
		)");
		$db->query("CREATE TABLE formacion_academica (
			id_formacion_academica INT UNSIGNED AUTO_INCREMENT,
			id_alumno INT UNSIGNED NOT NULL,
			descripcion TEXT,
			id_oferta_formativa INT UNSIGNED,
			id_tipo_titulacion INT UNSIGNED,
			nombre VARCHAR(250),
			fecha_inicio TIMESTAMP NOT NULL,
			fecha_fin TIMESTAMP,
			cursando BOOL,
			CONSTRAINT pk_formacion_academica PRIMARY KEY (id_formacion_academica),
			CONSTRAINT fk_formacion_academica_tipo_titulacion FOREIGN KEY (id_tipo_titulacion) REFERENCES tipo_titulacion(id_tipo_titulacion),
			CONSTRAINT fk_formacion_academica_alumno FOREIGN KEY(id_alumno) REFERENCES alumno(id_alumno),
			CONSTRAINT fk_fomaciton_academica_ofeta_formativa FOREIGN KEY (id_oferta_formativa) REFERENCES oferta_formativa(id_oferta_formativa	)
		)");
		$db->query("CREATE TABLE formacion_complementaria (
			id_formacion_complementaria INT UNSIGNED AUTO_INCREMENT,
			id_alumno INT UNSIGNED,
			descripcion TEXT,
			id_oferta_formativa INT UNSIGNED,
			fecha_inicio TIMESTAMP NOT NULL,
			fecha_fin TIMESTAMP,
			nombre VARCHAR(250),
			id_tipo_titulacion INT UNSIGNED,
			cursando BOOL,
			horas INT UNSIGNED,
			CONSTRAINT pk_formacion_complementaria PRIMARY KEY (id_formacion_complementaria),
			CONSTRAINT fk_formacion_complementaria_tipo_titulacion FOREIGN KEY (id_tipo_titulacion) REFERENCES tipo_titulacion(id_tipo_titulacion),
			CONSTRAINT fk_formacion_complementaria_alumno FOREIGN KEY(id_alumno) REFERENCES alumno(id_alumno),
			CONSTRAINT fk_fomaciton_complementaria_ofeta_formativa FOREIGN KEY (id_oferta_formativa) REFERENCES oferta_formativa(id_oferta_formativa)
		)");
		$db->query("ALTER TABLE identificador_alta ADD COLUMN email VARCHAR(40),DROP PRIMARY KEY
			, ADD CONSTRAINT pk_identificador_alta PRIMARY KEY(identificador,email)");
			echo "Migración 20161207131530 aplicada correctamente";
	}
	public function down(){
		$this->load->database();
		$db = $this->db;
		$db->query("DROP TABLE IF EXISTS formacion_complementaria");
		$db->query("DROP TABLE IF EXISTS formacion_academica");
		$db->query("DROP TABLE IF EXISTS oferta_formativa");
		$db->query("DROP TABLE IF EXISTS tipo_titulacion");
		$db->query("ALTER TABLE identificador_alta DROP PRIMARY KEY, DROP COLUMN email, ADD CONSTRAINT pk_identificador_alta PRIMARY KEY(identificador)");
	}
}
