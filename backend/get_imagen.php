<?php
    require_once "accesos.php";
    require_once 'classInsertInDropBox.php';

    $dropBoxLocFile = $_GET['dropBoxLocFile']; 

    $insertarEnDropBox = new classInsertInDropBox();
    $contents = $insertarEnDropBox->getData($dropBoxLocFile);

    header('Content-Type: image/*');
    echo $contents;
?>