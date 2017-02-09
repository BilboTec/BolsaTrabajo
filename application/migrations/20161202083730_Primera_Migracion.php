 <?php
 set_time_limit(0);
 class Migration_Primera_Migracion extends CI_Migration {
 	
	public function up(){
		$this->load->database();
		$db = $this->db;
		$db->query("SET FOREIGN_KEY_CHECKS=0");
		$db->query("DROP TABLE IF EXISTS alumno");
		$db->query("DROP TABLE IF EXISTS candidatura");
		$db->query("DROP TABLE IF EXISTS conocimiento");
		$db->query("DROP TABLE IF EXISTS conocimiento_departamento");
		$db->query("DROP TABLE IF EXISTS conocimiento_experiencia");
		$db->query("DROP TABLE IF EXISTS departamento");
		$db->query("DROP TABLE IF EXISTS email");
		$db->query("	DROP TABLE IF EXISTS empresa");
		$db->query("DROP TABLE IF EXISTS experiencia");
		$db->query("DROP TABLE IF EXISTS identificador_alta");
		$db->query("DROP TABLE IF EXISTS conocimiento_oferta");
		$db->query("DROP TABLE IF EXISTS idioma");
		$db->query("DROP TABLE IF EXISTS localidad");
		$db->query("DROP TABLE IF EXISTS oferta");
		$db->query("DROP TABLE IF EXISTS pais");
		$db->query("DROP TABLE IF EXISTS pregunta");
		$db->query("DROP TABLE IF EXISTS profesor");
		$db->query("DROP TABLE IF EXISTS provincia");
		$db->query("DROP TABLE IF EXISTS respuesta");
		$db->query("SET FOREIGN_KEY_CHECKS=1");
		$db->query("CREATE TABLE email(
					id_email INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador de email',
					email VARCHAR(150) NOT NULL UNIQUE COMMENT 'Dirección de correo, max 254 carácteres  (RFC 5321)',
					CONSTRAINT pk_email PRIMARY KEY (id_email)
				) COMMENT 'Tabla maestra de emails'");
		$db->query("CREATE TABLE departamento (
					id_departamento INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador de departamento',
					nombre VARCHAR(40) NOT NULL COMMENT 'Nombre del departamento',
					id_padre INT UNSIGNED COMMENT 'Departamento del que depende',
					CONSTRAINT pk_departamento PRIMARY KEY (id_departamento),
					CONSTRAINT fk_departamento_departamento FOREIGN KEY(id_padre) REFERENCES departamento(id_departamento)
				) COMMENT 'Tabla de departamentos/modulos, aquellos modulos que no dependan de ningun otro serán considerados departamentos'");
		$db->query("CREATE TABLE profesor (
					id_profesor INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador del profesor',
					nombre VARCHAR(40) NOT NULL COMMENT 'Nombre del profesor',
					apellido VARCHAR(40) NOT NULL COMMENT 'Primer apellido del profsor',
					apellido2 VARCHAR(40) COMMENT 'Segundo apellido del profesor (opcional)',
					clave VARCHAR(128) NOT NULL COMMENT 'Hash de la contraseña del profesor',
					id_departamento INT UNSIGNED NOT NULL COMMENT 'Departamento al que pertenece el profesor',
					id_email INT UNSIGNED NOT NULL COMMENT 'Identificador del email del profesor',
					id_rol INT UNSIGNED NOT NULL COMMENT 'Rol del profesor en la aplicación',
					CONSTRAINT pk_profesor PRIMARY KEY (id_profesor),
					CONSTRAINT fk_profesor_departamento FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento),
					CONSTRAINT fk_profesor_email FOREIGN KEY (id_email) REFERENCES email(id_email)
				) COMMENT 'Tabla de profesores'");
		$db->query("CREATE TABLE provincia(
					id_provincia INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador de la provincia',
					nombre VARCHAR(22) COMMENT 'Nombre de la provincia',
					CONSTRAINT pk_provincia PRIMARY KEY (id_provincia)
				) COMMENT 'Tabla maestra de provincias (solo provincias españolas)'");
		$db->query("CREATE TABLE pais(
							id_pais INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador de país',
						    nombre VARCHAR(36) COMMENT 'Nombre de país',
						    CONSTRAINT pk_pais PRIMARY KEY (id_pais)
						) COMMENT 'Tabla maestra de países'");
		$db->query("CREATE TABLE localidad(
							id_localidad INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador de localidad',
						    id_provincia INT UNSIGNED NOT NULL COMMENT 'Identificador de provincia',
						    nombre VARCHAR(40) COMMENT 'Nombre de localidad',
						    CONSTRAINT pk_localidad PRIMARY KEY (id_localidad),
						    CONSTRAINT fk_localidad_provincia FOREIGN KEY (id_provincia) REFERENCES provincia(id_provincia)
						) COMMENT 'Tabla maestra de localidades (solo españa)'");

		$db->query("CREATE TABLE empresa(
							id_empresa INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador de empresa',
						    id_email INT UNSIGNED NOT NULL COMMENT 'Identificador de email',
						    cif VARCHAR(9) COMMENT 'Cif/Dni de la empresa',
						    sector VARCHAR(80) NOT NULL COMMENT 'Sector en el que trabaja',
						    nombre VARCHAR(250) NOT NULL COMMENT 'Nombre de la empresa',
						    clave VARCHAR(128) NOT NULL COMMENT 'Contraseña de la empresa',
						    id_localidad INT UNSIGNED COMMENT 'Localidad a la que pertenece',
						    id_pais INT UNSIGNED COMMENT 'País al que pertenece',
						    CONSTRAINT pk_empresa PRIMARY KEY (id_empresa),
						    CONSTRAINT fk_empresa_email FOREIGN KEY (id_email) REFERENCES email(id_email),
						    CONSTRAINT fk_empresa_pais FOREIGN KEY (id_pais) REFERENCES pais(id_pais),
						    CONSTRAINT fk_empresa_localidad FOREIGN KEY (id_localidad) REFERENCES localidad(id_localidad)
						) COMMENT 'Tabla de empersas'");
		$db->query("CREATE TABLE oferta(
							id_oferta INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador de la oferta',
						    titulo VARCHAR(200) NOT NULL COMMENT 'Cabecera de la oferta',
						    id_empresa INT UNSIGNED COMMENT 'Identificador de la empresa a la que pertenece',
						    nombre_empresa VARCHAR(250) COMMENT 'Nombre de la empresa',
						    fecha DATETIME DEFAULT NOW() COMMENT 'Fecha en la cual se creó la oferta',
						    estudios_min VARCHAR(250) COMMENT 'Descripción de los estudios mínimos para la oferta',
						    experiencia_min VARCHAR(250) COMMENT 'Descripción de la experiencia mínima requerida para la oferta',
						    requisitos TEXT COMMENT 'Descripción del resto de requisitos de la oferta',
						    descripcion TEXT COMMENT 'Descripción detallada de la oferta',
						    horario VARCHAR(100) COMMENT 'Descripción del horario del puesto de trabajo',
						    salario VARCHAR(100) COMMENT 'Descripción del salario del puestod e trabajo',
						    visible BOOL DEFAULT FALSE COMMENT 'Si es visible (publica',
						    CONSTRAINT pk_oferta PRIMARY KEY (id_oferta),
						    CONSTRAINT fk_oferta_empresa FOREIGN KEY (id_empresa) REFERENCES empresa(id_empresa)
						) COMMENT 'Tabla de ofertas'");
		$db->query("CREATE TABLE conocimiento(
							id_conocimiento INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador del conocimiento',
						    nombre VARCHAR(40) NOT NULL COMMENT 'Nombre del conocimiento',
						    CONSTRAINT pk_conocimiento PRIMARY KEY (id_conocimiento)
						) COMMENT 'Tabla maestra de conocimientos'");
		$db->query("CREATE TABLE conocimiento_oferta(
							id_conocimiento INT UNSIGNED COMMENT 'Identificador del conocimiento',
						    id_oferta INT UNSIGNED COMMENT 'Identificador de la oferta',
						    CONSTRAINT pk_conocimiento_oferta PRIMARY KEY (id_conocimiento,id_oferta),
						    CONSTRAINT fk_conocimiento_oferta_conocimiento FOREIGN KEY (id_conocimiento) REFERENCES conocimiento(id_conocimiento),
						    CONSTRAINT fk_conocimiento_oferta_oferta FOREIGN KEY (id_oferta) REFERENCES oferta(id_oferta)
						) COMMENT 'Tabla de relación entre odertas y conocimientos'");
		$db->query("CREATE TABLE conocimiento_departamento(
							id_conocimiento INT UNSIGNED COMMENT 'Identificador del conocimiento',
						    id_departamento INT UNSIGNED COMMENT 'Identificador del departamento',
						    CONSTRAINT pk_conocimiento_departamento PRIMARY KEY (id_conocimiento,id_departamento),
						    CONSTRAINT fk_conocimiento_departamento_conocimiento FOREIGN KEY (id_conocimiento) REFERENCES conocimiento(id_conocimiento),
						    CONSTRAINT fk_conocimiento_departamento_departamento FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento)
						) COMMENT 'Tabla de relación entre departamento y conocimientos'");
		$db->query("CREATE TABLE pregunta (
							id_pregunta INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador de la pregunta',
						    id_oferta INT UNSIGNED NOT NULL COMMENT 'Identificador de la respuesta',
						    enunciado TEXT NOT NULL COMMENT 'Html del enunciado de la pregunta',
						    CONSTRAINT pk_pregunta PRIMARY KEY (id_pregunta),
						    CONSTRAINT fk_pregunta_oferta FOREIGN KEY (id_oferta) REFERENCES oferta(id_oferta)
						) COMMENT 'Tabla de preguntas del cuestionario de la oferta'");
		$db->query("CREATE TABLE alumno (
							id_alumno INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador del alumno',
						    nombre VARCHAR(40) NOT NULL COMMENT 'Nombre del alumno',
						    apellido1 VARCHAR(40) NOT NULL COMMENT 'Primer apellido del alimno',
						    apellido2 VARCHAR(40) COMMENT 'Segundo apellido del alumno',
						    fecha_nacimiento DATETIME COMMENT 'Fecha dde naciemnto del alumno',
						    calle VARCHAR(100) COMMENT 'Calle en la que vive el alumno',
						    cp  VARCHAR(5) COMMENT 'Código postal',
						    id_localidad INT UNSIGNED COMMENT 'Localidad en la que vive',
						    nacionalidad VARCHAR(40) COMMENT 'Nacionalidad del alumno',
						    tlf VARCHAR(14) COMMENT 'Número del teléfono',
						    sexo BOOL COMMENT 'Sexo del alumno',
						    disponibilidad BOOL COMMENT 'Disponibilidad del alumno para trabajar',
						    dni VARCHAR(9) NOT NULL UNIQUE COMMENT 'Dni del alumno',
						    id_email INT UNSIGNED NOT NULL COMMENT 'Dirección de correo electrónico del alumno',
						    otros_datos TEXT COMMENT 'Otros datos de interes',
						    CONSTRAINT pk_alumno PRIMARY KEY (id_alumno),
						    CONSTRAINT fk_alumno_email FOREIGN KEY (id_email) REFERENCES email(id_email),
						    CONSTRAINT fk_alumno_localidad FOREIGN KEY (id_localidad) REFERENCES localidad(id_localidad)
						) COMMENT 'Tabla de alumnos'");
		$db->query("CREATE TABLE experiencia (
							id_experiencia INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador de la experiencia laboral',
						    id_alumno INT UNSIGNED NOT NULL COMMENT 'Identificador del alumno al que pertenece',
						    fecha_inicio DATETIME NOT NULL COMMENT 'Fecha en la que comenzó la experiencia',
						    fecha_fin DATETIME COMMENT 'Fecha en la que terminó la experiencia',
						    trabajando_actualmente BOOL COMMENT 'Si se encuentra trabajando acualmente en el puesto',
						    empresa VARCHAR(40) COMMENT 'Empresa para la que trabajó',
						    cargo VARCHAR(40) COMMENT 'Descripción breve del cargo',
						    funciones TEXT COMMENT 'Descricón detallada de las funciones realizadas en el puesto',
						    CONSTRAINT pk_experiencia PRIMARY KEY (id_experiencia),
						    CONSTRAINT fk_experiencia_alumno FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno)
						) COMMENT 'Tabla de las distintas experiencisa laborales de los alumnos'");
		$db->query("CREATE TABLE conocimiento_experiencia(
							id_experiencia INT UNSIGNED COMMENT 'Identificador de la experiencia a la que pertenece la relación',
						    id_conocimiento INT UNSIGNED COMMENT 'Identificador del conocimiento al que pertenece la relación',
						    nivel TINYINT UNSIGNED CHECK (nivel BETWEEN 0 AND 2),
						    CONSTRAINT pk_conocimiento_experiencia PRIMARY KEY (id_experiencia,id_conocimiento),
						    CONSTRAINT fk_conocimiento_experiencia_experiencia FOREIGN KEY (id_experiencia) REFERENCES experiencia(id_experiencia),
						    CONSTRAINT fk_conocimiento_experiencia_conocimiento FOREIGN KEY (id_conocimiento) REFERENCES conocimiento(id_conocimiento)
						) COMMENT 'Tabla de los distintos conocimientos adquiridos por las experiencias'");
		$db->query("CREATE TABLE idioma (
							id_idioma INT UNSIGNED AUTO_INCREMENT COMMENT 'Identificador del idioma',
						    id_alumno INT UNSIGNED NOT NULL COMMENT 'Identificador del alumno',
						    nombre VARCHAR(40) COMMENT 'Nombre del idioma',
						    nivel TINYINT UNSIGNED CHECK (nivel BETWEEN 0 AND 3),
						    oficial BOOL COMMENT 'Si se dispone de un certificado oficial',
						    CONSTRAINT pk_idioma PRIMARY KEY (id_idioma),
						    CONSTRAINT fk_idioma_alumno FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno)
						) COMMENT 'Tabla de los distintos idiomas de los alumnos'");
		$db->query("CREATE TABLE candidatura (
							id_alumno INT UNSIGNED COMMENT 'Alumno propietario de la candidatura',
						    id_oferta INT UNSIGNED COMMENT 'Oferta a la que se dirije la candidatura',
						    fecha DATETIME COMMENT 'Fecha en la que se realizó la candidatura',
						    estado TINYINT COMMENT 'Estado en el que se encuentra la cnadidatura',
						    CONSTRAINT pk_candidatura PRIMARY KEY (id_alumno,id_oferta),
						    CONSTRAINT fk_candidatura_alumno FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno),
						    CONSTRAINT fk_candidatura_oferta FOREIGN KEY (id_oferta) REFERENCES oferta(id_oferta)
						) COMMENT 'Tabla de candidaturas de los alumnos'");
		$db->query("CREATE TABLE respuesta(
							id_pregunta INT UNSIGNED COMMENT 'Pregunta a la que responde ésta respuesta',
						    id_alumno INT UNSIGNED COMMENT 'Alumno que responde',
						    id_oferta INT UNSIGNED COMMENT 'Oferta para la cual responde',
						    valor TEXT COMMENT 'Html de la respuesta',
						    CONSTRAINT pk_respuesta PRIMARY KEY (id_pregunta,id_alumno,id_oferta),
						    CONSTRAINT fk_respuesta_pregunta FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta),
						    CONSTRAINT fk_respuesta_alumno FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno),
						    CONSTRAINT fk_respuesta_oferta FOREIGN KEY (id_oferta) REFERENCES oferta(id_oferta)
						) COMMENT 'Tabla de respuestas a los cuestionarios de las ofertas'");
		$db->query("CREATE TABLE identificador_alta (
							identificador TIMESTAMP DEFAULT CURRENT_TIMESTAMP() PRIMARY KEY COMMENT 'identificador para el alta'
						) COMMENT 'Tabla de los identificadores de alta válidos'");
						
						echo "Base de datos migrada a la versión 20161202083730<br>";
				}
	public function down(){
							$this->load->database();
							$db = $this->db;
							$db->query("SET FOREIGN_KEY_CHECKS=0");
							$db->query("DROP TABLE IF EXISTS alumno");
							$db->query("DROP TABLE IF EXISTS candidatura");
							$db->query("DROP TABLE IF EXISTS conocimiento");
							$db->query("DROP TABLE IF EXISTS conocimiento_departamento");
							$db->query("DROP TABLE IF EXISTS conocimiento_experiencia");
							$db->query("DROP TABLE IF EXISTS departamento");
							$db->query("DROP TABLE IF EXISTS email");
							$db->query("DROP TABLE IF EXISTS empresa");
							$db->query("DROP TABLE IF EXISTS conocimiento_oferta");
							$db->query("DROP TABLE IF EXISTS experiencia");
							$db->query("DROP TABLE IF EXISTS identificador_alta");
							$db->query("DROP TABLE IF EXISTS idioma");
							$db->query("DROP TABLE IF EXISTS localidad");
							$db->query("DROP TABLE IF EXISTS oferta");
							$db->query("DROP TABLE IF EXISTS pais");
							$db->query("DROP TABLE IF EXISTS pregunta");
							$db->query("DROP TABLE IF EXISTS profesor");
							$db->query("DROP TABLE IF EXISTS provincia");
							$db->query("DROP TABLE IF EXISTS respuesta");
							$db->query("SET FOREIGN_KEY_CHECKS=1");

						}
 }
