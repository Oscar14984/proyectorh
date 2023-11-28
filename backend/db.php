<?php
    class DB {
        protected $serverName;
        protected $user;
        protected $password;
        protected $database;
        protected $connection;

        public function __construct() {}

        public static function runQuery($query, $values = array()) {
            $host = '162.214.71.29';
            $user = 'wwdent_rrhhuser';
            $password = 'B?E}9;5!q~qQ';
            $database = 'wwdent_rrhh';
            $connection = new mysqli($host, $user, $password, $database);
            if( $connection->connect_errno ){
                die( "Database out of range" );
            }
            if ( count($values, COUNT_RECURSIVE) > 0 ) {
                $stmt = $connection->prepare($query);
                $cmd = strtoupper(substr(trim($query),0,6));
                $types = "";
                foreach($values as $value){
                    if (gettype($value) == 'integer'){ $types = $types . 'i'; } else 
                    if (gettype($value) == 'double') { $types = $types . 'd'; } else 
                                                     { $types = $types . 's'; }
                }
                if (strnatcmp(phpversion(),'5.3') >= 0){
                    foreach($values as $key => $val){ $bind[$key] = &$values[$key]; } } else 
                                                    { $bind = $values; }
                array_unshift($bind, $types);
                call_user_func_array(array($stmt, 'bind_param'), $bind);
                $exec = $stmt->execute();
                if( $cmd === "SELECT" ) { return $stmt->get_result(); } else
                                        { return $exec; }
            } else {
                if ( count($values, COUNT_RECURSIVE) == 0) {
                    return $connection->query($query);
                }
            }
            $connection->close();
        }

        public static function info( $query, $values ) { 
            $times = count($values);
            for ( $i = 1; $i <= $times; $i++ ) {
                $pos = strpos($query,"?");
                $value = $values[$i-1];
                if (gettype($value) == 'string') { $query = substr_replace($query,"'".$value."'",$pos,1); } else 
                                                 { $query = substr_replace($query,$value,$pos,1); }
            }
            return $query;
        }

        public static function dbDisconnect() {
            $host = NULL;
            $user = NULL;
            $password = NULL;
            $database = NULL;
            $connection = NULL;
        }
    }