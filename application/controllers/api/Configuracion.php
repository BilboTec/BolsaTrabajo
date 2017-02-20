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
    public function Email(){
        if($this->es_admin()) {
            $metodo = $this->input->method(true);
            if($metodo === "GET"){
                $conf = [
                    "email_user" => $this->bt_config->get("email_user"),
                    "email_host" => $this->bt_config->get("email_host"),
                    "email_port" => $this->bt_config->get("email_port"),
                    "email_pass" => $this->bt_config->get("email_pass"),
                    "email_protocol" => $this->bt_config->get("email_protocol"),
                    "email_crypto" => $this->bt_config->get("email_crypto")
                ];
                $this->json($conf);
            }else {
                $this->form_validation->set_rules([
                    [
                        "field" => "email_user",
                        "caption" => $this->lang->line("user"),
                        "rules" => "required"
                    ], [
                        "field" => "email_host",
                        "caption" => $this->lang->line("host"),
                        "rules" => "required"
                    ],
                    [
                        "field" => "email_port",
                        "caption" => $this->lang->line("puerto"),
                        "rules" => "required"
                    ],
                    [
                        "field" => "email_pass",
                        "caption" => "contraseña",
                        "rules" => "required"
                    ]
                ]);
                if ($this->form_validation->run()) {
                    $conf = [
                        "email_user" => $this->input->post("email_user"),
                        "email_host" => $this->input->post("email_host"),
                        "email_port" => $this->input->post("email_port"),
                        "email_pass" => $this->input->post("email_pass"),
                        "email_protocol" => $this->bt_config->get("email_protocol"),
                        "email_crypto" => $this->bt_config->get("email_crypto")
                    ];
                    foreach ($conf as $clave => $valor) {
                        $this->bt_config->set($clave, $valor);
                    }
                } else {
                    $this->json(strip_tags(validation_errors()), 400);
                }
            }
        }else{
            $this->json("acceso denegado",403);
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