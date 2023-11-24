<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: *');
  header('Access-Control-Allow-Methods: POST');
  $method = $_SERVER['REQUEST_METHOD'];
  if($method == "OPTIONS" || $method == "GET" || $method == "PUT" || $method == "DELETE") {
      die();
  }
?>