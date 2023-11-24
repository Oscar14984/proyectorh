<?php 
require_once 'dropbox/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

$dropboxKey ="1kf5q92ng3m2dwq";
$dropboxSecret ="c4unus9wecgp7w6";
$dropboxToken="sl.Bo7fXKgv28MS2tAvchFMVhKmZxN9fPepUIsBngn5JZbZsA6c25AVpsW5_VVkrwCBB1r8PH_sCfcrPctbHoUt8dA37T5jPTmFk1Mv_lpgotNNhXUscGDhmjpYCmsXe55MXz6zeJQEeaviMJH95YAcji0";


$app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
$dropbox = new Dropbox($app);

if(!empty($_FILES)){
    $localFile = $_FILES['file']['tmp_name'];
    $pathToLocalFile = $localFile;
    $dropboxFile = new DropboxFile($pathToLocalFile);
    $ext = explode(".",$_FILES['file']['name']);
    $ext = end($ext);
    $nombredropbox = "/" .$nombre . "." .$ext;

   try{
        $file = $dropbox->simpleUpload($dropboxFile ,$nombredropbox, ['autorename' => true]);
        echo "archivo subido";
   }catch(\exception $e){
        print_r($e);
        
   }



}


?>