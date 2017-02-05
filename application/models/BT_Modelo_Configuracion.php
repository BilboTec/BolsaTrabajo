<?php
set_include_path(APPPATH . "third_party". DIRECTORY_SEPARATOR . "phpseclib");
require_once APPPATH . "third_party". DIRECTORY_SEPARATOR .
    "phpseclib".DIRECTORY_SEPARATOR."Net".DIRECTORY_SEPARATOR."SSH2.php";
require_once APPPATH . "third_party". DIRECTORY_SEPARATOR . "phpseclib".
    DIRECTORY_SEPARATOR."Net".DIRECTORY_SEPARATOR."SFTP.php";

class BT_Modelo_Configuracion extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbutil();
    }
    public function hacer_backup_programado(){
        $frequencia = $this->get("backup_frequencia");
        if($frequencia == null){
            $frequencia = 15;
        }
        $ultimo_backup = $this->get("ultimo_backup");
        $ahora = new DateTime();
        if($ultimo_backup==null){
            exec("php -f index.php /Backup > log.txt");
        }else{
            $ultimo_backup = DateTime::createFromFormat("Y-m-d H:i:s",$ultimo_backup);
            $ultimo_backup->add(new DateInterval("P".$frequencia."D"));
            if($ahora>=$ultimo_backup){
                exec("php -f index.php /Backup > log.txt");
            }
        }

    }
    public function forzar_backup(){
        $ahora = new DateTime();
        $ahora = $ahora->format('Y-m-d H:i:s');
        $host = $this->get("sftp_host");
        $puerto = $this->get("sftp_port");
        $user = $this->get("sftp_user");
        $pass = $this->get("sftp_pass");
        $this->enviar_backup_sftpd($this,$host,$puerto,$user,$pass);
        $this->set("ultimo_backup",$ahora);
    }
    public function set($clave,$valor){
        $this->db->replace("config",["clave"=>$clave,"valor"=>$valor]);
    }
    public function get($clave){
        $valor = $this->db->get_where("config",["clave"=>$clave])->result();
        if(count($valor)>0){
            return $valor[0]->valor;
        }
        return null;
    }
    public function sftp_enviar($host,$puerto,$usuario,$clave,$archivos){
        $sftp = new Net_SFTP($host,$puerto);
        if($sftp->login($usuario,$clave)){
            foreach($archivos as $remoto => $local){
                $sftp->put($remoto,$local,NET_SFTP_LOCAL_FILE);
            }
            return true;
        }else{
            return [
                "error"=>"No se pudo conectar"
            ];
        }
    }
    public function crear_backup($controller){
        $path = "data";
        $date = new DateTime();
        $nombre  = "backup_" . $date->format("d_m_Y_H_i_s") . ".zip";
        $zip = new ZipArchive();
        $zip->open($nombre,ZipArchive::CREATE);
        $zip->addFromString("backup.zip",$controller->dbutil->backup());
        function introducirEnZip($path,$dir, &$zip){
            $files = scandir($path);
            foreach ($files as $file) {
                $ruta = $path . DIRECTORY_SEPARATOR . $file;
                if($file !== "." && $file !== ".."){
                    if(is_dir($path . DIRECTORY_SEPARATOR . $file)){
                        $zip->addEmptyDir($dir . DIRECTORY_SEPARATOR . $file);
                        introducirEnZip($path . DIRECTORY_SEPARATOR . $file ,$dir . DIRECTORY_SEPARATOR . $file,$zip);
                    }else{
                        $zip->addFile($path . DIRECTORY_SEPARATOR . $file,$dir . DIRECTORY_SEPARATOR . $file);
                    }
                }
            }
        }
        introducirEnZip($path,"",$zip);
        $zip->close();
        return [$nombre=>$nombre];
    }
    public function enviar_backup_sftpd(&$controller,$host,$puerto,$usuario,$clave){
        $backup = $this->crear_backup($controller);
        $this->sftp_enviar($host,$puerto, $usuario, $clave,$backup);
        foreach ($backup as $b){
            try{
                unlink($b);
            }catch(Exception $ex){
                echo "No se pudo borrar $b";
            }
        }
    }

}

