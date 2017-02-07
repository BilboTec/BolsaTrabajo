<?php
require_once "BT_Controlador_api_estandar.php";
class Configuracion extends BT_Controlador_api_estandar
{
    public  function __construct()
    {
        parent::__construct("","BT_Controlador_Configuracion","bt_config");
        $this->load->library("form_validation");
    }

    public function Get($item=null){
        $prohibidos = ["ftp_pass"];
        if($this->es_admin() && !in_array($item, $prohibidos)){
            $this->output->set_output(json_encode($this->bt_config->todos($prohibidos)));
        }
    }
    public function Ftp(){
        $this->form_validation->set_rules([
           [
               "field"=>"sftp_host",
               "caption"=>"host",
               "rules"=>"required"
           ],[
                "field"=>"sftp_port",
                "caption"=>"puerto",
                "rules"=>"required"
            ],
            [
                "field"=>"sftp_user",
                "caption"=>"usuario",
                "rules"=>"required"
            ],
            [
                "field"=>"sftp_pass",
                "caption"=>"contraseña"
            ],
            [
                "field"=>"backup_frequencia",
                "caption"=>"frequencia",
                "rules"=>"required"
            ]
        ]);
        if($this->form_validation->run()){
            $conf = [
                "sftp_port" => $this->input->post("sftp_port"),
                "sftp_user" => $this->input->post("sftp_user"),
                "sftp_host" => $this->input->post("sftp_host"),
                "sftp_pass" => $this->input->post("sftp_pass"),
                "backup_frequencia" => $this->input->post("backup_frequencia"),
            ];
            var_dump($conf);
            if($this->bt_config->probar_conexion($conf["sftp_host"],$conf["sftp_port"],$conf["sftp_user"],$conf["sftp_pass"]))
            {
                foreach ($conf as $clave => $valor){
                    $this->bt_config->set($clave,$valor);
                }
            }else{
                set_status_header(400);
                $this->json("imposible_conectar");
            }

        }else{
            $this->json(strip_tags(validation_errors()),400);
        }
    }
}