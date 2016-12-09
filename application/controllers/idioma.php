<?php

class idioma extends CI_Controller{
	
	public function cambiar($idioma){
		$this->load->helper("cookie");
		set_cookie("idioma", $idioma, 604800);
	
		echo '{"respuesta" : "ok"}';
	}
}
