<?php
class Auditoria{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "auditoria";

    //columns
    public $usuario;
    public $response_time;
    public $endpoint;
    public $created;

    public function __construct($connection){
        $this->connection = $connection;
    }

    /*function read(){
        $query = "SELECT
                        *
                FROM
                    " . $this->table_name . " 
                    
                ORDER BY
                    created DESC";
     
        $stmt = $this->connection->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }*/

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
        
        echo "\n QUERY:   $query";
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":endpoint", $this->endpoint);
        $stmt->bindParam(":response_time", $this->response_time);
        
        if($stmt->execute()){
            return true;
        }
        return false;
         
    }

    /*function search($keywords){
        //p.auditoria_id, p.response_time, p.usuario, p.endpoint, p.usuario, p.response_time, p.created, p.endpoint
        //Select opcional
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " p
                   
                WHERE
                    p.usuario LIKE ? OR p.usuario LIKE ? OR p.response_time LIKE ? OR p.endpoint LIKE ?
                ORDER BY
                    p.created DESC";
     
        $stmt = $this->connection->prepare($query);
     
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
     
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
        $stmt->bindParam(4, $keywords);
     
        $stmt->execute();
     
        return $stmt;
    }*/
}