<?php 
class Migration_Claves_Foraneas extends CI_Migration{
	public function up(){
		$this->load->database();
		$this->db->insert("config",["clave"=>"sftp_port","valor"=>"22"]);
		$this->db->insert("config",["clave"=>"sftp_user","valor"=>"u82799326-prueba"]);
		$this->db->insert("config",["clave"=>"sftp_host","valor"=>"home598636084.1and1-data.host"]);
		$this->db->insert("config",["clave"=>"sftp_pass","valor"=>"q1w2e3r4"]);
		$this->db->insert("config",["clave"=>"backup_frequencia","valor"=>"15"]);
		$this->db->insert("email",["id_email"=>1,"email"=>"admin@bolsatrabajo.es"]);
		$clave = password_hash("admin",PASSWORD_DEFAULT);
		$this->db->insert("profesor",["id_email"=>1,
									"nombre"=>"admin",
									"clave"=>$clave,
									"apellido"=>"admin",
									"id_departamento"=>1,
									"id_rol"=>3]);
		echo "Migraciones realizadas! Base de datos en la versión mas actual";
	}
	
	public function down(){
		
	}
}
