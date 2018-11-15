<?php
class auditoria{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "auditoria";

    //columns
    public $auditoria_id;
    public $patente;
    public $anho_patente;
    public $anho_fabricacion;
    public $marca;
    public $modelo;
    public $created;
    public $updated; 

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
                    patente=:patente, anho_patente=:anho_patente, anho_fabricacion=:anho_fabricacion, marca=:marca, modelo=:modelo, created=:created, updated=:updated";
     
        $stmt = $this->connection->prepare($query);

        $this->marca=htmlspecialchars(strip_tags($this->marca));
        $this->modelo=htmlspecialchars(strip_tags($this->modelo));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->updated=htmlspecialchars(strip_tags($this->updated));
        $this->patente=htmlspecialchars(strip_tags($this->patente));
        $this->anho_patente=htmlspecialchars(strip_tags($this->anho_patente));
        $this->anho_fabricacion=htmlspecialchars(strip_tags($this->anho_fabricacion));
        
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":updated", $this->updated);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":patente", $this->patente);
        $stmt->bindParam(":anho_patente", $this->anho_patente);
        $stmt->bindParam(":anho_fabricacion", $this->anho_fabricacion);
     
        if($stmt->execute()){
            return true;
        }
        return false;
         
    }

    function readOne(){
 
        $query = "SELECT
                    p.auditoria_id, p.patente, p.anho_patente, p.anho_fabricacion, p.marca, p.modelo, p.created, p.updated
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.auditoria_id = ?
                LIMIT
                    0,1";
    
        $stmt = $this->connection->prepare( $query );

        $stmt->bindParam(1, $this->auditoria_id);
    
        $stmt->execute();
    
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->anho_patente = $fila['anho_patente'];
        $this->patente = $fila['patente'];
        $this->anho_fabricacion = $fila['anho_fabricacion'];
        $this->marca = $fila['marca'];
        $this->modelo = $fila['modelo'];
        $this->auditoria_id = $fila['auditoria_id'];
        $this->created = $fila['created'];
        $this->updated = $fila['updated'];
    }

    function update(){
 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                patente=:patente,
                anho_patente=:anho_patente,
                anho_fabricacion=:anho_fabricacion,
                marca=:marca, 
                modelo=:modelo, 
                updated=:updated
                WHERE
                    auditoria_id = :auditoria_id";
     
        $stmt = $this->connection->prepare($query);

        $this->marca=htmlspecialchars(strip_tags($this->marca));
        $this->modelo=htmlspecialchars(strip_tags($this->modelo));
        $this->updated=htmlspecialchars(strip_tags($this->updated));
        $this->patente=htmlspecialchars(strip_tags($this->patente));
        $this->auditoria_id=htmlspecialchars(strip_tags($this->auditoria_id));
        $this->anho_patente=htmlspecialchars(strip_tags($this->anho_patente));
        $this->anho_fabricacion=htmlspecialchars(strip_tags($this->anho_fabricacion));
        
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":updated", $this->updated);
        $stmt->bindParam(":patente", $this->patente);
        $stmt->bindParam(":auditoria_id", $this->auditoria_id);
        $stmt->bindParam(":auditoria_id", $this->auditoria_id);
        $stmt->bindParam(":anho_patente", $this->anho_patente);
        $stmt->bindParam(":anho_fabricacion", $this->anho_fabricacion);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    
    function delete(){
 
        $query = "DELETE FROM " . $this->table_name . " WHERE auditoria_id = ?";

        $stmt = $this->connection->prepare($query);
     
        $this->auditoria_id=htmlspecialchars(strip_tags($this->auditoria_id));
     
        $stmt->bindParam(1, $this->auditoria_id);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }

    function search($keywords){
        //p.auditoria_id, p.anho_patente, p.patente, p.anho_fabricacion, p.marca, p.modelo, p.created, p.updated
        //Select opcional
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " p
                   
                WHERE
                    p.marca LIKE ? OR p.patente LIKE ? OR p.modelo LIKE ? OR p.anho_fabricacion LIKE ?
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