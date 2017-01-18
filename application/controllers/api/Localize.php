<?php


class Localize extends CI_Controller {
	protected $idioma;
		public function __construct(){
			parent::__construct();
			$this->load->helper("url");
			$this->load->library("session");
			$this->load->helper("cookie");
			$this->idioma = get_cookie("idioma");
			if($this->idioma==null){
				$this->idioma = "spanish";
			}
			$this->lang->load('form_validation', $this->idioma);
			$this->lang->load("calendar",$this->idioma);
			$this->lang->load('general', $this->idioma);
			$this->config->set_item('language', $this->idioma);
		
		}
		public function get($string=null){
			if($string){
				$archivos = explode("#", $string);
				foreach ($archivos as $archivo) {
					$this->lang->load($archivo, $this->idioma);
				}
			}
			$this->output
	        ->set_content_type('application/javascript');
	        $data["lang"] = json_encode($this->lang->language);
			$this->load->view("scripts/btLocale",$data);
		}
		public function index(){
			$this->get();
		}

}