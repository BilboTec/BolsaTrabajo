<?php
class Migration_Migracion_Final extends CI_Migration
{
	
	public function up(){
		$sql = file_get_contents("dump.sql");
		$this->load->database();
		$queries = explode(";",$sql);
		foreach($queries as $query){
			echo $query . "<br>";
			if($query){
				$this->db->query($query);
			}
		}
	}
	public function down(){

	}
}