<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: *');
  header('Access-Control-Allow-Methods: POST');
  $method = $_SERVER['REQUEST_METHOD'];
  if($method == "OPTIONS" || $method == "GET" || $method == "PUT" || $method == "DELETE") {
      die();
  }
  class Data {
    public function __construct( ) {}
    
    public static function get($variable = '') {
        if ( $variable !== "" ) {
            $data = file_get_contents( "php://input" );
            if ( !is_null( json_decode($data) ) && isset(json_decode($data)->{$variable}) ) {
                return json_decode($data)->{$variable};
            } else {
                return null;
            }
        } else {
            return "Esa variable no existe";
        }
    }
}
?>