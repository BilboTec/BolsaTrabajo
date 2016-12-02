 <?php
 
 class Migration_Primera_Migracion extends CI_Migration {
 	
	public function up(){
		$this->load->database();
		$db = $this->db;
		$db->query("USE bolsa_trabajo;
					DROP TABLE IF EXISTS email;
						CREATE TABLE email(
							id_email INT UNSIGNED,
						    email VARCHAR(40) NOT NULL UNIQUE,
						    CONSTRAINT pk_email PRIMARY KEY (id_email)
						);
						/*DROP TABLE IF EXISTS rol;
						CREATE TABLE rol (
							id_rol INT UNSIGNED,
						    nombre VARCHAR(40) NOT NULL UNIQUE,
						    CONSTRAINT pk_rol PRIMARY KEY (id_rol)
						);*/
						DROP TABLE IF EXISTS departamento;
						CREATE TABLE departamento (
							id_departamento INT UNSIGNED,
						    nombre VARCHAR(40) NOT NULL,
						    id_padre INT UNSIGNED,
						    CONSTRAINT pk_departamento PRIMARY KEY (id_departamento),
						    CONSTRAINT fk_departamento_departamento FOREIGN KEY(id_padre) REFERENCES departamento(id_departamento)
						);
						DROP TABLE IF EXISTS profesor;
						CREATE TABLE profesor (
							id_profesor INT UNSIGNED,
						    nombre VARCHAR(40) NOT NULL,
						    apellido VARCHAR(40) NOT NULL,
						    apellido2 VARCHAR(40),
						    clave VARCHAR(128) NOT NULL,
						    id_departamento INT UNSIGNED NOT NULL,
						    id_email INT UNSIGNED NOT NULL,
						    id_rol INT UNSIGNED NOT NULL,
						    CONSTRAINT pk_profesor PRIMARY KEY (id_profesor),
						    CONSTRAINT fk_profesor_departamento FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento),
						    CONSTRAINT fk_profesor_email FOREIGN KEY (id_email) REFERENCES email(id_email)/*,
						    CONSTRAINT fk_profesor_rol FOREIGN KEY (id_rol) REFERENCES rol(id_rol)*/
						);
						DROP TABLE IF EXISTS provincia;
						CREATE TABLE provincia(
							id_provincia INT UNSIGNED,
						    nombre VARCHAR(40),
						    CONSTRAINT pk_provincia PRIMARY KEY (id_provincia)
						);
						DROP TABLE IF EXISTS pais;
						CREATE TABLE pais(
							id_pais INT UNSIGNED,
						    nombre VARCHAR(40),
						    CONSTRAINT pk_pais PRIMARY KEY (id_pais)
						);
						DROP TABLE IF EXISTS localidad;
						CREATE TABLE localidad(
							id_localidad INT UNSIGNED,
						    id_provincia INT UNSIGNED NOT NULL,
						    nombre VARCHAR(40),
						    CONSTRAINT pk_localidad PRIMARY KEY (id_localidad),
						    CONSTRAINT fk_localidad_provincia FOREIGN KEY (id_provincia) REFERENCES provincia(id_provincia)
						);
						DROP TABLE IF EXISTS empresa;
						CREATE TABLE empresa(
							id_empresa INT UNSIGNED,
						    id_email INT UNSIGNED NOT NULL,
						    cif VARCHAR(40) NOT NULL UNIQUE,
						    sector VARCHAR(50) NOT NULL,
						    nombre VARCHAR(50) NOT NULL,
						    clave VARCHAR(128) NOT NULL,
						    id_localidad INT UNSIGNED,
						    id_pais INT UNSIGNED,
						    CONSTRAINT pk_empresa PRIMARY KEY (id_empresa),
						    CONSTRAINT fk_empresa_email FOREIGN KEY (id_email) REFERENCES email(id_email),
						    CONSTRAINT fk_empresa_pais FOREIGN KEY (id_pais) REFERENCES pais(id_pais),
						    CONSTRAINT fk_empresa_localidad FOREIGN KEY (id_localidad) REFERENCES localidad(id_localidad)
						);
						DROP TABLE IF EXISTS oferta;
						CREATE TABLE oferta(
							id_oferta INT UNSIGNED,
						    titulo VARCHAR(40) NOT NULL,
						    id_empresa INT UNSIGNED,
						    nombre_empresa VARCHAR(40),
						    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
						    estudios_min VARCHAR(100),
						    experiencia_min VARCHAR(100),
						    requisitos TEXT,
						    descripcion TEXT,
						    horario VARCHAR(40),
						    salario VARCHAR(50),
						    visible BOOL,
						    CONSTRAINT pk_oferta PRIMARY KEY (id_oferta),
						    CONSTRAINT fk_oferta_empresa FOREIGN KEY (id_empresa) REFERENCES empresa(id_empresa)
						);
						DROP TABLE IF EXISTS conocimiento;
						CREATE TABLE conocimiento(
							id_conocimiento INT UNSIGNED,
						    nombre VARCHAR(40) NOT NULL,
						    CONSTRAINT pk_conocimiento PRIMARY KEY (id_conocimiento)
						);
						DROP TABLE IF EXISTS conocimiento_oferta;
						CREATE TABLE conocimiento_oferta(
							id_conocimiento INT UNSIGNED,
						    id_oferta INT UNSIGNED,
						    CONSTRAINT pk_conocimiento_oferta PRIMARY KEY (id_conocimiento,id_oferta),
						    CONSTRAINT fk_conocimiento_oferta_conocimiento FOREIGN KEY (id_conocimiento) REFERENCES conocimiento(id_conocimiento),
						    CONSTRAINT fk_conocimiento_oferta_oferta FOREIGN KEY (id_oferta) REFERENCES oferta(id_oferta)
						);
						DROP TABLE IF EXISTS conocimiento_departamento;
						CREATE TABLE conocimiento_departamento(
							id_conocimiento INT UNSIGNED,
						    id_departamento INT UNSIGNED,
						    CONSTRAINT pk_conocimiento_departamento PRIMARY KEY (id_conocimiento,id_departamento),
						    CONSTRAINT fk_conocimiento_departamento_conocimiento FOREIGN KEY (id_conocimiento) REFERENCES conocimiento(id_conocimiento),
						    CONSTRAINT fk_conocimiento_departamento_departamento FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento)
						);
						DROP TABLE IF EXISTS pregunta;
						CREATE TABLE pregunta (
							id_pregunta INT UNSIGNED,
						    id_oferta INT UNSIGNED NOT NULL,
						    enunciado TEXT,
						    CONSTRAINT pk_pregunta PRIMARY KEY (id_pregunta),
						    CONSTRAINT fk_pregunta_oferta FOREIGN KEY (id_oferta) REFERENCES oferta(id_oferta)
						);
						DROP TABLE IF EXISTS alumno;
						CREATE TABLE alumno (
							id_alumno INT UNSIGNED,
						    nombre VARCHAR(40) NOT NULL,
						    apellido1 VARCHAR(40) NOT NULL,
						    apellido2 VARCHAR(40),
						    fecha_nacimiento TIMESTAMP,
						    calle VARCHAR(40),
						    cp  VARCHAR(5),
							id_provincia INT UNSIGNED,
						    id_localidad INT UNSIGNED,
						    nacionalidad VARCHAR(40),
						    tlf VARCHAR(14),
						    sexo BOOL,
						    disponibilidad BOOL,
						    dni VARCHAR(9) NOT NULL UNIQUE,
						    id_email INT UNSIGNED NOT NULL,
						    otros_datos TEXT,
						    CONSTRAINT pk_alumno PRIMARY KEY (id_alumno),
						    CONSTRAINT fk_alumno_email FOREIGN KEY (id_email) REFERENCES email(id_email),
						    CONSTRAINT fk_alumno_provincia FOREIGN KEY (id_provincia) REFERENCES provincia(id_provincia),
						    CONSTRAINT fk_alumno_localidad FOREIGN KEY (id_localidad) REFERENCES localidad(id_localidad)
						);
						/*DROP TABLE IF EXISTS formacion_academica;
						CREATE TABLE formacion_academica(
							id_formacion INT UNSIGNED,
						    id_alumno INT UNSIGNED NOT NULL,
						    fecha_inicio TIMESTAMP NOT NULL,
						    fecha_fin TIMESTAMP,
						    cursando BOOL,
						    tipo 
						);*/
						DROP TABLE IF EXISTS experiencia;
						CREATE TABLE experiencia (
							id_experiencia INT UNSIGNED,
						    id_alumno INT UNSIGNED NOT NULL,
						    fecha_inicio TIMESTAMP NOT NULL,
						    fecha_fin TIMESTAMP,
						    trabajando_actualmente BOOL,
						    empresa VARCHAR(40),
						    cargo VARCHAR(40),
						    funciones TEXT,
						    CONSTRAINT pk_experiencia PRIMARY KEY (id_experiencia),
						    CONSTRAINT fk_experiencia_alumno FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno)
						);
						DROP TABLE IF EXISTS conocimiento_exeperiencia;
						CREATE TABLE conocimiento_experiencia(
							id_experiencia INT UNSIGNED,
						    id_conocimiento INT UNSIGNED,
						    nivel TINYINT UNSIGNED CHECK (nivel BETWEEN 0 AND 2),
						    CONSTRAINT pk_conocimiento_experiencia PRIMARY KEY (id_experiencia,id_conocimiento),
						    CONSTRAINT fk_conocimiento_experiencia_experiencia FOREIGN KEY (id_experiencia) REFERENCES experiencia(id_experiencia),
						    CONSTRAINT fk_conocimiento_experiencia_conocimiento FOREIGN KEY (id_conocimiento) REFERENCES conocimiento(id_conocimiento)
						);
						DROP TABLE IF EXISTS idioma;
						CREATE TABLE idioma (
							id_idioma INT UNSIGNED,
						    id_alumno INT UNSIGNED NOT NULL,
						    nombre VARCHAR(40),
						    nivel TINYINT UNSIGNED CHECK (nivel BETWEEN 0 AND 3),
						    oficial BOOL,
						    CONSTRAINT pk_idioma PRIMARY KEY (id_idioma),
						    CONSTRAINT fk_idioma_alumno FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno)
						);
						DROP TABLE IF EXISTS candidatura;
						CREATE TABLE candidatura (
							id_alumno INT UNSIGNED,
						    id_oferta INT UNSIGNED,
						    fecha TIMESTAMP,
						    estado TINYINT,
						    CONSTRAINT pk_candidatura PRIMARY KEY (id_alumno,id_oferta),
						    CONSTRAINT fk_candidatura_alumno FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno),
						    CONSTRAINT fk_candidatura_oferta FOREIGN KEY (id_oferta) REFERENCES oferta(id_oferta)
						);
						DROP TABLE IF EXISTS respuesta;
						CREATE TABLE respuesta(
							id_pregunta INT UNSIGNED,
						    id_alumno INT UNSIGNED,
						    id_oferta INT UNSIGNED,
						    valor TEXT,
						    CONSTRAINT pk_respuesta PRIMARY KEY (id_pregunta,id_alumno,id_oferta),
						    CONSTRAINT fk_respuesta_pregunta FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta),
						    CONSTRAINT fk_respuesta_alumno FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno),
						    CONSTRAINT fk_respuesta_oferta FOREIGN KEY (id_oferta) REFERENCES oferta(id_oferta)
						);
						DROP TABLE IF EXISTS identificador_alta;
						CREATE TABLE identificador_alta (
							identificador TIMESTAMP DEFAULT CURRENT_TIMESTAMP() PRIMARY KEY
						);");
						
						echo "Base de datos migrada a la versión 20161202083730";
				}
	public function down(){
							$this->load->database();
							$db = $this->db;
							$db->query("USE bolsa_trabajo;
										SET FOREIGN_KEY_CHECKS=0;
										DROP TABLE IF EXISTS alumno;
										DROP TABLE IF EXISTS candidatura;
										DROP TABLE IF EXISTS conocimiento;
										DROP TABLE IF EXISTS conocimiento_departamento;
										DROP TABLE IF EXISTS conocimiento_experiencia;
										DROP TABLE IF EXISTS conocimiento_oferta;
										DROP TABLE IF EXISTS departamento;
										DROP TABLE IF EXISTS email;
										DROP TABLE IF EXISTS empresa;
										DROP TABLE IF EXISTS experiencia;
										DROP TABLE IF EXISTS identificador_alta;
										DROP TABLE IF EXISTS idioma;
										DROP TABLE IF EXISTS localidad;
										DROP TABLE IF EXISTS oferta;
										DROP TABLE IF EXISTS pais;
										DROP TABLE IF EXISTS pregunta;
										DROP TABLE IF EXISTS profesor;
										DROP TABLE IF EXISTS provincia;
										DROP TABLE IF EXISTS respuesta;
										SET FOREIGN_KEY_CHECKS=1;
									
									");
							
						}
 }
