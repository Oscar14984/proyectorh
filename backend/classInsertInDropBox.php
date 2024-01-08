<?php
    //Clase para postear directo en DropBox

    //Llamamos al API de DropBox para php

    require_once 'dropbox/vendor/autoload.php';
    
    use Kunnu\Dropbox\Dropbox;
    use Kunnu\Dropbox\DropboxApp;
    use Kunnu\Dropbox\DropboxFile;
    class classInsertInDropBox{

        protected $app;
        protected $dropbox;
        protected $key;
        protected $secret;
        protected $access_key;

        function __construct() {
            //Ingresamos las llaves de acceso para usar el paquete de DropBox
            $this->key = "1kf5q92ng3m2dwq";
            $this->secret = "c4unus9wecgp7w6";
            $this->access_key = "sl.BtT2O1NRESgj7Q3C3fkGXA2j7EuqyUacKOYt1_WjlngIlHXorDrmEXnIy1B5kMlNypKwsvGEALVQYoJ11rEP26YMsrOv7CnteL9Dve9RcmI_eTav_mwsDhxTt2122mg2i1W8CRntXhpjFBqP2qNbkGg";
            $this->app = new DropboxApp($this->key, $this->secret,$this->access_key);
            $this->dropbox = new Dropbox($this->app);
        }

        function post($localDir,$file,$dropDir,$dropFile){
            //Funcion que postea un archivo el dropbox.
            //Se le ingresa la direccion del folder en el esuta el archivo local, el nombre del archivo local, el directorio del dropbox donde se quiere guardar y el nombre del archivo como se quiere guardar
            try{
                $localFile = $localDir."/".$file;
                $pathToLocalFile = $localFile;
                $dropboxFile = new DropboxFile($pathToLocalFile);
                $dropBoxFileName = $dropDir."/".$dropFile;
                $file = $this->dropbox->simpleUpload($dropboxFile,$dropBoxFileName, ['autorename' => true]);
                $file->getName();
                return true;
            }catch(Exception $e){
                echo $e->getMessage();
                return false;
            }
        }

        function download($dropBoxLocFile){
            //Funcion que descarga un archivo de dropBox y lo guarda en nuestra compu local
            //Solicita la localidad del archivo en dropBox que se quiere descargar como tambien la localidad de donde quiera descargar
            try{
                // Download and the save the file at the given path
                $file = $this->dropbox->download($dropBoxLocFile);
                return $file;
            }catch(Exception $e){
                echo $e->getMessage();
                return false;
            }
        }

        function getData($dropBoxLocFile){
            //Funcion que solo devuelve el contenido del archivo de dropbox que se quiera consultar sin descargarlos
            $file = $this->dropbox->download($dropBoxLocFile);
            //File Contents
            $contents = $file->getContents();
            return $contents;
        }

        function createFolderDropBox($path,$folder_name){
            $folder_path = $path."/".$folder_name;
            $folder = $this->dropbox->createFolder($folder_path);
            $folder = $folder->getName();
        }
         
        function deleteFileOrFolder($path){
            try{
                $deletedFolder = $this->dropbox->delete($path);
                $deletedFolder->getName();
                return true;
            }catch(Exception $e){
                echo $e->getMessage();
                return false;
            }
        }
    }
?>