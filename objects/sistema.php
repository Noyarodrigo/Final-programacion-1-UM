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

    
}
