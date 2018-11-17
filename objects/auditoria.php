<?php
class auditoria{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "auditoria";

    //columns
    public $auditoria_id;
    public $user;
    public $response_time;
    public $endpoint;
    public $created;

    public function __construct($connection){
        $this->connection = $connection;
    }

    function read(){
        $query = "SELECT
                        *
                FROM
                    " . $this->table_name . " 
                    
                ORDER BY
                    created DESC";
     
        $stmt = $this->connection->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }

    function create(){
 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    user=:user, response_time=:response_time, endpoint=:endpoint, created=:created";
     
        $stmt = $this->connection->prepare($query);

        $this->user=htmlspecialchars(strip_tags($this->user));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->endpoint=htmlspecialchars(strip_tags($this->endpoint));
        $this->response_time=htmlspecialchars(strip_tags($this->response_time));
        
        $stmt->bindParam(":user", $this->user);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":endpoint", $this->endpoint);
        $stmt->bindParam(":response_time", $this->response_time);
     
        if($stmt->execute()){
            return true;
        }
        return false;
         
    }

    function search($keywords){
        //p.auditoria_id, p.response_time, p.user, p.endpoint, p.user, p.response_time, p.created, p.endpoint
        //Select opcional
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " p
                   
                WHERE
                    p.user LIKE ? OR p.user LIKE ? OR p.response_time LIKE ? OR p.endpoint LIKE ?
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
    }
}