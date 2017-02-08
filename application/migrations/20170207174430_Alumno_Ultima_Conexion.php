<?php
class Migration_Alumno_Ultima_Conexion extends CI_Migration{
    public function up(){
        $this->load->database();
        $this->db->query("ALTER TABLE alumno ADD COLUMN ultima_conexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE alumno ADD COLUMN avisado TINYINT DEFAULT 0");
        $this->db->query("CREATE OR REPLACE VIEW `vw_alumno` AS SELECT id_alumno, nombre, apellido1, apellido2, fecha_nacimiento, calle, cp, id_localidad, nacionalidad,    
                            tlf, sexo, disponibilidad, dni, e.id_email,e.email, otros_datos, 
                            ultima_conexion, avisado, clave FROM alumno a, email e WHERE a.id_email = e.id_email");
        $this->db->query("DROP TABLE IF EXISTS nota_alumno");
        $this->db->query("CREATE TABLE nota_alumno (
                            id_alumno INT UNSIGNED,
                            id_profesor INT UNSIGNED,
                            fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                            nota TEXT,
                            CONSTRAINT pk_nota_alumno PRIMARY KEY (id_alumno,id_profesor,fecha),
                            CONSTRAINT fk_alumno_nota_alumno FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno) ON DELETE CASCADE,
                            CONSTRAINT fk_profesor_nota_alumno FOREIGN KEY (id_profesor) REFERENCES profesor(id_profesor) ON DELETE CASCADE
                          )");
    }
    public function down(){
        $this->db->query("DROP TABLE IF EXISTS nota_alumno");
        $this->db->query("CREATE OR REPLACE VIEW `vw_alumno` AS SELECT id_alumno, nombre, apellido1, apellido2, fecha_nacimiento, calle, cp, id_localidad, nacionalidad,    
                            tlf, sexo, disponibilidad, dni, e.id_email,e.email, otros_datos, 
                            clave FROM alumno a, email e WHERE a.id_email = e.id_email");
        $this->db->query("ALTER TABLE alumno DROP COLUMN ultima_conexion");
        $this->db->query("ALTER TABLE alumno DROP COLUMN avisado");
    }
}