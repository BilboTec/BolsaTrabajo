<?php
class Migration_Rellenar_Departamentos_Oferta_Formativa extends CI_Migration{
    public function up(){
        $this->load->database();
        $db = $this->db;
        $db->query("USE bolsa_trabajo");
		$db->query("INSERT INTO departamento (id_departamento, nombre)
                        VALUES
                            (1,'Electricidad y electrónica'),
                            (2,'Comercio y marketing'),
                            (3,'Química'),
                            (4,'Informática')
        ");
		
		$db->query("INSERT INTO tipo_titulacion (id_tipo_titulacion, nombre)
                        VALUES
                            (1, 'Grado Superior(FP2)'),
                            (2, 'Grado Medio(FP1)')
                            
        ");
		
		$db->query("INSERT INTO oferta_formativa (id_departamento, id_tipo_titulacion, nombre)
                        VALUES
                            (2, 2, 'Actividades Comerciales'),
                            (1, 2, 'Instalaciones de Telecomunicaciones'),
                            (4, 2, 'Sistemas Microinformáticos y Redes'),
                            (4, 1, 'Desarrollo de Aplicaciones Multiplataforma'),
                            (2, 1, 'Administración y Finanzas'),
                            (2, 1, 'Gestión de Ventas y Espacios Comerciales'),
                            (3, 1, 'Laboratorio de Análisis y de Control de Calidad'),
                            (4, 1, 'Desarrollo de Aplicaciones Web'),
                            (4, 1, 'Administración de Sistemas Informáticos en Red')
        ");
	}


    public function down(){
      
    }
}