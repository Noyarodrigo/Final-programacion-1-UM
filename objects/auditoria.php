<?php
class Auditoria{

    private $connection;

    private $table_name = "auditoria";

    public $usuario;
    public $response_time;
    public $endpoint;
    public $created;

    public function __construct($connection){
        $this->connection = $connection;
    }

    function create(){

        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    usuario=:usuario, response_time=:response_time, endpoint=:endpoint, created=:created";
     
        $stmt = $this->connection->prepare($query);

        $this->usuario=htmlspecialchars(strip_tags($this->usuario));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->endpoint=htmlspecialchars(strip_tags($this->endpoint));
        $this->response_time=htmlspecialchars(strip_tags($this->response_time));
        
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":endpoint", $this->endpoint);
        $stmt->bindParam(":response_time", $this->response_time);
        
        if($stmt->execute()){
            return true;
        }
        return false;
         
    }
}