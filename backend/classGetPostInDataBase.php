<?php
    //Clase para postear en la base de datos
    class classGetPostInDataBase {
        //Protegemos los datos de acceso a la base de datos
        protected $serverName;
        protected $user;
        protected $password;
        protected $database;
        protected $connection;

        function __construct() {
            //La IP para acceder a la BD
            $this->host = '162.214.71.29';
            //Usuario de acceso a la BD
            $this->user = 'wwdent_rrhhuser';
            //Password de la BD
            $this->password = 'B?E}9;5!q~qQ';
            //Nombre de la BD
            $this->database = 'wwdent_rrhh';
            //Iniciamos la conexion con la BD
            $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($this -> connection->connect_errno){
                die( "Database out of range" );
            }
        }
        function info( $query,$values ) { 
            //Contamos cuantos valores vamos a ingresar
            $times = count($values);
            for ( $i = 1; $i <= $times; $i++ ) {
                //Obtenemos la posicion del primer ?
                $pos = strpos($query,"?");
                //Extraemos el valor del arreglo
                $value = $values[$i-1];
                //Si el valor a ingresar en un str lo insertamos con una comillas en caso de que no lo insertamos sin comillas, sustituyendo los ?
                if (gettype($value) == 'string') { $query = substr_replace($query,"'".$value."'",$pos,1); } else 
                                                 { $query = substr_replace($query,$value,$pos,1); }
            }
            return $query;
        }

        function consulta_sa($query) { return $this->connection->query($query); }

        //Funcion que optimiza la obtencion y posteo por medio de queries
        function consulta_ca($query, $values = array()){
            //Preparamos la query con los valores incognita "?"
            $stmt = $this->connection->prepare($query);
            //Obtenemos el primer comando de la consulta, eliminamos los espacios en blanco de los lados y volvemos todos el STR a mayusculas
            $cmd = strtoupper(substr(trim($query),0,6));
            //STR donde guardamos el tipo de dato de cada valor ingresado
            $types = "";
            //Por cada valor que se quiera ingresar vamos a guardarlo en el str types
            foreach($values as $value){
                if (gettype($value) == 'integer'){ $types = $types . 'i'; } else 
                if (gettype($value) == 'double') { $types = $types . 'd'; } else
                if (gettype($value) == 'BLOB')   { $types = $types . 'b'; } else
                                                 { $types = $types . 's'; }
            }
            //Checamos la version de PHP
            if (strnatcmp(phpversion(),'5.3') >= 0){
                //Si la version de PHP es mayor o igual a 5.3 vamos a clonar el array valor en el array bind por medio de apuntadores
                foreach($values as $key => $val){ $bind[$key] = &$values[$key]; } } else 
                                                { //En caso de que no solo lo clonamos igualando
                                                    $bind = $values; }
            // Vamos a insertar el array con los tipos de valores a insertar al inicio del arreglo bind
            array_unshift($bind, $types);
            //Vamos a insertar los valores del array bind en los "?" de la query
            call_user_func_array(array($stmt, 'bind_param'), $bind);
            //ejecutamos la query
            $exec = $stmt->execute();
            //En caso de hacer un query de lectura usamos get _result al contrario de escritura usamos exec
            if( $cmd === "SELECT" ) { return $stmt->get_result(); } else
                                    { return $exec; }
        }

        //Funcion que nos desconecta de la base de datos
        function dbDisconnect() {
            // Insertamos los valores como NULL y cerramos la coneccion
            $this->host = NULL;
            $this->user = NULL;
            $this->password = NULL;
            $this->database = NULL;
            $this->connection->close();
            $this->connection = NULL;
        }

    }    
?>