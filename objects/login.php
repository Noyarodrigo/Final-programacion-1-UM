<?php
class Login{

    private $connection;
    private $table_name = "usuarios";

    public $nombre;
    public $apellido;
    public $tipo;
    public $id;  

    public function __construct($connection){
        $this->connection = $connection;
    }


    function check(){
    
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 
                WHERE
                    nombre = :nombre AND clave = :clave";
    
        $stmt = $this->connection->prepare( $query );

        $stmt->bindValue(":clave", $this->clave);
        $stmt->bindValue(":nombre", $this->nombre);;
        
        $stmt->execute();
    
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->nombre = $fila['nombre'];
        $this->apellido= $fila['apellido'];
        $this->tipo= $fila['tipo'];
        $this->id= $fila['usuario_id'];        
    }

    function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        }elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    
}
