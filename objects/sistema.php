<?php
class sistema{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "sistema_transporte";

    //columns
    public $sistema_id;
    public $nombre;
    public $pais_procedencia;
    public $created;
    public $updated; 

    public function __construct($connection){
        $this->connection = $connection;
    }

    function read(){
        //hay que arreglar el query este
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 

                ORDER BY
                    created DESC";
     
        // prepare query statement
        $stmt = $this->connection->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function create(){
 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    nombre=:nombre, pais_procedencia=:pais_procedencia, created=:created, updated=:updated";
     
        $stmt = $this->connection->prepare($query);

        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->updated=htmlspecialchars(strip_tags($this->updated));
        $this->pais_procedencia=htmlspecialchars(strip_tags($this->pais_procedencia));
        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":updated", $this->updated);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":pais_procedencia", $this->pais_procedencia);
     
        if($stmt->execute()){
            return true;
        }
        return false;
         
    }
    
    function delete(){
 
        $query = "DELETE FROM " . $this->table_name . " WHERE sistema_id = ?";

        $stmt = $this->connection->prepare($query);
     
        $this->sistema_id=htmlspecialchars(strip_tags($this->sistema_id));
     
        $stmt->bindParam(1, $this->sistema_id);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }

    
}
